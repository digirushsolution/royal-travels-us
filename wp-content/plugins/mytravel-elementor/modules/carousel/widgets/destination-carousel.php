<?php
namespace MyTravelElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use MyTravelElementor\Modules\Carousel\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Destination Carousel
 */
class Destination_Carousel extends Base {
	/**
	 * Fetch the Scripts based on keyword.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'slick-carousel' ];
	}
	/**
	 * Skip widget.
	 *
	 * @var bool
	 */
	protected $_has_template_content = false;

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-destination-carousel';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Destination Carousel', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'destination', 'carousel' ];
	}

	/**
	 * Get the group for this widget.
	 *
	 * @return string
	 */
	public function get_group_name() {
		return 'carousel';
	}

	/**
	 * Register repeater controls for this widget.
	 *
	 * @param Repeater $repeater repeater control arguments.
	 * @return void
	 */
	protected function add_repeater_controls( Repeater $repeater ) {

		$repeater->add_control(
			'bg_image',
			[
				'label'   => esc_html__( 'Backround Image', 'mytravel-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'bg_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html( 'United States ' ),

			]
		);

		$repeater->add_control(
			'pre_title',
			[
				'label'   => esc_html__( 'Description', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html( '£99 / night average' ),

			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => __( 'Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'mytravel-elementor' ),
			]
		);
	}

	/**
	 * Register Style Controls for this widget.
	 *
	 * @return void
	 */
	protected function register_controls() {
		parent::register_controls();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mytravel_destination_carousel' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'wrap_css',
			[
				'label'       => esc_html__( 'Wrap CSS Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'This setting is allows to you add class for bg-image <div> tag.', 'mytravel-elementor' ),
				'separator'   => 'after',
			]
		);

		$this->add_control(
			'title_css',
			[
				'label'       => esc_html__( 'Title CSS Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'This setting is allows to you add class for bg-image <a> tag.', 'mytravel-elementor' ),
				'separator'   => 'after',
			]
		);

		$this->add_control(
			'desc_css',
			[
				'label'       => esc_html__( 'Description CSS Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'This setting is allows to you add class for bg-image <p> tag.', 'mytravel-elementor' ),
				'separator'   => 'after',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Slider defaults.
	 *
	 * @return string
	 */
	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		return [
			[
				'bg_image'  => [
					'url' => $placeholder_image_src,
				],
				'title'     => esc_html__( 'United States ', 'mytravel-elementor' ),
				'pre_title' => esc_html__( '£99 / night average', 'mytravel-elementor' ),
				'link'      => '',
			],
			[
				'bg_image'  => [
					'url' => $placeholder_image_src,
				],
				'title'     => esc_html__( 'United States ', 'mytravel-elementor' ),
				'pre_title' => esc_html__( '£99 / night average', 'mytravel-elementor' ),
				'link'      => '',
			],
			[
				'bg_image'  => [
					'url' => $placeholder_image_src,
				],
				'title'     => esc_html__( 'United States ', 'mytravel-elementor' ),
				'pre_title' => esc_html__( '£99 / night average', 'mytravel-elementor' ),
				'link'      => '',
			],
		];
	}

	/**
	 * Print the slide.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_slide( array $slide, array $settings, $element_key ) {

		$title     = $slide['title'];
		$pre_title = $slide['pre_title'];

		$this->add_render_attribute( 'wrap_' . $element_key, 'class', [ 'js-slide', 'bg-img-hero-center', 'rounded-border', 'min-height-350', 'gradient-overlay-half-bg-gradient-v1' ] );

		if ( ! empty( $settings['wrap_css'] ) ) {
			$this->add_render_attribute( 'wrap', 'class', $settings['wrap_css'] );
		}

		if ( ! empty( $title ) ) {
			$this->add_render_attribute( 'title_' . $element_key, 'class', [ 'mytravel_destination_carousel', 'text-white', 'font-weight-bold', 'font-size-21' ] );
			$this->add_link_attributes( 'title_' . $element_key, $slide['link'] );
		}

		if ( ! empty( $settings['title_css'] ) ) {
			$this->add_render_attribute( 'title', 'class', $settings['title_css'] );
		}

		if ( ! empty( $pre_title ) ) {
			$this->add_render_attribute( 'excerpt_' . $element_key, 'class', [ 'mytravel_destination_carousel', 'text-white', 'font-size-19', 'font-weight-bold', 'mt-1', 'mb-0' ] );
		}

		if ( ! empty( $settings['desc_css'] ) ) {
			$this->add_render_attribute( 'excerpt', 'class', $settings['desc_css'] );
		}

		?>
		<div <?php $this->print_render_attribute_string( 'wrap_' . $element_key ); ?> style="background-image: url(<?php echo esc_url( $slide['bg_image']['url'] ); ?> );">
			<div class="text-center py-4 mt-1">
				<a <?php $this->print_render_attribute_string( 'title_' . $element_key ); ?>><?php echo esc_html( $title ); ?></a>
				<p <?php $this->print_render_attribute_string( 'excerpt_' . $element_key ); ?>><?php echo wp_kses_post( $pre_title ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Get slider settings
	 *
	 * @param array $settings The widget settings.
	 * @return void
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
				'breakpoint' => 1025,
				'settings'   => [ 'slidesToShow' => $column_lg ],
			),
			array(
				'breakpoint' => 992,
				'settings'   => [ 'slidesToShow' => $column_md ],
			),
			array(
				'breakpoint' => 768,
				'settings'   => [ 'slidesToShow' => $column ],
			),
			array(
				'breakpoint' => 554,
				'settings'   => [ 'slidesToShow' => $column ],
			),
		];

		$this->add_render_attribute(
			'slider',
			[
				'class'                    => 'js-slick-carousel u-slick u-slick--gutters-3',
				'data-slides-show'         => $column_lg,
				'data-ride'                => 'slick',
				'data-responsive'          => wp_json_encode( $carousel_args ),
				'data-center-mode'         => ( $slick_settings['data-center-mode'] ),
				'data-autoplay'            => ( $slick_settings['data-autoplay'] ),
				'data-autoplay-speed'      => ( $slick_settings['data-autoplay-speed'] ),
				'data-pagi-classes'        => ( $slick_settings['data-pagi-classes'] ),
				'data-infinite'            => ( $slick_settings['data-infinite'] ),
				'data-fade'                => ( $slick_settings['data-fade'] ),
				'data-rows'                => ( $slick_settings['data-rows'] ),
				'data-arrows-classes'      => ( $slick_settings['data-arrows-classes'] ),
				'data-arrow-left-classes'  => ( $slick_settings['data-arrow-left-classes'] ),
				'data-arrow-right-classes' => ( $slick_settings['data-arrow-right-classes'] ),

			]
		);
		$this->add_render_attribute( 'slider', 'class', $settings['slider__class'] );

		?>
		<div <?php $this->print_render_attribute_string( 'slider' ); ?>>
			<?php foreach ( $settings['slides'] as $slide ) : ?> 
				<?php $this->print_slide( $slide, $settings, $slide['_id'] ); ?>	
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {
		$settings                  = $this->get_settings_for_display();
		$slider_class              = 'mytravel-' . uniqid();
		$settings['slider__class'] = $slider_class;
		$this->print_slider( $settings );
		$this->render_script( $slider_class );
	}


}
