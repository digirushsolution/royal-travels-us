<?php
/**
 * Template functions used in Single Tour v1
 */
function mytravel_get_single_tour_layout() {
	if ( ! mytravel_is_acf_activated() ) {
		return;
	}

	$layout = mytravel_get_field( 'tour_layout' );
	$layout = $layout ? $layout : 'v1';
	return apply_filters( 'mytravel_get_single_tour', $layout );
}


if ( ! function_exists( 'mytravel_single_tour_gallery' ) ) {
	/**
	 *  Output of single tour gallery
	 */
	function mytravel_single_tour_gallery() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$layout = mytravel_get_single_tour_layout();
		wc_get_template( 'single-product/tour/gallery-' . $layout . '.php' );
	}
}

if ( ! function_exists( 'mytravel_single_tour_header' ) ) {
	/**
	 *  Output of single tour header
	 */
	function mytravel_single_tour_header() {
		?><div class="d-block d-md-flex flex-center-between align-items-start mb-3">
			<div class="mb-1">
				<?php
				mytravel_tour_title();
				if ( mytravel_is_acf_activated() ) {
					?>
					<div class="mr-xl-3">
						<?php
							$location = mytravel_get_field( 'display_location' );
							$map      = mytravel_get_field( 'location_map' );
						?>
					</div>
					<?php
				}

				if ( ( mytravel_is_acf_activated() && ( $location || $map ) ) || wc_review_ratings_enabled() ) :
					?>
					<div class="d-block d-xl-flex flex-horizontal-center">
						<?php
						mytravel_hotel_location();
						if ( wc_review_ratings_enabled() ) :
							?>
							<a class="ml-xl-3 mr-4 mb-2 mb-md-0 flex-horizontal-center" href="#reviews" rel="nofollow">
								<?php woocommerce_template_loop_rating(); ?>
							</a>
							<?php
						endif;
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

if ( ! function_exists( 'mytravel_social_share_action_buttons' ) ) {
	/**
	 *  Output of social share action buttons
	 */
	function mytravel_social_share_action_buttons() {
		$buttons = apply_filters( 'mytravel_single_tour_sidebar_buttons', [] );

		if ( ! empty( $buttons ) ) {

			?>
		<ul class="ml-n1 list-group list-group-borderless list-group-horizontal custom-social-share">
			<?php
			foreach ( $buttons as $button ) {
				?>
				<li class="list-group-item px-1">
				<?php

				if ( isset( $button['callback'] ) ) :

					call_user_func( $button['callback'] );

					else :

						?>
					<a href="<?php echo esc_url( $button['href'] ); ?>" class="height-45 width-45 border rounded border-width-2 flex-content-center">
						<i class="<?php echo esc_attr( $button['icon'] ); ?> font-size-18 text-dark"></i>
					</a>
						<?php

								endif;

					?>
				</li>
				<?php
			}

			if ( apply_filters( 'mytravel_enable_share_button', true ) ) :
				?>
				<li class="list-group-item px-1"><?php mytravel_single_tour_social_share(); ?>
			<?php endif; ?>
		</ul>
			<?php
		}
	}
}


if ( ! function_exists( 'mytravel_tour_info_html' ) ) {
	/**
	 * Display room ameniity HTML
	 *
	 * @param string $icon  Icon name.
	 * @param string $amenity_name  Amenity name.
	 */
	function mytravel_tour_info_html( $icon, $amenity_name ) {
		?>
			<i class="<?php echo esc_attr( $icon ); ?> text-primary font-size-22 mr-2 d-block"></i>
			<div class="ml-1 text-gray-1"><?php echo esc_html( $amenity_name ); ?></div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_tour_info' ) ) {
	/**
	 *  Output of tour info
	 */
	function mytravel_tour_info() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$days          = mytravel_get_field( 'days' );
		$total_people  = mytravel_get_field( 'max_people' );
		$min_age       = mytravel_get_field( 'min_age' );
		$tour_schedule = mytravel_get_field( 'tour_period' );
		$amenities     = mytravel_get_field( 'snapshot' );

		$layout = mytravel_get_single_tour_layout();

		if ( 'v2' === $layout ) {
			$wrap_class = 'pt-2 mb-4';
		} else {
			$wrap_class = 'py-4 border-top border-bottom mb-4';

		}

		if ( $days || $total_people || $min_age || $tour_schedule ) :

			?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<ul class="list-group list-group-borderless list-group-horizontal row">
			<?php

			if ( $days ) {
				?>
					<li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
					<?php mytravel_tour_info_html( apply_filters( 'mytravel_tour_snapshot_1', 'flaticon-alarm' ), $days ); ?></li>
					<?php
			}

			if ( $total_people ) {
				?>
					<li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
					<?php mytravel_tour_info_html( apply_filters( 'mytravel_tour_snapshot_2', 'flaticon-social' ), $total_people ); ?></li>
					<?php
			}

			if ( $tour_schedule ) {
				?>
					<li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
					<?php mytravel_tour_info_html( apply_filters( 'mytravel_tour_snapshot_3', 'flaticon-month' ), $tour_schedule ); ?></li>
					<?php
			}

			if ( $min_age ) {
				?>
					<li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
					<?php mytravel_tour_info_html( apply_filters( 'mytravel_tour_snapshot_4', 'flaticon-user-2' ), $min_age ); ?></li>
					<?php
			}

			if ( $amenities ) {

				foreach ( $amenities as $amenity ) :
					if ( ! is_wp_error( $amenity ) && $amenity ) {
						$term_id               = $amenity->term_id;
						$taxonomy              = $amenity->taxonomy;
						$icon_additional_class = 'text-primary font-size-22 mr-2 d-block';

						?>
						<li class="col-md-4 flex-horizontal-center list-group-item text-lh-sm mb-2">
						<?php echo wp_kses( mytravel_tour_get_acf_icon_html( $term_id, $taxonomy, $icon_additional_class ), 'icon-html' ); ?>
							<div class="ml-1 text-gray-1"><?php echo esc_html( $amenity->name ); ?></div>
						</li>
						<?php
					}

				endforeach;

			}

			?>
			</ul>
		</div>
			<?php

		endif;
	}
}


if ( ! function_exists( 'mytravel_single_product_sidebar' ) ) {
	/**
	 *  Single tour sidebar functions
	 */
	function mytravel_single_product_sidebar() {
		global $product, $post;
		$price_html = $product->get_price_html();

		if ( $price_html ) :
			?>
			<div class="border border-color-7 rounded mb-5">
				<div class="border-bottom p-4">
					<?php woocommerce_template_single_price(); ?>
				</div>

				<div class="p-4">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			</div>
			<?php
		endif;
		mytravel_single_hotel_sidebar_location_tags();

	}
}


if ( ! function_exists( 'mytravel_tour_tabs' ) ) {
	/**
	 *  Output of tour tabs
	 */
	function mytravel_tour_tabs() {
		$tour_tabs = apply_filters( 'mytravel_tour_tabs', array() );

		?>
		<div id="stickyBlockStartPointTabs" class="mb-4">
			<div class="border rounded-pill rounded js-sticky-block p-1 border-width-2 z-index-4 bg-white"
			data-parent="#stickyBlockStartPointTabs"
			data-offset-target="#header"
			data-sticky-view="lg"
			data-start-point="#stickyBlockStartPointTabs"
			data-end-point="#stickyBlockEndPointReviews"
			data-offset-top="30"
			data-offset-bottom="30">
				<ul class="js-scroll-nav nav tab-nav-pill flex-nowrap tab-nav">
				<?php

				foreach ( $tour_tabs as $key => $tab ) :

					?>
					<li class="text-nowrap nav-item">
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

if ( ! function_exists( 'mytravel_default_tour_tabs' ) ) {

	/**
	 * Add default tour tabs to hotel pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function mytravel_default_tour_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content.
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => esc_html__( 'Description', 'mytravel' ),
				'priority' => 10,
				'callback' => 'mytravel_single_hotel_description',
			);
		}

		// Itinerary.
		$itinerary = mytravel_get_field( 'itinerary_places' );

		if ( $itinerary ) {
			$tabs['itinerary'] = array(
				'title'    => esc_html__( 'Itinerary', 'mytravel' ),
				'priority' => 20,
				'callback' => 'mytravel_single_tour_itinerary',
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

		// FAQ.
		$faq = mytravel_get_field( 'faq_tour' );
		if ( $faq ) {
			$tabs['faq'] = array(
				'title'    => esc_html__( 'Faq', 'mytravel' ),
				'priority' => 40,
				'callback' => 'mytravel_single_tour_faq',
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

		return apply_filters( 'mytravel_default_tour_tabs', $tabs );
	}
}


if ( ! function_exists( 'mytravel_single_tour_itinerary' ) ) {
	/**
	 *  Output of single tour itinerary
	 */
	function mytravel_single_tour_itinerary() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$tour_itinerary = mytravel_get_field( 'itinerary_places' );

		$should_display = false;

		if ( is_array( $tour_itinerary ) ) {
			foreach ( $tour_itinerary as $key => $itinerary ) {
				if ( ! empty( $itinerary ) ) {
					$should_display = true;
					break;
				}
			}
		}

		if ( $tour_itinerary && $should_display ) {
			?>
			<div id="single-hotel__itinerary" class="border-bottom py-4">
				<h5 class="font-size-21 font-weight-bold text-dark mb-4">
				<?php
					esc_html_e( 'Itinerary', 'mytravel' );
				?>
				</h5>
				<div id="basicsAccordion1">
				<?php
					$index = 0;
				foreach ( $tour_itinerary as $key => $itinerary ) :

					if ( empty( $itinerary ) ) {
						continue;
					}

					// $field = get_field_object( 'itinerary_' . $key );

					$tab_count = $index + 1;
					?>

							<!-- Card -->
							<div class="card border-0 mb-3">
								<div class="card-header border-bottom-0 p-0" id="heading-<?php echo esc_attr( $tab_count ); ?>">
									<h5 class="mb-0">
									<?php if ( ! empty( $itinerary['label'] ) || ! empty( $itinerary['title'] ) ) : ?>
										<a role="button" href="#" class="collapse-link btn btn-link btn-block d-flex align-items-md-center font-weight-bold p-0" data-toggle="collapse" data-target="#collapse-<?php echo esc_attr( $tab_count ); ?>" aria-expanded="<?php echo esc_attr( 0 === $index ) ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo esc_attr( $tab_count ); ?>">
											<span class="d-inline-block text-primary font-size-22 mb-3 mb-md-0 mr-3">
												<i class="far fa-circle"></i>
											</span>
											<?php if ( ! empty( $itinerary['label'] ) ) : ?>
											<span class="d-inline-block text-primary flex-shrink-0">
												<?php
												echo esc_html( $itinerary['label'] );
												?>
												<span class="px-2">-</span> 
											</span>
											<?php endif ?>
											<?php if ( ! empty( $itinerary['title'] ) ) : ?>
												<span class="d-inline-block h6 font-weight-bold text-gray-3 text-left mb-0"><?php echo esc_html( $itinerary['title'] ); ?></span>
											<?php endif ?>
										</a>
									<?php endif ?>
									</h5>
								</div>
								<div id="collapse-<?php echo esc_attr( $tab_count ); ?>" class="collapse 
									<?php
									if ( 1 === $tab_count ) :
										?>
									show<?php endif; ?>" aria-labelledby="heading-<?php echo esc_attr( $tab_count ); ?>" data-parent="#basicsAccordion1">
									<div class="card-body pl-6 pb-0 pt-0">
										<?php if ( ! empty( $itinerary['description'] ) ) : ?>
											<p class="mb-0">
												<?php echo esc_html( $itinerary['description'] ); ?>
											</p>
										<?php endif ?>
									</div>
								</div>
							</div>
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


if ( ! function_exists( 'mytravel_single_tour_faq' ) ) {
	/**
	 *  Ouput of single tour FAQ
	 */
	function mytravel_single_tour_faq() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$group          = mytravel_get_field( 'faq_tour' );
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
