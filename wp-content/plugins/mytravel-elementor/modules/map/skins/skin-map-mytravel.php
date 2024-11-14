<?php

namespace MyTravelElementor\Modules\Map\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Map Skin Mytravel class
 */
class Skin_Map_Mytravel extends Skin_Base {

	/**
	 * Get the ID of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'map-mytravel';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Map Mytravel', 'mytravel-elementor' );
	}

	/**
	 * Register controls for the skin.
	 */
	protected function _register_controls_actions() {
		add_filter( 'mytravel-elementor/widget/google_maps/print_template', [ $this, 'skin_print_template' ], 10, 2 );
	}

	/**
	 * Render the skin in the frontend.
	 */
	public function render() {
		$widget = $this->parent;

		$settings = $widget->get_settings_for_display();

		if ( empty( $settings['address'] ) ) {
			return;
		}

		if ( 0 === absint( $settings['zoom']['size'] ) ) {
			$settings['zoom']['size'] = 10;
		}

		$api_key = esc_html( get_option( 'elementor_google_maps_api_key' ) );

		$params = [
			rawurlencode( $settings['address'] ),
			absint( $settings['zoom']['size'] ),
		];

		if ( $api_key ) {
			$params[] = $api_key;

			$url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
		} else {
			$url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
		}

		?>
		<div class="elementor-custom-embed">
			<iframe 
					src="<?php echo esc_url( vsprintf( $url, $params ) ); ?>"
					title="<?php echo esc_attr( $settings['address'] ); ?>"
					aria-label="<?php echo esc_attr( $settings['address'] ); ?>"
			></iframe>
		</div>
		<?php
	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $widget widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $widget ) {
		if ( 'google_maps' === $widget->get_name() ) {
			return '';
		}
		return $content;
	}
}
