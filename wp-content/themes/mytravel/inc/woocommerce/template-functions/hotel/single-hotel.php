<?php
/**
 * Template functions used in Single Hotel v1
 */

if ( ! function_exists( 'mytravel_single_hotel_header' ) ) {
	/**
	 *  Output single hotel header
	 */
	function mytravel_single_hotel_header() {
		?><div class="d-block d-md-flex flex-center-between align-items-start mb-2">
			<div class="mb-3">
			<?php

				mytravel_single_hotel_top_badges();

				mytravel_hotel_title();

				mytravel_hotel_location();

			?>
			</div>

		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_top_badges' ) ) {
	/**
	 *  Single hotel top badges
	 */
	function mytravel_single_hotel_top_badges() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$badges = mytravel_get_single_hotel_top_badges();

		if ( $badges ) :

			?>
		<ul class="list-unstyled mb-2 d-md-flex flex-lg-wrap flex-xl-nowrap mb-2">
			<?php

			foreach ( $badges as $badge ) :

				$post_id = mytravel_get_taxonomy_post_id( $badge );
				$color   = mytravel_get_text_color_atts( 'text-', $badge );
				$bg      = mytravel_get_bg_color_atts( 'bg-', $badge );

				$atts = [
					'class' => 'rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 mr-md-2 mb-2 mb-md-0 mb-lg-2 mb-xl-0',
				];

				$span_atts = [
					'class' => 'font-weight-normal font-size-14',
				];

				?>
			<li <?php echo wp_kses( mytravel_render_color_attribute_string( $atts, array(), $bg ), 'badge-class' ); ?>>
				<span <?php echo wp_kses( mytravel_render_color_attribute_string( $span_atts, $color ), 'badge-class' ); ?>><?php echo esc_html( $badge->name ); ?></span>
			</li>
				<?php

			endforeach;

			?>
		</ul>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_get_single_hotel_layout' ) ) {
	/**
	 *  Get single hotel layout
	 */
	function mytravel_get_single_hotel_layout() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$layout = mytravel_get_field( 'layout' );
		$layout = $layout ? $layout : 'v1';
		return apply_filters( 'mytravel_get_single_hotel_layout', $layout );
	}
}

if ( ! function_exists( 'mytravel_single_hotel_gallery' ) ) {
	/**
	 *  Single hotel gallery
	 */
	function mytravel_single_hotel_gallery() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$layout = mytravel_get_single_hotel_layout();
		wc_get_template( 'single-product/hotel/gallery-' . $layout . '.php' );
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_product_gallery' ) ) {
	/**
	 *  List view gallery
	 */
	function mytravel_wc_template_loop_product_gallery() {
		wc_get_template( 'single-product/hotel/gallery-v4.php' );
	}
}


if ( ! function_exists( 'mytravel_hotel_tabs' ) ) {
	/**
	 *  Output hotel tabs
	 */
	function mytravel_hotel_tabs() {
		$hotel_tabs = apply_filters( 'mytravel_hotel_tabs', array() );

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

				foreach ( $hotel_tabs as $key => $tab ) :

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

if ( ! function_exists( 'mytravel_default_hotel_tabs' ) ) {

	/**
	 * Add default hotel tabs to hotel pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function mytravel_default_hotel_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content.
		if ( $post->post_content ) {
			$tabs['description'] = array(
				'title'    => esc_html__( 'Description', 'mytravel' ),
				'priority' => 10,
				'callback' => 'mytravel_single_hotel_description',
			);
		}

		// Select Room Tab.
		$products = array_filter( array_map( 'wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );

		if ( $products ) {
			$tabs['rooms'] = array(
				'title'    => esc_html__( 'Rooms', 'mytravel' ),
				'priority' => 20,
				'callback' => 'mytravel_single_hotel_select_room',
			);
		}

		// Amenities.
		$amenities = mytravel_get_field( 'amenities' );

		if ( $amenities ) {
			$tabs['amenities'] = array(
				'title'    => esc_html__( 'Amenities', 'mytravel' ),
				'priority' => 30,
				'callback' => 'mytravel_single_hotel_amenities',
			);
		}

		// Policy.
		$checkinout = mytravel_get_field( 'checkinout' );
		$children   = mytravel_get_field( 'children_policy' );
		$extra_beds = mytravel_get_field( 'extra_beds' );
		$others     = mytravel_get_field( 'others' );

		$has_checkinout = $checkinout && count( array_filter( $checkinout ) ) > 0;

		if ( $has_checkinout || $children || $extra_beds || $others ) {
			$tabs['policy'] = array(
				'title'    => esc_html__( 'Rules', 'mytravel' ),
				'priority' => 40,
				'callback' => 'mytravel_single_hotel_policy',
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

		return apply_filters( 'mytravel_default_hotel_tabs', $tabs );
	}
}

if ( ! function_exists( 'mytravel_single_hotel_description' ) ) {
	/**
	 *  Output single hotel description
	 */
	function mytravel_single_hotel_description() {
		$product_format = mytravel_get_product_format();
		$title_class    = '';

		if ( 'hotel' !== $product_format ) {
			$title_class = ' mb-3';
		}
		?>
		<div id="single-hotel__description" class="border-bottom position-relative">
			<h5 id="scroll-description" class="font-size-21 font-weight-bold text-dark
			<?php echo esc_attr( $title_class ); ?>">
			<?php
				echo esc_html__( 'Description', 'mytravel' );
			?>
			</h5>
			<div class="description">
			<?php
				the_content();
			?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_select_room' ) ) {
	/**
	 *  Single hotel single room
	 */
	function mytravel_single_hotel_select_room() {
		global $product;

		$products = array_filter( array_map( 'wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );

		if ( $products ) :

			?>
		<div id="single-hotel__rooms" class="mb-n5 py-4">
			<?php
			wc_get_template(
				'single-product/hotel/select-room.php',
				array(
					'grouped_product'    => $product,
					'grouped_products'   => $products,
					'quantites_required' => false,
				)
			);
			?>
		</div>
			<?php

		endif;

		?>
		<div id="stickyBlockEndPointSelectRoom"></div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_amenities' ) ) {
	/**
	 *  Output single hotel amenities
	 */
	function mytravel_single_hotel_amenities() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$product_format = mytravel_get_product_format();

		$list_item_class = '';

		if ( 'rental' === $product_format || 'car_rental' === $product_format || 'yacht' === $product_format ) {
			$list_item_class = ' mb-3';
		}

		$amenities = mytravel_get_field( 'amenities' );

		if ( $amenities ) {

			?>
			<div id="single-hotel__amenities" class="amenities border-bottom py-4 position-relative">
				<h3 class="font-size-21 font-weight-bold text-dark mb-4">
				<?php

					esc_html_e( 'Amenities', 'mytravel' );

				?>
				</h3>
				<ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">
				<?php

				foreach ( $amenities as $amenity ) :
					if ( ! is_wp_error( $amenity ) && $amenity ) {
						$term_id               = $amenity->term_id;
						$taxonomy              = $amenity->taxonomy;
						$icon_additional_class = 'mr-3 text-primary font-size-24 fa-fw fa-fh d-flex align-items-center justify-content-center';

						?>
						<li class="col-md-4 list-group-item<?php echo esc_attr( $list_item_class ); ?>">
							<div class="d-flex align-items-center">
							<?php
								echo wp_kses( mytravel_hotel_get_acf_icon_html( $term_id, $taxonomy, $icon_additional_class ), 'icon-html' );
								echo esc_html( $amenity->name );
							?>
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



if ( ! function_exists( 'mytravel_single_hotel_nearest_essentials' ) ) {
	/**
	 *  Output single hotel neareast essentials
	 */
	function mytravel_single_hotel_nearest_essentials() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$essentials      = mytravel_get_field( 'nearest_essentials' );
		$should_display  = false;
		$unique_id       = uniqid();
		$show_hide_limit = apply_filters( 'mytravel_nearest_essentials_limit', 9 );
		if ( $essentials ) {
			foreach ( $essentials as $essential ) {
				if ( ! empty( $essential ) ) {
					$should_display = true;
					break;
				}
			}
		}

		if ( $essentials && $should_display ) {

			?>
			<div id="single-hotel__essentials" class="border-bottom py-4 position-relative">
				<h3 class="font-size-21 font-weight-bold text-dark mb-4">
				<?php
					esc_html_e( 'Nearest Essentials', 'mytravel' );
				?>
				</h3>
				<div class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row mb-n5t">
				<?php
				$counter = 0;
				foreach ( $essentials as $key => $essential_types ) :

					if ( empty( $essential_types ) ) {
						continue;
					}

					if ( $show_hide_limit === $counter ) :
						echo '<div class="collapse w-100 d-block" id="collapse-' . esc_attr( $unique_id ) . '">';
						echo '<div class="ml-0 list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row mb-n5t">';
					endif;

					$field = get_field_object( 'nearest_essentials_' . $key );

					$essential_list = explode( "\n", $essential_types );
					?>
					<div class="col-md-4 mb-4 list-group-item py-0">
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
					</div>
					<?php

					if ( $show_hide_limit <= $counter && ( count( $essentials ) - 1 ) === $counter ) :
						?>
						</div>
					</div>

						<a class="link-collapse link-collapse-custom gradient-overlay-half mb-5 d-inline-block border-bottom border-primary" data-toggle="collapse" href="#collapse-<?php echo esc_attr( $unique_id ); ?>" role="button" aria-expanded="false" aria-controls="collapse-<?php echo esc_attr( $unique_id ); ?>">
							<span class="link-collapse__default font-size-14"><?php echo esc_html__( 'View More', 'mytravel' ); ?><i class="flaticon-down-chevron font-size-10 ml-1"></i></span>
							<span class="link-collapse__active font-size-14"><?php echo esc_html__( 'View Less', 'mytravel' ); ?><i class="flaticon-down-chevron font-size-10 ml-1"></i></span>
						</a>
						<?php

					endif;

					$counter++;

				endforeach;
				?>
					
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_hotel_landmarks' ) ) {
	/**
	 *  Output single hotel landmarks
	 */
	function mytravel_single_hotel_landmarks() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$landmarks       = mytravel_get_field( 'landmarks' );
		$should_display  = false;
		$unique_id       = uniqid();
		$show_hide_limit = apply_filters( 'mytravel_hotel_landmark_limit', 2 );

		if ( $landmarks ) {
			foreach ( $landmarks as $key => $landmark_list ) {
				if ( ! empty( $landmark_list ) ) {
					$should_display = true;
					break;
				}
			}
		}

		if ( $landmarks && $should_display ) {
			?>
			<div id="single-hotel__landmarks" class="border-bottom py-4 position-relative">
				<h3 class="font-size-21 font-weight-bold text-dark mb-4">
				<?php
					esc_html_e( 'What\'s Nearby', 'mytravel' );
				?>
				</h3>
				<div class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">
				<?php
				$counter = 0;
				foreach ( $landmarks as $key => $landmark_list ) :

					if ( empty( $landmark_list ) ) {
						continue;
					}
					if ( $show_hide_limit === $counter ) :
						echo '<div class="collapse w-100 d-block" id="collapse-' . esc_attr( $unique_id ) . '">';
						echo '<div class="ml-0 list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">';
					endif;

					$field = get_field_object( 'landmarks_' . $key );

					?>
					<div class="col-md-5 list-group-item py-0">
					<?php

					if ( isset( $field['label'] ) && 1 >= $counter ) :

						?>
						<div class="font-weight-bold text-dark mb-2"><?php echo esc_html( $field['label'] ); ?></div>
						<?php

						endif;

						$landmark = explode( "\n", $landmark_list );

					foreach ( $landmark as $landmark_detail ) :

						?>
						<div class="text-gray-1 mb-2 pt-1"><?php echo esc_html( $landmark_detail ); ?></div>
						<?php

						endforeach;

					?>
					</div>
					<?php
					if ( $show_hide_limit <= $counter && ( count( $landmarks ) - 1 ) === $counter ) :
						?>
						</div>
					</div>

						<a class="link-collapse link-collapse-custom gradient-overlay-half mb-5 d-inline-block border-bottom border-primary" data-toggle="collapse" href="#collapse-<?php echo esc_attr( $unique_id ); ?>" role="button" aria-expanded="false" aria-controls="collapse-<?php echo esc_attr( $unique_id ); ?>">
							<span class="link-collapse__default font-size-14"><?php echo esc_html__( 'View More', 'mytravel' ); ?><i class="flaticon-down-chevron font-size-10 ml-1"></i></span>
							<span class="link-collapse__active font-size-14"><?php echo esc_html__( 'View Less', 'mytravel' ); ?><i class="flaticon-down-chevron font-size-10 ml-1"></i></span>
						</a>
						<?php

					endif;

					$counter++;

				endforeach;

				?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_hotel_policy' ) ) {
	/**
	 *  Output single hotel policy
	 */
	function mytravel_single_hotel_policy() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$checkinout = mytravel_get_field( 'checkinout' );
		$children   = mytravel_get_field( 'children_policy' );
		$extra_beds = mytravel_get_field( 'extra_beds' );
		$others     = mytravel_get_field( 'others' );

		$has_checkinout = $checkinout && count( array_filter( $checkinout ) ) > 0;

		if ( $has_checkinout || $children || $extra_beds || $others ) :

			?>
		<div id="single-hotel__policy" class="border-bottom py-4 position-relative">
			<h3 class="font-size-21 font-weight-bold text-dark mb-4">
			<?php
				esc_html_e( 'Guest Policy', 'mytravel' );
			?>
			</h3>
			<ul class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row mb-n5">
			<?php

			if ( $has_checkinout ) :

				?>
			<li class="col-md-12 mb-5 list-group-item py-0">
				<?php
				mytravel_hotel_group_details_html( $checkinout, 'checkinout', esc_html__( 'Check-in/Check-out', 'mytravel' ), true );
				?>
			</li>
				<?php

			endif;

			if ( $children && ! empty( $children ) ) :

				?>
			<li class="col-md-12 mb-5 list-group-item py-0">
				<div class="font-weight-bold text-dark mb-2">
				<?php
					esc_html_e( 'Children', 'mytravel' );
				?>
				</div>
				<div class="text-gray-1"><?php the_field( 'children_policy' ); ?></div>
			</li>
				<?php

			endif;

			if ( $extra_beds && ! empty( $extra_beds ) ) :

				?>
			<li class="col-md-12 mb-5 list-group-item py-0">
				<div class="font-weight-bold text-dark mb-2">
				<?php
					esc_html_e( 'Extra Beds', 'mytravel' );
				?>
				</div>
				<div class="text-gray-1"><?php the_field( 'extra_beds' ); ?></div>
			</li>
				<?php

			endif;

			if ( $others && ! empty( $others ) ) :

				?>
			<li class="col-md-12 mb-5 list-group-item py-0">
				<div class="font-weight-bold text-dark mb-2">
				<?php
					esc_html_e( 'Others', 'mytravel' );
				?>
				</div>
				<div class="text-gray-1"><?php the_field( 'others' ); ?></div>
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

if ( ! function_exists( 'mytravel_single_hotel_facts' ) ) {
	/**
	 *  Output single hotel facts
	 */
	function mytravel_single_hotel_facts() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$getting_around = mytravel_get_field( 'getting_around' );
		$the_property   = mytravel_get_field( 'the_property' );
		$extras         = mytravel_get_field( 'extras' );
		$unique_id      = uniqid();

		$has_getting_around = $getting_around && count( array_filter( $getting_around ) ) > 0;
		$has_the_property   = $the_property && count( array_filter( $the_property ) ) > 0;
		$has_extras         = $extras && count( array_filter( $extras ) ) > 0;

		if ( $has_getting_around || $has_the_property || $has_extras ) :

			?>
		<div id="single-hotel__facts" class="border-bottom py-4 position-relative">
			<h3 class="font-size-21 font-weight-bold text-dark mb-4">
			<?php
				esc_html_e( 'Helpful Facts', 'mytravel' );
			?>
			</h3>
			<div class="list-group list-group-borderless list-group-horizontal list-group-flush no-gutters row">
			<?php

			if ( $has_getting_around ) :

				?>
					<div class="col-md-5 mb-5 list-group-item py-0">
				<?php
				mytravel_hotel_group_details_html( $getting_around, 'getting_around', esc_html__( 'Getting Around', 'mytravel' ) );
				?>
					</div>
				<?php

					endif;

			if ( $has_extras ) :

				?>
					<div class="col-md-5 mb-5 list-group-item py-0">
				<?php
				mytravel_hotel_group_details_html( $extras, 'extras', esc_html__( 'Extras', 'mytravel' ) );
				?>
					</div>
				<?php

					endif;

			if ( $has_the_property ) :

				?>
					<div class="col-12 mb-5 list-group-item py-0">
				<?php
				mytravel_hotel_group_details_html( $the_property, 'the_property', esc_html__( 'The Property', 'mytravel' ), true );
				?>
					</div>
				<?php

					endif;

			?>
			</div>

		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_single_hotel_review' ) ) {
	/**
	 *  Output single hotel review
	 */
	function mytravel_single_hotel_review() {
		?>
		<div id="single-hotel__reviews"><?php comments_template(); ?></div>
		<div id="stickyBlockEndPointReviews"></div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_sidebar' ) ) {
	/**
	 *  Single hotel sidebar functions
	 */
	function mytravel_single_hotel_sidebar() {
		mytravel_single_hotel_sidebar_header();
		mytravel_single_hotel_sidebar_badge();
		mytravel_single_hotel_availability();
	}
}

if ( ! function_exists( 'mytravel_single_hotel_sidebar_header' ) ) {
	/**
	 *  Output single hotel sidebar header
	 */
	function mytravel_single_hotel_sidebar_header() {
		?>
		<div class="flex-horizontal-center mb-4">
		<?php
			mytravel_single_hotel_action_buttons();
			mytravel_single_hotel_guest_rating();
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_action_buttons' ) ) {
	/**
	 *  Output single hotel action buttons
	 */
	function mytravel_single_hotel_action_buttons() {
		$buttons = apply_filters( 'mytravel_single_hotel_sidebar_buttons', [] );

		if ( ! empty( $buttons ) ) {

			?>
		<ul class="ml-n1 list-group list-group-borderless list-group-horizontal custom-social-share">
			<?php
			foreach ( $buttons as $button ) {
				?>
				<li class="list-group-item px-1 py-0">
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
				<li class="list-group-item px-1 pt-0 pb-0"><?php mytravel_single_tour_social_share(); ?>
			<?php endif; ?>
		</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_hotel_guest_rating' ) ) {
	/**
	 *  Output single hotel guest rating
	 */
	function mytravel_single_hotel_guest_rating() {

		global $product;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		$rating_count = $product->get_rating_count();
		$review_count = $product->get_review_count();
		$average      = $product->get_average_rating();

		if ( $rating_count > 0 ) :

			?>
		<a class="flex-horizontal-center ml-2" href="#reviews" rel="nofollow">
			<div class="badge-primary rounded-xs px-1">
				<span class="badge font-size-19 px-2 py-2 mb-0 text-lh-inherit text-nowrap">
				<?php
					echo esc_html( mytravel_hotel_get_rating_html( $average ) );
				?>
				</span>
			</div>

			<div class="ml-2 text-lh-1">
				<div class="ml-1">
					<h4 class="text-primary font-size-16  font-weight-bold mb-0">
					<?php
						echo esc_html( mytravel_hotel_get_user_rating_text( $average ) );
					?>
					</h4>
					<span class="text-gray-1 font-size-14">
						(
							<?php
								/* translators: %s: total review */
								echo wp_kses_post( sprintf( _n( '%s Review', '%s Reviews', $review_count, 'mytravel' ), '<span class="count">' . ( $review_count ) . '</span>' ) );
							?>
						)
					</span>
				</div>
			</div>
		</a>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_single_hotel_sidebar_badge' ) ) {
	/**
	 *  Output single hotel sidebar badge
	 */
	function mytravel_single_hotel_sidebar_badge() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$field = mytravel_get_hotel_sidebar_badge_field();
		$value = mytravel_get_hotel_sidebar_badge_value();

		if ( $field && $value ) :

			?>
		<ul class="list-unstyled d-md-flex mb-5">
			<li class="border border-violet-1 bg-violet-1 rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 mb-2 mb-md-0">
				<span class="font-weight-normal font-size-14 text-white"><?php echo esc_html( $field ); ?></span>
			</li>
			<li class="border border-violet-1 rounded-xs d-flex align-items-center text-lh-1 py-1 px-4 ml-md-n1 mb-2 mb-md-0">
				<span class="font-weight-normal font-size-14 text-violet-1"><?php echo esc_html( $value->name ); ?></span>
			</li>
		</ul>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_single_hotel_availability' ) ) {
	/**
	 *  Output single hotel availability
	 */
	function mytravel_single_hotel_availability() {
		global $product, $post, $hotel;
		$product             = wc_get_product( $post->ID );
		$price_html          = $product->get_price_html();
		$product_format      = mytravel_get_product_format();
		$easy_booking        = mytravel_is_wceb_activated();
		$product_is_bookable = $easy_booking ? wceb_is_bookable( $product ) : '';

		if ( ( mytravel_is_woocommerce_booking_activated() && 'booking' === $product->get_type() ) || 'grouped' !== $product->get_type() ) {
			mytravel_single_product_sidebar();
		} else {
			?>
			<div id="stickyBlockStartPointAvailability" class="mytravel-hotel-availability">
				<div class="js-sticky-block single-hotel-availability"
					data-parent="#stickyBlockStartPointAvailability"
					data-offset-target="#header"
					data-sticky-view="lg"
					data-start-point="#stickyBlockStartPointAvailability"
					data-end-point="#stickyBlockEndPointSelectRoom"
					data-offset-top="30"
					data-offset-bottom="30">
					<div class="border border-color-7 rounded mb-5 bg-white">
						<?php if ( $price_html ) : ?>
							<div class="border-bottom p-4"><?php woocommerce_template_single_price(); ?></div>
						<?php endif; ?>
						<div class="p-4">
							<div class="mb-4 mytravel-datepicker">
								<div class="d-block text-gray-1 font-weight-normal mb-0 text-left"><?php echo esc_html__( 'Check In - Out', 'mytravel' ); ?></div>
								<div class="border-bottom border-width-2 border-color-1">
									<?php
										mytravel_input_datepicker();
									?>
								</div>
							</div>
							
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
							<?php if ( 'grouped' === $product->get_type() ) { ?>
							<div class="text-center">
								<button id="updateAvailability" type="submit" class="btn btn-primary height-60 w-100 mb-xl-0 mb-lg-1 transition-3d-hover"><?php esc_html_e( 'Update', 'mytravel' ); ?></button>
							</div>
							<?php } ?>
							<?php if ( 'grouped' !== $product->get_type() ) : ?>
								<div class="mt-3">
									<?php mytravel_room_book_now( $product, $product ); ?>
								</div>
								<?php
							endif;

							?>

						</div><!-- /.checkinout-wrapper -->
					</div>
					<?php
					if ( 'hotel' === $product_format ) {
						mytravel_single_hotel_location_info();
					} else {
						mytravel_single_hotel_sidebar_location_tags();
					}
					?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_hotel_location_info' ) ) {
	/**
	 *  Output single hotel location info
	 */
	function mytravel_single_hotel_location_info() {
		?>
		<div class="border border-color-7 rounded px-4 pt-4 pb-3 mb-5">
			<div class="px-2 pt-2">
			<?php
				mytravel_single_hotel_show_map();
				mytravel_single_hotel_location_rating();
				mytravel_single_hotel_location_tags();
			?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_hotel_show_map' ) ) {
	/**
	 *  Output single hotel show map
	 */
	function mytravel_single_hotel_show_map() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}
		$location_map = mytravel_get_field( 'location_map' );

		if ( $location_map ) :
			?>
		<a href="http://maps.google.com/maps?q=<?php echo rawurlencode( $location_map['address'] ); ?>" data-src="#hotel-map" data-speed="700" class="d-block border rounded mb-4">
			<img class="img-fluid" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/map-markers/map.jpg' ); ?>" alt="<?php esc_attr_e( 'Map-Image', 'mytravel' ); ?>">
		</a>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_single_hotel_location_rating' ) ) {
	/**
	 *  Output single hotel location rating
	 */
	function mytravel_single_hotel_location_rating() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$rating = mytravel_get_field( 'location_rating' );

		if ( $rating ) :

			?>
		<div class="flex-horizontal-center mb-4">
			<div class="border-primary border rounded-xs px-3 text-lh-1dot7 py-1">
				<span class="font-size-21 font-weight-bold px-1 mb-0 text-lh-inherit text-primary text-nowrap"><?php echo esc_html( $rating ); ?></span>
			</div>

			<div class="ml-2 text-lh-1">
				<div class="ml-1">
					<h4 class="text-primary font-size-17 font-weight-bold mb-0"><?php echo esc_html( mytravel_hotel_get_user_rating_text( $rating ) ); ?></h4>
					<span class="text-gray-1 font-size-14"><?php esc_html_e( 'Location rating score', 'mytravel' ); ?></span>
				</div>
			</div>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_single_hotel_location_tags' ) ) {
	/**
	 *  Output single hotel location tags
	 */
	function mytravel_single_hotel_location_tags() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$tags           = mytravel_get_field( 'location_tags' );
		$product_format = mytravel_get_product_format();

		if ( 'hotel' === $product_format ) {
			$wrap_class = 'mb-2';
		} else {
			$wrap_class = 'mb-3';
		}

		if ( $tags ) {
			foreach ( $tags as $tag ) {
				if ( ! is_wp_error( $tag ) && $tag ) {
					?>
					<div class="d-flex align-items-center <?php echo esc_attr( $wrap_class ); ?>">
					<?php

						$term_id  = $tag->term_id;
						$taxonomy = $tag->taxonomy;
						$i_class  = 'font-size-25 text-primary mr-3 pr-1';

						echo wp_kses( mytravel_hotel_get_acf_icon_html( $term_id, $taxonomy, $i_class ), 'icon-html' );

					?>
						<h6 class="mb-0 font-size-14 text-dark"><?php echo esc_html( $tag->name ); ?></h6>
					</div>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'mytravel_output_related_hotels' ) ) {

	/**
	 * Output the related products.
	 */
	function mytravel_output_related_hotels() {

		$args = array(
			'posts_per_page' => 8,
			'columns'        => 4,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
		);

		mytravel_related_hotels( apply_filters( 'mytravel_output_related_hotels_args', $args ) );
	}
}

if ( ! function_exists( 'mytravel_related_hotels' ) ) {
	/**
	 * Related hotels.
	 *
	 * @param array $args Array of arguments.
	 */
	function mytravel_related_hotels( $args = array() ) {
		global $product;

		if ( ! $product ) {
			return;
		}

		$defaults = array(
			'posts_per_page' => 8,
			'columns'        => 4,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
			'order'          => 'desc',
		);

		$args = wp_parse_args( $args, $defaults );

		// Get visible related products then sort them at random.
		$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

		// Handle orderby.
		$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

		// Set global loop values.
		wc_set_loop_prop( 'name', 'related' );
		wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );

		wc_get_template( 'single-product/hotel/related.php', $args );
	}
}

/* Room */
if ( ! function_exists( 'mytravel_single_room_sidebar' ) ) {
	/**
	 *  Output single room sidebar
	 */
	function mytravel_single_room_sidebar() {
		global $product;
		$price_html = $product->get_price_html();

		?>
		<div class="flex-horizontal-center mb-4">
		<?php
			mytravel_social_share_action_buttons();
		?>
		</div>
		<?php if ( $price_html ) : ?>
			<div class="border border-color-7 rounded mb-5">
				<div class="border-bottom">
					<div class="p-4">
						<?php woocommerce_template_single_price(); ?>
					</div>
				</div>
				<div class="p-4">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_single_room_top_badges' ) ) {
	/**
	 *  Output single room top badges
	 */
	function mytravel_single_room_top_badges() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$badges = mytravel_get_single_room_top_badges();

		if ( $badges ) :

			?>
		<ul class="list-unstyled mb-2 d-md-flex flex-lg-wrap flex-xl-nowrap mb-2">
			<?php

			foreach ( $badges as $badge ) :

				$post_id = mytravel_get_taxonomy_post_id( $badge );
				$color   = mytravel_get_text_color_atts( 'text-', $badge );
				$bg      = mytravel_get_bg_color_atts( 'bg-', $badge );

				$atts = [
					'class' => 'rounded-xs d-flex align-items-center text-lh-1 py-1 px-3 mr-md-2 mb-2 mb-md-0 mb-lg-2 mb-xl-0',
				];

				$span_atts = [
					'class' => 'font-weight-normal font-size-14',
				];

				?>
			<li <?php echo wp_kses( mytravel_render_color_attribute_string( $atts, array(), $bg ), 'badge-class' ); ?>>
				<span <?php echo wp_kses( mytravel_render_color_attribute_string( $span_atts, $color ), 'badge-class' ); ?>><?php echo esc_html( $badge->name ); ?></span>
			</li>
				<?php

			endforeach;

			?>
		</ul>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_wceb_single_product_html' ) ) {
	/**
	 * Remove before add to cart HTML
	 */
	function mytravel_wceb_single_product_html() {
		global $product;
		$product_format      = mytravel_get_product_format();
		$easy_booking        = mytravel_is_wceb_activated();
		$product_is_bookable = $easy_booking ? wceb_is_bookable( $product ) : '';

		if ( 'room' === $product_format && $product_is_bookable ) {
			remove_action( 'woocommerce_before_add_to_cart_button', 'wceb_single_product_html', 20 );
		}
	}
}
