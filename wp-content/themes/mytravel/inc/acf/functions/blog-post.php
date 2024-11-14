<?php
/**
 * Functions related to post cover image
 */

if ( ! function_exists( 'mytravel_acf_post_cover_image' ) ) {
	/**
	 * Blog post image.
	 */
	function mytravel_acf_post_cover_image() {
		return mytravel_get_field( 'cover_url' );
	}
}
