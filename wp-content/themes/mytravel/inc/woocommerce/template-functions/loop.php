<?php
/**
 * Template functions used in product loop
 */

if ( ! function_exists( 'mytravel_cart_link_count' ) ) {
	/**
	 * Cart link count
	 */
	function mytravel_cart_link_count() {
		?>
		<span class="cart-contents-count">
			<?php echo absint( is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?>
		</span>

		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_product_loop_start' ) ) {
	/**
	 *  Output product loop start
	 */
	function mytravel_wc_product_loop_start() {
		$col = wc_get_loop_prop( 'columns' );

		$column = apply_filters( 'mytravel_shop_loop_columns', $col );

		$loop_start = '<div class="mb-0 list-unstyled products row row-cols-md-6 row-cols-lg-6 row-cols-xl-' . esc_attr( $column ) . '">';
		return $loop_start;
	}
}

if ( ! function_exists( 'mytravel_output_card_wrapper' ) ) {
	/**
	 *  Output card wrapper start
	 */
	function mytravel_output_card_wrapper() {
		$layout = mytravel_get_product_format();

		$card_class = '';

		if ( 'activity' !== $layout && 'rental' !== $layout && 'car_rental' !== $layout && 'yacht' !== $layout ) {
			$card_class = ' tab-card';
		}
		?>
		<div class="card transition-3d-hover shadow-hover-2 h-100<?php echo esc_attr( $card_class ); ?>">
		<?php
	}
}

if ( ! function_exists( 'mytravel_output_card_wrapper_end' ) ) {
	/**
	 *  Output card wrapper end
	 */
	function mytravel_output_card_wrapper_end() {
		?>
		</div><!-- /.card -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_output_card_header_wrapper' ) ) {
	/**
	 *  Output card header wrapper start
	 */
	function mytravel_output_card_header_wrapper() {
		$layout              = mytravel_get_product_format();
		$card_header_classes = '';

		if ( 'tour' === $layout ) {
			$card_header_classes = 'mb-2 p-0';
		} else {
			$card_header_classes = 'p-0';
		}

		?>
		<div class="card-header position-relative <?php echo esc_attr( $card_header_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'mytravel_output_card_header_wrapper_end' ) ) {
	/**
	 *  Output card header wrapper end
	 */
	function mytravel_output_card_header_wrapper_end() {
		?>
		</div><!-- /.card-header -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_output_card_body_wrapper' ) ) {
	/**
	 *  Output card body wrapper start
	 */
	function mytravel_output_card_body_wrapper() {
		$layout            = mytravel_get_product_format();
		$card_body_classes = '';

		if ( 'activity' === $layout ) {
			$card_body_classes = 'px-4 py-3';
		} elseif ( 'tour' === $layout ) {
			$card_body_classes = 'px-4 py-2';
		} elseif ( 'standard' === $layout ) {
			$card_body_classes = 'pl-3 pr-4 pt-3 pb-3';
		} else {
			$card_body_classes = 'pl-3 pr-4 pt-2 pb-3';
		}

		?>
		<div class="position-relative card-body <?php echo esc_attr( $card_body_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'mytravel_output_card_body_wrapper_end' ) ) {
	/**
	 *  Output card body wrapper end
	 */
	function mytravel_output_card_body_wrapper_end() {
		?>
		</div><!-- /.card-body -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_product_thumbnail' ) ) {
	/**
	 * Output of product thumbnail
	 *
	 * @param string $view pass the view of the archive loop 'grid' or 'list'.
	 */
	function mytravel_wc_template_loop_product_thumbnail( $view = 'grid' ) {
		global $product;

		if ( ! $product ) {
			return;
		}

		$img_class = 'min-height-230 bg-img-hero';

		if ( 'list' === $view ) {
			$img_class .= ' card-img-left';
		} else {
			$img_class .= ' card-img-top';
		}

		?>
		<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="d-block gradient-overlay-half-bg-gradient-v5">
		<?php
			echo wp_kses( $product->get_image( 'woocommerce_thumbnail', [ 'class' => $img_class ] ), 'image' );

		?>
		</a>
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_product_link_open' ) ) {
	/**
	 *  Product link wrap start
	 */
	function mytravel_wc_template_loop_product_link_open() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		?>
		<a href="<?php echo esc_url( $link ); ?>" class="stretched-link card-title text-dark">
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_product_price_wrap' ) ) {
	/**
	 *  Product price wrap start
	 */
	function mytravel_wc_template_loop_product_price_wrap() {
		?>
		<div class="price-wrapper mt-3 mb-0">
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_product_price_wrap_end' ) ) {
	/**
	 *  Product price wrap end
	 */
	function mytravel_wc_template_loop_product_price_wrap_end() {
		?>
		</div><!-- /.price-wrapper -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_hotel_display_location' ) ) {
	/**
	 *  Output hotel archive display location
	 */
	function mytravel_wc_template_loop_hotel_display_location() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$product_format = mytravel_get_product_format();

		$location = mytravel_get_hotel_location();

		if ( $location && ( 'hotel' === $product_format || 'activity' === $product_format ) ) {
			?>
			<div class="position-absolute bottom-0 left-0 right-0">
				<div class="px-4 pb-3">
					<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="d-block">
						<div class="d-flex align-items-center font-size-14 text-white">
							<i class="icon flaticon-pin-1 mr-2 font-size-20"></i>
							<?php
							the_field( 'display_location' );
							?>
						</div>
					</a>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_tour_time_duration' ) ) {
	/**
	 *  Output archive tour time duration
	 */
	function mytravel_wc_template_loop_tour_time_duration() {
		if ( ! mytravel_is_acf_activated() ) {
			return;
		}

		$time_duration = mytravel_get_tour_time_duration();

		if ( $time_duration ) {
			?>
			<div class="mb-1 d-flex align-items-center font-size-14 text-gray-1">
				<i class="icon flaticon-clock-circular-outline mr-2 font-size-14"></i>
				<?php
				mytravel_tour_time_duration();
				?>
			</div>
			<?php
		}
	}
}



if ( ! function_exists( 'mytravel_wc_template_loop_star_rating' ) ) {
	/**
	 *  Get gold star rating
	 */
	function mytravel_wc_template_loop_star_rating() {
		if ( mytravel_is_acf_activated() ) {
			$star_rating = mytravel_get_field( 'gold_star_rating' );
			if ( $star_rating ) {
				?>
				<div class="mb-2 gold-star-rating">
					<div class="d-inline-flex align-items-center font-size-13 text-lh-1 text-primary letter-spacing-3">
					<?php
						mytravel_gold_star_rating_html();
					?>
					</div>
				</div>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_rating' ) ) {
	/**
	 *  Output of archive rating
	 */
	function mytravel_wc_template_loop_rating() {
		global $product;

		if ( ! wc_review_ratings_enabled() ) {
			return;
		}

		$layout = mytravel_get_product_format();

		if ( 'activity' === $layout ) {
			$badge_classes = 'badge-warning text-lh-sm text-white';
		} else {
			$badge_classes = 'badge-primary';
		}

		$rating = $product->get_average_rating();

		if ( $rating > 0 ) :

			$review_count = intval( $product->get_review_count() );
			/* translators: 1: number of comments*/
			$review_html = sprintf( _n( '(%d review)', '(%d reviews)', $review_count, 'mytravel' ), $review_count );
			?>
		<div class="mt-2 mb-3">
			<span class="badge badge-pill <?php echo esc_attr( $badge_classes ); ?> py-1 px-2 font-size-14 border-radius-3 font-weight-normal">
				<?php
					echo esc_html( number_format( round( $rating, 1 ), 1 ) . '/5.0' );
				?>
			</span>
			<span class="font-size-14 text-gray-1 ml-2"><?php echo esc_html( $review_html ); ?></span>
		</div>
			<?php
			else :

				?>
				<div class="text-gray-1 mt-2 mb- text-lh-md mb-n2"><?php echo esc_html__( 'Not yet rated', 'mytravel' ); ?></div>
				<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_badges' ) ) {
	/**
	 *  Output of product badges
	 */
	function mytravel_wc_template_loop_badges() {

		global $product;

		$product_format = mytravel_get_product_format();

		$badges_html = '';

		ob_start();

		do_action( 'mytravel_loop_badges' );

		do_action( 'mytravel_loop_badges_' . $product_format );

		$badges_html = ob_get_clean();

		if ( ! empty( $badges_html ) ) :

			?>
		<div class="position-absolute top-0 left-0 pt-5 pl-3">
			<?php
			echo wp_kses( $badges_html, 'badge-html' );
			?>
		</div>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_tour_loop_featured_badge_wrap' ) ) {
	/**
	 *  Output of featured badge wrap
	 */
	function mytravel_tour_loop_featured_badge_wrap() {
		?>
		<div class="position-absolute top-0 left-0 pt-5 pl-3">
		<?php
			mytravel_wc_template_loop_featured_badge();
		?>
		</div>
		<?php

	}
}


if ( ! function_exists( 'mytravel_wc_template_loop_featured_badge' ) ) {
	/**
	 *  Output of featured badge
	 */
	function mytravel_wc_template_loop_featured_badge() {
		global $product;
		$layout = mytravel_get_product_format();

		if ( apply_filters( 'mytravel_enable_featured_badge', true ) && $product->is_featured() ) :
			$featured_badge_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'bg-blue-1 text-white px-4 py-1 font-size-14 font-weight-normal text-lh-1dot6 mb-1 mr-2' : 'bg-white text-primary py-2 font-size-14 font-weight-normal';

			if ( 'rental' === $layout || 'car_rental' === $layout ) {
				$featured_badge_class .= ' px-3';
			} elseif ( 'activity' === $layout ) {
				$featured_badge_class .= ' px-4 mr-3';
			} else {
				$featured_badge_class .= ' px-4';
			}

			?>
		<span class="badge badge-pill <?php echo esc_attr( $featured_badge_class ); ?>"><?php esc_html_e( 'Featured', 'mytravel' ); ?></span>
			<?php

		endif;
	}
}



if ( ! function_exists( 'mytravel_wc_template_loop_onsale_badge' ) ) {
	/**
	 *  Output of onsale badge
	 */
	function mytravel_wc_template_loop_onsale_badge() {
		global $product;

		if ( apply_filters( 'mytravel_enable_onsale_badge', true ) && $product->is_on_sale() ) :

			$layout = mytravel_get_product_format();

			$sale_badge_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'mr-md-2 bg-pink-1 text-white px-3 py-1 font-size-14 font-weight-normal text-lh-1dot6 mb-1' : 'bg-white text-danger px-3 ml-3 py-2 font-size-14 font-weight-normal';

			?>
		<span class="badge badge-pill <?php echo esc_attr( $sale_badge_class ); ?>"><?php wc_get_template( 'loop/sale-flash.php' ); ?></span>
			<?php

		endif;
	}
}

if ( ! function_exists( 'mytravel_wc_results_count' ) ) {
	/**
	 *  Display product result count
	 */
	function mytravel_wc_results_count() {
		?>
		<div class="text-center text-md-left font-size-14 mb-3 text-lh-1"><?php woocommerce_result_count(); ?></div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_layered_nav_term_html' ) ) {
	/**
	 * Override WooCommerce Nav Term HTML
	 *
	 * @param  string $term_html default HTML of star rating.
	 * @param  string $term default HTML of star rating.
	 * @param  string $link   average rating of the product.
	 * @param  int    $count            total reviews.
	 * @return string
	 */
	function mytravel_wc_layered_nav_term_html( $term_html, $term, $link, $count ) {
		$count_html = '';
		if ( $count > 0 ) {
			$count_html = '<span class="count">' . absint( $count ) . '</span>';
		}

		if ( $link ) {
			$term_html = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"><a class="woocommerce-widget-layered-nav-list__item__link custom-control-label d-inline-block text-reset" rel="nofollow" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a></div>' . $count_html;
		} else {
			$term_html = '<span>' . esc_html( $term->name ) . '</span>';
		}

		return '<div class="woocommerce-widget-layered-nav-list__item__inner form-group font-size-14 text-lh-md text-secondary mb-3 flex-center-between">' . $term_html . '</div>';
	}
}

if ( ! function_exists( 'mytravel_view_map' ) ) {
	/**
	 * Display location map
	 */
	function mytravel_view_map() {
		global $product;
		$i                      = 1;
		$product_with_locations = array();
		$latitudes              = array();
		$longitudes             = array();

		while ( have_posts() ) {
			the_post();
			$locations = get_post_meta( get_the_ID(), 'location_map', true );
			$slug      = get_post_field( 'post_name', get_the_ID() );

			if ( isset( $locations['lat'] ) && isset( $locations['lng'] ) ) {
				$latitudes  = $locations['lat'];
				$longitudes = $locations['lng'];
			}
		}

		if ( count( array( $latitudes ) ) < 1 || count( array( $longitudes ) ) < 1 ) {
			return;
		}
		$total   = wc_get_loop_prop( 'total' );
		$img_src = apply_filters( 'mytravel_view_map_image', get_template_directory_uri() . '/assets/img/map-markers/map.jpg' );
		?>
		<div data-toggle="collapse" data-target="#map">
			<a href="#ontargetModal" class="d-block border rounded" data-modal-target="#ontargetModal" data-modal-effect="fadein">
				<img class="w-100" src="<?php echo esc_url( $img_src ); ?>" alt="<?php esc_attr_e( 'Map-Image', 'mytravel' ); ?>">
			</a>
		</div>

		<div id="ontargetModal" class="js-modal-window u-modal-window max-height-100vh width-100vw"
			data-modal-type="ontarget"
			data-open-effect="zoomIn"
			data-close-effect="zoomOut"
			data-speed="500">
			<div class="bg-white-1">
				<div class="bg-white border-bottom py-xl-2 js-modal-window-top">
					<div class="row d-block d-md-flex flex-horizontal-center mx-0">
						<div class="col-xl-10 d-none d-lg-block">
							<?php woocommerce_catalog_ordering(); ?>
						</div>

						<div class="col-xl-2 pt-5 pt-lg-0">
							<div class="d-flex justify-content-center justify-content-xl-end">
								<button type="button" class="btn btn-wide btn-blue-1 font-weight-normal font-size-14 rounded-xs mb-3 mb-xl-0" data-toggle="collapse" data-target="#map" aria-label="Close" onclick="Custombox.modal.close();">
									<span aria-hidden="true"><?php echo esc_html__( 'Back to hotel list', 'mytravel' ); ?></span>
									<i class="fas fa-times font-size-15 ml-3"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="height-100vh-72 overflow-hidden">
					<div class="row no-gutters">
						<div class="col-lg-5 col-xl-4 col-wd-3gdot5 order-1 order-lg-0 bg-white">
							<div class="pt-4 px-4 px-xl-5">
								<div class="mb-4">
									<div class="mb-2 text-gray-1">
										<?php
											echo wp_kses_post(
												sprintf(
													/* translators: %d: total hotel */
													esc_html( _n( '%d result shown', '%d results shown', $total, 'mytravel' ) ),
													number_format_i18n( $total )
												)
											);
										?>
									</div>
								</div>

								<div class="js-scrollbar height-100vh-72">
									<ul class="d-block list-unstyled">
										<?php
										while ( have_posts() ) {
											the_post();
											wc_get_template_part( 'content', 'map-hotel-list-view' );
										}

										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_product_geolocations' ) ) {
	/**
	 * Display Product Gelocations
	 */
	function mytravel_product_geolocations() {
		if ( function_exists( 'mytravel_view_map' ) && class_exists( 'MAS_Travels' ) && mytravel_is_acf_activated() && mytravel_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) ) {

			global $product;
			$i                      = 1;
			$product_with_locations = array();
			$latitudes              = array();
			$longitudes             = array();

			while ( have_posts() ) {
				the_post();
				$locations = get_post_meta( get_the_ID(), 'location_map', true );
				$slug      = get_post_field( 'post_name', get_the_ID() );
				ob_start();

				?>
				<div class="p-3 mytravel-map-view-popup">
					<div class="position-relative media">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="d-block mr-2">
								<?php
								the_post_thumbnail( 'thumbnail', array( 'class' => 'card-img-left' ) );
								?>
							</a>
							<?php
						}
						?>
						<div class="media-body">
							<a class="d-block" href="<?php echo esc_url( get_the_permalink() ); ?>">
								<span class="font-weight-medium font-size-14 text-dark mb-1 text-lh-1"><?php the_title(); ?></span>
							</a>
						</div>
					</div>	
				</div>
				<?php
				$popup_content = ob_get_clean();

				$map_listing = str_replace( array( "\n", "\t" ), '', $popup_content );

				if ( isset( $locations['lat'] ) && isset( $locations['lng'] ) ) {
					$latitudes                                      = $locations['lat'];
					$longitudes                                     = $locations['lng'];
					$product_with_locations[ $slug ]['className']   = 'custom-marker-dot';
					$product_with_locations[ $slug ]['coordinates'] = array( $locations['lat'], $locations['lng'] );
					$product_with_locations[ $slug ]['popup']       = $popup_content;

				}
			}

			$product_with_locations = array_values( $product_with_locations );
			$default                = 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=OvBraDfNWQ0GqQ63gXSj';
			$map_obj                = array(
				'mapLayer'    => $default,
				'coordinates' => array( $latitudes, $longitudes ),
				'zoom'        => 16,
				'markers'     => $product_with_locations,

			);
			$map_obj['mapLayer'] = apply_filters( 'mytravel_view_map_api', get_theme_mod( 'mytravel_maptiler_api_key', $default ) );

			if ( count( array( $latitudes ) ) < 1 || count( array( $longitudes ) ) < 1 ) {
				return;
			}
			?>

			<div id="map" class="map-popup">
				<div class="interactive-map w-100" style="height:100vh;" data-map-options='<?php echo esc_attr( wp_json_encode( $map_obj, JSON_UNESCAPED_SLASHES ) ); ?>'></div>
			</div>
							
			<?php
		}
	}
}



if ( ! function_exists( 'show_only_products_with_gold_star_rating' ) ) {
	/**
	 * Override the main query on a archive tag.
	 *
	 * @param array $meta_query Meta query.
	 * @param array $query Wp_query query.
	 */
	function show_only_products_with_gold_star_rating( $meta_query, $query ) {
		$is_gold_star_rating = isset( $_GET['gold_star_rating'] ) ? filter_var( wp_unslash( $_GET['gold_star_rating'] ) ) : ''; //phpcs:ignore WordPress.Security.NonceVerification.Recommended

		// Only on shop pages.
		if ( ! is_shop() || ! $is_gold_star_rating ) {
			return $meta_query;
		}

		if ( $is_gold_star_rating ) {
			$meta_query[] = array(
				'key'     => 'gold_star_rating',
				'compare' => '>=',
				'value'   => filter_var( wp_unslash( $_GET['gold_star_rating'] ) ), //phpcs:ignore WordPress.Security.NonceVerification.Recommended
			);
		}

		return $meta_query;
	}
}

if ( ! function_exists( 'mytravel_get_gold_star_rating_html' ) ) {
	/**
	 * Get gold star rating HTML
	 *
	 * @param float $rating Rating average.
	 */
	function mytravel_get_gold_star_rating_html( $rating ) {

		$star_rating_html = '';

		for ( $i = 1; $i <= $rating; $i++ ) {

			$icon = 'fas fa-star font-size-13';

			$star_rating_html .= '<i class="' . esc_attr( $icon ) . ' green-lighter"></i>';
		}

		return $star_rating_html;
	}
}

if ( ! function_exists( 'mytravel_wc_get_rating_html' ) ) {
	/**
	 * Override WooCommerce rating HTML
	 *
	 * @param string $rating_html default rating HTML.
	 * @param  float  $rating           average rating of the product.
	 * @param  int    $count            total reviews.
	 * @return string
	 */
	function mytravel_wc_get_rating_html( $rating_html, $rating, $count ) {

		$rating_html = '';

		$rating_class = 'font-12 star-rating';

		if ( ! is_product() ) {
			$rating_class .= ' mb-3';
		}

		if ( ! ( 0 < $rating ) && post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) {
			$rating_html  = '<div class="' . esc_attr( $rating_class ) . '">';
			$rating_html .= esc_html__( 'Not yet rated', 'mytravel' );
			$rating_html .= '</div>';
		}

		if ( 0 < $rating ) {
			/* translators: %s: rating */
			$label       = sprintf( __( 'Rated %s out of 5', 'mytravel' ), $rating );
			$rating_html = '<div class="' . esc_attr( $rating_class ) . '" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( $rating, $count ) . '</div>';
		}

		return $rating_html;
	}
}


if ( ! function_exists( 'mytravel_wc_get_star_rating_html' ) ) {
	/**
	 * Override WooCommerce star rating HTML
	 *
	 * @param  string $star_rating_html default HTML of star rating.
	 * @param  float  $rating           average rating of the product.
	 * @param  int    $count            total reviews.
	 * @return string
	 */
	function mytravel_wc_get_star_rating_html( $star_rating_html, $rating, $count ) {
		global $product;
		$product_format = mytravel_get_product_format();

		if ( empty( $count ) && $product ) {
			$count = $product->get_rating_count();
		}

		if ( is_product() ) {
			$star_tag    = 'span';
			$wrap_class  = '';
			$count_class = '';
			if ( 'tour' === $product_format ) {
				$wrap_class  = ' d-block green-lighter ml-1 font-size-10 letter-spacing-2';
				$count_class = 'text-gray-1';
			} elseif ( 'yacht' === $product_format ) {
				$star_tag    = 'small';
				$wrap_class  = ' letter-spacing-2';
				$count_class = 'text-secondary mt-1';
			} elseif ( 'room' === $product_format ) {
				$star_tag    = 'span';
				$wrap_class  = ' letter-spacing-2';
				$count_class = 'text-secondary mt-1';
			}
		} else {
			$star_tag    = 'small';
			$wrap_class  = '';
			$count_class = 'text-secondary mt-1';

		}

		$newline = "\n";

		if ( $rating > 0 ) {

			$star_rating_html = '<span class="green-lighter' . $wrap_class . '">';

			for ( $i = 0; $i < 5; $i++ ) {

				$diff = $rating - $i;
				if ( $diff > 0.5 ) {
					$icon = 'fas fa-star';
				} elseif ( 0.5 === $diff ) {
					$icon = 'fas fa-star-half-alt';
				} else {
					$icon = 'far fa-star';
				}

				$star_rating_html .= '<' . esc_html( $star_tag ) . ' class="' . esc_attr( $icon ) . '"></' . esc_html( $star_tag ) . '>';
				$star_rating_html .= esc_attr( $newline );

			}

			$star_rating_html .= '</span>';
			/* translators: %s: reviews */
			$star_rating_html .= '<span class="font-size-14 rating-count ml-2 ' . $count_class . '">' . sprintf( esc_html( _n( '(%1$s review)', '(%1$s reviews)', $count, 'mytravel' ) ), esc_html( $count ) ) . '</span>';

		}

		return $star_rating_html;
	}
}

if ( ! function_exists( 'mytravel_wc_rating_filter_count_html' ) ) {
	/**
	 * Wrap rating filter count HTML
	 *
	 * @param string $count_html filter count html.
	 * @param string $count count value.
	 * @return string
	 */
	function mytravel_wc_rating_filter_count_html( $count_html, $count ) {
		$count_html = '<span class="text-secondary font-size-14 mt-1 rating-count">(' . $count . ')</span>';

		return $count_html;
	}
}


if ( ! function_exists( 'mytravel_template_loop_categories' ) ) {
	/**
	 * Display product categories
	 *
	 * @param string $cat_class  Category name.
	 * @param string $cat_link_class  Category link name.
	 */
	function mytravel_template_loop_categories( $cat_class = 'text-gray-10', $cat_link_class = 'font-weight-normal font-size-14 text-white' ) {
		global $product;
		$taxonomy = 'product_cat';
		$terms    = get_the_terms( $product->get_id(), $taxonomy );
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return;
		}

		$links = [];
		foreach ( $terms as $term ) {
			$link = get_term_link( $term, $taxonomy );
			if ( is_wp_error( $link ) ) {
				continue;
			}

			$links[] = sprintf(
				'<a href="%s" class="' . esc_attr( $cat_link_class ) . '" rel="tag">%s</a>',
				esc_url( $link ),
				esc_html( $term->name )
			);
		}
		echo wp_kses( apply_filters( 'mytravel_template_loop_categories_html', sprintf( '<span class="123 woocommerce-loop-product__categories text-truncate d-block %s">%s</span>', $cat_class, implode( ', ', $links ) ) ), 'category-html' );
	}
}

if ( ! function_exists( 'mytravel_template_loop_categories_wrap' ) ) {
	/**
	 * Product categories wrapper
	 */
	function mytravel_template_loop_categories_wrap() {
		$product_format = mytravel_get_product_format();
		if ( 'standard' === $product_format ) :
			?>
			<div class="position-absolute bottom-0 left-0 right-0">
				<div class="pr-4 pl-3 pb-3">
					<?php mytravel_template_loop_categories(); ?>
				</div>
			</div>
			<?php
		endif;
	}
}


if ( ! function_exists( 'mytravel_view_detail_button' ) ) {
	/**
	 * Output View Detail Button.
	 */
	function mytravel_view_detail_button() {
		?>
		<div class="d-flex justify-content-center justify-content-md-start justify-content-xl-center">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-outline-primary d-flex align-items-center justify-content-center font-weight-bold min-height-50 border-radius-3 border-width-2 px-2 px-5 py-2"><?php echo esc_html__( 'View Detail', 'mytravel' ); ?>
			</a>
		</div>
		<?php

	}
}

if ( ! function_exists( 'mytravel_modify_wc_product_cat_widget_args' ) ) {
	/**
	 * Product categories arguments
	 *
	 * @param array $args Arguments. (default: array).
	 */
	function mytravel_modify_wc_product_cat_widget_args( $args ) {
		require_once get_template_directory() . '/inc/woocommerce/classes/class-mytravel-product-cat-list-walker.php';
		$args['walker'] = new Mytravel_WC_Product_Cat_List_Walker();
		return $args;
	}
}

if ( ! function_exists( 'mytravel_product_single_add_to_cart_text' ) ) {
	/**
	 * Modify product Add to cart text
	 *
	 * @param string $text Add to Cart Text.
	 */
	function mytravel_product_single_add_to_cart_text( $text ) {
		global $product;

		if ( 'simple' === $product->get_type() ) {
			$text = esc_html__( 'Book Now', 'mytravel' );
		}
		return $text;
	}
}

if ( ! function_exists( 'mytravel_wc_paging_nav' ) ) {
	/**
	 * Product Pagination.
	 *
	 * @param string $ul_class Product.
	 */
	function mytravel_wc_paging_nav( $ul_class ) {
		global $wp_query;
		$pages = null;

		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}
		$ul_class = empty( $ul_class ) ? 'list-pagination-1 pagination border border-color-4 rounded-sm overflow-auto overflow-xl-visible justify-content-md-center align-items-center py-2 mb-0' : $ul_class;
		?>
		<div class="text-center mt-4">
			<?php
				mytravel_bootstrap_pagination( $pages, $wp_query, true, $ul_class, 'font-size-14' );
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_get_breadcrumb' ) ) {
	/**
	 * Get breadcrumb crumb
	 *
	 * @param string $crumbs Breadcrumb crumb.
	 * @param string $obj Breadcrumb object.
	 */
	function mytravel_wc_get_breadcrumb( $crumbs, $obj ) {
		if ( is_home() ) {
			if ( isset( $crumbs[2] ) && get_query_var( 'paged' ) < 2 ) {
				unset( $crumbs[2] );
			}

			if ( empty( $crumbs[1][0] ) ) {
				$crumbs[1][0] = esc_html__( 'Blog', 'mytravel' );
			}
		}
		return $crumbs;
	}
}

if ( ! function_exists( 'mytravel_dropdown_cats' ) ) {
	/**
	 * Filter to change dropdown categories
	 *
	 * @param string $output Dropdown output.
	 */
	function mytravel_dropdown_cats( $output ) {
		return str_replace( '<select', '<select title="' . esc_html__( 'Where are you going?', 'mytravel' ) . '" data-style="" data-live-search="true" data-searchbox-classes="input-group-sm"', $output );

	}
}



if ( ! function_exists( 'mytravel_mini_cart_content' ) ) {
	/**
	 * Mini Cart content
	 */
	function mytravel_mini_cart_content() {
		?>
		<div class="mytravel-minicart card-body p-0">
			<?php woocommerce_mini_cart(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function mytravel_cart_link_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		mytravel_mini_cart_content();
		$fragments['div.mytravel-minicart'] = ob_get_clean();

		ob_start();
		mytravel_cart_link_count();
		$fragments['span.cart-contents-count'] = ob_get_clean();

		return $fragments;

	}
}

if ( ! function_exists( 'mytravel_get_location_taxonomy' ) ) {
	/**
	 * Get location taxonomy
	 */
	function mytravel_get_location_taxonomy() {
		return apply_filters( 'mytravel_get_location_taxonomy', 'pa_locations' );
	}
}

require get_template_directory() . '/inc/woocommerce/template-functions/hotel/loop-hotel.php';
require get_template_directory() . '/inc/woocommerce/template-functions/hotel/loop-hotel-list-view.php';
require get_template_directory() . '/inc/woocommerce/template-functions/tour/loop-tour.php';
require get_template_directory() . '/inc/woocommerce/template-functions/activity/loop-activity.php';
require get_template_directory() . '/inc/woocommerce/template-functions/rental/loop-rental.php';
require get_template_directory() . '/inc/woocommerce/template-functions/yacht/loop-yacht.php';

