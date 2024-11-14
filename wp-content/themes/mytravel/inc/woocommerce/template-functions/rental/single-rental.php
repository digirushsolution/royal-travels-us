<?php
/**
 * Template functions used in Single Rental v1
 */
function mytravel_get_single_rental_layout() {
	if ( ! mytravel_is_acf_activated() ) {
		return;
	}

	$layout = mytravel_get_field( 'rental_layout' );
	$layout = $layout ? $layout : 'v1';
	return apply_filters( 'mytravel_get_single_rental', $layout );
}


if ( ! function_exists( 'mytravel_single_rental_gallery_v1' ) ) {
	/**
	 *  Output of hotel v3 gallery
	 */
	function mytravel_single_rental_gallery_v1() {
		remove_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 1 );
		woocommerce_breadcrumb();
		wc_get_template( 'single-product/hotel/gallery-v3.php' );
	}
}

if ( ! function_exists( 'mytravel_single_rental_gallery_v2' ) ) {
	/**
	 *  Output of rental v2 gallery
	 */
	function mytravel_single_rental_gallery_v2() {
		wc_get_template( 'single-product/tour/gallery-v2.php' );
	}
}

if ( ! function_exists( 'mytravel_wc_template_single_rental_rating' ) ) {
	/**
	 *  Output of single rental rating
	 */
	function mytravel_wc_template_single_rental_rating() {
		global $product;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		$rating = $product->get_average_rating();

		if ( $rating > 0 ) :

			$review_count = intval( $product->get_review_count() );
			/* translators: %d: total review count */
			$review_html = sprintf( _n( '%d review', '%d reviews', $review_count, 'mytravel' ), $review_count );

			?>
			<a href="#reviews">
				<span class="font-size-14 text-primary mr-2">
				<?php
					echo ( esc_html( number_format( round( $rating, 1 ), 1 ) . '/5.0' ) . ' ' . esc_html( mytravel_hotel_get_user_rating_text( $rating ) ) );
				?>
				</span>
				<span class="font-size-14 text-gray-1 ml-1"><?php echo esc_html( $review_html ); ?></span>
			</a>
			<?php

		endif;
	}
}


if ( ! function_exists( 'mytravel_single_rental_header' ) ) {
	/**
	 *  Output of single renatl header
	 */
	function mytravel_single_rental_header() {

		?>
		<div class="d-block d-md-flex flex-center-between align-items-start mb-3">
			<div class="mb-3">
				<div class="d-block d-md-flex flex-horizontal-center">
					<?php
					mytravel_tour_title();
					mytravel_wc_template_single_rental_rating();
					?>
				</div>
				<?php mytravel_hotel_location(); ?>
			</div>
			<?php mytravel_social_share_action_buttons(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_rental_tabs' ) ) {
	/**
	 *  Output of rental tabs
	 */
	function mytravel_rental_tabs() {
		$rental_tabs = apply_filters( 'mytravel_rental_tabs', array() );

		?>
		<div id="stickyBlockStartPointTabs" class="mb-4">
			<div class="border rounded-pill js-sticky-block p-1 border-width-2 z-index-4 bg-white"
			data-parent="#stickyBlockStartPointTabs"
			data-offset-target="#header"
			data-sticky-view="lg"
			data-start-point="#stickyBlockStartPointTabs"
			data-end-point="#stickyBlockEndPointReviews"
			data-offset-top="30"
			data-offset-bottom="30">
				<ul class="js-scroll-nav nav tab-nav-pill flex-nowrap tab-nav">
				<?php

					$i = 0;
				foreach ( $rental_tabs as $key => $tab ) :
					$i++;
					?>
					<li class="text-nowrap nav-item
					<?php
					if ( 1 === $i ) {
						echo esc_attr( ' active' );
					}
					?>
					">
						<a class="nav-link font-weight-medium" href="#single-hotel__<?php echo esc_attr( $key ); ?>">
							<div class="d-flex flex-column flex-md-row position-relative text-dark align-items-center">
								<span class="tabtext font-weight-semi-bold"><?php echo esc_html( $tab['title'] ); ?></span>
							</div>
						</a>
					</li>
					<?php

				endforeach;

				?>
				</ul>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_default_rental_tabs' ) ) {

	/**
	 * Add default rental tabs to rental pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function mytravel_default_rental_tabs( $tabs = array() ) {
		global $product, $post;

		$product_format = mytravel_get_product_format();

		// Description tab - shows product content.
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => esc_html__( 'Description', 'mytravel' ),
				'priority' => 10,
				'callback' => 'mytravel_single_hotel_description',
			);
		}

		if ( 'rental' === $product_format ) {
			// Details.
			$price_list  = mytravel_get_field( 'price_list' );
			$allowed     = mytravel_get_field( 'terms_&_rules' );
			$not_allowed = mytravel_get_field( 'not_allowed' );

			if ( $price_list || $allowed || $not_allowed ) {
				$tabs['details'] = array(
					'title'    => esc_html__( 'Details', 'mytravel' ),
					'priority' => 30,
					'callback' => 'mytravel_single_rental_details',
				);
			}

			// Map.
			$map = mytravel_get_field( 'location_map' );
			if ( $map ) {
				$tabs['map'] = array(
					'title'    => esc_html__( 'Map', 'mytravel' ),
					'priority' => 40,
					'callback' => 'mytravel_single_hotel_location_map',
				);
			}

			// Video.
			$video = mytravel_get_field( 'video' );
			if ( $video ) {
				$tabs['video'] = array(
					'title'    => esc_html__( 'Video', 'mytravel' ),
					'priority' => 50,
					'callback' => 'mytravel_single_rental_video',
				);
			}
		}

		if ( 'car_rental' === $product_format ) {
			// Specifications.
			$specifications = mytravel_get_field( 'specification' );
			if ( $specifications ) {
				$tabs['specifications'] = array(
					'title'    => esc_html__( 'Specifications', 'mytravel' ),
					'priority' => 30,
					'callback' => 'mytravel_single_hotel_specification',
				);
			}

			// Map.
			$map = mytravel_get_field( 'location_map' );
			if ( $map ) {
				$tabs['map'] = array(
					'title'    => esc_html__( 'Location', 'mytravel' ),
					'priority' => 40,
					'callback' => 'mytravel_single_hotel_location_map',
				);
			}
		}

		// Reviews tab - shows comments.
		if ( comments_open() ) {
			$tabs['reviews'] = array(
				'title'    => esc_html__( 'Reviews', 'mytravel' ),
				'priority' => 60,
				'callback' => 'comments_template',
			);
		}

		return apply_filters( 'mytravel_default_rental_tabs', $tabs );
	}
}

if ( ! function_exists( 'mytravel_rental_loop_amenity_html' ) ) {
	/**
	 * Display room ameniity HTML
	 *
	 * @param string $icon  Icon name.
	 * @param string $amenity_name  Amenity name.
	 */
	function mytravel_rental_loop_amenity_html( $icon, $amenity_name ) {
		?>
		<div class="media mb-2 text-gray-1 align-items-center">
			<small class="mr-2">
				<i class="<?php echo esc_attr( $icon ); ?> font-size-16 small"></i>
			</small>
			<div class="media-body font-size-1"><?php echo esc_html( $amenity_name ); ?></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_rental_amenity_html' ) ) {
	/**
	 * Display room ameniity HTML
	 *
	 * @param string $icon  Icon name.
	 * @param string $amenity_name  Amenity name.
	 */
	function mytravel_rental_amenity_html( $icon, $amenity_name ) {
		$product_format = mytravel_get_product_format();

		if ( 'rental' === $product_format ) {
			$font_class = 'font-size-50';
		} else {
			$font_class = 'font-size-50';
		}

		?>
		<i class="<?php echo esc_attr( $icon ); ?> text-primary mb-1 d-block <?php echo esc_attr( $font_class ); ?>"></i>
		<div class="text-gray-1"><?php echo esc_html( $amenity_name ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_rental_details' ) ) {
	/**
	 *  Output of single rental details
	 */
	function mytravel_single_rental_details() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$price_list  = mytravel_get_field( 'price_list' );
		$allowed     = mytravel_get_field( 'terms_&_rules' );
		$not_allowed = mytravel_get_field( 'not_allowed' );

		$title   = apply_filters( 'mytravel_rental_details_title', esc_html__( 'Details', 'mytravel' ) );
		$title_1 = apply_filters( 'mytravel_rental_price_list_title', esc_html__( 'Prices', 'mytravel' ) );
		$title_2 = apply_filters( 'mytravel_rental_allowed_list_title', esc_html__( 'Terms & rules', 'mytravel' ) );

		if ( $price_list || $allowed || $not_allowed ) :
			?>
			<div id="single-hotel__details" class="py-4">
				<h5 class="font-size-21 font-weight-bold text-dark mb-4">
					<?php echo esc_html( $title ); ?>
				</h5>
				<ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">

				<?php if ( $price_list && ! empty( $price_list ) ) : ?>
					<li class="col-md-2 mb-5 list-group-item pt-0 border-bottom pb-3">
						<div class="font-weight-bold text-dark">
							<?php echo esc_html( $title_1 ); ?>
						</div>
					</li>

					<li class="col-md-10 mb-5 list-group-item pt-0 border-bottom pb-3">
						<div class="row no-gutters">
							<?php
							$list_arr = explode( "\n", $price_list );

							foreach ( $list_arr as $list ) :
								?>
							<div class="col-md-6 flex-horizontal-center mb-3 text-gray-1"><i class="fas fa-circle mr-3 font-size-8 text-primary"></i><?php echo esc_html( $list ); ?></div>
								<?php

							endforeach;
							?>
						</div>
					</li>
					<?php

				endif;

				if ( $allowed && ! empty( $allowed ) ) :
					?>
					<li class="col-md-2 mb-5 mb-md-0 list-group-item pt-0 border-bottom pb-3">
						<div class="font-weight-bold text-dark">
							<?php echo esc_html( $title_2 ); ?>
						</div>
					</li>

					<li class="col-md-5 mb-5 mb-md-0 list-group-item pt-0 border-bottom pb-3">

						<?php
						$allowed_arr = explode( "\n", $allowed );

						foreach ( $allowed_arr as $list ) :

							?>
						<div class="flex-horizontal-center mb-3 text-gray-1"><i class="flaticon-tick mr-3 font-size-16 text-primary"></i><?php echo esc_html( $list ); ?></div>
							<?php
						endforeach;
						?>
					</li>
					<?php

				endif;

				if ( $not_allowed && ! empty( $not_allowed ) ) :
					?>
					<li class="col-md-5 mb-5 mb-md-0 list-group-item pt-0 border-bottom pb-3">

						<?php
						$not_allowed_arr = explode( "\n", $not_allowed );

						foreach ( $not_allowed_arr as $list ) :

							?>
						<div class="flex-horizontal-center mb-3 text-gray-1"><i class="flaticon-close mr-3 font-size-16 text-primary"></i><?php echo esc_html( $list ); ?></div>
							<?php
						endforeach;
						?>
					</li>
					<?php

				endif;
				?>
				</ul>
			</div>
			<?php
		endif;
	}
}


if ( ! function_exists( 'mytravel_loop_rental_snapshot_preview' ) ) {
	/**
	 *  Archive rental snapshot preview
	 */
	function mytravel_loop_rental_snapshot_preview() {
		$area            = mytravel_get_field( 'area' );
		$total_rooms     = mytravel_get_field( 'total_rooms' );
		$total_bathrooms = mytravel_get_field( 'total_bathrooms' );
		$total_beds      = mytravel_get_field( 'total_beds' );

		if ( $area || $total_beds || $total_rooms || $total_bathrooms ) :
			?>

		<div class="row">
			<?php

			if ( $area ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_rental_snapshot_1', 'flaticon-plans' ), $area ); ?></div>
				<?php
			}

			if ( $total_rooms ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_rental_snapshot_2', 'flaticon-door' ), $total_rooms ); ?></div>
				<?php
			}

			if ( $total_bathrooms ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_rental_snapshot_3', 'flaticon-bathtub' ), $total_bathrooms ); ?></div>
				<?php
			}

			if ( $total_beds ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_rental_snapshot_4', 'flaticon-bed-1' ), $total_beds ); ?></div>
				<?php
			}

			?>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_loop_car_rental_snapshot_preview' ) ) {
	/**
	 *  Archive car rental snapshot preview
	 */
	function mytravel_loop_car_rental_snapshot_preview() {
		$distance        = mytravel_get_field( 'distance' );
		$cardinal_points = mytravel_get_field( 'cardinal_points' );
		$fuel            = mytravel_get_field( 'fuel' );
		$event_calendar  = mytravel_get_field( 'event_calendar' );

		if ( $distance || $cardinal_points || $fuel || $event_calendar ) :
			?>

		<div class="row">
			<?php

			if ( $distance ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_car_rental_snapshot_1', 'flaticon-meter' ), $distance ); ?></div>
				<?php
			}

			if ( $fuel ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_car_rental_snapshot_2', 'flaticon-fuel' ), $fuel ); ?></div>
				<?php
			}

			if ( $cardinal_points ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_car_rental_snapshot_3', 'flaticon-cardinal-points' ), $cardinal_points ); ?></div>
				<?php
			}

			if ( $event_calendar ) {
				?>
				<div class="col-6"><?php mytravel_rental_loop_amenity_html( apply_filters( 'mytravel_loop_car_rental_snapshot_4', 'flaticon-event' ), $event_calendar ); ?></div>
				<?php
			}

			?>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_rental_snapshot_preview' ) ) {
	/**
	 *  Output of rental snapshot preview
	 */
	function mytravel_rental_snapshot_preview() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$area            = mytravel_get_field( 'area' );
		$total_rooms     = mytravel_get_field( 'total_rooms' );
		$total_bathrooms = mytravel_get_field( 'total_bathrooms' );
		$total_beds      = mytravel_get_field( 'total_beds' );
		$layout          = mytravel_get_single_rental_layout();

		if ( 'v2' === $layout ) {
			$wrap_class = 'pt-4 border-top mb-4';
		} else {
			$wrap_class = 'py-4 border-top border-bottom mb-4';
		}

		if ( $area || $total_beds || $total_rooms || $total_bathrooms ) :

			?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<ul class="list-group list-group-borderless list-group-horizontal flex-center-between text-center mx-md-4 flex-wrap">
			<?php

			if ( $area ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_rental_snapshot_1', 'flaticon-plans' ), $area ); ?></li>
				<?php
			}

			if ( $total_rooms ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_rental_snapshot_2', 'flaticon-door' ), $total_rooms ); ?></li>
				<?php
			}

			if ( $total_bathrooms ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_rental_snapshot_3', 'flaticon-bathtub' ), $total_bathrooms ); ?></li>
				<?php
			}

			if ( $total_beds ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_rental_snapshot_4', 'flaticon-bed-1' ), $total_beds ); ?></li>
				<?php
			}

			?>
			</ul>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_car_rental_snapshot_preview' ) ) {
	/**
	 *  Output of car rental snapshot preview
	 */
	function mytravel_car_rental_snapshot_preview() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$distance        = mytravel_get_field( 'distance' );
		$cardinal_points = mytravel_get_field( 'cardinal_points' );
		$fuel            = mytravel_get_field( 'fuel' );
		$event_calendar  = mytravel_get_field( 'event_calendar' );
		$layout          = mytravel_get_single_rental_layout();

		if ( 'v2' === $layout ) {
			$wrap_class = 'pt-4 border-top mb-4';
		} else {
			$wrap_class = 'py-4 border-top border-bottom mb-4';
		}

		if ( $distance || $cardinal_points || $fuel || $event_calendar ) :

			?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<ul class="list-group list-group-borderless list-group-horizontal flex-center-between text-center mx-md-4 flex-wrap">
			<?php

			if ( $distance ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_car_rental_snapshot_1', 'flaticon-download-speed' ), $distance ); ?></li>
				<?php
			}

			if ( $fuel ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_car_rental_snapshot_2', 'flaticon-gasoline-pump' ), $fuel ); ?></li>
				<?php
			}

			if ( $cardinal_points ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_car_rental_snapshot_3', 'flaticon-gear' ), $cardinal_points ); ?></li>
				<?php
			}

			if ( $event_calendar ) {
				?>
				<li class="list-group-item text-lh-sm "><?php mytravel_rental_amenity_html( apply_filters( 'mytravel_car_rental_snapshot_4', 'flaticon-calendar' ), $event_calendar ); ?></li>
				<?php
			}

			?>
			</ul>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_single_rental_video' ) ) {
	/**
	 *  Output of single rental video
	 */
	function mytravel_single_rental_video() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$video = mytravel_get_field( 'video' );
		$image = mytravel_get_field( 'video_image' );

		parse_str( wp_parse_url( $video, PHP_URL_QUERY ), $video_id );

		if ( $video ) {
			?>
			<div id="single-hotel__video" class="border-bottom py-4">
				<h5 class="font-size-21 font-weight-bold text-dark mb-4">
					<?php echo esc_html( apply_filters( 'mytravel_single_rental_video_title', __( 'Video', 'mytravel' ) ) ); ?>
				</h5>

				<div id="youTubeVideoPlayerExample1" class="u-video-player rounded-sm">
					<!-- Cover Image -->
					<?php echo wp_get_attachment_image( $image['id'], 'full', false, [ 'class' => 'img-fluid u-video-player__preview rounded-sm' ] ); ?>

					<!-- End Cover Image -->

					<!-- Play Button -->
					<a class="js-inline-video-player u-video-player__btn u-video-player__centered" href="javascript:;"
						data-video-id="<?php echo esc_attr( $video_id['v'] ); ?>"
						data-parent="youTubeVideoPlayerExample1"
						data-is-autoplay="true"
						data-target="youTubeVideoIframeExample1"
						data-classes="u-video-player__played">
						<span class="u-video-player__icon u-video-player__icon--lg text-primary bg-transparent">
							<span class="flaticon-multimedia text-white ml-0 font-size-60 u-video-player__icon-inner"></span>
						</span>
					</a>
					<!-- End Play Button -->

					<!-- Video Iframe -->
					<div class="embed-responsive embed-responsive-16by9 rounded-sm">
						<div id="youTubeVideoIframeExample1"></div>
					</div>
					<!-- End Video Iframe -->
				</div>

				<!-- Video Section -->
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_rental_sidebar' ) ) {
	/**
	 *  Single rental sidebar functions
	 */
	function mytravel_single_rental_sidebar() {
		global $product;
		$product_type        = $product->get_type();
		$price_html          = $product->get_price_html();
		$easy_booking        = mytravel_is_wceb_activated();
		$product_is_bookable = $easy_booking ? wceb_is_bookable( $product ) : '';

		if ( 'simple' === $product_type ) {
			?>
			<div class="mytravel-hotel-availability">
				<div class="single-hotel-availability rental-availability">
					<div class="border border-color-7 rounded mb-5 bg-white">
						<?php if ( $price_html ) : ?>
							<div class="border-bottom p-4"><?php woocommerce_template_single_price(); ?></div>
						<?php endif; ?>
						<div class="p-4">
							<?php
							if ( ! $product_is_bookable ) {
								?>
							<div class="mb-4 mytravel-datepicker">
								<div class="d-block text-gray-1 font-weight-normal mb-0 text-left"><?php echo esc_html__( 'Check In - Out', 'mytravel' ); ?></div>
								<div class="border-bottom border-width-2 border-color-1">
									<?php
										mytravel_input_datepicker();
									?>
								</div>
							</div>
								<?php
							}
							?>
								
							<div class="mb-4">
								<div class="d-block text-gray-1 font-weight-normal mb-0 text-left"><?php esc_html_e( 'Guests', 'mytravel' ); ?></div>
								<div class="border-bottom border-width-2 border-color-1 mb-4 position-relative">
									<?php
										$rooms    = 1;
										$adults   = mytravel_room_get_max_adults();
										$children = mytravel_room_get_max_children();
										mytravel_guests_picker( $rooms, $adults, $children );
									?>
								</div>
							</div>
							<div class="mt-3">
								<?php woocommerce_template_single_add_to_cart(); ?>
							</div>
							
						</div><!-- /.checkinout-wrapper -->
					</div>
					<?php mytravel_single_hotel_sidebar_location_tags(); ?>
				</div>
			</div>
			<?php
		} else {
			mytravel_single_product_sidebar();
		}
	}
}
