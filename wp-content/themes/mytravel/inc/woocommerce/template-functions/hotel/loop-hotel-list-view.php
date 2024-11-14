<?php
/**
 * Template Functions used in Hotel List View
 */

if ( ! function_exists( 'mytravel_hotel_loop_list_view_user_rating' ) ) {
	/**
	 *  Output hotel archive list view user rating
	 */
	function mytravel_hotel_loop_list_view_user_rating() {
		global $product;

		$details = mytravel_hotel_get_rating_details();

		if ( $details ) :

			$comments = get_comments(
				array(
					'post_id'    => $product->get_id(),
					'number'     => 1,
					'meta_value' => '5', //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
					'meta_key'   => 'rating', //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				)
			);

			$comment_title = '';

			if ( $comments && isset( $comments[0] ) ) {
				$comment_title = get_comment_meta( $comments[0]->comment_ID, 'comment_title', true );
			}

			?><div class="mb-xl-5 mb-wd-7">
			<div class="mb-0">
				<div class="my-xl-1">
					<div class="d-flex align-items-center justify-content-xl-end mb-2">
						<span class="badge badge-primary rounded-xs font-size-14 p-2 mr-2 mb-0">
						<?php
							echo esc_html( $details['value'] );
						?>
						</span>
						<span class="font-size-17 font-weight-bold text-primary">
						<?php
							echo esc_html( $details['text'] );
						?>
						</span>
					</div>
				</div>
				<span class="font-size-14 text-gray-1">(<?php echo esc_html( $details['reviews'] ); ?>)</span>
			</div>
			<?php

			if ( ! empty( $comment_title ) ) :

				?>
			<span class="font-size-14 pl-xl-2">&quot;<?php echo esc_html( $comment_title ); ?>&quot;</span>
				<?php

			endif;

			?>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_hotel_loop_list_view_price' ) ) {
	/**
	 *  Output hotel archive list view price
	 */
	function mytravel_hotel_loop_list_view_price() {
		?>
		<div class="mb-0">
		<?php
			woocommerce_template_loop_price();
		?>
		</div>
		<?php
	}
}
