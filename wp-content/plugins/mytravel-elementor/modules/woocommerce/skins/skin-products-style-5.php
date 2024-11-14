<?php

namespace MyTravelElementor\Modules\Woocommerce\Skins;

use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Widget_Base;
use MyTravelElementor\Modules\Woocommerce\Module;
use MyTravelElementor\Modules\Woocommerce\Widgets\Products;
use MyTravelElementor\Modules\Woocommerce\Classes\Products_Renderer;
use ElementorPro\Modules\Woocommerce\Classes\Current_Query_Renderer;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Product Style v1 Skin class.
 */
class Skin_Products_Style_5 extends Skin_Base {
	/**
	 * Get the ID for the skin.
	 */
	public function get_id() {
		return 'car_rental';
	}
	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Style v5', 'mytravel-elementor' );
	}
	/**
	 * Print column settings
	 */
	public function print_column() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		$columns  = $settings['columns'];

		return $columns;

	}

	/**
	 * Get elementor layout.
	 *
	 * @param string $layout Product layout.
	 */
	public function mytravel_elementor_get_product_layout( $layout ) {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$layout = $settings['_skin'];
		return $layout;
	}
	/**
	 * Get shortcode object.
	 *
	 * @param string $settings Product settings.
	 */
	protected function get_shortcode_object( $settings ) {
		if ( 'current_query' === $settings[ Products_Renderer::QUERY_CONTROL_NAME . '_post_type' ] ) {
			$type = 'current_query';
			return new Current_Query_Renderer( $settings, $type );
		}
		$type = 'products';
		return new Products_Renderer( $settings, $type );
	}

	/**
	 * Render the widget.
	 */
	public function render() {
		if ( WC()->session ) {
			wc_print_notices();
		}
		// For Products_Renderer.
		if ( ! isset( $GLOBALS['post'] ) ) {
			$GLOBALS['post'] = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}

		$widget   = $this->parent;
		$settings = $widget->get_settings();
		$columns  = $settings['columns'];

		$shortcode = $this->get_shortcode_object( $settings );
		$content   = $shortcode->get_car_rental_content();
		if ( $content ) {
			echo $content; // phpcs:ignore.
		} elseif ( $widget->get_settings( 'nothing_found_message' ) ) {
			echo '<div class="elementor-nothing-found mytravel-elementorducts-nothing-found">' . esc_html( $widget->get_settings( 'nothing_found_message' ) ) . '</div>';
		}
	}
}


