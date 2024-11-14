<?php
namespace MyTravelElementor\Modules\ParallaxBanner;

use MyTravelElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Module for Parallax Banner.
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
		return [
			'Parallax_Banner',
		];
	}

	/**
	 * Get Widgets Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-parallax-banner';
	}

	/**
	 * Register frontend script.
	 */
	public function register_scripts() {
		wp_register_script(
			'dzsparallaxer',
			get_template_directory_uri() . '/assets/vendor/dzsparallaxer/dzsparallaxer.js',
			[],
			'5.6.6',
			true
		);
		wp_enqueue_script( 'dzsparallaxer' );

	}
}
