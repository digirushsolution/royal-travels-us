<?php
namespace MyTravelElementor\Modules\IconBox\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Plugin;
use Elementor\Utils;
use MyTravelElementor\Core\Utils as MYTUtils;

/**
 * Skin Icon Box V2 Mytravel
 */
class Skin_Icon_Box_V2 extends Skin_Base {

	/**
	 * Constructor.
	 *
	 * @param Elementor\Widget_Base $parent The widget settings.
	 * @return void
	 */
	public function __construct( Elementor\Widget_Base $parent ) {
		parent::__construct( $parent );
		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
		add_action( 'elementor/element/icon-box/section_icon/after_section_end', [ $this, 'remove_content_controls' ], 10 );
		add_action( 'elementor/element/icon-box/section_style_content/before_section_end', [ $this, 'add_style_control' ], 10 );
	}

	/**
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'myt-icon-box-v2';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Style 2', 'mytravel-elementor' );
	}

	/**
	 * Register mytravel Icon Box content controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function remove_content_controls( $widget ) {

		$this->parent = $widget;

		$update_control_ids = [ 'description_text' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$widget->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin!' => 'myt-icon-box-v2',
					],
				]
			);
		}
	}

	/**
	 * Added control of the Style tab.
	 */
	public function add_style_control() {

		$widget = $this->parent;

		$update_control_ids = [ 'heading_description', 'description_color', 'description_typography_typography', 'description_shadow_text_shadow_type' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$widget->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin!' => 'myt-icon-box-v2',
					],
				]
			);
		}

		$this->parent->start_injection(
			[
				'of' => 'section_style_content',

			]
		);

		$this->add_control(
			'wrap_css',
			[
				'label'       => esc_html__( 'Wrap CSS Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Wrap CSS classes separated by space that you\'d like to apply to the backround image class <div> tag.', 'mytravel-elementor' ),
			]
		);

		$this->parent->end_injection();

		$this->parent->start_injection(
			[
				'of' => 'section_style_icon',

			]
		);

		$this->add_control(
			'icon_css',
			[
				'label'       => esc_html__( 'Icon CSS Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your class', 'mytravel-elementor' ),
			]
		);

		$widget->update_control(
			'primary_color',
			[
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .myt-icon-box-icon' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->parent->end_injection();
		$this->parent->start_injection(
			[
				'of' => 'heading_title',
			]
		);

		$this->add_control(
			'title_css',
			[
				'label'       => esc_html__( 'Title CSS Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your class', 'mytravel-elementor' ),
			]
		);

		$widget->update_control(
			'title_color',
			[
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .myt-icon-box-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->parent->end_injection();

	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {

		$widget    = $this->parent;
		$settings  = $widget->get_settings_for_display();
		$title     = $settings['title_text'];
		$title_tag = $settings['title_size'];

		$widget->add_render_attribute(
			'wrap_class',
			'class',
			[
				'color-hover',
				'py-4',
				'px-3',
				'bg-gray-4',
				'rounded-xs',
				'text-center',
				'transition-3d-hover',
				'shadow-hover-2',
				$this->get_instance_value( 'wrap_css' ),
			]
		);

		$widget->add_render_attribute(
			'title',
			'class',
			[
				'myt-icon-box-title',
				'elementor-icon-box-title',
				'font-size-17',
				'font-weight-bold',
				'text-gray-3',
				$this->get_instance_value( 'title_css' ),
			]
		);

		$widget->add_link_attributes( 'link', $settings['link'] );
		$widget->add_render_attribute( 'link', 'class', 'd-block' );
		?>
		<a <?php $widget->print_render_attribute_string( 'link' ); ?>>
			<div <?php $widget->print_render_attribute_string( 'wrap_class' ); ?>>
				<?php
				if ( ! isset( $settings['selected_icon']['value']['url'] ) ) {
					$widget->add_render_attribute( 'icon', 'class', $this->get_instance_value( 'icon_css' ) . ' elementor-icon-box-icon myt-icon-box-icon font-size-60 text-brown-light ' . $settings['selected_icon']['value'] );
					?>
						<i <?php $widget->print_render_attribute_string( 'icon' ); ?>></i>
					<?php
				}
				if ( isset( $settings['selected_icon']['value']['url'] ) ) {
					?>
						<i <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>></i>
					<?php
				}
				?>
				<h6 <?php $widget->print_render_attribute_string( 'title' ); ?>><?php echo esc_html( $title ); ?></h6>
			</div>
		</a>
		<?php
	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $widget widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $widget ) {
		if ( 'icon-box' === $widget->get_name() ) {
			return '';
		}
		return $content;
	}
}
