<?php
/**
 * Plugin Name: MyTravel Elementor
 * Description: Elementor Extensions built for Mytravel Multipurpose Business WordPress Theme
 * Plugin URI:  https://themeforest.net/user/madrasthemes/portfolio
 * Version:     1.0.18
 * Author:      MadrasThemes
 * Author URI:  https://madrasthemes.com/
 * Text Domain: mytravel-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'MYTRAVEL_ELEMENTOR_VERSION', '0.0.293' );
define( 'MYTRAVEL_ELEMENTOR_PREVIOUS_STABLE_VERSION', '0.0.293' );

define( 'MYTRAVEL_ELEMENTOR__FILE__', __FILE__ );
define( 'MYTRAVEL_ELEMENTOR_PLUGIN_BASE', plugin_basename( MYTRAVEL_ELEMENTOR__FILE__ ) );
define( 'MYTRAVEL_ELEMENTOR_PATH', plugin_dir_path( MYTRAVEL_ELEMENTOR__FILE__ ) );
define( 'MYTRAVEL_ELEMENTOR_ASSETS_PATH', MYTRAVEL_ELEMENTOR_PATH . 'assets/' );
define( 'MYTRAVEL_ELEMENTOR_MODULES_PATH', MYTRAVEL_ELEMENTOR_PATH . 'modules/' );
define( 'MYTRAVEL_ELEMENTOR_INCLUDES_PATH', MYTRAVEL_ELEMENTOR_PATH . 'includes/' );
define( 'MYTRAVEL_ELEMENTOR_TEMPLATES_PATH', MYTRAVEL_ELEMENTOR_PATH . 'templates/' );
define( 'MYTRAVEL_ELEMENTOR_URL', plugins_url( '/', MYTRAVEL_ELEMENTOR__FILE__ ) );
define( 'MYTRAVEL_ELEMENTOR_ASSETS_URL', MYTRAVEL_ELEMENTOR_URL . 'assets/' );
define( 'MYTRAVEL_ELEMENTOR_MODULES_URL', MYTRAVEL_ELEMENTOR_URL . 'modules/' );
define( 'MYTRAVEL_ELEMENTOR_INCLUDES_URL', MYTRAVEL_ELEMENTOR_URL . 'includes/' );

/**
 * Load gettext translate for our text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function mytravel_elementor_load_plugin() {
	load_plugin_textdomain( 'mytravel-elementor' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'mytravel_elementor_fail_load' );

		return;
	}

	$elementor_version_required = '3.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'mytravel_elementor_fail_load_out_of_date' );

		return;
	}

	$elementor_version_recommendation = '3.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_recommendation, '>=' ) ) {
		add_action( 'admin_notices', 'mytravel_elementor_admin_notice_upgrade_recommendation' );
	}

	require MYTRAVEL_ELEMENTOR_PATH . 'plugin.php';
}

add_action( 'plugins_loaded', 'mytravel_elementor_load_plugin' );

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function mytravel_elementor_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message  = '<p>' . esc_html__( 'My Travel Elementor is not working because you need to activate the Elementor plugin.', 'mytravel-elementor' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'mytravel-elementor' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

		$message  = '<p>' . esc_html__( 'My Travel Elementor is not working because you need to install the Elementor plugin.', 'mytravel-elementor' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'mytravel-elementor' ) ) . '</p>';
	}
	echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
}

/**
 * Display a message when using out of date Elementor.
 */
function mytravel_elementor_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message      = '<p>' . esc_html__( 'My Travel Elementor is not working because you are using an old version of Elementor.', 'mytravel-elementor' ) . '</p>';
	$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, esc_html__( 'Update Elementor Now', 'mytravel-elementor' ) ) . '</p>';

	echo '<div class="error">' . wp_kses_post( $message ) . '</div>';
}

/**
 * Display update Elementor notice.
 */
function mytravel_elementor_admin_notice_upgrade_recommendation() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message      = '<p>' . esc_html__( 'A new version of Elementor is available. For better performance and compatibility of My Travel Elementor, we recommend updating to the latest version.', 'mytravel-elementor' ) . '</p>';
	$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, esc_html__( 'Update Elementor Now', 'mytravel-elementor' ) ) . '</p>';

	echo '<div class="error">' . wp_kses_post( $message ) . '</div>';
}


if ( ! function_exists( '_is_elementor_installed' ) ) {
	/**
	 * Check if Elementor is installed.
	 *
	 * @return bool
	 */
	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function mytravel_elementor_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'mytravel_elementor_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}
