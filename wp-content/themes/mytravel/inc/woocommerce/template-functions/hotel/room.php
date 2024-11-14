<?php
/**
 * Template functions of Room
 */

if ( ! function_exists( 'mytravel_room_badge' ) ) {
	/**
	 *  Output room badge
	 */
	function mytravel_room_badge() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$badge = mytravel_get_field( 'badge' );

		if ( $badge ) :

			$badge_details = explode( '|', $badge );
			$color         = isset( $badge_details[1] ) ? trim( $badge_details[1] ) : 'maroon';
			$class_color   = 'border-' . $color . ' bg-' . $color;

			?><div class="<?php echo esc_attr( $class_color ); ?> border rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 mr-2 mt-2">
			<span class="font-weight-normal text-white font-size-14">
			<?php
				echo esc_html( trim( $badge_details[0] ) );
			?>
			</span>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_room_badge_html' ) ) {
	/**
	 *  Output room badge HTML
	 */
	function mytravel_room_badge_html() {

		ob_start();

		mytravel_room_badge();

		$badge_html = ob_get_clean();

		if ( ! empty( $badge_html ) ) :

			?>
		<div class="position-absolute top-0 right-0 mr-md-1 mt-md-1"><?php echo wp_kses( $badge_html, 'badge-html' ); ?></div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_room_amenities_preview' ) ) {
	/**
	 *  Output room ameniities preview
	 */
	function mytravel_room_amenities_preview() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$area       = mytravel_get_field( 'area' );
		$total_beds = mytravel_get_field( 'total_beds' );
		$amenities  = mytravel_get_field( 'primary_room_amenities' );

		if ( $area || $total_beds || $amenities ) :

			?>
		<ul class="list-unstyled mb-0 row">
			<?php

			if ( $area ) {
				?>
				<li class="col-6 mb-3"><?php mytravel_room_amenity_html( apply_filters( 'mytravel_room_amenities_1', 'flaticon-plans' ), $area ); ?></li>
				<?php
			}

			if ( $total_beds ) {
				?>
				<li class="col-6 mb-3"><?php mytravel_room_amenity_html( apply_filters( 'mytravel_room_amenities_2', 'flaticon-bed-1' ), $total_beds ); ?></li>
				<?php
			}

			if ( $amenities ) {

				foreach ( $amenities as $amenity ) :
					if ( ! is_wp_error( $amenity ) && $amenity ) {
						$term_id  = $amenity->term_id;
						$taxonomy = $amenity->taxonomy;
						$icon     = mytravel_get_field( 'icon_class', $taxonomy . '_' . $term_id );

						?>
							<li class="col-6 mb-3"><?php mytravel_room_amenity_html( $icon, $amenity->name ); ?></li>
						<?php
					}

				endforeach;

			}

			?>
		</ul>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_room_amenity_html' ) ) {
	/**
	 * Display room ameniity HTML
	 *
	 * @param string $icon  Icon name.
	 * @param string $amenity_name  Amenity name.
	 */
	function mytravel_room_amenity_html( $icon, $amenity_name ) {
		?>
		<div class="media text-gray-1">
			<small class="mr-2">
				<i class="<?php echo esc_attr( $icon ); ?> font-size-17 text-primary small"></i>
			</small>
			<div class="media-body font-size-1 ml-1"><?php echo esc_html( $amenity_name ); ?></div>
		</div>
		<?php
	}
}


if ( ! function_exists( 'mytravel_room_photos_and_details' ) ) {
	/**
	 *  Output room photos and details
	 */
	function mytravel_room_photos_and_details() {
		wc_get_template( 'single-product/room/photos-and-details.php' );
	}
}
