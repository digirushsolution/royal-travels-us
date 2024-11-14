<?php

if ( ! function_exists( 'mytravel_hotel_loop_list_view_top_badge' ) ) {
	/**
	 *  Output mytravel single hotel loop list view top badge.
	 */
	function mytravel_hotel_loop_list_view_top_badge() {
		if ( mytravel_is_acf_activated() ) {
			$badge = mytravel_get_hotel_list_view_top_badge();

			if ( $badge ) :

				$post_id = mytravel_get_taxonomy_post_id( $badge );
				$color   = mytravel_get_text_color_atts( 'text-', $badge );
				$bg      = mytravel_get_bg_color_atts( 'badge-', $badge );

				$atts = [
					'class' => 'badge rounded-xs font-size-13 py-1 p-xl-2 mr-2',
				];

				?><span <?php echo wp_kses( mytravel_render_color_attribute_string( $atts, $color, $bg ), 'badge-class' ); ?>><?php echo esc_html( $badge->name ); ?></span>
				<?php

			endif;
		}
	}
}

if ( ! function_exists( 'mytravel_hotel_loop_list_view_title' ) ) {
	/**
	 *  Output mytravel hotel loop list view title
	 */
	function mytravel_hotel_loop_list_view_title() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		?>
		<a href="<?php echo esc_url( $link ); ?>">
			<span class="font-weight-medium font-size-17 text-dark d-flex mb-1"><?php the_title(); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'mytravel_hotel_loop_list_view_location' ) ) {
	/**
	 *  Output hotel loop list view location.
	 */
	function mytravel_hotel_loop_list_view_location() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		$location = mytravel_get_hotel_location();

		if ( $location ) :

			?>
		<a href="<?php echo esc_url( $link ); ?>" class="d-block mb-3">
			<div class="d-flex flex-wrap flex-xl-nowrap align-items-center font-size-14 text-gray-1">
				<i class="icon flaticon-placeholder mr-2 font-size-20"></i> <?php mytravel_the_hotel_location(); ?>
				<small class="px-1 font-size-15"> - </small>
				<span class="text-primary font-size-14"><?php echo esc_html__( 'View on map', 'mytravel' ); ?></span>
			</div>
		</a>
			<?php

		endif;

	}
}

if ( ! function_exists( 'mytravel_hotel_loop_list_view_badges' ) ) {
	/**
	 *  Output hotel loop list view badges.
	 */
	function mytravel_hotel_loop_list_view_badges() {
		if ( mytravel_is_acf_activated() ) {

			$badges = mytravel_get_hotel_list_view_badges();

			if ( $badges ) :

				?>
			<ul class="list-unstyled mb-2 d-md-flex flex-lg-wrap flex-xl-nowrap">
				<?php

				foreach ( $badges as $badge ) :

					?>
				<li class="border border-dark rounded-xs d-flex align-items-center text-lh-1 py-1 px-2 mr-md-2 mb-2 mb-md-0 mb-lg-2 mb-xl-0">
					<span class="font-weight-normal font-size-14 text-nowrap"><?php echo esc_html( $badge->name ); ?></span>
				</li>
					<?php

				endforeach;

				?>
			</ul>
				<?php

			endif;
		}
	}
}

if ( ! function_exists( 'mytravel_hotel_loop_list_view_bottom_badge' ) ) {
	/**
	 *  Output hotel loop list view bottom badge.
	 */
	function mytravel_hotel_loop_list_view_bottom_badge() {
		if ( mytravel_is_acf_activated() ) {

			$field = mytravel_get_hotel_sidebar_badge_field();
			$value = mytravel_get_hotel_sidebar_badge_value();

			if ( $field && isset( $value->name ) ) :

				?>
			<ul class="list-unstyled d-md-flex">
				<li class="border border-green bg-green rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 mb-2 mb-md-0">
					<span class="font-weight-normal font-size-14 text-white"><?php echo esc_html( $field ); ?></span>
				</li>
				<li class="border border-green rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 ml-md-n1 mb-2 mb-md-0">
					<span class="font-weight-normal font-size-14 text-green"><?php echo esc_html( $value->name ); ?></span>
				</li>
			</ul>
				<?php

			endif;
		}
	}
}
