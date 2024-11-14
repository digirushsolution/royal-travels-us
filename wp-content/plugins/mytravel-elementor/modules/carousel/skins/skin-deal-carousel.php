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
 * Skin Deal Carousel
 */
class Skin_Deal_Carousel extends Skin_Base {
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
		return 'deal-carousel-v1';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Deal Carousel v1', 'mytravel-elementor' );
	}

	/**
	 * Register Control Actions in the skin.
	 *
	 * @return void
	 */
	protected function _register_controls_actions() {
		add_filter( 'mytravel-elementor/widget/myt-deal-carousel/print_template', [ $this, 'skin_print_template' ], 10, 2 );
	}

	/**
	 * Print the slide.
	 *
	 * @param array $settings the widget settings.
	 * @return void
	 */
	public function print_slide( array $settings ) {
		$widget                = $this->parent;
		$placeholder_image_src = Utils::get_placeholder_image_src();

		foreach ( $settings['slides'] as $slide ) : ?> 
			<div class="js-slide mb-4">
				<?php
				$widget->render_image( $slide, $settings, $slide['_id'] );
				$widget->render_title( $slide, $settings, $slide['_id'] );
				$widget->render_excerpt( $slide, $settings, $slide['_id'] );
				?>
			</div>
			<?php
		endforeach;
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
				'breakpoint' => 1025,
				'settings'   => [ 'slidesToShow' => $column_lg ],
			),
			array(
				'breakpoint' => 992,
				'settings'   => [ 'slidesToShow' => $column_md ],
			),
			array(
				'breakpoint' => 768,
				'settings'   => [ 'slidesToShow' => $column_md ],
			),
			array(
				'breakpoint' => 554,
				'settings'   => [ 'slidesToShow' => $column ],
			),
		];

		$widget->add_render_attribute(
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

		$widget->add_render_attribute( 'slider', 'class', $settings['slider__class'] );
		?>

		<div <?php $widget->print_render_attribute_string( 'slider' ); ?>>
			<?php
			$element_key = 1;
			$this->print_slide( $settings );
			?>
		</div>
		<?php
	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {
		$widget                    = $this->parent;
		$settings                  = $widget->get_settings_for_display();
		$slider_class              = 'mytravel-' . uniqid();
		$settings['slider__class'] = $slider_class;
		$this->print_slider( $settings );
		$widget->render_script( $slider_class );

	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $deal_carousel widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $deal_carousel ) {

		if ( 'myt-deal-carousel' === $deal_carousel->get_name() ) {
			return '';
		}

		return $content;
	}

}
