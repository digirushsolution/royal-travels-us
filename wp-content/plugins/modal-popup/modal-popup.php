<?php
/**
 * Plugin Name: Popup
 * Description: Popup is an Elementor plugin that has a preset dialog box.Custom content will show which has been created by Elementor template. It has also available on page load, on scroll, on exit intent, and on inactivity options.
 * Plugin URI:  https://bestwpdeveloper.com/modal-popup
 * Version:     1.0
 * Author:      Best WP Developer
 * Author URI:  https://wppluginzone.com/
 * Text Domain: bwdmp-modal-popup
 * Elementor tested up to: 3.0.0
 * Elementor Pro tested up to: 3.7.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once ( plugin_dir_path(__FILE__) ) . '/includes/requires-check.php';
function bwdmp_for_wp_template() {
	return \Elementor\Plugin::instance();
}

final class BWDMPModalPopupFinal{

	const VERSION = '1.0';

	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	const MINIMUM_PHP_VERSION = '7.0';

	public function __construct() {

		// Load translation
		add_action( 'bwdmp_init', array( $this, 'bwdmp_loaded_textdomain' ) );

		// bwdmp_init Plugin
		add_action( 'plugins_loaded', array( $this, 'bwdmp_init' ) );
	}

	public function bwdmp_loaded_textdomain() {
		load_plugin_textdomain( 'bwdmp-modal-popup' );
	}

	public function bwdmp_init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', 'bwdmp_admin_notice_missing_main_plugin');
			return;
		}


		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'bwdmp_admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'bwdmp_admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'bwdmp-modal-popup-boots.php' );
	}

	public function bwdmp_admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'bwdmp-modal-popup' ),
			'<strong>' . esc_html__( 'BWD Modal Popup', 'bwdmp-modal-popup' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'bwdmp-modal-popup' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>' . esc_html__('%1$s', 'bwdmp-modal-popup') . '</p></div>', $message );
	}

	public function bwdmp_admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'bwdmp-modal-popup' ),
			'<strong>' . esc_html__( 'BWD Modal Popup', 'bwdmp-modal-popup' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'bwdmp-modal-popup' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>' . esc_html__('%1$s', 'bwdmp-modal-popup') . '</p></div>', $message );
	}

	public function bwdmp_admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'bwdmp-modal-popup' ),
			'<strong>' . esc_html__( 'BWD Modal Popup', 'bwdmp-modal-popup' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'bwdmp-modal-popup' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>' . esc_html__('%1$s', 'bwdmp-modal-popup') . '</p></div>', $message );
	}
}

// Instantiate bwdmp-modal-popup.
new BWDMPModalPopupFinal();
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );