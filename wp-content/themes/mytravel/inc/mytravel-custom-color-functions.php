<?php
/**
 * MyTravel Theme Customizer
 *
 * @package mytravel
 */

if ( ! function_exists( 'mytravel_sass_hex_to_rgba' ) ) {
	/**
	 * Query WooCommerce activation
	 *
	 * @param string $hex The HEX color.
	 * @param string $alpa Alpha.
	 */
	function mytravel_sass_hex_to_rgba( $hex, $alpa = '' ) {
		$hex = sanitize_hex_color( $hex );
		preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches );
		for ( $i = 1; $i <= 3; $i++ ) {
			$matches[ $i ] = hexdec( $matches[ $i ] );
		}
		if ( ! empty( $alpa ) ) {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ', ' . $alpa . ')';
		} else {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ')';
		}
		return $rgb;
	}
}

if ( ! function_exists( 'mytravel_sass_yiq' ) ) {
	/**
	 * Hex color value
	 *
	 * @param string $hex The HEX color.
	 */
	function mytravel_sass_yiq( $hex ) {
		$hex    = sanitize_hex_color( $hex );
		$length = strlen( $hex );
		if ( $length < 5 ) {
			$hex = ltrim( $hex, '#' );
			$hex = '#' . $hex . $hex;
		}

		preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches );

		for ( $i = 1; $i <= 3; $i++ ) {
			$matches[ $i ] = hexdec( $matches[ $i ] );
		}
		$yiq = ( ( $matches[1] * 299 ) + ( $matches[2] * 587 ) + ( $matches[3] * 114 ) ) / 1000;
		return ( $yiq >= 128 ) ? '#000' : '#fff';
	}
}

if ( ! function_exists( 'mytravel_get_theme_colors' ) ) {
	/**
	 * Get all of the mytravel theme colors.
	 *
	 * @return array $mytravel_theme_colors The mytravel Theme Colors.
	 */
	function mytravel_get_theme_colors() {
		$mytravel_theme_colors = array(
			'primary_color' => get_theme_mod( 'mytravel_primary_color', apply_filters( 'mytravel_default_primary_color', '#297cbb' ) ),
			'blue_color'    => get_theme_mod( 'mytravel_blue_color', apply_filters( 'mytravel_default_blue_color', '#045cff' ) ),

		);

		return apply_filters( 'mytravel_get_theme_colors', $mytravel_theme_colors );
	}
}




if ( ! function_exists( 'mytravel_get_custom_color_css' ) ) {
	/**
	 * Get Customizer Color css.
	 *
	 * @see mytravel_get_custom_color_css()
	 * @return array $styles the css
	 */
	function mytravel_get_custom_color_css() {
		$mytravel_theme_colors    = mytravel_get_theme_colors();
		$primary_color            = $mytravel_theme_colors['primary_color'];
		$blue_color               = $mytravel_theme_colors['blue_color'];
		$primary_color_yiq        = mytravel_sass_yiq( $primary_color );
		$primary_color_darken_10p = mytravel_adjust_color_brightness( $primary_color, 10 );
		$blue_color_darken_10p    = mytravel_adjust_color_brightness( $blue_color, 10 );
		// $primary_color_darken_15p  = mytravel_adjust_color_brightness( $primary_color, -5.7 );
		// $primary_color_lighten_20p = mytravel_adjust_color_brightness( $primary_color, 20 );
		// $primary_color_lighten_10p = mytravel_adjust_color_brightness( $primary_color, 27.7 );
		$styles =
		'
/*
 * Primary Color
 */


';

		return apply_filters( 'mytravel_get_custom_color_css', $styles );
	}
}


if ( ! function_exists( 'mytravel_enqueue_custom_color_css' ) ) {
	/**
	 * Add CSS in <head> for styles handled by the theme customizer
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function mytravel_enqueue_custom_color_css() {
		if ( get_theme_mod( 'mytravel_enable_custom_color', 'no' ) === 'yes' ) {
			$mytravel_theme_colors = mytravel_get_theme_colors();

			$primary_color            = $mytravel_theme_colors['primary_color'];
			$blue_color               = $mytravel_theme_colors['blue_color'];
			$primary_color_yiq        = mytravel_sass_yiq( $primary_color );
			$primary_color_darken_10p = mytravel_adjust_color_brightness( $primary_color, 10 ); // #206091
			$primary_color_darken_7p  = mytravel_adjust_color_brightness( $primary_color, 7.5 ); // #22679c
			$primary_color_darken_15p = mytravel_adjust_color_brightness( $primary_color, 15 ); // #1b527c
			$primary_color_darken_12p = mytravel_adjust_color_brightness( $primary_color, 12.8 ); // #1d508d

			$blue_color_darken_10p = mytravel_adjust_color_brightness( $blue_color, 10 ); // #0049d0
			$blue_color_darken_8p  = mytravel_adjust_color_brightness( $blue_color, 8 ); // #0049d0

			$primary_color_opacity   = mytravel_sass_hex_to_rgba( $primary_color, '.35' );
			$primary_color_opacity_5 = mytravel_sass_hex_to_rgba( $primary_color, '0.5' );
			$primary_color_opacity_1 = mytravel_sass_hex_to_rgba( $primary_color, '0.1' );

			$color_root = ':root { --bs-primary: ' . $mytravel_theme_colors['primary_color'] . ';  --bs-primary-hover
			: ' . $primary_color_darken_15p . '; --bs-primary-shadow: ' . $primary_color_opacity . '; --bs-primary-hover-bg
			: ' . $primary_color_darken_7p . '; --bs-primary-hover-border : ' . $primary_color_darken_10p . '; --bs-form-focus-border-color: ' . $primary_color_opacity_5 . '; --bs-form-focus-box-shadow: ' . $primary_color_opacity_1 . '; --bs-tab-nav-pill : ' . $primary_color_darken_12p . '; --bs-blue-color : ' . $blue_color . ';   --bs-blue-hover : ' . $blue_color_darken_10p . '; --bs-blue-hover-bg : ' . $blue_color_darken_8p . '; }';
			$styles     = $color_root . mytravel_get_custom_color_css();

			wp_add_inline_style( 'mytravel-color', $styles );
		}
	}
}


add_action( 'wp_enqueue_scripts', 'mytravel_enqueue_custom_color_css', 130 );
