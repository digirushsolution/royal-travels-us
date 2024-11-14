<?php
/**
 * WooCommerce functions used in MyTravel
 */

if ( ! function_exists( 'mytravel_wc_has_sidebar' ) ) {
	/**
	 *  Get archive sidebar
	 */
	function mytravel_wc_has_sidebar() {
		$has_sidebar = false;
		$sidebar     = mytravel_get_archive_sidebar();

		if ( is_shop() || is_product_category() || ( is_product() && ! class_exists( 'MAS_Travels' ) ) ) {
			if ( is_active_sidebar( 'sidebar-shop' ) && 'no-sidebar' !== $sidebar ) {
				$has_sidebar = true;
			} else {
				$has_sidebar = false;
			}
		}

		return apply_filters( 'mytravel_has_sidebar', $has_sidebar );
	}
}

if ( ! function_exists( 'mytravel_get_golden_star_rating' ) ) {
	/**
	 *  Get golden star rating
	 */
	function mytravel_get_golden_star_rating() {
		if ( mytravel_is_acf_activated() ) {
			$star_rating = mytravel_get_field( 'gold_star_rating' );

			if ( ! $star_rating ) {
				$star_rating = 3;

			}

			return $star_rating;
		}
	}
}
if ( ! function_exists( 'mytravel_format_rating' ) ) {
	/**
	 * Get hotel rating
	 *
	 * @param  float $rating average rating of the product.
	 */
	function mytravel_format_rating( $rating ) {
		return number_format( round( $rating, 1 ), 1 );
	}
}


if ( ! function_exists( 'mytravel_get_shop_archive_layout' ) ) {
	/**
	 *  Get shop archive layout
	 */
	function mytravel_get_shop_archive_layout() {
		$layout = get_theme_mod( 'mytravel_shop_archive_style', 'hotel' );
		return apply_filters( 'mytravel_shop_archive_layout', $layout );
	}
}


if ( ! function_exists( 'mytravel_get_archive_sidebar' ) ) {
	/**
	 *  Get archive sidebar
	 */
	function mytravel_get_archive_sidebar() {
		$archive_sidebar = get_theme_mod( 'product_archive_layout', 'right-sidebar' );

		if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
			$archive_sidebar = 'no-sidebar';
		}

		return sanitize_key( apply_filters( 'mytravel_get_archive_sidebar', $archive_sidebar ) );
	}
}

if ( ! function_exists( 'mytravel_content_product_actions' ) ) {
	/**
	 *  Display content product actions
	 */
	function mytravel_content_product_actions() {

		do_action( 'woocommerce_before_shop_loop_item' );

		do_action( 'woocommerce_before_shop_loop_item_title' );

		do_action( 'woocommerce_shop_loop_item_title' );

		do_action( 'woocommerce_after_shop_loop_item_title' );

		do_action( 'woocommerce_after_shop_loop_item' );

	}
}

if ( ! function_exists( 'mytravel_rental_content_product_actions' ) ) {
	/**
	 *  Display rental content product actions
	 */
	function mytravel_rental_content_product_actions() {

		do_action( 'mytravel_rental_before_shop_loop_item' );

		do_action( 'mytravel_rental_before_shop_loop_item_title' );

		do_action( 'mytravel_rental_shop_loop_item_title' );

		do_action( 'mytravel_rental_after_shop_loop_item_title' );

		do_action( 'mytravel_rental_after_shop_loop_item' );

	}
}

if ( ! function_exists( 'mytravel_car_rental_content_product_actions' ) ) {
	/**
	 *  Display car rental content product actions
	 */
	function mytravel_car_rental_content_product_actions() {

		do_action( 'mytravel_car_rental_before_shop_loop_item' );

		do_action( 'mytravel_car_rental_before_shop_loop_item_title' );

		do_action( 'mytravel_car_rental_shop_loop_item_title' );

		do_action( 'mytravel_car_rental_after_shop_loop_item_title' );

		do_action( 'mytravel_car_rental_after_shop_loop_item' );

	}
}

if ( ! function_exists( 'mytravel_yacht_content_product_actions' ) ) {
	/**
	 *  Display yacht content product actions
	 */
	function mytravel_yacht_content_product_actions() {

		do_action( 'mytravel_yacht_before_shop_loop_item' );

		do_action( 'mytravel_yacht_before_shop_loop_item_title' );

		do_action( 'mytravel_yacht_shop_loop_item_title' );

		do_action( 'mytravel_yacht_after_shop_loop_item_title' );

		do_action( 'mytravel_yacht_after_shop_loop_item' );

	}
}

if ( ! function_exists( 'mytravel_wc_page_header' ) ) {
	/**
	 *  Display page header
	 */
	function mytravel_wc_page_header() {
		if ( ( is_cart() || is_checkout() || is_account_page() ) && class_exists( 'MAS_Travels' ) ) {
			remove_action( 'mytravel_page_before', 'mytravel_page_header', 10 );
		}
	}
}
require get_template_directory() . '/inc/woocommerce/functions/hotel.php';
require get_template_directory() . '/inc/woocommerce/functions/room.php';
require get_template_directory() . '/inc/woocommerce/functions/tour.php';

