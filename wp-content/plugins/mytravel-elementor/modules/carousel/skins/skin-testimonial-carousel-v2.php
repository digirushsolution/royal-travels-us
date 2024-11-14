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
class Skin_Testimonial_Carousel_V2 extends Skin_Base {
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
		return 'testimonial-carousel-2';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Skin v2', 'mytravel-elementor' );
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
		$column_md = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 1;
		$column_lg = ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 1;

		$carousel_args = [

			array(
				'breakpoint' => 992,
				'settings'   => [ 'slidesToShow' => $column_lg ],
			),
			array(
				'breakpoint' => 768,
				'settings'   => [ 'slidesToShow' => $column_md ],
			),
			array(
				'breakpoint' => 552,
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

		?><div <?php $widget->print_render_attribute_string( 'slider' ); ?>>
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
	 * Print the Blockquote Image.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_blockquote_image( array $slide, array $settings, $element_key ) {

		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		?>
			<figure class="testimonial-v2">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="21" x="0px" y="0px" viewBox="0 0 30 21" style="enable-background:new 0 0 30 21;" xml:space="preserve" class="injected-svg myt-blockquote-icon js-svg-injector myt-blockquote " data-parent="#quote"><style type="text/css">	.st0{enable-background:new    ;}	.st1{fill:#FFFFFF;}</style><g class="st0">	<path class="st1" d="M5.5,19.4c-1.1-1.8-1.9-3.8-2.3-5.8c-0.4-2-0.4-4-0.1-5.9c0.3-1.9,1-3.8,2-5.6c1-1.8,2.4-3.4,4.2-4.8L12.1-1  c0.5,0.3,0.7,0.7,0.6,1.1c0,0.4-0.2,0.8-0.5,1c-0.5,0.6-1,1.4-1.4,2.3c-0.4,1-0.8,2-0.9,3.2C9.7,7.9,9.8,9.1,10,10.5  c0.2,1.4,0.7,2.7,1.6,4.1c0.4,0.7,0.5,1.3,0.4,1.8c-0.2,0.5-0.6,0.9-1.2,1.1L5.5,19.4z M17.2,19.4c-1.1-1.8-1.9-3.8-2.3-5.8  c-0.4-2-0.4-4-0.1-5.9c0.3-1.9,1-3.8,2-5.6c1-1.8,2.4-3.4,4.2-4.8L23.7-1c0.5,0.3,0.7,0.7,0.6,1.1c0,0.4-0.2,0.8-0.5,1  c-0.5,0.6-1,1.4-1.4,2.3c-0.4,1-0.8,2-0.9,3.2c-0.2,1.2-0.2,2.5,0.1,3.8c0.2,1.4,0.7,2.7,1.6,4.1c0.4,0.7,0.5,1.3,0.3,1.8  c-0.2,0.5-0.6,0.9-1.2,1.1L17.2,19.4z"></path></g></svg>
			</figure>
			<?php
	}

	/**
	 * Print the Blockquote.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_blockquote( array $slide, array $settings, $element_key ) {

		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$text_css = [ 'js-slide blockquote', ' text-gray-1', 'font-italic', 'text-lh-inherit', 'px-xl-20', 'mx-xl-15', 'mx-xl-18' ];
		if ( $settings['blockquote_text_css'] ) {
			$text_css[] = $settings['blockquote_text_css'];
		}
		$widget->add_render_attribute(
			'blockquote-text-' . $element_key,
			[
				'class' => $text_css,
			]
		);
		?>
		<p <?php $widget->print_render_attribute_string( 'blockquote-text-' . $element_key ); ?>><?php echo esc_html( $slide['blockquote'] ); ?></p>
		<?php
	}

	/**
	 * Print the author.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_avatar_image( array $slide, array $settings, $element_key ) {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		$widget->add_render_attribute(
			'avatar-' . $element_key,
			[
				'class'  => 'img-fluid mx-auto rounded-circle ',
				'src'    => $slide['avatar']['url'],
				'alt'    => $slide['name'],
				'width'  => '137',
				'height' => '137',
			]
		);
		?>
		<img <?php $widget->print_render_attribute_string( 'avatar-' . $element_key ); ?>>
		<?php
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

		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		?>
		<div class="d-flex justify-content-center mb-6">
			<div class="position-relative">
				<?php $this->print_avatar_image( $slide, $settings, $element_key ); ?>
				<div class="myt-blockquote btn-position btn btn-icon btn-dark rounded-circle d-flex align-items-center justify-content-center height-60 width-60">
					<?php $this->print_blockquote_image( $slide, $settings, $element_key ); ?>
				</div>
			</div>
		</div>
		<div class="text-center">
		<?php $this->print_blockquote( $slide, $settings, $element_key ); ?>
			<?php $widget->print_author( $slide, $settings, $element_key ); ?>
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

	/**|
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

