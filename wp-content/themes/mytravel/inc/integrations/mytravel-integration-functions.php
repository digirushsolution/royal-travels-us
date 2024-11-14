<?php
/**
 * Integration with third-party plugins
 */

/**
 * Query WooCommerce Extension Activation.
 *
 * @param string $extension Extension class name.
 * @return boolean
 */
function mytravel_is_woocommerce_extension_activated( $extension ) {

	if ( mytravel_is_woocommerce_activated() ) {
		$is_activated = class_exists( $extension ) ? true : false;
	} else {
		$is_activated = false;
	}

	return $is_activated;
}

if ( ! function_exists( 'mytravel_is_yith_wcwl_activated' ) ) {
	/**
	 * Yith activation
	 */
	function mytravel_is_yith_wcwl_activated() {
		return mytravel_is_woocommerce_extension_activated( 'YITH_WCWL' );
	}
}

if ( mytravel_is_yith_wcwl_activated() ) {
	require get_template_directory() . '/inc/integrations/yith-wcwl/functions.php';
}
