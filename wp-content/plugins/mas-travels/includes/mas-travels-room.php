<?php
/**
 * Template functions & Hooks related to Rooms
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mas_travels_room_custom_fields_html' ) ) {
	/**
	 * Custom fields HTML
	 *
	 * @param string $room Product.
	 * @param string $hotel Product.
	 */
	function mas_travels_room_custom_fields_html( $room, $hotel ) {
		$room_id      = $room->get_id();
		$max_adults   = mytravel_room_get_max_adults();
		$max_children = mytravel_room_get_max_children();

		?><div class="room-custom-field-wrapper">
			<div class="form-row form-row-wide">
				<label for="guests_adults-<?php echo esc_attr( $room_id ); ?>"><?php esc_html_e( 'Adults', 'mas-travels' ); ?></label>
				<input type="number" id="guests_adults-<?php echo esc_attr( $room_id ); ?>" name="guests_adults" class="form-control" value="<?php echo esc_attr( $max_adults ); ?>" step="1" min="1" data-max="<?php echo esc_attr( $max_adults ); ?>" size="2">
			</div>
			<div class="form-row form-row-wide">
				<label for="guests_children-<?php echo esc_attr( $room_id ); ?>"><?php esc_html_e( 'Children', 'mas-travels' ); ?></label>
				<input type="number" id="guests_children-<?php echo esc_attr( $room_id ); ?>" name="guests_children" class="form-control" value="<?php echo esc_attr( $max_children ); ?>" step="1" min="0" data-max="<?php echo esc_attr( $max_children ); ?>" size="2">
			</div>
			<div class="form-row form-row-wide">
				<label for="hotel_id-<?php echo esc_attr( $room_id ); ?>"><?php esc_html_e( 'Hotel ID', 'mas-travels' ); ?></label>
				<input type="text" id="hotel_id-<?php echo esc_attr( $room_id ); ?>" name="hotel_id"  class="form-control" value="<?php echo esc_attr( $hotel->get_id() ); ?>" readonly>
			</div>
		</div>
		<?php
	}
}

add_action( 'mytravel_before_book_now_button', 'mas_travels_room_custom_fields_html', 30, 2 );

if ( ! function_exists( 'mas_travels_validate_room_custom_fields' ) ) {
	/**
	 *  Validate room vacancy
	 *
	 * @param bool $passed Check vacancy.
	 * @param int  $product_id room id.
	 * @param int  $quantity Number of rooms.
	 */
	function mas_travels_validate_room_custom_fields( $passed, $product_id, $quantity ) {
		/*// phpcs:ignore.
		wc_add_notice( esc_html__( 'We are sorry. This room has reached the maximum occupancy. Please increase the number of rooms or select a different room.', 'mas-travels' ), 'error' );
		return false;*/
		return true;
	}
}

add_filter( 'woocommerce_add_to_cart_validation', 'mas_travels_validate_room_custom_fields', 10, 3 );

if ( ! function_exists( 'mas_travels_add_cart_item_guests_data' ) ) {
	/**
	 *  Room booking dates
	 *
	 * @param array $cart_item_meta Cart meta data.
	 * @param int   $product_id room id.
	 * @param int   $variation_id variation id.
	 * @param int   $quantity Number of rooms.
	 */
	function mas_travels_add_cart_item_guests_data( $cart_item_meta, $product_id, $variation_id, $quantity ) {
		// Use $_REQUEST to allow $_POST and $_GET.
		if ( isset( $_REQUEST ) && ! empty( $product_id ) ) { // phpcs:ignore.
			$post_data = $_REQUEST;// phpcs:ignore.
		} else {
			return $cart_item_meta;
		}

		$_product_id    = empty( $variation_id ) ? $product_id : $variation_id;
		$product        = wc_get_product( $product_id );
		$_product       = wc_get_product( $_product_id );
		$product_format = get_product_format( $product_id );

		if ( 'room' !== get_product_format( $product_id ) || ! isset( $post_data['guests_adults'] ) || ! isset( $post_data['hotel_id'] ) ) {
			return $cart_item_meta;
		}

		$hotel_id = $post_data['hotel_id'];
		$adults   = $post_data['guests_adults'];
		$children = isset( $post_data['guest_children'] ) ? $post_data['guest_children'] : false;

		$cart_item_meta['_hotel_id'] = sanitize_text_field( $hotel_id );
		$cart_item_meta['_adults']   = absint( $adults );

		if ( false !== $children ) {
			$cart_item_meta['_children'] = absint( $children );
		}

		return apply_filters( 'mas_travels_add_cart_item_guests_data', $cart_item_meta );
	}
}

add_filter( 'woocommerce_add_cart_item_data', 'mas_travels_add_cart_item_guests_data', 10, 4 );

add_action( 'manage_product_posts_custom_column', 'mytravel_admin_products_visibility_column_content', 11, 2 );
/**
 *  Display hotel name in column name
 *
 * @param string $column wp_list_table column.
 * @param int    $product_id Product id.
 */
function mytravel_admin_products_visibility_column_content( $column, $product_id ) {
	$product_format = get_product_format() ? get_product_format() : 'standard';
	$acf_activation = function_exists( 'mytravel_is_acf_activated' ) ? mytravel_is_acf_activated() : '';

	if ( 'name' === $column && 'room' === $product_format && $acf_activation ) {

		$hotel_name = mytravel_get_hotel_name();

		if ( $hotel_name ) :
			echo '<strong>';
			echo ' — ' . esc_html( $hotel_name->post_title );
			echo '</strong>';
		endif;
	}
}
