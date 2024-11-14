<?php

if ( ! function_exists( 'mytravel_tour_loop_product_price_wrap' ) ) {
	/**
	 *  Output archive tour product price wrap start
	 */
	function mytravel_tour_loop_product_price_wrap() {
		?><div class="price-wrapper position-absolute bottom-0 left-0 right-0"><div class="px-3 pb-2">
		<?php
	}
}

if ( ! function_exists( 'mytravel_tour_loop_product_price_wrap_end' ) ) {
	/**
	 *  Output archive tour product price wrap end
	 */
	function mytravel_tour_loop_product_price_wrap_end() {
		?>
		</div></div><!-- /.price-wrapper -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_tour_display_location' ) ) {
	/**
	 *  Output archive tour display location
	 */
	function mytravel_wc_template_loop_tour_display_location() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$location = mytravel_get_hotel_location();

		if ( $location ) {
			?>
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="d-block">
				<div class="mb-1 d-flex align-items-center font-size-14 text-gray-1">
					<i class="icon flaticon-pin-1 mr-2 font-size-15"></i>
					<?php
					the_field( 'display_location' );
					?>
				</div>
			</a>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_tour_loop_rating_wrap' ) ) {
	/**
	 *  Output archive tour rating wrap
	 */
	function mytravel_tour_loop_rating_wrap() {
		global $product;
		$count  = $product->get_rating_count();
		$layout = mytravel_get_product_format();

		if ( wc_review_ratings_enabled() ) {
			if ( $count > 0 ) {
				if ( 'yacht' === $layout ) {
					$rating_class = 'font-size-14';
					$wrap_class   = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'mb-3' : 'my-2';
				} else {
					$rating_class = 'font-size-17';
					$wrap_class   = 'my-2';
				}

				?>
				<div class="<?php echo esc_attr( $wrap_class ); ?>">
					<div class="d-inline-flex align-items-center text-lh-1 <?php echo esc_attr( $rating_class ); ?>">
						<?php woocommerce_template_loop_rating(); ?>
					</div>
				</div>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'mytravel_tour_loop_list_view_title' ) ) {
	/**
	 *  Output archive tour list view title
	 */
	function mytravel_tour_loop_list_view_title() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		?>
		<a href="<?php echo esc_url( $link ); ?>" class="mr-xl-5 d-block text-dark">
			<span class="font-weight-bold font-size-17 text-dark d-flex mb-1"><?php the_title(); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'mytravel_tour_loop_product_categories' ) ) {
	/**
	 *  Output archive tour product categories
	 */
	function mytravel_tour_loop_product_categories() {
		mytravel_template_loop_categories();
	}
}

if ( ! function_exists( 'mytravel_wc_template_list_view_tour_time_duration' ) ) {
	/**
	 *  Output archive tour list view time duration
	 */
	function mytravel_wc_template_list_view_tour_time_duration() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$time_duration = mytravel_get_tour_time_duration();

		if ( $time_duration ) {
			?>
			<span class="font-weight-normal font-size-14 text-gray-1">
				<?php mytravel_tour_time_duration(); ?>
			</span>
			<?php
		}
	}
}

