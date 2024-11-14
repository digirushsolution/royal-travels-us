<?php
/**
 * Rating Filter Widget and related functions.
 *
 * @package WooCommerce\Widgets
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Widget rating filter class.
 */
class MAS_Travels_Widget_Rating_Filter extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_rating_filter mytravel_widget_gold_rating_filter';
		$this->widget_description = esc_html__( 'Display a list of star ratings to filter products in your store.', 'mas-travels' );
		$this->widget_id          = 'mytravel_rating_filter';
		$this->widget_name        = esc_html__( 'MyTravel Filter Products by Gold Star Rating', 'mas-travels' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Average rating', 'mas-travels' ),
				'label' => esc_html__( 'Title', 'mas-travels' ),
			),
		);
		parent::__construct();
	}

	/**
	 * Count products after other filters have occurred by adjusting the main query.
	 *
	 * @param  int $rating Rating.
	 * @return int
	 */
	protected function get_filtered_product_count( $rating ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		// Unset current rating filter.
		foreach ( $tax_query as $key => $query ) {
			if ( ! empty( $query['rating_filter'] ) ) {
				unset( $tax_query[ $key ] );
				break;
			}
		}

		// Set new rating filter.
		$product_visibility_terms = wc_get_product_visibility_term_ids();
		$tax_query[]              = array(
			'taxonomy'      => 'product_visibility',
			'field'         => 'term_taxonomy_id',
			'terms'         => $product_visibility_terms[ 'rated-' . $rating ],
			'operator'      => 'IN',
			'rating_filter' => true,
		);

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) FROM {$wpdb->posts} ";
		$sql .= $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= " WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$sql .= ' AND ' . $search;
		}

		return absint( $wpdb->get_var( $sql ) ); // WPCS: unprepared SQL ok.
	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		if ( ! WC()->query->get_main_query()->post_count ) {
			return;
		}

		$star_rating = mytravel_get_hotel_gold_star_rating();

		if ( $star_rating ) {
			ob_start();
			$found         = false;
			$rating_filter = isset( $_GET['gold_star_rating'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['gold_star_rating'] ) ) ) ) : array(); //phpcs:ignore
			$base_link     = remove_query_arg( 'paged', $this->get_current_page_url() );

			$this->widget_start( $args, $instance );

			echo '<ul>';
			for ( $rating = 5; $rating >= 1; $rating-- ) {
				$found = true;
				$link  = $base_link;

				if ( in_array( $rating, $rating_filter, true ) ) {
					$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
				} else {
					$link_ratings = implode( ',', array_merge( $rating_filter, array( $rating ) ) );
				}
				$class = in_array( $rating, $rating_filter, true ) ? 'wc-layered-nav-rating chosen' : 'wc-layered-nav-rating';
				$link  = apply_filters( 'woocommerce_rating_filter_link', $link_ratings ? add_query_arg( 'gold_star_rating', $link_ratings, $link ) : remove_query_arg( 'gold_star_rating' ) );

				$rating_html = mytravel_get_gold_star_rating_html( $rating );
				switch ( $rating ) {
					case 5:
						$rating_percentage = 100;
						break;
					case 4:
						$rating_percentage = 80;
						break;
					case 3:
						$rating_percentage = 60;
						break;
					case 2:
						$rating_percentage = 40;
						break;
					case 1:
						$rating_percentage = 20;
						break;
				}
				printf( '<li class="%s"><div class="form-group font-size-14 text-lh-md text-secondary mb-3 flex-center-between"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="' . esc_attr( $rating ) . '" name="gold_star_rating"><a href="%s" class="custom-control-label d-inline-block"><span class="star-rating ml-1 letter-spacing-3"> %s</span></a></div></div></li>', esc_attr( $class ), esc_url( $link ), wp_kses_post( $rating_html ) ); // phpcs:ignore Standard.Category.SniffName.ErrorCode.

			}
			echo '</ul>';
			$this->widget_end( $args );

			if ( ! $found ) {
				ob_end_clean();
			} else {
				echo wp_kses_post( ob_get_clean() ); // phpcs:ignore Standard.Category.SniffName.ErrorCode.
			}
		}
	}
}
