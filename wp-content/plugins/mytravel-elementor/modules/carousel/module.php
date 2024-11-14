<?php
namespace MyTravelElementor\Modules\Carousel;

use MyTravelElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Module for Carousel
 */
class Module extends Module_Base {

	/**
	 * Instantiate the class.
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'register_scripts' ] );
	}

	/**
	 * Get Widgets.
	 *
	 * @return array
	 */
	public function get_widgets() {
		$widgets = [
			'Deal_Carousel',
			'Testimonial_Carousel',
			'Destination_Carousel',
			'Hero_Carousel',

		];

		if ( function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated() ) {
			$widgets[] = 'Product_Carousel';
		}

		return $widgets;

	}

	/**
	 * Get Widgets Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'carousel';
	}

	/**
	 * Register frontend script.
	 */
	public function register_scripts() {
		wp_register_script(
			'slick-carousel',
			get_template_directory_uri() . '/assets/vendor/slick-carousel/slick/slick.js',
			get_template_directory_uri() . '/assets/js/components/hs.slick-carousel.js',
			[],
			'1.30',
			true
		);
	}
}
