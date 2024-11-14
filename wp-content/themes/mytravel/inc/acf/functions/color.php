<?php
/**
 * Functions related to color fields
 */

if ( ! function_exists( 'mytravel_get_text_color' ) ) {
	/**
	 * Get text color.
	 *
	 * @param int|bool $post_id ID of the post.
	 * @param bool     $format_value should format the meta value or not.
	 * @return mixed
	 */
	function mytravel_get_text_color( $post_id = false, $format_value = true ) {
		return mytravel_get_field( 'text_color', $post_id, $format_value );
	}
}

if ( ! function_exists( 'mytravel_get_bg_color' ) ) {
	/**
	 * Get bg color.
	 *
	 * @param int|bool $post_id ID of the post.
	 * @param bool     $format_value should format the meta value or not.
	 * @return mixed
	 */
	function mytravel_get_bg_color( $post_id = false, $format_value = true ) {
		return mytravel_get_field( 'background_color', $post_id, $format_value );
	}
}

if ( ! function_exists( 'mytravel_get_bg_color_atts' ) ) {
	/**
	 * Get bg color atts.
	 *
	 * @param string   $prefix Prefix.
	 * @param int|bool $post_id ID of the post.
	 * @param bool     $format_value should format the meta value or not.
	 * @return mixed
	 */
	function mytravel_get_bg_color_atts( $prefix = 'bg-', $post_id = false, $format_value = true ) {
		$color = mytravel_get_bg_color( $post_id, $format_value );
		$atts  = false;

		if ( $color ) {
			if ( $color['bg_pre_defined'] ) {
				$atts = [
					'class' => $prefix . $color['background_color_select'],
				];
			} else {
				$atts = [
					'style' => 'background-color: ' . $color['background_color_picker'] . ';',
				];
			}
		}

		return $atts;
	}
}

if ( ! function_exists( 'mytravel_get_text_color_atts' ) ) {
	/**
	 * Get bg color atts.
	 *
	 * @param string   $prefix Prefix.
	 * @param int|bool $post_id ID of the post.
	 * @param bool     $format_value should format the meta value or not.
	 * @return mixed
	 */
	function mytravel_get_text_color_atts( $prefix = 'text-', $post_id = false, $format_value = true ) {
		$color = mytravel_get_text_color( $post_id, $format_value );
		$atts  = false;

		if ( $color ) {
			if ( $color['color_pre_defined'] ) {
				$atts = [
					'class' => $prefix . $color['text_color_select'],
				];
			} else {
				$atts = [
					'style' => 'color: ' . $color['text_color_picker'] . ';',
				];
			}
		}

		return $atts;
	}
}

if ( ! function_exists( 'mytravel_render_color_attribute_string' ) ) {
	/**
	 * Get color attribute string.
	 *
	 * @param array $atts Attribute.
	 * @param array $color Color name.
	 * @param array $bg Background name.
	 * @return mixed
	 */
	function mytravel_render_color_attribute_string( $atts, $color = array(), $bg = array() ) {

		$class = '';
		$style = '';
		$color = false === $color ? array() : $color;
		$bg    = false === $bg ? array() : $bg;

		if ( isset( $atts['class'] ) ) {
			$class = $atts['class'];
			unset( $atts['class'] );
		}

		if ( isset( $color['class'] ) && ! empty( $color['class'] ) ) {
			$class .= ' ' . $color['class'];
			unset( $color['class'] );
		}

		if ( isset( $bg['class'] ) && ! empty( $bg['class'] ) ) {
			$class .= ' ' . $bg['class'];
			unset( $bg['class'] );
		}

		if ( isset( $atts['style'] ) ) {
			$style = $atts['style'];
			unset( $atts['style'] );
		}

		if ( isset( $color['style'] ) && ! empty( $color['style'] ) ) {
			$style .= ' ' . $color['style'];
			unset( $color['style'] );
		}

		if ( isset( $bg['style'] ) && ! empty( $bg['style'] ) ) {
			$style .= ' ' . $bg['style'];
			unset( $bg['style'] );
		}

		$str_att = '';

		if ( ! empty( $class ) ) {
			$str_att .= ' class="' . esc_attr( trim( $class ) ) . '"';
		}

		if ( ! empty( $style ) ) {
			$str_att .= ' style="' . esc_attr( trim( $style ) ) . '"';
		}

		$arr_att  = array_merge( $atts, $color, $bg );
		$str_att .= ' ' . mytravel_render_html_attributes( $arr_att );
		return $str_att;
	}
}

