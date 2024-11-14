<?php
/**
 * MyTravel engine room
 *
 * @package mytravel
 */

/**
 * Assign the MyTravel version to a var
 */
$theme            = wp_get_theme( 'mytravel' );
$mytravel_version = $theme['Version'];

/**
 * Define Constants
 */

define( 'MYTRAVEL_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'MYTRAVEL_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

if ( function_exists( 'wpforms' ) ) {
	require get_template_directory() . '/inc/wpforms/class-mytravel-wpforms.php';
}

$mytravel = (object) array(
	'version'    => $mytravel_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require get_template_directory() . '/inc/class-mytravel.php',
	'customizer' => require get_template_directory() . '/inc/customizer/class-mytravel-customizer.php',
);

require get_template_directory() . '/inc/mytravel-functions.php';
require get_template_directory() . '/inc/mytravel-template-hooks.php';
require get_template_directory() . '/inc/mytravel-template-functions.php';
require get_template_directory() . '/inc/wordpress-shims.php';
require get_template_directory() . '/inc/customizer/mytravel-customizer-functions.php';

/**
 * Bootstrap Nav Menu Walker
 */
require get_template_directory() . '/inc/classes/class-wp-bootstrap-navwalker.php';

/**
 * Load Integrations
 */
require get_template_directory() . '/inc/integrations/mytravel-integration-functions.php';

/**
 * Tags and Functions used in Cartzilla
 */

if ( mytravel_is_woocommerce_activated() ) {
	$mytravel->woocommerce            = require get_template_directory() . '/inc/woocommerce/class-mytravel-woocommerce.php';
	$mytravel->woocommerce_customizer = require get_template_directory() . '/inc/woocommerce/class-mytravel-woocommerce-customizer.php';

	require get_template_directory() . '/inc/woocommerce/mytravel-woocommerce-template-hooks.php';
	require get_template_directory() . '/inc/woocommerce/mytravel-woocommerce-template-functions.php';
	require get_template_directory() . '/inc/woocommerce/mytravel-woocommerce-functions.php';
}

/**
 * Query ACF activation
 */
function mytravel_is_acf_activated() {
	return function_exists( 'get_field' ) ? true : false;
}

// Define path and URL to the ACF plugin.

define( 'MY_ACF_PRO_PATH', get_template_directory() . '/inc/acf/acf-pro/pro/' );
define( 'MY_ACF_PATH', get_template_directory() . '/inc/acf/acf-pro/' );
define( 'MY_ACF_PRO_URL', get_template_directory_uri() . '/inc/acf/acf-pro/' );

// Include the ACF plugin.
require_once MY_ACF_PATH . 'acf.php';
require_once MY_ACF_PRO_PATH . 'acf-pro.php';


// Customize the url setting to fix incorrect asset URLs.
add_filter( 'acf/settings/url', 'my_acf_pro_settings_url' );
/**
 * ACF Pro URL
 *
 * @param string $url Url.
 */
function my_acf_pro_settings_url( $url ) {
	return MY_ACF_PRO_URL;
}

// (Optional) Hide the ACF admin menu item.
add_filter( 'acf/settings/show_admin', 'my_acf_pro_settings_show_admin' );

/**
 * ACF Pro settings show in admin panel
 *
 * @param boolean $show_admin Show admin True or False.
 */
function my_acf_pro_settings_show_admin( $show_admin ) {
	return true;
}

/**
 * ACF Integration
 */
require get_template_directory() . '/inc/acf/mytravel-acf-functions.php'; // This should not be placed inside the acf_activated check because of fallback function.
if ( mytravel_is_acf_activated() ) {

	$mytravel->acf = require get_template_directory() . '/inc/acf/class-mytravel-acf.php';
	require get_template_directory() . '/inc/acf/mytravel-acf-hooks.php';
}

if ( is_admin() ) {
	$mytravel->admin = require get_template_directory() . '/inc/admin/class-mytravel-admin.php';

	/**
	 * TGM Plugin Activation class.
	 */
	require get_template_directory() . '/inc/classes/class-tgm-plugin-activation.php';
	$mytravel->plugin_install = require get_template_directory() . '/inc/admin/class-mytravel-plugin-install.php';

	if ( mytravel_is_ocdi_activated() ) {
		$mytravel->ocdi = require get_template_directory() . '/inc/ocdi/class-mytravel-ocdi.php';
	}
}
/**
 * Social Share
 */
require get_template_directory() . '/inc/classes/class-mytravel-socialshare.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
/**
 * Functions used for MyTravel Custom Theme Color
 */
require get_template_directory() . '/inc/mytravel-custom-color-functions.php';



