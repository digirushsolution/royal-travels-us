<?php
/**
 * Hotel ACF Functions
 */

if ( ! function_exists( 'mytravel_get_hotel_location' ) ) {
	/**
	 * Get hotel location.
	 */
	function mytravel_get_hotel_location() {
		return mytravel_get_field( 'display_location' );
	}
}

if ( ! function_exists( 'mytravel_get_hotel_location_map' ) ) {
	/**
	 * Get hotel location map
	 */
	function mytravel_get_hotel_location_map() {
		return mytravel_get_field( 'location_map' );
	}
}

if ( ! function_exists( 'mytravel_get_hotel_gold_star_rating' ) ) {
	/**
	 * Get hotel gold star rating
	 */
	function mytravel_get_hotel_gold_star_rating() {
		return mytravel_get_field( 'gold_star_rating' );
	}
}

if ( ! function_exists( 'mytravel_the_hotel_location' ) ) {
	/**
	 * Get hotel location
	 */
	function mytravel_the_hotel_location() {
		the_field( 'display_location' );
	}
}

if ( ! function_exists( 'mytravel_get_hotel_sidebar_badge_field' ) ) {
	/**
	 * Get hotel sidebar badge field
	 */
	function mytravel_get_hotel_sidebar_badge_field() {
		return mytravel_get_field( 'sidebar_badge_sidebar_badge_field' );
	}
}

if ( ! function_exists( 'mytravel_get_hotel_sidebar_badge_value' ) ) {
	/**
	 * Get hotel sidebar badge value
	 */
	function mytravel_get_hotel_sidebar_badge_value() {
		return mytravel_get_field( 'sidebar_badge_sidebar_badge_value' );
	}
}

if ( ! function_exists( 'mytravel_get_hotel_list_view_top_badge' ) ) {
	/**
	 * Get hotel list view top badge
	 */
	function mytravel_get_hotel_list_view_top_badge() {
		return mytravel_get_field( 'list_view_top_badge' );
	}
}

if ( ! function_exists( 'mytravel_get_hotel_list_view_badges' ) ) {
	/**
	 * Get hotel list view badges
	 */
	function mytravel_get_hotel_list_view_badges() {
		return mytravel_get_field( 'list_view_badges' );
	}
}

if ( ! function_exists( 'mytravel_get_single_hotel_top_badges' ) ) {
	/**
	 * Get single hotel top badges
	 */
	function mytravel_get_single_hotel_top_badges() {
		return mytravel_get_field( 'single_hotel_above_title_badges' );
	}
}

if ( ! function_exists( 'mytravel_get_single_room_top_badges' ) ) {
	/**
	 * Get single room top badges
	 */
	function mytravel_get_single_room_top_badges() {
		return mytravel_get_field( 'single_room_above_title_badges' );
	}
}
