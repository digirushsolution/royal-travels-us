<?php
namespace MyTravelElementor\Modules\Accordion\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Plugin;
use Elementor\Repeater;
use MyTravelElementor\Core\Utils as SNUtils;

/**
 * Skin Accordion Mytravel
 */
class Skin_Accordion_Mytravel extends Skin_Base {

	/**
	 * Constructor.
	 *
	 * @param Elementor\Widget_Base $parent The widget settings.
	 * @return void
	 */
	public function __construct( Elementor\Widget_Base $parent ) {
		parent::__construct( $parent );
		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
		add_action( 'elementor/element/accordion/section_title/before_section_end', [ $this, 'remove_content_controls' ], 10 );
		add_action( 'elementor/element/accordion/section_toggle_style_content/after_section_end', [ $this, 'modifying_style_sections' ], 10 );
	}

	/**
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'myt-accordion-mytravel';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mytravel', 'mytravel-elementor' );
	}

	/**
	 * Remove accordion style controls.
	 *
	 * @param Elementor\Widget_Base $widget The widget settings.
	 * @return void
	 */
	public function remove_content_controls( Elementor\Widget_Base $widget ) {

		$this->parent = $widget;

		$update_control_ids = [ 'title_html_tag', 'faq_schema', 'selected_icon', 'selected_active_icon' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$this->parent->update_control(
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
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
				'default'   => 'div',
				'separator' => 'before',
			]
		);

		$this->parent->end_injection();

	}

	/**
	 * Update mytravel accordion content controls.
	 *
	 * @param Elementor\Widget_Base $widget The widget settings.
	 * @return void
	 */
	public function modifying_style_sections( Elementor\Widget_Base $widget ) {

		$this->parent = $widget;

		$update_control_ids = [ 'tab_active_color', 'section_toggle_style_icon', 'section_title_style' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$this->parent->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin' => '',
					],
				]
			);
		}

		$widget->update_control(
			'title_background',
			[
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mytravel-accordion .mytravel-tab-title' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$widget->update_control(
			'title_color',
			[
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion-icon, {{WRAPPER}} .elementor-accordion-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-accordion-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .mytravel-accordion .mytravel-tab-title' => 'color: {{VALUE}} !important;',
				],
			]
		);

	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		$tag      = $this->get_instance_value( 'title_tag' );

		$widget->add_render_attribute( 'accordion_title', 'class', [ 'elementor-accordion-title', 'elementor-tab-title', 'mytravel-tab-title', 'font-weight-bold', 'text-gray-3', 'mb-0', 'h6' ] );

		$widget->add_render_attribute( 'accordion_content', 'class', [ 'elementor-tab-content', 'mb-0', 'text-gray-1', 'text-lh-lg', 'mytravel-accordion__content' ] );

		$id_int = substr( $this->parent->get_id_int(), 0, 3 );

		?>
		<div class="mytravel-accordion" id="accordion-<?php echo esc_attr( $id_int ); ?>">
			<?php
			foreach ( $settings['tabs'] as $index => $item ) :
				$tab_count    = $index + 1;
				$button_class = [ 'mytravel-tab-title', 'collapse-link', 'btn', 'btn-link', 'btn-block', 'd-flex', 'align-items-md-center', 'p-0' ];
				if ( 1 !== $tab_count ) {
					$button_class[] = 'collapsed';
				}

				$widget->add_render_attribute(
					'toggle-' . $tab_count,
					[
						'role'          => 'button',
						'class'         => $button_class,
						'href'          => '',
						'data-toggle'   => 'collapse',
						'data-target'   => '#collapse-' . $id_int . $tab_count,
						'aria-expanded' => ( 0 === $index ) ? 'true' : 'false',
						'aria-controls' => 'collapse-' . $id_int . $tab_count,
					]
				);

				$widget->add_render_attribute(
					'collapse-' . $tab_count,
					[
						'class'           => [ 'collapse' ],
						'id'              => 'collapse-' . $id_int . $tab_count,
						'aria-labelledby' => 'collapse-' . $id_int . $tab_count,
						'data-parent'     => '#accordion-' . $id_int,
					]
				);

				if ( 1 === $tab_count ) {
					$widget->add_render_attribute( 'collapse-' . $tab_count, 'class', 'show' );
				}

				?>
				<div class="card border-0 mb-4 pb-1">
					<div class="card-header border-bottom-0 p-0" id="accordion<?php echo esc_attr( $id_int . $tab_count ); ?>">
						<h5 class="mb-0">
							<a <?php $widget->print_render_attribute_string( 'toggle-' . $tab_count ); ?>>
								<span class="d-inline-block border border-color-8 rounded-xs border-width-2 p-2 mb-3 mb-md-0 mr-4">
									<span class="minus">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="2px" class="injected-svg js-svg-injector mb-0" data-parent="#rectangle">
											<path fill-rule="evenodd" fill="rgb(59, 68, 79)" d="M-0.000,-0.000 L15.000,-0.000 L15.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"></path>
										</svg>
									</span>
									<span class="plus">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="16px" class="injected-svg js-svg-injector mb-0" data-parent="#plus1">
											<path fill-rule="evenodd" fill="rgb(59, 68, 79)" d="M16.000,9.000 L9.000,9.000 L9.000,16.000 L7.000,16.000 L7.000,9.000 L-0.000,9.000 L-0.000,7.000 L7.000,7.000 L7.000,-0.000 L9.000,-0.000 L9.000,7.000 L16.000,7.000 L16.000,9.000 Z"></path>
										</svg>
									</span>
								</span>
								<<?php echo esc_html( $tag ); ?> <?php $widget->print_render_attribute_string( 'accordion_title' ); ?>><?php echo esc_html( $item['tab_title'] ); ?></<?php echo esc_html( $tag ); ?>>
							</a>
						</h5>
					</div>
					<div <?php $widget->print_render_attribute_string( 'collapse-' . $tab_count ); ?>>
						<div class="card-body pl-10 pl-md-10 pr-md-12 pt-0">
							<p <?php $widget->print_render_attribute_string( 'accordion_content' ); ?>><?php echo wp_kses_post( SNUtils::parse_text_editor( $item['tab_content'], $settings ) ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
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
		if ( 'accordion' === $widget->get_name() ) {
			return '';
		}
		return $content;
	}
}
