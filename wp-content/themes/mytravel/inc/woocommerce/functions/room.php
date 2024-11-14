<?php
/**
 * Functions related to Rooms
 */

if ( ! function_exists( 'mytravel_room_book_now' ) ) {
	/**
	 * Get room type
	 *
	 * @param string $room Product.
	 * @param string $hotel Product.
	 */
	function mytravel_room_book_now( $room, $hotel ) {
		do_action( 'mytravel_room_' . $room->get_type() . '_book_now', $room, $hotel );
	}
}

if ( ! function_exists( 'mytravel_room_simple_book_now' ) ) {
	/**
	 * Simple product add to cart area
	 *
	 * @param string $room Product.
	 * @param string $hotel Product.
	 */
	function mytravel_room_simple_book_now( $room, $hotel ) {
		wc_get_template(
			'single-product/room/book-now/simple.php',
			array(
				'product' => $room,
				'hotel'   => $hotel,
			)
		);
	}
}

if ( ! function_exists( 'mytravel_room_external_book_now' ) ) {
	/**
	 * External product add to cart area
	 *
	 * @param string $room Product.
	 * @param string $hotel Product.
	 */
	function mytravel_room_external_book_now( $room, $hotel ) {
		global $product;

		if ( ! $product->add_to_cart_url() ) {
			return;
		}

		wc_get_template(
			'single-product/room/book-now/external.php',
			array(
				'product_url' => $product->add_to_cart_url(),
				'button_text' => $product->single_add_to_cart_text(),
				'hotel'       => $hotel,
				'room'        => $room,
			)
		);
	}
}

if ( ! function_exists( 'mytravel_room_booking_dates' ) ) {
	/**
	 *  Room booking dates
	 */
	function mytravel_room_booking_dates() {
		?><div class="room-booking-dates">
			<input type="hidden" name="start_date_submit" value="">
			<input type="hidden" name="end_date_submit" value="">
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_room_get_max_adults' ) ) {
	/**
	 *  Get number of adults per room
	 */
	function mytravel_room_get_max_adults() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$max_adults = apply_filters( 'mytravel_room_get_max_adults_default', 2 );
		if ( function_exists( 'get_field_object' ) ) {
			$max_adults_field = get_field_object( 'max_adults' );
			if ( isset( $max_adults_field['default'] ) && ! empty( $max_adults_field['default'] ) ) {
				$max_adults = $max_adults_field['default'];
			}
		}

		$max_adults_acf = mytravel_get_field( 'max_adults' );
		if ( $max_adults_acf ) {
			$max_adults = $max_adults_acf;
		}

		return apply_filters( 'mytravel_room_get_max_adults', $max_adults );
	}
}

if ( ! function_exists( 'mytravel_room_get_max_children' ) ) {
	/**
	 *  Get number of children per room
	 */
	function mytravel_room_get_max_children() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$max_children = apply_filters( 'mytravel_room_get_max_children_default', 2 );
		if ( function_exists( 'get_field_object' ) ) {
			$max_children_field = get_field_object( 'max_children' );
			if ( isset( $max_children_field['default'] ) && ! empty( $max_children_field['default'] ) ) {
				$max_children = $max_children_field['default'];
			}
		}

		$max_children_acf = mytravel_get_field( 'max_children' );
		if ( $max_children_acf ) {
			$max_children = $max_children_acf;
		}

		return apply_filters( 'mytravel_room_get_max_children', $max_children );
	}
}

if ( ! function_exists( 'mytravel_get_max_adults' ) ) {
	/**
	 *  Get number of adults
	 */
	function mytravel_get_max_adults() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$max_adults = apply_filters( 'mytravel_get_max_adults_default', 2 );
		if ( function_exists( 'get_field_object' ) ) {
			$max_adults_field = get_field_object( 'max_adults' );
			if ( isset( $max_adults_field['default'] ) && ! empty( $max_adults_field['default'] ) ) {
				$max_adults = $max_adults_field['default'];
			}
		}

		$max_adults_acf = mytravel_get_field( 'max_adults' );
		if ( $max_adults_acf ) {
			$max_adults = $max_adults_acf;
		}

		return apply_filters( 'mytravel_get_max_adults', $max_adults );
	}
}

if ( ! function_exists( 'mytravel_get_max_children' ) ) {
	/**
	 *  Get number of children
	 */
	function mytravel_get_max_children() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$max_children = apply_filters( 'mytravel_get_max_children_default', 2 );
		if ( function_exists( 'get_field_object' ) ) {
			$max_children_field = get_field_object( 'max_children' );
			if ( isset( $max_children_field['default'] ) && ! empty( $max_children_field['default'] ) ) {
				$max_children = $max_children_field['default'];
			}
		}

		$max_children_acf = mytravel_get_field( 'max_children' );
		if ( $max_children_acf ) {
			$max_children = $max_children_acf;
		}

		return apply_filters( 'mytravel_get_max_children', $max_children );
	}
}

if ( ! function_exists( 'mytravel_get_max_infant' ) ) {
	/**
	 *  Get number of infant
	 */
	function mytravel_get_max_infant() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$max_infant = apply_filters( 'mytravel_get_max_infant_default', 1 );
		if ( function_exists( 'get_field_object' ) ) {
			$max_infant_field = get_field_object( 'max_infant' );
			if ( isset( $max_infant_field['default'] ) && ! empty( $max_infant_field['default'] ) ) {
				$max_infant = $max_infant_field['default'];
			}
		}

		$max_infant_acf = mytravel_get_field( 'max_infant' );
		if ( $max_infant_acf ) {
			$max_infant = $max_infant_acf;
		}

		return apply_filters( 'mytravel_get_max_infant', $max_infant );
	}
}

