<?php
/**
 * Hotel review functions
 */

add_filter( 'woocommerce_product_review_comment_form_args', 'mas_travels_hotel_review_comment_form_args' );
/**
 *  Output hotel review comment form
 *
 * @param string $comment_form Comment form.
 */
function mas_travels_hotel_review_comment_form_args( $comment_form ) {

	$comment_form['comment_field'] = '';

	if ( wc_review_ratings_enabled() ) {

		$rating_options = '<option value="">' . esc_html__( 'Rate&hellip;', 'mas-travels' ) . '</option>
            <option value="5">' . esc_html__( 'Perfect', 'mas-travels' ) . '</option>
            <option value="4">' . esc_html__( 'Good', 'mas-travels' ) . '</option>
            <option value="3">' . esc_html__( 'Average', 'mas-travels' ) . '</option>
            <option value="2">' . esc_html__( 'Not that bad', 'mas-travels' ) . '</option>
            <option value="1">' . esc_html__( 'Very poor', 'mas-travels' ) . '</option>';

		$rating_categories = mas_travels_hotel_get_rating_categories();

		$rating_categories_html = '<div class="row">';

		foreach ( $rating_categories as $key => $rating_category ) {
			$rating_categories_html .= '<div class="col-md-4 mb-6 respond__rating-category"><label class="d-block font-weight-bold text-dark mb-1 h6">' . esc_html( $rating_category ) . '</label><select name="rating_' . $key . '" id="rating_' . $key . '" class="rating_category" required>' . $rating_options . '</select></div>';
		}

		$rating_categories_html .= '</div>';

		$comment_form['comment_field'] = '<div class="mb-6 col-12 comment-form-rating"><label class="d-block font-weight-bold text-dark mb-1 h6" for="rating">' . esc_html__( 'Overall rating', 'mas-travels' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>' . $rating_options . '</select></div><div class="col-12 comment-form-category-rating">' . $rating_categories_html . '</div>';
	}

	$comment_form['comment_field'] .= '<div class="col-sm-12 mb-5 comment-form-title"><label class="sr-only" for="comment-title">' . esc_html__( 'Title', 'mas-travels' ) . '&nbsp;<span class="required">*</span></label><input class="form-control" id="comment-title" placeholder="' . esc_attr__( 'Title', 'mas-travels' ) . '" name="comment_title" required></div>';

	$comment_form['comment_field'] .= '<div class="col-sm-12 mb-5 comment-form-comment"><label class="sr-only" for="comment">' . esc_html__( 'Your review', 'mas-travels' ) . '&nbsp;<span class="required">*</span></label><textarea class="form-control" id="comment" placeholder="' . esc_attr__( 'Your Review', 'mas-travels' ) . '" name="comment" cols="45" rows="8" required></textarea></div>';

	return $comment_form;
}

/**
 *  Get hotel rating categories options
 */
function mas_travels_hotel_get_rating_categories() {
	$rating_categories = apply_filters(
		'mas_travels_hotel_rating_categories',
		[
			'cleanliness' => esc_html__( 'Cleanliness', 'mas-travels' ),
			'facilities'  => esc_html__( 'Facilities', 'mas-travels' ),
			'location'    => esc_html__( 'Location', 'mas-travels' ),
			'service'     => esc_html__( 'Service', 'mas-travels' ),
			'value'       => esc_html__( 'Value for money', 'mas-travels' ),
			'room'        => esc_html__( 'Room comfort and quality', 'mas-travels' ),
		]
	);

	return $rating_categories;
}

/**
 *  Get hotel rating by categories
 */
function mas_travels_hotel_get_rating_by_categories() {
	global $product;

	$categories     = mas_travels_hotel_get_rating_categories();
	$ratings        = [];
	$average_rating = $product->get_average_rating();
	$product_id     = $product->get_id();

	foreach ( $categories as $key => $category ) {
		$rating = get_post_meta( $product_id, '_wc_average_rating_' . $key, true );

		if ( empty( $rating ) ) {
			$rating = $average_rating;
		}

		$ratings[ $key ] = [
			'title'  => $category,
			'rating' => $rating,
		];
	}

	return $ratings;
}

add_action( 'comment_post', 'mas_travels_hotel_add_comment_rating', 5 );

/**
 *  Get hotel comment rating
 *
 *  @param string $comment_id comment id.
 */
function mas_travels_hotel_add_comment_rating( $comment_id ) {
	if ( isset( $_POST['rating'], $_POST['comment_post_ID'] ) && 'product' === get_post_type( absint( $_POST['comment_post_ID'] ) ) ) { // phpcs:ignore.
		if ( ! $_POST['rating'] || $_POST['rating'] > 5 || $_POST['rating'] < 0 ) { // phpcs:ignore.
			return;
		}

		$categories = mas_travels_hotel_get_rating_categories();
		$rating     = intval( $_POST['rating'] );// phpcs:ignore
		$title      = isset( $_POST['comment_title'] ) ? sanitize_text_field( $_POST['comment_title'] ) : ''; // phpcs:ignore.

		foreach ( $categories as $key => $category ) {
			$index = 'rating_' . $key;
			if ( isset( $_POST[ $index ] ) ) { // phpcs:ignore.
				if ( ! ( ! $_POST[ $index ] || $_POST[ $index ] > 5 || $_POST[ $index ] < 0 ) ) { // phpcs:ignore.
					$rating = intval( $_POST[ $index ] ); // phpcs:ignore.
				}
			}

			add_comment_meta( $comment_id, 'rating_' . $key, $rating, true ); // WPCS: input var ok, CSRF ok.
		}

		add_comment_meta( $comment_id, 'comment_title', $title, true );

		$post_id = isset( $_POST['comment_post_ID'] ) ? absint( $_POST['comment_post_ID'] ) : 0; // phpcs:ignore.
		if ( $post_id ) {
			mas_travels_hotel_comment_clear_transients( $post_id );
		}
	}
}

add_action( 'wp_update_comment_count', 'mas_travels_hotel_comment_clear_transients' );

/**
 *  Get hotel comment clear transients
 *
 * @param  string $post_id product id.
 */
function mas_travels_hotel_comment_clear_transients( $post_id ) {
	if ( 'product' === get_post_type( $post_id ) ) {
		$product    = wc_get_product( $post_id );
		$product_id = $product->get_id();
		$categories = mas_travels_hotel_get_rating_categories();

		foreach ( $categories as $key => $category ) {
			$average_rating = mas_travels_get_average_category_rating( $product, $key );
			if ( $average_rating > 0 ) {
				update_post_meta( $product_id, '_wc_average_rating_' . $key, $average_rating );
			}
		}

		$product->save();
	}
}

/**
 *  Get hotel average category rating
 *
 * @param  string $product Global product.
 * @param  string $key Product key.
 */
function mas_travels_get_average_category_rating( $product, $key ) {
	global $wpdb;

	$count = $product->get_rating_count();

	if ( $count ) {
		$ratings = $wpdb->get_var(
			$wpdb->prepare(
				"
            SELECT SUM(meta_value) FROM $wpdb->commentmeta
            LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
            WHERE meta_key = %s
            AND comment_post_ID = %d
            AND comment_approved = '1'
            AND meta_value > 0
                ",
				'rating_' . $key,
				$product->get_id()
			)
		);
		$average = number_format( $ratings / $count, 2, '.', '' );
	} else {
		$average = 0;
	}

	return $average;
}
