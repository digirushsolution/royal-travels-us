<?php
/**
 * Plugin Name: MAS Travels for WooCommerce
 * Plugin URI: https://github.com/madrasthemes/mas-woocommerce-brands
 * Description: Extend your WooCommerce for Hotels, Rooms, Tours, Activities, Rentals, etc.
 * Version: 1.0.18
 * Author: MadrasThemes
 * Author URI: https://madrasthemes.com/
 * Text Domain: mas-travels
 * Domain Path: /languages/
 * WC tested up to: 4.1.0
 *
 * @package MAS_Travels
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'MAS_TRAVELS_PLUGIN_FILE' ) ) {
	define( 'MAS_TRAVELS_PLUGIN_FILE', __FILE__ );
}

add_action( 'widgets_init', 'mytravel_widgets_register' );

/**
 * Required functions
 */
if ( ! function_exists( 'mas_travels_is_woocommerce_active' ) ) {
	/**
	 * Check Woocommerce activated
	 */
	function mas_travels_is_woocommerce_active() {
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ); //phpcs:ignore
	}
}

if ( mas_travels_is_woocommerce_active() ) {
	// Include the main MAS_Travels class.
	if ( ! class_exists( 'MAS_Travels' ) ) {
		include_once dirname( MAS_TRAVELS_PLUGIN_FILE ) . '/includes/class-mas-travels.php';
	}

	/**
	 * Unique access instance for MAS Travels
	 */
	function MAS_Travels() { //phpcs:ignore
		return MAS_Travels::instance();
	}

	// Global for backwards compatibility.
	$GLOBALS['mas_travels'] = MAS_Travels();
}

// Register widgets.
if ( ! function_exists( 'mytravel_widgets_register' ) ) {
	/**
	 * Required widgets
	 */
	function mytravel_widgets_register() {
		if ( class_exists( 'MAS_Travels' ) && mas_travels_is_woocommerce_active() && apply_filters( 'mytravel_woocommerce_enable_widgets', true ) ) {
			// MyTravel Display Product Filter Widget.
			include_once dirname( MAS_TRAVELS_PLUGIN_FILE ) . '/includes/widgets/class-mas-travels-product-filter-widget.php';
			register_widget( 'MAS_Travels_Products_Filter_Widget' );
			include_once dirname( MAS_TRAVELS_PLUGIN_FILE ) . '/includes/widgets/class-mas-travels-widget-layered-nav.php';
			register_widget( 'MAS_Travels_Widget_Layered_Nav' );
			if ( class_exists( 'MyTravel_ACF' ) ) {
				include_once dirname( MAS_TRAVELS_PLUGIN_FILE ) . '/includes/widgets/class-mas-travels-widget-rating-filter.php';
				register_widget( 'MAS_Travels_Widget_Rating_Filter' );
				include_once dirname( MAS_TRAVELS_PLUGIN_FILE ) . '/includes/widgets/class-mas-travels-view-map-widget.php';
				register_widget( 'MAS_Travels_View_Map' );
			}
		}
	}
}
