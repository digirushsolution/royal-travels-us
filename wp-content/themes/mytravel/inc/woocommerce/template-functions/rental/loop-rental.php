<?php
if ( ! function_exists( 'mytravel_wc_template_loop_rental_display_location' ) ) {
	/**
	 *  Output archive rental display location
	 */
	function mytravel_wc_template_loop_rental_display_location() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$product_format = mytravel_get_product_format();
		$wrap_class     = '';

		if ( 'yacht' === $product_format ) {
			$wrap_class = ' mb-1';
		}
		$location = mytravel_get_hotel_location();

		if ( $location ) {
			?>
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="d-block<?php echo esc_attr( $wrap_class ); ?>">
				<div class="d-flex align-items-center font-size-14 text-gray-1">
					<i class="icon flaticon-pin-1 mr-2 font-size-20"></i>
					<?php
					the_field( 'display_location' );
					?>
				</div>
			</a>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_wc_template_rental_loop_rating' ) ) {
	/**
	 *  Output archive rental rating
	 */
	function mytravel_wc_template_rental_loop_rating() {
		global $product;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		$rating = $product->get_average_rating();

		if ( $rating > 0 ) :

			$review_count = intval( $product->get_review_count() );
			/* translators: %d: total review count */
			$review_html = sprintf( _n( '(%d review)', '(%d reviews)', $review_count, 'mytravel' ), $review_count );

			?>
		<div class="mt-1">
			<span class="py-1 font-size-14 border-radius-3 font-weight-normal pagination-v2-arrow-color">
			<?php
				echo ( esc_html( number_format( round( $rating, 1 ), 1 ) . '/5.0' ) . ' ' . esc_html( mytravel_hotel_get_user_rating_text( $rating ) ) );
			?>
			</span>
			<span class="font-size-14 text-gray-1 ml-2"><?php echo esc_html( $review_html ); ?></span>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_rental_output_card_body_wrapper' ) ) {
	/**
	 *  Output archive rental card body wrapper start
	 */
	function mytravel_rental_output_card_body_wrapper() {

		if ( mytravel_is_acf_activated() ) {
			$location   = mytravel_get_hotel_location();
			$area       = mytravel_get_field( 'area' );
			$total_beds = mytravel_get_field( 'total_beds' );
			$total_bathrooms = mytravel_get_field( 'total_bathrooms' );
			$total_rooms = mytravel_get_field( 'total_rooms' );
			$amenities  = mytravel_get_field( 'primary_room_amenities' );
		}

		if ( ! wc_review_ratings_enabled() || ( mytravel_is_acf_activated() && ! $location ) ) {
			return;
		}

		?>
		<div class="card-body px-4 py-3
		<?php
		if ( mytravel_is_acf_activated() && ( $area || $total_beds || $total_bathrooms || $total_rooms ) ) :
			?>
			border-bottom<?php endif; ?>">
		<?php
	}
}


if ( ! function_exists( 'mytravel_car_rental_output_card_body_wrapper' ) ) {
	/**
	 *  Output archive car rental card body wrapper start
	 */
	function mytravel_car_rental_output_card_body_wrapper() {

		if ( mytravel_is_acf_activated() ) {
			$location        = mytravel_get_hotel_location();
			$distance        = mytravel_get_field( 'distance' );
			$cardinal_points = mytravel_get_field( 'cardinal_points' );
			$fuel            = mytravel_get_field( 'fuel' );
			$event_calendar  = mytravel_get_field( 'event_calendar' );
		}

		if ( ! wc_review_ratings_enabled() || ( mytravel_is_acf_activated() && ! $location ) ) {
			return;
		}

		?>
		<div class="card-body px-4 py-3
		<?php
		if ( mytravel_is_acf_activated() && ( $distance || $cardinal_points || $fuel || $event_calendar ) ) :
			?>
			border-bottom<?php endif; ?>">
		<?php
	}
}


if ( ! function_exists( 'mytravel_rental_list_view_output_card_body_wrapper' ) ) {
	/**
	 *  Output archive rental list view card body wrapper start
	 */
	function mytravel_rental_list_view_output_card_body_wrapper() {

		if ( mytravel_is_acf_activated() ) {
			$location = mytravel_get_hotel_location();
		}

		if ( ! wc_review_ratings_enabled() || ( mytravel_is_acf_activated() && ! $location ) ) {
			return;
		}

		?>
		<div class="card-body p-0 mt-2">
		<?php
	}
}

if ( ! function_exists( 'mytravel_rental_output_card_body_wrapper_end' ) ) {
	/**
	 *  Output archive rental card body wrapper end
	 */
	function mytravel_rental_output_card_body_wrapper_end() {

		if ( mytravel_is_acf_activated() ) {
			$location = mytravel_get_hotel_location();
		}

		if ( ! wc_review_ratings_enabled() || ( mytravel_is_acf_activated() && ! $location ) ) {
			return;
		}

		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_rental_footer_wrapper' ) ) {
	/**
	 *  Output rental footer wrapper
	 */
	function mytravel_rental_footer_wrapper() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$area            = mytravel_get_field( 'area' );
		$total_rooms     = mytravel_get_field( 'total_rooms' );
		$total_bathrooms = mytravel_get_field( 'total_bathrooms' );
		$total_beds      = mytravel_get_field( 'total_beds' );

		if ( $area || $total_beds || $total_rooms || $total_bathrooms ) :
			?>
			<div class="px-4 pt-3 pb-2">
				<?php mytravel_loop_rental_snapshot_preview(); ?>
			</div>
			<?php
		endif;

	}
}

if ( ! function_exists( 'mytravel_car_rental_footer_wrapper' ) ) {
	/**
	 *  Output car rental footer wrapper
	 */
	function mytravel_car_rental_footer_wrapper() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$distance        = mytravel_get_field( 'distance' );
		$cardinal_points = mytravel_get_field( 'cardinal_points' );
		$fuel            = mytravel_get_field( 'fuel' );
		$event_calendar  = mytravel_get_field( 'event_calendar' );

		if ( $distance || $cardinal_points || $fuel || $event_calendar ) :
			?>
			<div class="px-4 pt-3 pb-2">
				<?php mytravel_loop_car_rental_snapshot_preview(); ?>
			</div>
			<?php
		endif;

	}
}

if ( ! function_exists( 'mytravel_rental_loop_list_view_title' ) ) {
	/**
	 *  Output archive rental loop list view title
	 */
	function mytravel_rental_loop_list_view_title() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		?>
		<a href="<?php echo esc_url( $link ); ?>" class="d-block text-dark">
			<span class="font-weight-bold font-size-17 text-dark d-flex"><?php the_title(); ?></span>
		</a>
		<?php
	}
}

