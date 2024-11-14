<?php
/**
 * Template functions used in Single Activity v1
 */
function mytravel_get_single_activity_layout() {
	if ( ! mytravel_is_acf_activated() ) {
		return;
	}

	$layout = mytravel_get_field( 'activity_layout' );
	$layout = $layout ? $layout : 'v1';
	return apply_filters( 'mytravel_get_single_activity', $layout );
}


if ( ! function_exists( 'mytravel_single_activity_gallery_2' ) ) {
	/**
	 *  Get single activity layout for gallery
	 */
	function mytravel_single_activity_gallery_2() {
		wc_get_template( 'single-product/tour/gallery-v2.php' );
	}
}

if ( ! function_exists( 'mytravel_single_activity_gallery' ) ) {
	/**
	 *  Get single activity layout for gallery
	 */
	function mytravel_single_activity_gallery() {
		woocommerce_breadcrumb();
		$layout = mytravel_get_single_activity_layout();
		wc_get_template( 'single-product/activity/gallery-' . $layout . '.php' );
		remove_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 1 );

	}
}

if ( ! function_exists( 'mytravel_single_activity_header' ) ) {
	/**
	 *  Output of single activity header
	 */
	function mytravel_single_activity_header() {
		?><div class="d-block d-md-flex flex-center-between align-items-start mb-3">
			<div class="mb-1">
				<?php
				mytravel_tour_title();
				if ( mytravel_is_acf_activated() ) {
					$location = mytravel_get_field( 'display_location' );
					$map      = mytravel_get_field( 'location_map' );
				}

				if ( ( mytravel_is_acf_activated() && ( $location || $map ) ) || wc_review_ratings_enabled() ) :
					?>
					<div class="d-block d-md-flex flex-horizontal-center">
						<?php
						if ( wc_review_ratings_enabled() ) :
							mytravel_single_activity_guest_rating();
						endif;
						mytravel_hotel_location();
						?>
					   
					</div>
				<?php endif; ?>

			</div>
			<?php
			mytravel_social_share_action_buttons();
			?>

		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_activity_guest_rating' ) ) {
	/**
	 *  Output of single activity guest rating
	 */
	function mytravel_single_activity_guest_rating() {

		global $product;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		$rating_count = $product->get_rating_count();
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();

		if ( $rating_count > 0 ) :

			?>
		<a class="mr-4 mb-2 mb-md-0" href="#reviews">
			<span class="badge badge-pill badge-warning text-lh-sm text-white py-1 px-2 font-size-14 border-radius-3 font-weight-normal">
			<?php
					echo esc_html( mytravel_hotel_get_rating_html( $average ) );
			?>
			</span>

			<span class="font-size-14 text-gray-1 ml-2">
				(
					<?php
					/* translators: %s: total review */
					echo wp_kses_post( sprintf( _n( '%s Review', '%s Reviews', $review_count, 'mytravel' ), '<span class="count">' . $review_count . '</span>' ) );
					?>
				)

			</span>
		</a>
			<?php

		endif;
	}
}


if ( ! function_exists( 'mytravel_single_activity_experience' ) ) {
	/**
	 *  Output of single activity experience
	 */
	function mytravel_single_activity_experience() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$highlights  = mytravel_get_field( 'highlights' );
		$includes    = mytravel_get_field( 'includes' );
		$not_include = mytravel_get_field( 'not_include' );

		$title = apply_filters( 'mytravel_experience_title', esc_html__( 'Experience', 'mytravel' ) );

		if ( $highlights || $includes || $not_include ) :
			?>
			<div id="single-hotel__experience" class="py-4">
				<h5 class="font-size-21 font-weight-bold text-dark mb-4">
					<?php echo esc_html( $title ); ?>
				</h5>
				<ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">

				<?php if ( $highlights && ! empty( $highlights ) ) : ?>
					<li class="col-md-2 mb-5 list-group-item pt-0 border-bottom pb-3">
						<div class="font-weight-bold text-dark"><?php echo esc_html__( 'Highlights', 'mytravel' ); ?></div>
					</li>
					<li class="col-md-10 mb-5 list-group-item pt-0 border-bottom pb-3">
					<?php
					$highlights_arr = explode( "\n", $highlights );

					foreach ( $highlights_arr as $highlight ) :
						?>
					<div class="flex-horizontal-center mb-3 text-gray-1"><i class="fas fa-circle mr-3 font-size-8 text-primary"></i><?php echo esc_html( $highlight ); ?></div>
						<?php

					endforeach;
					?>
					</li>
					<?php

				endif;

				if ( $includes && ! empty( $includes ) ) :
					?>
					<li class="col-md-2 mb-5 mb-md-0 list-group-item pt-0 border-bottom pb-3">
						<div class="font-weight-bold text-dark"><?php echo esc_html__( 'Includes', 'mytravel' ); ?></div>
					</li>
					<li class="col-md-5 mb-5 mb-md-0 list-group-item pt-0 border-bottom pb-3">

					<?php
					$includes_arr = explode( "\n", $includes );

					foreach ( $includes_arr as $include ) :

						?>
					<div class="flex-horizontal-center mb-3 text-gray-1"><i class="flaticon-tick mr-3 font-size-16 text-primary"></i><?php echo esc_html( $include ); ?></div>
						<?php
					endforeach;
					?>
					</li>
					<?php

				endif;

				if ( $not_include && ! empty( $not_include ) ) :
					?>
					<li class="col-md-5 mb-5 mb-md-0 list-group-item pt-0 border-bottom pb-3">

					<?php
					$not_include_arr = explode( "\n", $not_include );

					foreach ( $not_include_arr as $include_list ) :

						?>
					<div class="flex-horizontal-center mb-3 text-gray-1"><i class="flaticon-close mr-3 font-size-12 text-primary"></i><?php echo esc_html( $include_list ); ?></div>
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

if ( ! function_exists( 'mytravel_single_activity_amenities' ) ) {
	/**
	 *  Output of single activity amenities
	 */
	function mytravel_single_activity_amenities() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$layout = mytravel_get_single_activity_layout();

		if ( 'v2' === $layout ) {
			$wrap_class = '';
		} else {
			$wrap_class = ' py-4 border-top border-bottom';
		}

		$amenities = mytravel_get_field( 'snapshot' );

		if ( $amenities ) {

			?>
			<div id="single-hotel__amenities" class="mb-4<?php echo esc_attr( $wrap_class ); ?>">

				<ul class="list-group list-group-borderless list-group-horizontal row">
				<?php

				foreach ( $amenities as $amenity ) :
					if ( ! is_wp_error( $amenity ) && $amenity ) {
						$term_id               = $amenity->term_id;
						$taxonomy              = $amenity->taxonomy;
						$icon_additional_class = 'text-primary font-size-22 mr-2 d-block';

						?>
						<li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
							<div class="d-flex align-items-center">
							<?php
								echo wp_kses( mytravel_hotel_get_acf_icon_html( $term_id, $taxonomy, $icon_additional_class ), 'icon-html' );
							?>
								<div class="ml-1 text-gray-1"><?php echo esc_html( $amenity->name ); ?></div>
							</div>
						</li>
						<?php
					}

				endforeach;

				?>
				</ul>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_activity_tabs' ) ) {
	/**
	 *  Output of single activity tabs
	 */
	function mytravel_activity_tabs() {
		$activity_tabs = apply_filters( 'mytravel_activity_tabs', array() );

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
				foreach ( $activity_tabs as $key => $tab ) :
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

if ( ! function_exists( 'mytravel_default_activity_tabs' ) ) {

	/**
	 * Add default tour tabs to hotel pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function mytravel_default_activity_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content.
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => esc_html__( 'Description', 'mytravel' ),
				'priority' => 10,
				'callback' => 'mytravel_single_hotel_description',
			);
		}

		// Experience.
		$highlights  = mytravel_get_field( 'highlights' );
		$includes    = mytravel_get_field( 'includes' );
		$not_include = mytravel_get_field( 'not_include' );

		if ( $highlights || $includes || $not_include ) {
			$tabs['experience'] = array(
				'title'    => esc_html__( 'Experience', 'mytravel' ),
				'priority' => 20,
				'callback' => 'mytravel_single_activity_experience',
			);
		}

		// FAQ.
		$faq = mytravel_get_field( 'faq_activity' );
		if ( $faq ) {
			$tabs['faq'] = array(
				'title'    => esc_html__( 'Faq', 'mytravel' ),
				'priority' => 40,
				'callback' => 'mytravel_single_activity_faq',
			);
		}

		// Map.
		$map = mytravel_get_field( 'location_map' );
		if ( $map ) {
			$tabs['map'] = array(
				'title'    => esc_html__( 'Map', 'mytravel' ),
				'priority' => 30,
				'callback' => 'mytravel_single_hotel_location_map',
			);
		}

		// Reviews tab - shows comments.
		if ( comments_open() ) {
			$tabs['reviews'] = array(
				'title'    => esc_html__( 'Reviews', 'mytravel' ),
				'priority' => 50,
				'callback' => 'comments_template',
			);
		}

		return apply_filters( 'mytravel_default_activity_tabs', $tabs );
	}
}

if ( ! function_exists( 'mytravel_single_activity_faq' ) ) {
	/**
	 *  Ouput of single activity FAQ
	 */
	function mytravel_single_activity_faq() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$group = mytravel_get_field( 'faq_activity' );
		$should_display = false;

		if ( is_array( $group ) ) {
			foreach ( $group as $key => $faq ) {
				if ( ! empty( $faq ) ) {
					$should_display = true;
					break;
				}
			}
		}

		if ( is_array( $group ) && $should_display ) {
			?>
			<div id="single-hotel__faq" class="border-bottom py-4">
				<h5 class="font-size-21 font-weight-bold text-dark mb-4">
				<?php
					esc_html_e( 'Faq', 'mytravel' );
				?>
				</h5>
				<div id="faqAccordion1">
				<?php
				$index = 0;
				foreach ( $group as $key => $faq ) :

					if ( empty( $faq ) ) {
						continue;
					}

					// $field = get_field_object( 'faq_' . $key );

					$tab_count = $index + 1;
					?>

							<!-- Card -->
							<?php if ( ! empty( $faq['title'] ) || ! empty( $faq['description'] ) ) : ?>
							<div class="card border-0 mb-3">
								<div class="card-header border-bottom-0 p-0" id="faq-heading-<?php echo esc_attr( $tab_count ); ?>">
									<h5 class="mb-0">
										<a role="button" class="collapse-link btn btn-link btn-block d-flex align-items-md-center p-0" href="#" data-toggle="collapse" data-target="#faq-collapse-<?php echo esc_attr( $tab_count ); ?>" aria-expanded="<?php echo esc_attr( 0 === $index ) ? 'true' : 'false'; ?>" aria-controls="faq-collapse-<?php echo esc_attr( $tab_count ); ?>">

											<span class="d-inline-block border border-color-8 rounded-xs border-width-2 p-2 mb-3 mb-md-0 mr-4">
												<span class="minus" style="">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="2px" class="injected-svg js-svg-injector mb-0" data-parent="#rectangle"><path fill-rule="evenodd" fill="rgb(59, 68, 79)" d="M-0.000,-0.000 L15.000,-0.000 L15.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"></path></svg>
												</span>

												<span class="plus" style="">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="16px" class="injected-svg js-svg-injector mb-0" data-parent="#plus1"><path fill-rule="evenodd" fill="rgb(59, 68, 79)" d="M16.000,9.000 L9.000,9.000 L9.000,16.000 L7.000,16.000 L7.000,9.000 L-0.000,9.000 L-0.000,7.000 L7.000,7.000 L7.000,-0.000 L9.000,-0.000 L9.000,7.000 L16.000,7.000 L16.000,9.000 Z"></path></svg>
												</span>
											</span>
											<?php if ( ! empty( $faq['title'] ) ) : ?>
											<span class="h6 font-weight-bold text-gray-3 mb-0"><?php echo esc_html( $faq['title'] ); ?></span>
											<?php endif; ?>
										</a>
									</h5>
								</div>
								<div id="faq-collapse-<?php echo esc_attr( $tab_count ); ?>" class="collapse
									<?php
									if ( 1 === $tab_count ) :
										?>
									show<?php endif; ?>" aria-labelledby="faq-heading-<?php echo esc_attr( $tab_count ); ?>" data-parent="#faqAccordion1">
									<div class="card-body pl-10 pl-md-10 pr-md-12 pt-0">
										<?php if ( ! empty( $faq['description'] ) ) : ?>
											<p class="mb-0 text-gray-1 text-lh-lg">
												<?php echo esc_html( $faq['description'] ); ?>
											</p>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php endif; ?>
							<!-- End Card -->
							<?php
							$index++;
						endforeach;

				?>
				</div>
			</div>
			<?php
		}
	}
}

