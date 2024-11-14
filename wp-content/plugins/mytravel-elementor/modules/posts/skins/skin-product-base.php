<?php
namespace MyTravelElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use MyTravelElementor\Plugin;



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The posts skin base
 */
abstract class Skin_Product_Base extends Elementor_Skin_Base {

	/**
	 * Save current permalink to avoid conflict with plugins the filters the permalink during the post render.
	 *
	 * @var string
	 */
	protected $current_permalink;

	/**
	 * Register control actions
	 */
	protected function _register_controls_actions() {
		add_action( 'elementor/element/gk-posts/section_layout/before_section_end', [ $this, 'register_controls' ] );
	}

	/**
	 * Register controls for the skin.
	 *
	 * @param Widget_Base $widget The widget instance.
	 */
	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_post_count_control();
	}

	/**
	 * Register post count control.
	 */
	protected function register_post_count_control() {
		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'mytravel-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);
	}

	/**
	 * The base render class. Just include the render_post inside the skin.
	 */
	public function render() {
		$this->parent->query_posts();

		$query = $this->parent->get_query();

		if ( ! $query->found_posts ) {
			return;
		}
				$this->render_product_control_bar();

		$this->render_loop_header();

		// It's the global `wp_query` it self. and the loop was started from the theme.
		if ( $query->in_the_loop ) {
			$this->current_permalink = get_permalink();
			$this->render_post();
		} else {
			while ( $query->have_posts() ) {
				$query->the_post();

				$this->current_permalink = get_permalink();
				$this->render_post();
			}
		}

		wp_reset_postdata();
		$this->render_loop_footer();

	}

	/**
	 * Get the container class for the loop.
	 */
	public function get_container_class() {
		return 'elementor-posts--skin-' . $this->get_id();
	}

	/**
	 * Render Loop Header
	 */
	protected function render_loop_header() {

		$settings = $this->parent->get_settings_for_display();
		$classes  = [
			'elementor-posts-container',
			'elementor-posts',
			$this->get_container_class(),
		];

		$wp_query = $this->parent->get_query();

		$this->parent->add_render_attribute(
			'container',
			[
				'class' => $classes,
			]
		);
		?>
		<div <?php $this->parent->print_render_attribute_string( 'container' ); ?>>
		<?php
	}

	/**
	 * Render Loop Footer
	 */
	protected function render_loop_footer() {
		?>
		</div>
		<?php
	}

	/**
	 * Render loop post.
	 */
	protected function render_post() {}

	/**
	 * Render products result count.
	 */
	public function render_products_result_count() {

		$this->parent->query_posts();

		$wp_query    = $this->parent->get_query();
		$total       = $wp_query->found_posts;
		$total_pages = $wp_query->max_num_pages;
		$per_page    = $wp_query->get( 'posts_per_page' );
		$current     = max( 1, $wp_query->get( 'paged', 1 ) );
		?>
		<div class="col-12 text-center text-md-left font-size-14 mb-3 text-lh-1">
			<p class="woocommerce-result-count text-dark text-lh-1 mb-0">
				<?php
				// phpcs:disable WordPress.Security
				if ( 1 === intval( $total ) ) {
					_e( 'Showing the single result', 'mytravel-elementor' );
				} elseif ( $total <= $per_page || -1 === $per_page ) {
					/* translators: %d: total results */
					printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'mytravel-elementor' ), $total );
				} else {
					$first = ( $per_page * $current ) - $per_page + 1;
					$last  = min( $total, $per_page * $current );
					/* translators: 1: first result 2: last result 3: total results */
					printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'mytravel-elementor' ), $first, $last, $total );
				}
				// phpcs:enable WordPress.Security
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * Render product control bar.
	 */
	public function render_product_control_bar() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		if ( $settings['enable_shop_control_bar'] ) :
			?>
			<div class="d-md-flex justify-content-md-between mb-md-5 align-items-center">
				
				<div class="d-md-flex">
					<?php
					if ( $settings['enable_sorting'] ) {
						 woocommerce_catalog_ordering();
					}

					?>
				</div>
			</div>
			<?php
		endif;
	}
}
