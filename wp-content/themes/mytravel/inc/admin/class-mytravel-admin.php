<?php
/**
 * Mytravel Admin Class
 *
 * @package  mytravel
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Mytravel_Admin' ) ) :
	/**
	 * The Silicon admin class
	 */
	class Mytravel_Admin {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {}
	}

endif;

return new Mytravel_Admin();
