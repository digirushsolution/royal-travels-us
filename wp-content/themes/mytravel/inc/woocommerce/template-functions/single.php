<?php
/**
 * Template functions used in single-product.php
 */

if ( ! function_exists( 'mytravel_single_product_layout' ) ) {
	/**
	 * Get the single product layout.
	 *
	 * @return string
	 */
	function mytravel_single_product_layout() {
		$single_product_layout = mytravel_get_field( 'single_product_layout' );

		if ( ! $single_product_layout ) {
			$single_product_layout = 'v3';
		}

		return apply_filters( 'mytravel_single_product_layout', $single_product_layout );
	}
}

if ( ! function_exists( 'mytravel_output_single_product_wrapper' ) ) {
	/**
	 * Output single product wrapper start
	 */
	function mytravel_output_single_product_wrapper() {
		?><div class="container">
			<div class="mb-4">
				<?php woocommerce_output_all_notices(); ?>
			</div>

			<div class="row">
				<div class="col-lg-8 col-xl-9">
				<?php
	}
}

if ( ! function_exists( 'mytravel_output_single_product_wrapper_end' ) ) {
	/**
	 * Output single product wrapper end
	 */
	function mytravel_output_single_product_wrapper_end() {
		?>
				</div>
				<div class="col-lg-4 col-xl-3">
				<?php

					$product_format = mytravel_get_product_format();

				if ( 'standard' === $product_format || 'room' === $product_format ) {
					do_action( 'mytravel_standard_single_product_sidebar' );
				} else {
					do_action( 'mytravel_single_' . $product_format . '_sidebar' );
				}

				?>
				</div>
			</div><!-- /.row -->
		</div><!-- /.container -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_hotel_badges' ) ) {
	/**
	 * Output hotel badges
	 */
	function mytravel_hotel_badges() {
		$badges_field = mytravel_get_field( 'badges' );

		if ( $badges_field && ! empty( $badges_field ) ) {
			$badges = explode( "\n", $badges_field );

			?>
			<ul class="list-unstyled mb-2 d-md-flex flex-lg-wrap flex-xl-nowrap mb-2">
			<?php

			foreach ( $badges as $badge ) :

				$badge_detail = explode( '|', $badge );
				$badge_text   = trim( isset( $badge_detail[0] ) ? $badge_detail[0] : '' );
				$badge_color  = trim( isset( $badge_detail[1] ) ? $badge_detail[1] : 'maroon' );

				if ( ! empty( $badge_text ) ) :

					$badge_class = 'border-' . $badge_color . ' bg-' . $badge_color;

					?>
				<li class="<?php esc_attr( $badge_class ); ?> border rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 mr-md-2 mb-2 mb-md-0 mb-lg-2 mb-xl-0">
					<span class="font-weight-normal text-white font-size-14"><?php esc_html( $badge_text ); ?></span>
				</li>
					<?php

							endif;

			endforeach;

			?>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_hotel_title' ) ) {
	/**
	 * Output hotel title
	 */
	function mytravel_hotel_title() {
		?>
		<div class="d-block d-md-flex flex-horizontal-center mb-2 mb-md-0">
		<?php

			the_title( '<h1 class="font-size-23 font-weight-bold mb-1">', '</h1>' );

		?>
			<div class="ml-3 font-size-10 letter-spacing-2">
			<?php
				mytravel_gold_star_rating_html( 'fas fa-star', 'green-lighter ml-1' );
			?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_room_title' ) ) {
	/**
	 * Output room title
	 */
	function mytravel_room_title() {
		?>
		<div class="d-block d-md-flex flex-horizontal-center mb-2 mb-md-0">
		<?php

			the_title( '<h1 class="font-size-23 font-weight-bold mb-1">', '</h1>' );

		if ( wc_review_ratings_enabled() ) :
			?>
				<div class="ml-3 font-size-10 text-lh-sm">
				<?php woocommerce_template_loop_rating(); ?>
				</div>
			<?php
			endif;
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_tour_title' ) ) {
	/**
	 * Output tour title
	 */
	function mytravel_tour_title() {
		?>
		<div class="mb-2 mb-md-0">
		<?php
			the_title( '<h4 class="font-size-23 font-weight-bold mb-1 mr-3">', '</h4>' );
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_hotel_location' ) ) {
	/**
	 * Output hotel location
	 */
	function mytravel_hotel_location() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$location = mytravel_get_field( 'display_location' );
		$map      = mytravel_get_field( 'location_map' );

		if ( $location || $map ) :

			?>
		<div class="d-block d-md-flex flex-horizontal-center font-size-14 text-gray-1">
			<?php

			if ( $location ) :

				?>
			<i class="icon flaticon-placeholder mr-2 font-size-20"></i>
				<?php
				echo esc_html( $location );

			endif;

			if ( $map ) :

				?>
			<a href="javascript:;" data-src="#hotel-map" data-speed="700" class="js-fancybox ml-1 d-block d-md-inline"> - <?php echo esc_html__( 'View on map', 'mytravel' ); ?></a>
				<?php

			endif;

			?>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_hotel_map' ) ) {
	/**
	 * Output hotel map
	 */
	function mytravel_hotel_map() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$location = mytravel_get_field( 'location_map' );

		if ( $location ) :

			?>
		<div id="hotel-map" style="display: none; width: 80%; height: 80%;">
			<div class="acf-map" data-zoom="16">
				<div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>" data-lng="<?php echo esc_attr( $location['lng'] ); ?>"></div>
			</div>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_single_hotel_location_map' ) ) {
	/**
	 * Output single hotel location map
	 */
	function mytravel_single_hotel_location_map() {

		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$location = mytravel_get_field( 'location_map' );

		if ( $location ) :

			?>
		<div id="single-hotel__map" class="position-relative border-bottom pt-4 pb-5">
			<h5 class="font-size-21 font-weight-bold text-dark mb-4"><?php echo esc_html__( 'Location', 'mytravel' ); ?></h5>
			<div class="acf-map" data-zoom="14" style="width: 100%; height: 480px;">
				<div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>" data-lng="<?php echo esc_attr( $location['lng'] ); ?>"></div>
			</div>
		</div>
			<?php

		endif;
	}
}


if ( ! function_exists( 'mytravel_single_hotel_sidebar_location_tags' ) ) {
	/**
	 * Output single hotel sidebar location tags
	 */
	function mytravel_single_hotel_sidebar_location_tags() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$tags = mytravel_get_field( 'location_tags' );

		if ( $tags ) {
			?>
			<div class="border border-color-7 rounded p-4 mb-5">
				<h6 class="font-size-17 font-weight-bold text-gray-3 mx-1 mb-3 pb-1"><?php echo esc_html( apply_filters( 'mytravel_single_yacht_location_tag_title', __( 'Why Book With Us?', 'mytravel' ) ) ); ?></h6>
				<?php mytravel_single_hotel_location_tags(); ?>
			</div>
			<?php
		}
	}
}
if ( ! function_exists( 'mytravel_before_single_hotel' ) ) {
	/**
	 * Get single hotel layout
	 */
	function mytravel_before_single_hotel() {
		$layout = mytravel_get_single_hotel_layout();
		do_action( 'mytravel_before_single_hotel_' . $layout );
	}
}

if ( ! function_exists( 'mytravel_before_single_tour' ) ) {
	/**
	 * Get single tour layout
	 */
	function mytravel_before_single_tour() {
		$layout = mytravel_get_single_tour_layout();
		do_action( 'mytravel_before_single_tour_' . $layout );
	}
}

if ( ! function_exists( 'mytravel_before_single_activity' ) ) {
	/**
	 * Get single activity layout
	 */
	function mytravel_before_single_activity() {
		$layout = mytravel_get_single_activity_layout();
		do_action( 'mytravel_before_single_activity_' . $layout );
	}
}

if ( ! function_exists( 'mytravel_before_single_rental' ) ) {
	/**
	 * Get single rental layout
	 */
	function mytravel_before_single_rental() {
		$layout = mytravel_get_single_rental_layout();
		do_action( 'mytravel_before_single_rental_' . $layout );
	}
}

if ( ! function_exists( 'mytravel_before_single_yacht' ) ) {
	/**
	 * Get single yacht layout
	 */
	function mytravel_before_single_yacht() {
		$layout = mytravel_get_single_yacht_layout();
		do_action( 'mytravel_before_single_yacht_' . $layout );
	}
}

if ( ! function_exists( 'mytravel_single_hotel_v3_hooks' ) ) {
	/**
	 * Single hotel v3 hooks
	 */
	function mytravel_single_hotel_v3_hooks() {
		remove_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 3 );
		remove_action( 'mytravel_single_hotel', 'mytravel_single_hotel_gallery', 30 );
		add_action( 'mytravel_single_hotel', 'mytravel_hotel_tabs', 20 );
	}
}

if ( ! function_exists( 'mytravel_single_tour_v1_hooks' ) ) {
	/**
	 * Single tour v1 hooks
	 */
	function mytravel_single_tour_v1_hooks() {
		do_action( 'mytravel_single_tour_v1' );
		remove_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 3 );
	}
}


if ( ! function_exists( 'mytravel_single_tour_v2_hooks' ) ) {
	/**
	 * Single tour v2 hooks
	 */
	function mytravel_single_tour_v2_hooks() {
		add_action( 'mytravel_single_tour', 'mytravel_single_tour_gallery', 30 );
		add_action( 'mytravel_single_tour', 'mytravel_tour_tabs', 40 );

	}
}

if ( ! function_exists( 'mytravel_single_activity_v2_hooks' ) ) {
	/**
	 * Single activity v2 hooks
	 */
	function mytravel_single_activity_v2_hooks() {
		add_action( 'mytravel_single_activity', 'mytravel_single_activity_gallery_2', 30 );
		add_action( 'mytravel_single_activity', 'mytravel_activity_tabs', 40 );

	}
}

if ( ! function_exists( 'mytravel_single_rental_v2_hooks' ) ) {
	/**
	 * Single rental v2 hooks
	 */
	function mytravel_single_rental_v2_hooks() {
		add_action( 'mytravel_single_rental', 'mytravel_single_rental_gallery_v2', 30 );
		add_action( 'mytravel_single_rental', 'mytravel_rental_tabs', 40 );
		add_action( 'mytravel_single_car_rental', 'mytravel_single_rental_gallery_v2', 30 );
		add_action( 'mytravel_single_car_rental', 'mytravel_rental_tabs', 40 );

	}
}

if ( ! function_exists( 'mytravel_single_yacht_v2_hooks' ) ) {
	/**
	 * Single yacht v2 hooks
	 */
	function mytravel_single_yacht_v2_hooks() {
		add_action( 'mytravel_single_yacht', 'mytravel_single_activity_gallery_2', 30 );
		add_action( 'mytravel_single_yacht', 'mytravel_yacht_tabs', 40 );

	}
}

if ( ! function_exists( 'mytravel_single_tour_social_share' ) ) {
	/**
	 *  Mytravel single social share.
	 */
	function mytravel_single_tour_social_share() {

		?>
		<div class="dropdown d-inline-block mytravel-share">
			<a class="height-45 width-45 border rounded border-width-2 flex-content-center bg-transparent" href="#" role="button" data-toggle="dropdown"><i class="flaticon-share font-size-18 text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right py-2">
				<?php
				$services = Mytravel_SocialShare::get_share_services();
				foreach ( $services as $service ) :
					if ( ! isset( $service['share'] ) ) {
						continue; }
					?>
					<a href="<?php echo esc_url( $service['share'] ); ?>" class="dropdown-item px-3" target="_blank" rel="noopener noreferrer">
						<?php if ( isset( $service['icon'] ) ) : ?>
							<i class="dropdown-item-icon <?php echo esc_attr( $service['icon'] ); ?>"></i><?php echo esc_html( $service['name'] ); ?>
						<?php endif; ?>
					</a>
					<?php
				endforeach;
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_booking_reason' ) ) {
	/**
	 *  Mytravel single hotel booking reason.
	 */
	function mytravel_single_hotel_booking_reason() {
		$booking_reason = mytravel_get_field( 'booking_reason' );

		?>
		<div class="border border-color-7 rounded p-4 mb-5">
			<h6 class="font-size-17 font-weight-bold text-gray-3 mx-1 mb-3 pb-1"><?php echo esc_html( apply_filters( 'mytravel_booking_reason_block_title', __( 'Why Book With Us?', 'mytravel' ) ) ); ?></h6>
		</div>
		<?php
	}
}


if ( ! function_exists( 'mytravel_wc_product_summary_wrap_open' ) ) {
	/**
	 *  Single product summary wrap start
	 */
	function mytravel_wc_product_summary_wrap_open() {
		global $product, $post;
		$product    = wc_get_product( $post->ID );
		$price_html = $product->get_price_html();
		?>
		<div class="col-lg-4 col-xl-3">
			<?php
			if ( $price_html ) :
				?>
				<div class="mb-4">
					<div class="border border-color-7 rounded mb-5">
				<?php
			endif;
	}
}

if ( ! function_exists( 'mytravel_wc_product_summary_wrap_close' ) ) {
	/**
	 *  Single product summary wrap end
	 */
	function mytravel_wc_product_summary_wrap_close() {
		global $product, $post;
		$product    = wc_get_product( $post->ID );
		$price_html = $product->get_price_html();
		if ( $price_html ) :
			?>
				</div>
			</div>
			<?php
		endif;
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_product_title_wrap_open' ) ) {
	/**
	 *  Single product title wrap open
	 */
	function mytravel_wc_product_title_wrap_open() {
		?>
		<div class="mb-3">
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_product_title_wrap_close' ) ) {
	/**
	 *  Single product title wrap close
	 */
	function mytravel_wc_product_title_wrap_close() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_show_product_images' ) ) {
	/**
	 *  Single product images
	 */
	function mytravel_show_product_images() {
		wc_get_template( 'single-product/hotel/gallery-v1.php' );

	}
}

if ( ! function_exists( 'mytravel_output_related_products_args' ) ) {
	/**
	 * Output Related Product Args
	 *
	 * @param  array $args Arguments for related products.
	 */
	function mytravel_output_related_products_args( $args ) {

		$args = array(
			'posts_per_page' => 4,
			'columns'        => apply_filters( 'mytravel_related_products_columns', 4 ),
		);
		return $args;
	}
}

if ( ! function_exists( 'mytravel_wc_format_sale_price' ) ) {
	/**
	 * Override sale price HTML
	 *
	 * @param string $price         Price HTML.
	 * @param mixed  $regular_price Regular Price.
	 * @param mixed  $sale_price    Sale Price.
	 */
	function mytravel_wc_format_sale_price( $price, $regular_price, $sale_price ) {
		$price = '<ins class="text-decoration-none">' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del class="font-weight-normal font-size-1">' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
		return $price;
	}
}


if ( ! function_exists( 'mytravel_woocommerce_breadcrumb_wrapper' ) ) {
	/**
	 *  Single product breadcrumb wrapper
	 */
	function mytravel_woocommerce_breadcrumb_wrapper() {
		?>
		<div class="mb-8">
			<?php woocommerce_breadcrumb(); ?>
		</div>
		<?php

	}
}


if ( ! function_exists( 'mytravel_is_wc_single_product_variations' ) ) {
	/**
	 * Returns if a variation when product format is tour
	 */
	function mytravel_is_wc_single_product_variations() {
		$product_format = mytravel_get_product_format();
		$qty_enable     = false;
		if ( 'tour' === $product_format || 'activity' === $product_format ) {
			$qty_enable = true;
		}

		return apply_filters( 'mytravel_is_wc_single_product_variations', $qty_enable );
	}
}

if ( ! function_exists( 'mytravel_toggle_single_product_hooks' ) ) {
	/**
	 * Toggle single product hooks
	 */
	function mytravel_toggle_single_product_hooks() {
		if ( class_exists( 'MAS_Travels' ) ) {
			$product_format = mytravel_get_product_format();
			$tour_layout    = mytravel_get_single_tour_layout();
			$hotel_layout   = mytravel_get_single_hotel_layout();

			add_action( 'woocommerce_before_single_product_0', 'mytravel_woocommerce_breadcrumb_wrapper', 3 );
			add_action( 'woocommerce_before_single_product', 'mytravel_output_single_product_wrapper', 5 );
			add_action( 'woocommerce_after_single_product', 'mytravel_output_single_product_wrapper_end', 10 );

			remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

			add_action( 'woocommerce_before_single_product_summary', 'mytravel_wc_product_title_wrap_open', 10 );
			add_action( 'woocommerce_before_single_product_summary', 'mytravel_single_room_top_badges', 15 );
			add_action( 'woocommerce_before_single_product_summary', 'mytravel_room_title', 20 );
			add_action( 'woocommerce_before_single_product_summary', 'mytravel_wc_product_title_wrap_close', 40 );
			add_action( 'woocommerce_before_single_product_summary', 'mytravel_show_product_images', 50 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

			add_action( 'mytravel_after_single_standard', 'woocommerce_output_related_products', 10 );
			add_action( 'mytravel_after_single_room', 'woocommerce_output_related_products', 10 );

			add_action( 'mytravel_before_add_to_cart_button', 'mas_travels_input_datepicker_wrapper', 10 );
			add_action( 'woocommerce_before_variations_form', 'mas_travels_input_datepicker_wrapper', 10 );

			if ( 'v1' === $tour_layout || 'v3' === $hotel_layout ) {
				remove_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 3 );
			}

			if ( 'standard' === $product_format || 'room' === $product_format ) {
				add_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 4 );
			}
		} else {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			add_action( 'woocommerce_before_single_product_summary', 'mytravel_single_product_container_wrap_start', 1 );
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 2 );

			add_action( 'woocommerce_before_single_product_summary', 'mytravel_single_product_row_wrap_start', 3 );

			add_action( 'woocommerce_before_single_product_summary', 'mytravel_single_product_left_column_wrap_start', 5 );

			add_action( 'woocommerce_before_single_product_summary', 'mytravel_single_product_left_column_wrap_end', 30 );
			add_action( 'woocommerce_before_single_product_summary', 'mytravel_single_product_right_column_wrap_start', 40 );
			add_action( 'woocommerce_single_product_summary', 'mytravel_single_product_right_column_wrap_end', 100 );
			add_action( 'woocommerce_single_product_summary', 'mytravel_single_product_row_wrap_end', 110 );

			add_action( 'woocommerce_after_single_product_summary', 'mytravel_single_product_container_wrap_end', 30 );

			add_action( 'mytravel_after_row_wrap', 'woocommerce_output_related_products' );
		}
	}
}

if ( ! function_exists( 'mytravel_single_product_left_column_wrap_start' ) ) {
	/**
	 * Left column wrap start
	 */
	function mytravel_single_product_left_column_wrap_start() {
		?>
		<div class="col-md-6 col-lg-5 single-product-left-content">
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_left_column_wrap_end' ) ) {
	/**
	 * Left column wrap end
	 */
	function mytravel_single_product_left_column_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_right_column_wrap_start' ) ) {
	/**
	 * Right column wrap start
	 */
	function mytravel_single_product_right_column_wrap_start() {
		?>
		<div class="col-md-6 col-lg-7 single-product-right-content">
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_right_column_wrap_end' ) ) {
	/**
	 * Right column wrap end
	 */
	function mytravel_single_product_right_column_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_row_wrap_start' ) ) {
	/**
	 * Row wrap start
	 */
	function mytravel_single_product_row_wrap_start() {
		?>
		<div class="row mt-0">
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_row_wrap_end' ) ) {
	/**
	 * Row wrap end
	 */
	function mytravel_single_product_row_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_container_wrap_start' ) ) {
	/**
	 * Container wrap start
	 */
	function mytravel_single_product_container_wrap_start() {
		?>
		<div class="container space-y-6">
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_product_container_wrap_end' ) ) {
	/**
	 * Container wrap end
	 */
	function mytravel_single_product_container_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mas_travels_input_datepicker_wrapper' ) ) {
	/**
	 * Date Picker Wrap
	 */
	function mas_travels_input_datepicker_wrapper() {
		global $product;
		$easy_booking        = mytravel_is_wceb_activated();
		$product_is_bookable = $easy_booking ? wceb_is_bookable( $product ) : '';

		if ( ! ( $product->is_type( 'booking' ) || $product_is_bookable ) ) {
			?>
			<div class="mb-4 mytravel-datepicker">
				<div class="d-block text-gray-1 font-weight-normal mb-0 text-left"><?php echo esc_html__( 'Date', 'mytravel' ); ?></div>
				<div class="border-bottom border-width-2 border-color-1">
					<?php
						mytravel_input_datepicker();
					?>
				</div>
			</div>
			<?php
		}
	}
}

require get_template_directory() . '/inc/woocommerce/template-functions/hotel/single-hotel.php';
require get_template_directory() . '/inc/woocommerce/template-functions/hotel/room.php';
require get_template_directory() . '/inc/woocommerce/template-functions/tour/single-tour.php';
require get_template_directory() . '/inc/woocommerce/template-functions/activity/single-activity.php';
require get_template_directory() . '/inc/woocommerce/template-functions/rental/single-rental.php';
require get_template_directory() . '/inc/woocommerce/template-functions/yacht/single-yacht.php';


