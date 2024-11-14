<?php
/**
 * Template functions used in Single Rental v1
 */
function mytravel_get_single_yacht_layout() {
	if ( ! mytravel_is_acf_activated() ) {
		return;
	}

	$layout = mytravel_get_field( 'layout' );
	$layout = $layout ? $layout : 'v1';
	return apply_filters( 'mytravel_get_single_yacht_', $layout );
}


if ( ! function_exists( 'mytravel_single_yacht_gallery_v1' ) ) {
	/**
	 *  Output of single yacht gallery v1
	 */
	function mytravel_single_yacht_gallery_v1() {
		remove_action( 'woocommerce_before_single_product', 'mytravel_woocommerce_breadcrumb_wrapper', 1 );
		woocommerce_breadcrumb();
		wc_get_template( 'single-product/hotel/gallery-v3.php' );
	}
}

if ( ! function_exists( 'mytravel_single_yacht_header' ) ) {
	/**
	 *  Output of single yacht header
	 */
	function mytravel_single_yacht_header() {

		?><div class="d-block d-md-flex flex-center-between align-items-start mb-3">
			<div class="mb-3">
				<div class="d-block d-md-flex flex-horizontal-center">
					<?php
					mytravel_tour_title();
					if ( wc_review_ratings_enabled() ) :
						?>
						<a class="d-inline-flex align-items-center font-size-13 text-lh-1" href="#reviews">
							<?php woocommerce_template_loop_rating(); ?>
						</a>
							<?php
						endif;
					?>
				</div>
				<?php mytravel_hotel_location(); ?>
			</div>
			<?php mytravel_social_share_action_buttons(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_yacht_tabs' ) ) {
	/**
	 *  Output of single yacht tabs
	 */
	function mytravel_yacht_tabs() {
		$yacht_tabs = apply_filters( 'mytravel_yacht_tabs', array() );

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
				foreach ( $yacht_tabs as $key => $tab ) :
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

if ( ! function_exists( 'mytravel_default_yacht_tabs' ) ) {

	/**
	 * Add default yacht tabs to yacht pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function mytravel_default_yacht_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content.
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => esc_html__( 'Description', 'mytravel' ),
				'priority' => 10,
				'callback' => 'mytravel_single_hotel_description',
			);
		}

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

		// Reviews tab - shows comments.
		if ( comments_open() ) {
			$tabs['reviews'] = array(
				'title'    => esc_html__( 'Reviews', 'mytravel' ),
				'priority' => 50,
				'callback' => 'comments_template',
			);
		}

		return apply_filters( 'mytravel_default_yacht_tabs', $tabs );
	}
}

if ( ! function_exists( 'mytravel_yacht_amenity_html' ) ) {
	/**
	 * Display room ameniity HTML
	 *
	 * @param string $icon  Icon name.
	 * @param string $amenity_name  Amenity name.
	 */
	function mytravel_yacht_amenity_html( $icon, $amenity_name ) {
		?>
		<i class="<?php echo esc_attr( $icon ); ?> text-primary font-size-40 mb-1 d-block"></i>
		<div class="text-gray-1"><?php echo esc_html( $amenity_name ); ?></div>
		<?php

	}
}


if ( ! function_exists( 'mytravel_yacht_snapshot_preview' ) ) {
	/**
	 *  Output of yacht snapshot preview
	 */
	function mytravel_yacht_snapshot_preview() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$area       = mytravel_get_field( 'area' );
		$speed      = mytravel_get_field( 'speed' );
		$total_beds = mytravel_get_field( 'bed' );
		$max_adult  = mytravel_get_field( 'number_of_passengers' );
		$layout     = mytravel_get_single_yacht_layout();

		if ( $area || $speed || $total_beds || $max_adult ) :

			if ( 'v2' === $layout ) {
				$wrap_class = 'pt-4 border-top mb-4';
			} else {
				$wrap_class = 'py-4 border-top border-bottom mb-4';
			}

			?>
			<div class="<?php echo esc_attr( $wrap_class ); ?>">
				<ul class="list-group list-group-borderless list-group-horizontal flex-center-between text-center mx-md-4 flex-wrap">
				<?php

				if ( $area ) {
					?>
						<li class="list-group-item text-lh-sm "><?php mytravel_yacht_amenity_html( apply_filters( 'mytravel_yacht_snapshot_1', 'flaticon-ruler' ), $area ); ?></li>
						<?php
				}

				if ( $speed ) {
					?>
						<li class="list-group-item text-lh-sm "><?php mytravel_yacht_amenity_html( apply_filters( 'mytravel_yacht_snapshot_2', 'flaticon-download-speed' ), $speed ); ?></li>
						<?php
				}

				if ( $max_adult ) {
					?>
						<li class="list-group-item text-lh-sm "><?php mytravel_yacht_amenity_html( apply_filters( 'mytravel_yacht_snapshot_3', 'flaticon-user-2' ), $max_adult ); ?></li>
						<?php
				}

				if ( $total_beds ) {
					?>
						<li class="list-group-item text-lh-sm "><?php mytravel_yacht_amenity_html( apply_filters( 'mytravel_yacht_snapshot_4', 'flaticon-bed-1' ), $total_beds ); ?></li>
						<?php
				}

				?>
				</ul>
			</div>
			<?php

		endif;
	}
}


if ( ! function_exists( 'mytravel_single_hotel_specification' ) ) {
	/**
	 *  Output of hotel specification
	 */
	function mytravel_single_hotel_specification() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$specifications = mytravel_get_field( 'specification' );
		$should_display = false;

		if ( $specifications ) {
			foreach ( $specifications as $specification ) {
				if ( ! empty( $specification ) ) {
					$should_display = true;
					break;
				}
			}
		}

		if ( $specifications && $should_display ) {

			?>
			<div id="single-hotel__specifications" class="border-bottom py-4 position-relative">
				<h3 class="font-size-21 font-weight-bold text-dark mb-4">
				<?php
					esc_html_e( 'Specification', 'mytravel' );
				?>
				</h3>
				<ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row mb-n5">
				<?php

				foreach ( $specifications as $key => $specification_list ) :

					if ( empty( $specification_list ) ) {
						continue;
					}

					$field = get_field_object( 'specification_' . $key );

					$essential_list = explode( "\n", $specification_list );

					?>
					<li class="col-md-4 mb-5 list-group-item py-0">
					<?php

					if ( isset( $field['label'] ) ) :

						?>
						<div class="font-weight-bold text-dark mb-1">
						<?php
						echo esc_html( $field['label'] );
						?>
						</div>
						<?php

						endif;

					foreach ( $essential_list as $essential ) :

						$essential_detail = explode( '|', $essential );

						?>
							<div class="mb-2">
								<div class="text-gray-1">
								<?php
								echo esc_html( $essential_detail[0] );
								?>
								</div>
								<?php

								if ( isset( $essential_detail[1] ) ) :

									?>
								<div class="text-primary">
									<?php
									echo esc_html( $essential_detail[1] );
									?>
								</div>
									<?php

								endif;
								?>
							</div>
							<?php

						endforeach;

					?>
					</li>
					<?php

				endforeach;

				?>
				</ul>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_yacht_sidebar' ) ) {
	/**
	 *  Single yacht sidebar functions
	 */
	function mytravel_single_yacht_sidebar() {
		mytravel_single_hotel_availability();
	}
}

