<?php
namespace MyTravelElementor\Modules\Woocommerce\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Base query render class.
 */
abstract class Base_Products_Renderer extends \WC_Shortcode_Products {

	/**
	 * Override original `get_content` that returns an HTML wrapper even if no results found.
	 *
	 * @return string Products HTML
	 */
	public function get_content() {
		$result = $this->get_query_results();

		if ( empty( $result->total ) ) {
			return '';
		}

		return parent::get_content();
	}
	/**
	 * Override original `get_tour_content` that returns an HTML wrapper even if no results found.
	 *
	 * @return string Products HTML
	 */
	public function get_tour_content() {
		$products = $this->get_query_results();
		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $this->attributes['columns'],
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when quering hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					wc_get_template_part( 'content', 'tour' );

					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return ob_get_clean();
	}
	/**
	 * Override original `get_activity_content` that returns an HTML wrapper even if no results found.
	 *
	 * @return string Products HTML
	 */
	public function get_activity_content() {
		$products = $this->get_query_results();
		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $this->attributes['columns'],
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when quering hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					// Render product template.
					wc_get_template_part( 'content', 'activity' );

					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return ob_get_clean();
	}
	/**
	 * Override original `get_rental_content` that returns an HTML wrapper even if no results found.
	 *
	 * @return string Products HTML
	 */
	public function get_rental_content() {
		$products = $this->get_query_results();
		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $this->attributes['columns'],
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when quering hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					// Render product template.
					wc_get_template_part( 'content', 'rental' );

					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return ob_get_clean();
	}
	/**
	 * Override original `get_car_rental_content` that returns an HTML wrapper even if no results found.
	 *
	 * @return string Products HTML
	 */
	public function get_car_rental_content() {
		$products = $this->get_query_results();
		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $this->attributes['columns'],
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when quering hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					// Render product template.
					wc_get_template_part( 'content', 'car_rental' );

					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return ob_get_clean();
	}
	/**
	 * Override original `get_yacht_content` that returns an HTML wrapper even if no results found.
	 *
	 * @return string Products HTML
	 */
	public function get_yacht_content() {
		$products = $this->get_query_results();
		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $this->attributes['columns'],
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when quering hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					// Render product template.
					wc_get_template_part( 'content', 'yacht' );

					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return ob_get_clean();
	}

}
