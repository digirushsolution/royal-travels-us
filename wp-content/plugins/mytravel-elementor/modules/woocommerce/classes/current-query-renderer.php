<?php
namespace ElementorPro\Modules\Woocommerce\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Current query render class.
 */
class Current_Query_Renderer extends Base_Products_Renderer {
	/**
	 * Initialise settings.
	 *
	 * @var array
	 */
	private $settings = [];
	/**
	 * Constructor.
	 *
	 * @param string $settings Array of settings.
	 * @param string $type Product type.
	 */
	public function __construct( $settings = [], $type = 'products' ) {
		$this->settings = $settings;
		$this->type = $type;
		$this->attributes = $this->parse_attributes(
			[
				'paginate' => $settings['paginate'],
				'cache' => false,
			]
		);
		$this->query_args = $this->parse_query_args();
	}

	/**
	 * Override the original `get_query_results`
	 * with modifications that:
	 * 1. Remove `pre_get_posts` action if `is_added_product_filter`.
	 *
	 * @return bool|mixed|object
	 */
	protected function get_query_results() {
		$query = $GLOBALS['wp_query'];

		$paginated = ! $query->get( 'no_found_rows' );

		// Check is_object to indicate it's called the first time.
		if ( ! empty( $query->posts ) && is_object( $query->posts[0] ) ) {
			$query->posts = array_map(
				function ( $post ) {
					return $post->ID;
				},
				$query->posts
			);
		}

		$results = (object) array(
			'ids'          => wp_parse_id_list( $query->posts ),
			'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
			'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
			'per_page'     => (int) $query->get( 'posts_per_page' ),
			'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1,
		);

		return $results;
	}
	/**
	 * Parse query args.
	 */
	protected function parse_query_args() {
		$settings = &$this->settings;

		if ( ! is_page( wc_get_page_id( 'shop' ) ) ) {
			$query_args = $GLOBALS['wp_query']->query_vars;
		}
		add_action(
			"woocommerce_shortcode_before_{$this->type}_loop",
			function () {
				wc_set_loop_prop( 'is_shortcode', false );
			}
		);

		if ( 'yes' === $settings['paginate'] ) {
			$page = get_query_var( 'paged', 1 );

			if ( 1 < $page ) {
				$query_args['paged'] = $page;
			}

			if ( 'yes' !== $settings['allow_order'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
				remove_action( 'mytravel_fullwidth_controls', 'woocommerce_catalog_ordering', 10 );

			}

			if ( 'yes' !== $settings['show_result_count'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
				remove_action( 'mytravel_shop_control_bar_title', 'mytravel_wc_product_page_title', 10 );
			}

			if ( 'yes' !== $settings['show_sidebar_toggle'] ) {
				remove_action( 'mytravel_fullwidth_controls', 'mytravel_wc_product_filter_sidebar_toggle', 20 );

			}
		}

		// Always query only IDs.
		$query_args['fields'] = 'ids';

		return $query_args;
	}

}
