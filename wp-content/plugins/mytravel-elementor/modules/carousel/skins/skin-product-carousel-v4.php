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
class Skin_Product_Carousel_V4 extends Skin_Base {

	/**
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'rental';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Rental', 'mytravel-elementor' );
	}

	/**
	 * Register Control Actions in the skin.
	 *
	 * @return void
	 */
	protected function _register_controls_actions() {
		add_filter( 'mytravel-elementor/widget/myt-product-carousel/print_template', [ $this, 'skin_print_template' ], 10, 2 );
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

		$column        = ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 1;
		$column_md     = ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 2;
		$column_lg     = ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 3;
		$carousel_args = [
			array(
				'breakpoint' => 1025,
				'settings'   => [ 'slidesToShow' => 3 ],
			),
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
				'class'                    => 'js-slick-carousel u-slick u-slick--equal-height u-slick--gutters-3',
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

		$widget->query_posts( $settings );

		/**
		 * Mytravel Elementor posts widget Query args.
		 *
		 * It allows developers to alter individual posts widget queries.
		 *
		 * The dynamic portions of the hook name, `$widget_name` & `$query_id`, refers to the Widget name and Query ID respectively.
		 *
		 * @since 2.1.0
		 *
		 * @param \WP_Query     $wp_query
		 * @param Widget_Base   $this->current_widget
		 */
		$wp_query = $widget->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}
		add_filter( 'mytravel_shop_archive_layout', [ $this, 'mytravel_elementor_get_product_layout' ], 10, 1 );
		$widget->add_render_attribute( 'slider', 'class', $settings['slider__class'] );

		?><div <?php $widget->print_render_attribute_string( 'slider' ); ?>>
			<?php
			while ( $wp_query->have_posts() ) :
				$wp_query->the_post();
				?>
				<div class="js-slide"> 
					<?php
						wc_get_template_part( 'content', 'rental' );
					?>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php
			remove_filter( 'mytravel_shop_archive_layout', [ $this, 'mytravel_elementor_get_product_layout' ], 10, 1 );

	}

	/**|
	 * Render.
	 *
	 * @return void
	 */
	public function render() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$slide_class = 'myt-carousel rental-slide-wrap';
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

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $product_carousel widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $product_carousel ) {

		if ( 'myt-product-carousel' === $product_carousel->get_name() ) {
			return '';
		}

		return $content;
	}

	/**
	 * Get product layout.
	 *
	 * @param string $layout Product layout.
	 */
	public function mytravel_elementor_get_product_layout( $layout ) {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$layout = $settings['_skin'];
		return $layout;
	}
}
