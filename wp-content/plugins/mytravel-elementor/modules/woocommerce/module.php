<?php
namespace MyTravelElementor\Modules\Woocommerce;

use Elementor\Core\Documents_Manager;
use Elementor\Settings;
use MyTravelElementor\Base\Module_Base;
use MyTravelElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Class Module
 */
class Module extends Module_Base {

	const WOOCOMMERCE_GROUP = 'woocommerce';
	/**
	 * Woocommerce is active
	 */
	public static function is_active() {
		return class_exists( 'woocommerce' );
	}
	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-woocommerce';
	}
	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_widgets() {
		return [
			'Products',
		];
	}
	/**
	 * Add product post class
	 *
	 * @param string $classes Product classes.
	 */
	public function add_product_post_class( $classes ) {
		$classes[] = 'product';

		return $classes;
	}
	/**
	 * Add products post class filter
	 */
	public function add_products_post_class_filter() {
		add_filter( 'post_class', [ $this, 'add_product_post_class' ] );
	}
	/**
	 * Remove products post class filter
	 */
	public function remove_products_post_class_filter() {
		remove_filter( 'post_class', [ $this, 'add_product_post_class' ] );
	}
	/**
	 * Register WC hooks
	 */
	public function register_wc_hooks() {
		wc()->frontend_includes();
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		// On Editor - Register WooCommerce frontend hooks before the Editor init.
		// Priority = 5, in order to allow plugins remove/add their wc hooks on init.
		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', [ $this, 'register_wc_hooks' ], 10 );
		}

		$this->add_actions();
	}
	/**
	 * Add actions
	 */
	public function add_actions() {
		add_action( 'elementor/widget/myt-woocommerce-products/skins_init', [ $this, 'init_skins' ], 10 );
	}
	/**
	 * Register skins for the widget.
	 *
	 * @param string $widget Skin.
	 */
	public function init_skins( $widget ) {
		$widget->add_skin( new Skins\Skin_Products_Style_1( $widget ) );
		$widget->add_skin( new Skins\Skin_Products_Style_2( $widget ) );
		$widget->add_skin( new Skins\Skin_Products_Style_3( $widget ) );
		$widget->add_skin( new Skins\Skin_Products_Style_4( $widget ) );
		$widget->add_skin( new Skins\Skin_Products_Style_5( $widget ) );
		$widget->add_skin( new Skins\Skin_Products_Style_6( $widget ) );
	}
}
