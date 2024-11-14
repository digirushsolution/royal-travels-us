<?php

if ( ! function_exists( 'mytravel_yacht_loop_room_snapshot_preview' ) ) {
	/**
	 *  Output archive yacht room amenities perview
	 */
	function mytravel_yacht_loop_room_snapshot_preview() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$area       = mytravel_get_field( 'area' );
		$speed      = mytravel_get_field( 'speed' );
		$total_beds = mytravel_get_field( 'bed' );
		$max_adult  = mytravel_get_field( 'number_of_passengers' );
		$wrap_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? ' d-block' : 'px-4 pt-3 pb-2';

		if ( $area || $speed || $total_beds || $max_adult ) :

			?>            
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<ul class="list-unstyled mb-0 row">
			<?php

			if ( $area ) {
				?>
					<li class="col-6 mb-2"><?php mytravel_yacht_room_amenity_html( apply_filters( 'mytravel_yacht_loop_room_snapshot_1', 'flaticon-ruler' ), $area ); ?></li>
					<?php
			}

			if ( $speed ) {
				?>
					<li class="col-6 mb-2"><?php mytravel_yacht_room_amenity_html( apply_filters( 'mytravel_yacht_loop_room_snapshot_2', 'flaticon-download-speed' ), $speed ); ?></li>
					<?php
			}
			if ( $max_adult ) {
				?>
					<li class="col-6 mb-2"><?php mytravel_yacht_room_amenity_html( apply_filters( 'mytravel_yacht_loop_room_snapshot_3', 'flaticon-user' ), $max_adult ); ?></li>
					<?php
			}

			if ( $total_beds ) {
				?>
					<li class="col-6 mb-2"><?php mytravel_yacht_room_amenity_html( apply_filters( 'mytravel_yacht_loop_room_snapshot_4', 'flaticon-bed-1' ), $total_beds ); ?></li>
					<?php
			}

			?>
			</ul>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_yacht_room_amenity_html' ) ) {
	/**
	 * Display room ameniity HTML
	 *
	 * @param string $icon  Icon name.
	 * @param string $amenity_name  Amenity name.
	 */
	function mytravel_yacht_room_amenity_html( $icon, $amenity_name ) {
		?>
		<div class="media text-gray-1">
			<small class="mr-3">
				<i class="<?php echo esc_attr( $icon ); ?> font-size-16 small"></i>
			</small>
			<div class="media-body font-size-1"><?php echo esc_html( $amenity_name ); ?></div>
		</div>
		<?php
	}
}


if ( ! function_exists( 'mytravel_yacht_output_card_body_wrapper' ) ) {
	/**
	 *  Output archive yacht card body wrapper start
	 */
	function mytravel_yacht_output_card_body_wrapper() {
		if ( mytravel_is_acf_activated() ) {
			$area       = mytravel_get_field( 'area' );
			$speed      = mytravel_get_field( 'speed' );
			$total_beds = mytravel_get_field( 'bed' );
			$max_adult  = mytravel_get_field( 'number_of_passengers' );
			$location   = mytravel_get_hotel_location();
		}

		if ( ! wc_review_ratings_enabled() || ( mytravel_is_acf_activated() && ! $location ) ) {
			return;
		}

		?>
		<div class="card-body px-4 pt-3 pb-2
		<?php
		if ( mytravel_is_acf_activated() && ( $area || $total_beds || $speed || $max_adult ) ) :
			?>
			border-bottom<?php endif; ?>">
		<?php
	}
}

if ( ! function_exists( 'mytravel_yacht_loop_list_view_title' ) ) {
	/**
	 *  Output archive yacht list view title
	 */
	function mytravel_yacht_loop_list_view_title() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		?>
		<a href="<?php echo esc_url( $link ); ?>" class="d-block mb-1 text-dark">
			<span class="font-weight-bold font-size-17 text-dark d-flex mb-1"><?php the_title(); ?></span>
		</a>
		<?php
	}
}
