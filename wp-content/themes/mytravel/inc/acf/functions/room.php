<?php
/**
 * Room ACF Functions
 */

if ( ! function_exists( 'mytravel_get_hotel_name' ) ) {
	/**
	 * Get hotel name.
	 */
	function mytravel_get_hotel_name() {
		return mytravel_get_field( 'hotel_name' );
	}
}
