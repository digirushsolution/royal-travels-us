<?php
/**
 * MyTravel Theme Customizer
 *
 * @package mytravel
 */

/**
 * Mas Static block
 */
function mytravel_static_content_options() {
	if ( mytravel_is_mas_static_content_activated() ) {
		$static_block = array();
		$args         = array(
			'post_type'      => 'mas_static_content',
			'post_status'    => 'publish',
			'limit'          => '-1',
			'posts_per_page' => '-1',
		);

		$static_blocks = get_posts( $args );

		if ( ! empty( $static_blocks ) ) {
			$options = array( '' => esc_html__( '— Select —', 'mytravel' ) );
			foreach ( $static_blocks as $static_block ) {
				$options[ $static_block->ID ] = $static_block->post_title;
			}
		} else {
			$options = array( '' => esc_html__( 'No Static Content Found', 'mytravel' ) );
		}

		return $options;
	}
}
