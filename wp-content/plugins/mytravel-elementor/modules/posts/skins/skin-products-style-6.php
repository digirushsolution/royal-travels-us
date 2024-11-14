<?php

namespace MyTravelElementor\Modules\Posts\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Product Style v6 Skin class.
 */
class Skin_Products_Style_6 extends Skin_Product_Base {
	/**
	 * Get the ID for the skin.
	 */
	public function get_id() {
		return 'yacht';
	}
	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Yacht', 'mytravel-elementor' );
	}

	/**
	 * Print column settings
	 */
	public function print_column() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		$columns  = $settings['columns'];

		return $columns;

	}

	/**
	 * Get elementor layout.
	 *
	 * @param string $layout Product layout.
	 */
	public function mytravel_elementor_get_product_layout( $layout ) {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$layout = $settings['_skin'];
		return $layout;
	}

	/**
	 * Render post.
	 */
	public function render_post() {
		wc_get_template_part( 'content', 'yacht' );
	}

	/**
	 * Render the widget.
	 */
	public function render() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

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
			?>
				<p class="alert alert-warning align-items-center d-flex font-size-xl font-weight-medium justify-content-center p-5">
					<?php esc_html_e( 'No Products Found', 'mytravel-elementor' ); ?>
				</p>
			<?php
			return;
		}

		$this->render_loop_header();

		add_filter( 'mytravel_shop_loop_columns', [ $this, 'print_column' ] );
		add_filter( 'mytravel_shop_archive_layout', [ $this, 'mytravel_elementor_get_product_layout' ], 10, 1 );

		?>
		<div class="mytravel-elementor-products mb-0 list-unstyled products row row-cols-md-6 row-cols-lg-6 row-cols-xl-<?php echo esc_html( $settings['columns'] ); ?>">
			<?php
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				wc_get_template_part( 'content', 'yacht' );
			}
			$this->render_loop_footer();
			wp_reset_postdata();
			wc_reset_loop();

			?>
		</div>
		<?php
		remove_filter( 'mytravel_shop_archive_layout', [ $this, 'mytravel_elementor_get_product_layout' ], 10, 1 );
		remove_filter( 'mytravel_shop_loop_columns', [ $this, 'print_column' ] );
	}
}
