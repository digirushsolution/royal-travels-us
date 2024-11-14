<?php
/**
 * Template functions used in Product Archive
 */

if ( ! function_exists( 'mytravel_output_archive_wrapper' ) ) {
	/**
	 *  Output archive wrapper start
	 */
	function mytravel_output_archive_wrapper() {
		$sidebar = mytravel_get_archive_sidebar();
		if ( ! class_exists( 'MAS_Travels' ) ) {
			if ( is_product() ) {
				$full_width_class = ' col-xl-9 mx-auto pb-5 pb-lg-0';
			} else {
				$full_width_class = ' col-lg-12 col-xl-12 order-1 order-lg-2 pb-5 pb-lg-0';
			}
		} else {
			$full_width_class = ' col-lg-12 col-xl-12 order-1 order-lg-2 pb-5 pb-lg-0';
		}
		if ( ( is_product() && ! class_exists( 'MAS_Travels' ) ) || ( is_archive() ) ) :
			$main_class = 'main';

			if ( mytravel_wc_has_sidebar() ) {
				$main_class .= ' col-lg-8 col-xl-9 order-1 pb-5 pb-lg-0';
				if ( 'left-sidebar' === $sidebar ) {
					$main_class .= ' order-lg-2';
				} elseif ( 'right-sidebar' === $sidebar ) {
					$main_class .= ' order-lg-1';
				}
			} else {
				$main_class .= $full_width_class;
			}

			$container_class = 'container';

			if ( is_shop() || is_product_category() ) {
				$container_class .= ' pt-5 pt-xl-8';
			}

			?><div class="<?php echo esc_attr( $container_class ); ?>">
				<div class="row mb-5 mb-lg-8 mt-xl-1">
					<div class="<?php echo esc_attr( $main_class ); ?>">
						<?php

		endif;
	}
}



if ( ! function_exists( 'mytravel_output_archive_wrapper_end' ) ) {
	/**
	 *  Output archive wrapper end
	 */
	function mytravel_output_archive_wrapper_end() {

		if ( ( is_product() && ! class_exists( 'MAS_Travels' ) ) || ( is_archive() ) ) :
			?>
			</div><!-- /.row -->
			<?php do_action( 'mytravel_after_row_wrap' ); ?>
		</div><!-- /.container -->
			<?php
			if ( class_exists( 'MAS_Travels' ) ) :
				?>
			<div class="border-bottom border-gray-33"></div>
				<?php
		endif;
			?>

			<?php
			do_action( 'mytravel_site_main_before' );

		endif;
	}
}

if ( ! function_exists( 'mytravel_output_sidebar_wrapper' ) ) {
	/**
	 *  Output archive sidebar wrapper start
	 */
	function mytravel_output_sidebar_wrapper() {
		if ( ( is_product() && ! class_exists( 'MAS_Travels' ) ) || ( is_archive() ) ) :
			?>
			</div><!-- /.main -->
			<?php

			if ( mytravel_wc_has_sidebar() ) :
				?>
				<div class="shop-sidebar col-lg-4 col-xl-3 order-lg-1 width-md-50">
					<?php
				endif;
		endif;
	}
}

if ( ! function_exists( 'mytravel_output_sidebar_wrapper_end' ) ) {
	/**
	 *  Output archive sidebar wrapper end
	 */
	function mytravel_output_sidebar_wrapper_end() {
		if ( mytravel_wc_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) ) :
			?>
			</div><!-- /.sidebar -->
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_wc_product_page_title' ) ) {
	/**
	 *  WC product page title
	 */
	function mytravel_wc_product_page_title() {
		$total = wc_get_loop_prop( 'total' );

		if ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) {
			$page_title = woocommerce_page_title( false );
			$title      = str_replace( 'product-format-', '', $page_title );
		} else {
			$title = get_the_title();
		}
		?>
		<h3 class="font-size-21 font-weight-bold mb-0 text-lh-1">
			<?php
				echo wp_kses_post(
					sprintf(
						/* translators: %1$s: page title, %2$d: total result */
						wp_kses_post( _n( '<span class="page-title">%1$s:</span> %2$d result found', '<span class="page-title">%1$s:</span> %2$d results found', $total, 'mytravel' ) ),
						$title,
						number_format_i18n( $total )
					)
				);
			?>
		</h3>
		<?php
	}
}


if ( ! function_exists( 'mytravel_shop_control_bar' ) ) {
	/**
	 *  Output archive control bar
	 */
	function mytravel_shop_control_bar() {
		if ( ! woocommerce_products_will_display() ) {
			return;
		}

		?>
		<div class="d-md-flex justify-content-between align-items-center mb-4">
			<?php
			do_action( 'mytravel_shop_control_bar_title' );

			if ( mytravel_wc_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) && class_exists( 'MAS_Travels' ) ) {
				mytravel_shop_view_switcher();
			}

			if ( ! mytravel_wc_has_sidebar() ) {
				?>
				<div class="d-md-flex">
					<?php
					do_action( 'mytravel_fullwidth_controls' );
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
		if ( mytravel_wc_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) ) {
			woocommerce_catalog_ordering();
		}
	}
}

if ( ! function_exists( 'mytravel_wc_product_filter_sidebar_toggle' ) ) {
	/**
	 *  Output shop sidebar toggle
	 */
	function mytravel_wc_product_filter_sidebar_toggle() {
		if ( ! mytravel_wc_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) ) :
			?>
			<div class="filters mb-3 mb-md-0">
				<!-- Account Sidebar Toggle Button -->
				<a id="sidebarNavToggler" class="btn btn-sm btn-primary min-width-170 height-50 font-size-16 d-flex align-items-center justify-content-center" href="javascript:;" role="button"
					aria-controls="sidebarContent"
					aria-haspopup="true"
					aria-expanded="false"
					data-unfold-event="click"
					data-unfold-hide-on-scroll="false"
					data-unfold-target="#sidebarContent"
					data-unfold-type="css-animation"
					data-unfold-overlay='{
					"className": "u-search-slide-down-bg-overlay",
					"background": "rgba(59, 68, 79, .851)",
					"animationSpeed": 400
					}'
					data-unfold-animation-in="fadeInRight"
					data-unfold-animation-out="fadeOutRight"
					data-unfold-duration="500">
					<i class="flaticon-filter mr-2 font-size-20"></i>
					<?php echo esc_html__( 'Show Filters', 'mytravel' ); ?>
				</a>
				<!-- End Account Sidebar Toggle Button -->
				<aside id="sidebarContent" class="u-sidebar" aria-labelledby="sidebarNavToggler">
					<div class="u-sidebar__scroller">
						<div class="u-sidebar__container">
							<div class="u-header-sidebar__footer-offset pb-0">
								<!-- Toggle Button -->
								<div class="d-flex align-items-center pt-2 px-5">
									<button type="button" class="btn btn-sm ml-auto font-size-14 p-0"
										aria-controls="sidebarContent"
										aria-haspopup="true"
										aria-expanded="false"
										data-unfold-event="click"
										data-unfold-hide-on-scroll="false"
										data-unfold-target="#sidebarContent"
										data-unfold-type="css-animation"
										data-unfold-animation-in="fadeInRight"
										data-unfold-animation-out="fadeOutRight"
										data-unfold-duration="500">
										<span aria-hidden="true" class="text-primary"><?php echo esc_html__( 'Back to List', 'mytravel' ); ?><i class="flaticon-close ml-2 font-size-10"></i></span>
									</button>
								</div>
								<!-- End Toggle Button -->
								<!-- Content -->
								<div class="js-scrollbar u-sidebar__body">
									<div class="u-sidebar__content u-header-sidebar__content">
										<?php dynamic_sidebar( 'sidebar-shop' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</aside>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_shop_view_switcher' ) ) {
	/**
	 *  Archive view switcher
	 */
	function mytravel_shop_view_switcher() {
		?>
		<ul class="nav tab-nav-shop flex-nowrap mt-4 mt-md-0" id="pills-tab" role="tablist">
			<li class="nav-item">
				<a class="nav-link font-size-22 p-0" id="list-view-tab" data-toggle="pill" href="#list-view" role="tab" aria-controls="list-view" aria-selected="true">
					<div class="d-md-flex justify-content-md-center align-items-md-center">
						<i class="fa fa-list"></i>
					</div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link font-size-22 p-0 ml-2 active" id="grid-view-tab" data-toggle="pill" href="#grid-view" role="tab" aria-controls="grid-view" aria-selected="false">
					<div class="d-md-flex justify-content-md-center align-items-md-center">
						<i class="fa fa-th"></i>
					</div>
				</a>
			</li>
		</ul>
		<?php
	}
}


if ( ! function_exists( 'mytravel_wc_catalog_ordering' ) ) {
	/**
	 * Returns if catalog orderby as nav links
	 */
	function mytravel_wc_catalog_ordering() {
		if ( mytravel_wc_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) ) {
			woocommerce_catalog_ordering();
		}
	}
}

if ( ! function_exists( 'mytravel_toggle_page_header' ) ) {
	/**
	 * Toggle page header
	 */
	function mytravel_toggle_page_header() {
		if ( ! class_exists( 'MAS_Travels' ) ) {
			mytravel_page_header();
		}
	}
}


