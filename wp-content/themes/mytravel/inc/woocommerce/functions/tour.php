<?php
if ( ! function_exists( 'mytravel_tour_get_acf_icon_html' ) ) {
	/**
	 * Get hotel icon HTML
	 *
	 * @param int    $term_id taxonamy ID.
	 * @param string $taxonomy taxonamy name.
	 * @param string $icon_additional_class The icon name.
	 * @return string
	 */
	function mytravel_tour_get_acf_icon_html( $term_id, $taxonomy, $icon_additional_class = '' ) {
		$icon = mytravel_get_field( 'icon_class', $taxonomy . '_' . $term_id );
		$html = '';

		if ( $icon ) {
			if ( ! empty( $icon_additional_class ) ) {
				$icon .= ' ' . $icon_additional_class;
			}
			$html = '<i class="' . esc_attr( $icon ) . '"></i>';
		}

		return apply_filters( 'mytravel_tour_get_acf_icon_html', $html );
	}
}
