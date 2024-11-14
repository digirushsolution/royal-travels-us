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
class Hero_Carousel extends Base {
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
		return 'myt-hero-carousel';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Hero Carousel', 'mytravel-elementor' );
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
		return [ 'image', 'hero', 'carousel' ];
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

	}

	/**
	 * Register Style Controls for this widget.
	 *
	 * @return void
	 */
	protected function register_controls() {
		parent::register_controls();
		$this->remove_control( 'slides_per_view' );
		$this->remove_control( 'data_rows' );
		$this->remove_control( 'arrow_position' );

		$this->start_injection(
			[
				'of' => 'slides',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [
					'url' => '',
				],
			]
		);
		$this->end_injection();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
			],
			[
				'bg_image'  => [
					'url' => $placeholder_image_src,
				],
				'title'     => esc_html__( 'United States ', 'mytravel-elementor' ),
				'pre_title' => esc_html__( '£99 / night average', 'mytravel-elementor' ),
			],
			[
				'bg_image'  => [
					'url' => $placeholder_image_src,
				],
				'title'     => esc_html__( 'United States ', 'mytravel-elementor' ),
				'pre_title' => esc_html__( '£99 / night average', 'mytravel-elementor' ),
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

		$this->add_render_attribute( 'wrap_' . $element_key, 'class', [ 'js-slide', 'bg-img-hero-center', 'rounded-xs' ] );

		if ( ! empty( $settings['wrap_css'] ) ) {
			$this->add_render_attribute( 'wrap_' . $element_key, 'class', $settings['wrap_css'] );
		}

		?>
		<div <?php $this->print_render_attribute_string( 'wrap_' . $element_key ); ?> style="background-image: url(<?php echo esc_url( $slide['bg_image']['url'] ); ?> );">
			<div class="space-5"></div>
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
		$column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 1;
		$column_lg = ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 1;

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

		$slick_settings = array(
			'data-center-mode'             => isset( $settings['center_slides'] ) && 'yes' === $settings['center_slides'] ? 1 : 0,
			'data-autoplay'                => isset( $settings['autoplay'] ) && 'yes' === $settings['autoplay'] ? true : false,
			'data-autoplay-speed'          => 'yes' === $settings['autoplay'] && $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 3000,
			'data-pagi-classes'            => isset( $settings['show_dots'] ) && 'yes' === $settings['show_dots'] ? 'text-center u-slick__pagination mt-5 ' . $settings['dots_class'] : '',
			'data-infinite'                => isset( $settings['infinite'] ) && 'yes' === $settings['infinite'] ? true : false,
			'data-fade'                    => isset( $settings['fade'] ) && 'yes' === $settings['fade'] ? true : false,
			'data-rows'                    => isset( $settings['data_rows'] ) ? $settings['data_rows'] : 1,
			'left_arrow_additional_class'  => isset( $settings['arrow_position'] ) && 'inner' === $settings['arrow_position'] ? 'ml-lg-2 ml-xl-9' : '',
			'right_arrow_additional_class' => isset( $settings['arrow_position'] ) && 'inner' === $settings['arrow_position'] ? 'mr-lg-2 mr-xl-9' : '',
			'arrow_additional_class'       => isset( $settings['arrow_position'] ) && 'inner' !== $settings['arrow_position'] ? 'shadow-5' : '',
			'data-arrows-classes'          => isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ? 'elementor-slick-arrow d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-classic--v1 u-slick__arrow-centered--y rounded-circle ' : '',
			'data-arrow-left-classes'      => isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ? 'flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-9' : '',
			'data-arrow-right-classes'     => isset( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ? 'flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-9' : '',
		);

		$this->add_render_attribute(
			'slider',
			[
				'class'                    => 'js-slick-carousel u-slick pb-2 ',
				'data-slides-show'         => 1,
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
