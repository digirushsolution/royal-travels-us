<?php
/**
 * MyTravel ACF Class
 *
 * @package  mytravel
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyTravel_ACF' ) ) :

	/**
	 * The MyTravel ACF Integration class
	 */
	class MyTravel_ACF {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// $this->includes();
		}
		/**
		 * Include settings.
		 */
		public function includes() {
			if ( function_exists( 'acf_add_local_field_group' ) ) {
				$settings = [ 'hotel-details', 'activity-details', 'car-rental-details', 'color-details', 'icon', 'rental-details', 'room-details', 'tour-details', 'yacht-details', 'blog-post', 'product-category' ];
				foreach ( $settings as $setting ) {
					require get_template_directory() . '/inc/acf/settings/' . $setting . '.php';
				}
			}
		}
	}

endif;

return new MyTravel_ACF();
