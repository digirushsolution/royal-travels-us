<?php
namespace MyTravelElementor\Modules\Counter\Skins;

use Elementor;
use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use MyTravelElementor\Core\Controls_Manager as MYT_Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Counter
 */
class Counter_Skin extends Skin_Base {

	/**
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'counter-skin';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Skin-v1', 'mytravel-elementor' );
	}

	/**
	 * Constructor.
	 *
	 * @param Widget_Base $parent The widget settings.
	 * @return void
	 */
	public function __construct( Widget_Base $parent ) {
		parent::__construct( $parent );
	}

	/**
	 * Register control actions.
	 *
	 * @return void
	 */
	protected function _register_controls_actions() {
		add_filter( 'mytravel-elementor/widget/counter/print_template', [ $this, 'print_template' ], 10, 2 );
		add_action( 'elementor/element/counter/section_counter/before_section_end', [ $this, 'register_counter_content_controls' ], 10 );
		add_action( 'elementor/element/counter/section_title/after_section_end', [ $this, 'style_counter_controls' ], 10 );

	}

	/**
	 * Register mytravel counter content controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function register_counter_content_controls( $widget ) {

		$this->parent = $widget;

		$update_control_ids = [ 'prefix', 'suffix', 'duration', 'thousand_separator', 'thousand_separator_char' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$widget->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin' => '',
					],
				]
			);
		}

		$this->parent->start_injection(
			[
				'at' => 'after',
				'of' => '_skin',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'mytravel-elementor' ),
				'type'  => Controls_Manager::ICONS,
			]
		);
	}

	/**
	 * Register mytravel counter style controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function style_counter_controls( $widget ) {

		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .mytravel-elementor-counter__icon' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__( 'Counter', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->update_control(
			'number_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-counter-number-wrapper' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'counter_css',
			[
				'label'       => esc_html__( 'Counter CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <h5> tag', 'mytravel-elementor' ),
			]
		);

		$widget->update_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-counter-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'excerpt_css',
			[
				'label'       => esc_html__( 'Title CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <p> tag', 'mytravel-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {

		$widget        = $this->parent;
		$settings      = $widget->get_settings();
		$selected_icon = $this->get_instance_value( 'icon' );

		$widget->add_render_attribute(
			'counter',
			'class',
			[
				'elementor-counter-number-wrapper',
				'font-size-30',
				'font-weight-bold',
				'mb-2',
				'js-counter',
				$this->get_instance_value( 'counter_css' ),
			]
		);

		$widget->add_render_attribute(
			'description',
			'class',
			[
				'elementor-counter-title',
				'px-xl-2',
				'text-lh-inherit',
				'px-uw-3',
				$this->get_instance_value( 'excerpt_css' ),
			]
		);

		?>
		<?php
		Icons_Manager::render_icon(
			$selected_icon,
			[
				'class'       => 'mytravel-elementor-counter__icon font-size-80 mb-3',
				'aria-hidden' => 'true',
			]
		);
		?>
		<h5 <?php $widget->print_render_attribute_string( 'counter' ); ?>><?php echo esc_attr( $settings['ending_number'] ); ?></h5>
		<p <?php $widget->print_render_attribute_string( 'description' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></p>
		<?php
		$this->render_script();

	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $counter widget name.
	 * @return string
	 */
	public function print_template( $content, $counter ) {

		if ( 'counter' === $counter->get_name() ) {
			return '';
		}

		return $content;
	}

	/**
	 * Render script in the editor.
	 */
	public function render_script() {
		if ( Plugin::$instance->editor->is_edit_mode() ) :
			?>
			<script type="text/javascript">
				(function($) {
					$(document).ready( function() {
						// initialization of counters
						var counters = $.HSCore.components.HSCounter.init('[class*="js-counter"]');
					});
				})(jQuery);
			</script>
			<?php
		endif;
	}
}
