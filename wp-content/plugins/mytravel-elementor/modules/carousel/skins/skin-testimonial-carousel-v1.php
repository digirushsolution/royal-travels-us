<?php
namespace MyTravelElementor\Modules\Carousel\Skins;

use Elementor;
use Elementor\Skin_Base;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use MyTravelElementor\Core\Utils as MYT_Utils;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Skin Testimonial Carousel
 */
class Skin_Testimonial_Carousel_V1 extends Skin_Base {
	/**
	 * Fetch the Scripts based on keyword.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'slick-carousel' ];
	}
	/**
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'testimonial-carousel-1';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Skin v1', 'mytravel-elementor' );
	}

	/**
	 * Register Control Actions in the skin.
	 *
	 * @return void
	 */
	protected function _register_controls_actions() {
		add_filter( 'mytravel-elementor/widget/myt-testimonial-carousel/print_template', [ $this, 'skin_print_template' ], 10, 2 );
	}

	/**
	 * Get slider settings
	 *
	 * @param array $settings The widget settings.
	 * @return void
	 */
	protected function print_slider( array $settings = null ) {
		$widget = $this->parent;
		if ( null === $settings ) {
			$settings = $widget->get_settings_for_display();
		}

		$slick_settings = $widget->get_slick_settings( $settings );

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

		$widget->add_render_attribute(
			'slider',
			[
				'class'                    => 'mytravel-carousel js-slick-carousel u-slick u-slick--equal-height u-slick-bordered-primary u-slick--gutters-3 mb-4 pb-1',
				'data-slides-show'         => $column_lg,
				'data-ride'                => 'slick',
				'data-responsive'          => wp_json_encode( $carousel_args ),
				'data-center-mode'         => ( $slick_settings['data-center-mode'] ),
				'data-autoplay'            => ( $slick_settings['data-autoplay'] ),
				'data-autoplay-speed'      => ( $slick_settings['data-autoplay-speed'] ),
				'data-pagi-classes'        => isset( $settings['show_dots'] ) && 'yes' === $settings['show_dots'] ? 'text-center u-slick__pagination mb-0 mt-n6 ' . $settings['dots_class'] : '',
				'data-infinite'            => ( $slick_settings['data-infinite'] ),
				'data-fade'                => ( $slick_settings['data-fade'] ),
				'data-rows'                => ( $slick_settings['data-rows'] ),
				'data-arrows-classes'      => ( $slick_settings['data-arrows-classes'] ),
				'data-arrow-left-classes'  => ( $slick_settings['data-arrow-left-classes'] ),
				'data-arrow-right-classes' => ( $slick_settings['data-arrow-right-classes'] ),

			]
		);

		$widget->add_render_attribute( 'slider', 'class', $settings['slider__class'] );

		?><div <?php $widget->print_render_attribute_string( 'slider' ); ?>>
			<?php foreach ( $settings['slides'] as $slide ) : ?> 
				<div class="js-slide my-10">                                   
					<?php
					$widget->print_slide( $slide, $settings, $slide['_id'] );
					?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}


	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $testimonial_carousel widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $testimonial_carousel ) {

		if ( 'myt-testimonial-carousel' === $testimonial_carousel->get_name() ) {
			return '';
		}

		return $content;
	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$slide_class = 'myt-carousel slide-wrap';

		?>
		<div class="<?php echo esc_attr( $slide_class ); ?>">
		<?php
		$slider_class              = 'mytravel-' . uniqid();
		$settings['slider__class'] = $slider_class;
			$this->print_slider( $settings );
		?>
		</div>
			<?php
			$widget->render_script( $slider_class );

	}
}
