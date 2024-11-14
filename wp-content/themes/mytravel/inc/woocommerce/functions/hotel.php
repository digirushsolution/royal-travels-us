<?php
/**
 * Functions used in Hotel Product Format
 */
function mytravel_get_hotel_archive_view() {
	$view = 'grid-view';
	$view = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'list-view' : 'grid-view';

	return apply_filters( 'mytravel_hotel_archive_view', $view );
}

if ( ! function_exists( 'mytravel_hotel_get_user_rating_text' ) ) {
	/**
	 * Get hotel rating
	 *
	 * @param  float $rating average rating of the product.
	 */
	function mytravel_hotel_get_user_rating_text( $rating ) {
		$ranges      = mytravel_hotel_get_user_rating_guide();
		$rating      = round( $rating, 1 );
		$rating_text = '';

		foreach ( $ranges as $range ) {
			$min = $range['min'];
			$max = $range['max'];

			if ( $rating >= $min && $rating <= $max ) {
				$rating_text = $range['text'];
				break;
			}
		}

		return $rating_text;
	}
}

if ( ! function_exists( 'mytravel_hotel_get_user_rating_guide' ) ) {
	/**
	 *  Get hotel user rating guide
	 */
	function mytravel_hotel_get_user_rating_guide() {
		return apply_filters(
			'mytravel_hotel_guest_rating_guide',
			[
				[
					'text' => esc_html__( 'Exceptional', 'mytravel' ),
					'min'  => 4.5,
					'max'  => 5,
				],
				[
					'text' => esc_html__( 'Excellent', 'mytravel' ),
					'min'  => 4,
					'max'  => 4.5,
				],
				[
					'text' => esc_html__( 'Very Good', 'mytravel' ),
					'min'  => 3.5,
					'max'  => 4,
				],
				[
					'text' => esc_html__( 'Good', 'mytravel' ),
					'min'  => 3,
					'max'  => 3.5,
				],
				[
					'text' => esc_html__( 'Below Expectation', 'mytravel' ),
					'min'  => 0,
					'max'  => 3,
				],
			]
		);
	}
}

if ( ! function_exists( 'mytravel_hotel_get_rating_html' ) ) {
	/**
	 * Get hotel rating
	 *
	 * @param  float $rating average rating of the product.
	 */
	function mytravel_hotel_get_rating_html( $rating ) {
		$html = '';

		if ( 0 < $rating ) {
			/* translators: %s: rating */
			$html = sprintf( esc_html__( '%s/5', 'mytravel' ), number_format( round( $rating, 1 ), 1 ) );
		}

		return apply_filters( 'mytravel_hotel_get_rating_html', $html );
	}
}

if ( ! function_exists( 'mytravel_hotel_get_user_rating' ) ) {
	/**
	 * Get user rating
	 *
	 * @param  float $rating average rating of the product.
	 */
	function mytravel_hotel_get_user_rating( $rating = false ) {
		global $product;

		$user_rating = false;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		if ( false === $rating ) {
			$rating = $product->get_average_rating();
		}

		if ( $rating > 0 ) {
			$user_rating = mytravel_hotel_get_rating_html( $rating );
		}

		return $user_rating;
	}
}

if ( ! function_exists( 'mytravel_hotel_the_user_rating_texts' ) ) {
	/**
	 *  Output hotel user rating texts
	 */
	function mytravel_hotel_the_user_rating() {
		$user_rating = mytravel_hotel_get_user_rating();

		if ( $user_rating ) {
			echo esc_html( $user_rating );
		}
	}
}

if ( ! function_exists( 'mytravel_hotel_the_user_rating_texts' ) ) {
	/**
	 * Get user rating texts
	 *
	 * @param  float $rating average rating of the product.
	 */
	function mytravel_hotel_the_user_rating_text( $rating ) {
		$rating_text = mytravel_hotel_get_user_rating_text( $rating );

		if ( ! empty( $rating_text ) ) {
			echo esc_html( $rating_text );
		}
	}
}

if ( ! function_exists( 'mytravel_hotel_get_rating_details' ) ) {
	/**
	 *  Get hotel rating details
	 */
	function mytravel_hotel_get_rating_details() {
		global $product;

		$details = false;

		if ( wc_review_ratings_enabled() ) {

			$rating       = $product->get_average_rating();
			$review_count = intval( $product->get_review_count() );

			if ( $rating > 0 ) {
				$details['text']  = mytravel_hotel_get_user_rating_text( $rating );
				$details['value'] = mytravel_hotel_get_user_rating( $rating );
				/* translators: %d: total review count */
				$details['reviews'] = sprintf( _n( '%d review', '%d reviews', $review_count, 'mytravel' ), $review_count );
			}
		}

		return $details;
	}
}

if ( ! function_exists( 'mytravel_hotel_group_details_html' ) ) {
	/**
	 * Get hotel group details HTML
	 *
	 * @param string $group Array of text.
	 * @param string $group_key Group key.
	 * @param string $title Group title.
	 * @param bool   $is_flex is enable or not.
	 */
	function mytravel_hotel_group_details_html( $group, $group_key, $title, $is_flex = false ) {
		if ( $group ) {
			?><div class="font-weight-bold text-dark mb-2">
			<?php
				echo esc_html( $title );
			?>
			</div>
			<div class="d-block">
			<?php
			foreach ( $group as $key => $detail ) :
				if ( ! empty( $detail ) ) :

					$field = get_field_object( $group_key . '_' . $key );
					$label = isset( $field['label'] ) ? $field['label'] : '';

					?>
					<div class="mb-2
					<?php
					if ( $is_flex ) :
						?>
						d-flex<?php endif; ?>">
						<div class="text-gray-1 mr-2"><?php echo esc_html( $label ); ?>
																<?php
																if ( $is_flex ) :
																	?>
							:<?php endif; ?></div>
						<div class="text-primary"><?php echo esc_html( $detail ); ?></div>
					</div>
					<?php

					endif;
				endforeach;

			?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_hotel_get_acf_icon_html' ) ) {
	/**
	 * Get hotel icon HTML
	 *
	 * @param int    $term_id taxonamy ID.
	 * @param string $taxonomy taxonamy name.
	 * @param string $icon_additional_class The icon name.
	 * @return string
	 */
	function mytravel_hotel_get_acf_icon_html( $term_id, $taxonomy, $icon_additional_class = '' ) {
		$icon = mytravel_get_field( 'icon_class', $taxonomy . '_' . $term_id );
		$html = '';

		if ( $icon ) {
			if ( ! empty( $icon_additional_class ) ) {
				$icon .= ' ' . $icon_additional_class;
			}
			$html = '<i class="' . esc_attr( $icon ) . '"></i>';
		}

		return apply_filters( 'mytravel_hotel_get_acf_icon_html', $html );
	}
}
