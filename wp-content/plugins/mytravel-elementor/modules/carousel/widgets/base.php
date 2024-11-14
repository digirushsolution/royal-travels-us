<?php
namespace MyTravelElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use MyTravelElementor\Base\Base_Widget;
use MyTravelElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Carousel Base for Carousel Control
 */
abstract class Base extends Base_Widget {

	/**
	 * Number of Slides.
	 *
	 * @var int
	 */
	private $slide_prints_count = 0;

	/**
	 * Fetch the Scripts based on keyword.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'slick-carousel' ];
	}

	/**
	 * Add repeater controls for carousels.
	 *
	 * @param Repeater $repeater repeater arguments.
	 * @return array
	 */
	abstract protected function add_repeater_controls( Repeater $repeater );

	/**
	 * Default repeater values.
	 *
	 * @return array
	 */
	abstract protected function get_repeater_defaults();

	/**
	 * Display Carousel.
	 *
	 * @param array  $slide repeater single control arguments.
	 * @param array  $settings control arguments.
	 * @param string $element_key slider id argument.
	 * @return array
	 */
	abstract protected function print_slide( array $slide, array $settings, $element_key );

	/**
	 * Register Controls.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$this->add_repeater_controls( $repeater );

		$this->add_control(
			'slides',
			[
				'label'   => esc_html__( 'Slides', 'mytravel-elementor' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => $this->get_repeater_defaults(),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'              => esc_html__( 'Autoplay', 'mytravel-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'no',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'              => esc_html__( 'Autoplay Speed', 'mytravel-elementor' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 5000,
				'condition'          => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'show_arrows',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Arrows', 'mytravel-elementor' ),
				'default'   => 'yes',
				'label_off' => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'  => esc_html__( 'Show', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'arrow_position',
			[
				'label'     => esc_html__( 'Arrow Position', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''      => esc_html__( 'Outer', 'mytravel-elementor' ),
					'inner' => esc_html__( 'Inner', 'mytravel-elementor' ),
				],
				'condition' => [
					'show_arrows' => 'yes',
				],
			]
		);

		$this->add_control(
			'arrow_class',
			[
				'label'     => esc_html__( 'Arrow CSS Classes', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => ' u-slick__arrow-classic--v1',
				'condition' => [
					'show_arrows' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_dots',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Dots Enable ?', 'mytravel-elementor' ),
				'default'   => 'no',
				'label_off' => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'  => esc_html__( 'Show', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'dots_class',
			[
				'label'     => esc_html__( 'Dot CSS Classes', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'show_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'center_slides',
			[
				'type'               => Controls_Manager::SWITCHER,
				'label'              => esc_html__( 'Center Mode', 'mytravel-elementor' ),
				'default'            => 'no',
				'label_off'          => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'           => esc_html__( 'Show', 'mytravel-elementor' ),
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'slides_per_view',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Slides Per View', 'mytravel-elementor' ),
				'options' => [
					'1' => __( '1', 'mytravel-elementor' ),
					'2' => __( '2', 'mytravel-elementor' ),
					'3' => __( '3', 'mytravel-elementor' ),
					'4' => __( '4', 'mytravel-elementor' ),
					'5' => __( '5', 'mytravel-elementor' ),
					'6' => __( '6', 'mytravel-elementor' ),
				],
				'default' => '3',
			]
		);

		$this->add_responsive_control(
			'data_rows',
			[
				'type'    => Controls_Manager::NUMBER,
				'label'   => esc_html__( 'Select Rows', 'mytravel-elementor' ),
				'default' => '1',
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'              => esc_html__( 'Infinite Loop', 'mytravel-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'no',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'fade',
			[
				'label'              => esc_html__( 'Fade', 'mytravel-elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'no',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label'     => esc_html__( 'Size', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'min' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slick-arrow' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slick-arrow' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => esc_html__( 'Background Hover Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .u-slick__arrow-classic:hover' => 'background-color: {{VALUE}} !important;',
				],
				'condition' => [
					'show_arrows' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .u-slick__pagination li.slick-active span' => 'border-color: {{VALUE}} !important',
					'{{WRAPPER}} .u-slick__paging span, {{WRAPPER}} .u-slick__paging span::before' => 'color: {{VALUE}} !important',
				],
				'condition' => [
					'show_dots' => 'yes',
				],
			]
		);

		$this->add_control(
			'pagination_size',
			[
				'label'     => esc_html__( 'Size', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .u-slick__pagination li span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .u-slick__paging span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}} !important',
				],
				'condition' => [
					'show_dots' => 'yes',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Get carousel settings
	 *
	 * @param array $settings The widget settings.
	 * @return array
	 */
	public function get_slick_settings( array $settings = null ) {
		if ( null === $settings ) {
			$settings = $this->get_settings_for_display();
		}

		$slick_settings = array(
			'data-center-mode'             => isset( $settings['center_slides'] ) && 'yes' === $settings['center_slides'] ? 1 : 0,
			'data-autoplay'                => isset( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ? true : false,
			'data-autoplay-speed'          => 'yes' === $settings['autoplay'] && $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 3000,
			'data-pagi-classes'            => isset( $settings['show_dots'] ) && 'yes' === $settings['show_dots'] ? 'text-center u-slick__pagination mt-4 ' . $settings['dots_class'] : '',
			'data-infinite'                => isset( $settings['infinite'] ) && 'yes' === $settings['infinite'] ? true : false,
			'data-fade'                    => isset( $settings['fade'] ) && 'yes' === $settings['fade'] ? true : false,
			'data-rows'                    => isset( $settings['data_rows'] ) ? $settings['data_rows'] : 1,
			'left_arrow_additional_class'  => isset( $settings['arrow_position'] ) && 'inner' === $settings['arrow_position'] ? 'ml-xl-n8' : '',
			'right_arrow_additional_class' => isset( $settings['arrow_position'] ) && 'inner' === $settings['arrow_position'] ? 'mr-xl-n8' : '',
			'arrow_additional_class'       => isset( $settings['arrow_position'] ) && 'inner' !== $settings['arrow_position'] ? 'shadow-5' : '',
			'data-arrows-classes'          => isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ? 'elementor-slick-arrow d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle ' . $settings['arrow_class'] : '',
			'data-arrow-left-classes'      => isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ? 'fas fa-chevron-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left' : '',
			'data-arrow-right-classes'     => isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ? 'fas fa-chevron-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right' : '',
		);

		if ( isset( $settings['arrow_position'] ) && 'inner' !== $settings['arrow_position'] ) {
			$slick_settings['data-arrow-left-classes']  .= ' ml-xl-n8';
			$slick_settings['data-arrow-right-classes'] .= ' mr-xl-n8';
		}

		if ( isset( $settings['arrow_position'] ) && 'inner' === $settings['arrow_position'] ) {
			$slick_settings['data-arrows-classes'] .= ' shadow-5';
		}
		return $slick_settings;
	}

	/**
	 * Print the carousel
	 *
	 * @param array $settings The widget settings.
	 */
	protected function print_slider( array $settings = null ) {
		if ( null === $settings ) {
			$settings = $this->get_settings_for_display();
		}

		$slick_settings = $this->get_slick_settings( $settings );

		$column    = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 1;
		$column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 2;
		$column_lg = ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 3;

		$carousel_args = [

			array(
				'breakpoint' => 992,
				'settings'   => [ 'slidesToShow' => $column_md ],
			),
			array(
				'breakpoint' => 768,
				'settings'   => [ 'slidesToShow' => $column ],
			),

		];

		$this->add_render_attribute(
			'slider',
			array(
				'class'                    => 'js-slick-carousel u-slick u-slick--equal-height u-slick-bordered-primary u-slick--gutters-3 mb-4 pb-1',
				'data-slides-show'         => $column_lg,
				'data-ride'                => 'slick',
				'data-responsive'          => wp_json_encode( $carousel_args ),
				'data-center-mode'         => wp_json_encode( $slick_settings['data-center-mode'] ),
				'data-autoplay'            => wp_json_encode( $slick_settings['data-autoplay'] ),
				'data-autoplay-speed'      => wp_json_encode( $slick_settings['data-autoplay-speed'] ),
				'data-pagi-classes'        => wp_json_encode( $slick_settings['mobile_pagination'] ),
				'data-pagi-classes'        => wp_json_encode( $slick_settings['data-pagi-classes'] ),
				'data-numbered-pagination' => wp_json_encode( $slick_settings['data-numbered-pagination'] ),
				'data-infinite'            => wp_json_encode( $slick_settings['data-infinite'] ),
				'data-fade'                => wp_json_encode( $slick_settings['data-fade'] ),
				'data-rows'                => wp_json_encode( $slick_settings['data-rows'] ),
				'data-arrows-classes'      => wp_json_encode( $slick_settings['data-arrows-classes'] ),
				'data-arrow-left-classes'  => wp_json_encode( $slick_settings['data-arrow-left-classes'] ),
				'data-arrow-right-classes' => wp_json_encode( $slick_settings['data-arrow-right-classes'] ),
			)
		);
		?>
		<div <?php $this->print_render_attribute_string( 'slider' ); ?>>
			<?php foreach ( $settings['slides'] as $slide ) : ?> 
				<div class="js-slide">                                   
					<?php
					$this->print_slide( $slide, $settings, $slide['_id'] );
					?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Render script in the editor.
	 *
	 * @param array $args Argument.
	 */
	public function render_script( $args = 'js-slick-carousel' ) {

		if ( Plugin::elementor()->editor->is_edit_mode() ) :
			?>
			<script type="text/javascript">
				(function($) {
					'use strict';

					$(document).ready( function() {
						if ( $.HSCore.components.hasOwnProperty( 'HSSlickCarousel' ) ) {
							$.HSCore.components.HSSlickCarousel.init('.<?php echo esc_attr( $args ); ?>');
						}

					});
				})(jQuery);

			</script>
			<?php
		endif;
	}
}
