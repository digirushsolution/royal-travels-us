<?php
/**
 * Tour ACF Functions
 */

if ( ! function_exists( 'mytravel_get_tour_time_duration' ) ) {
	/**
	 * Get tour time duration.
	 */
	function mytravel_get_tour_time_duration() {
		return mytravel_get_field( 'time_duration' );
	}
}

if ( ! function_exists( 'mytravel_get_tour_itinerary' ) ) {
	/**
	 * Get tour itinerary.
	 */
	function mytravel_get_tour_itinerary() {
		return mytravel_get_field( 'itinerary' );
	}
}


if ( ! function_exists( 'mytravel_tour_time_duration' ) ) {
	/**
	 * Get tour time duration.
	 */
	function mytravel_tour_time_duration() {
		the_field( 'time_duration' );
	}
}
