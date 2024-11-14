<?php
/**
 * Template Functions used in Header.
 *
 * @package mytravel
 */

if ( ! function_exists( 'mytravel_transparent_header_enable' ) ) {
	/**
	 * Transparent Header Enable / Disable.
	 */
	function mytravel_transparent_header_enable() {

		$default = 'no';
		if ( ! class_exists( 'MAS_Travels' ) ) {
			$default = 'yes';
		}

		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();
		$myt_page_options = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$transparent_enable = isset( $myt_page_options['header']['mytravel_enable_transparent_header'] ) ? $myt_page_options['header']['mytravel_enable_transparent_header'] : 'no';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && ( ! class_exists( 'MAS_Travels' ) ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
			$transparent_enable = get_theme_mod( 'mytravel_shop_enable_transparent_header', $default );
		} else {
			$transparent_enable = get_theme_mod( 'mytravel_enable_transparent_header', $default );
		}
		return apply_filters( 'mytravel_transparent_header', filter_var( $transparent_enable, FILTER_VALIDATE_BOOLEAN ) );
	}
}

/**
 * Check if a page has custom header
 *
 * @param array $options Page meta options.
 */
function mytravel_has_custom_header( $options ) {

	$has_custom_header = false;

	if ( isset( $options['header'] ) && isset( $options['header']['mytravel_enable_custom_header'] ) && 'yes' === $options['header']['mytravel_enable_custom_header'] ) {
		$has_custom_header = true;
	}
	return $has_custom_header;
}

if ( ! function_exists( 'mytravel_top_navbar_enable' ) ) {
	/**
	 * Top Navbar Enable / Disable.
	 */
	function mytravel_top_navbar_enable() {

		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$topbar_enable = isset( $myt_page_options['header']['mytravel_enable_top_navbar'] ) ? $myt_page_options['header']['mytravel_enable_top_navbar'] : '';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() ) ) ) {
			$topbar_enable = get_theme_mod( 'mytravel_shop_enable_top_navbar', 'no' );
		} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
			$topbar_enable = get_theme_mod( 'mytravel_404_enable_top_navbar', 'no' );
		} else {
			$topbar_enable = get_theme_mod( 'mytravel_enable_top_navbar', 'no' );
		}

		return apply_filters( 'mytravel_topbar_enable', filter_var( $topbar_enable, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_top_navbar_starts' ) ) {
	/**
	 * Top Navbar <div> Starts.
	 */
	function mytravel_top_navbar_starts() {

		$header_style = mytravel_get_header_style();
		if ( mytravel_top_navbar_enable() ) :

				$myt_page_options = array();

			if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
				$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
				$_myt_page_options = maybe_unserialize( $clean_meta_data );

				if ( is_array( $_myt_page_options ) ) {
					$myt_page_options = $_myt_page_options;
				}
			}

			if ( mytravel_has_custom_header( $myt_page_options ) ) {
				$classes = isset( $myt_page_options['header']['mytravel_top_navbar_skin'] ) ? ' bg-' . $myt_page_options['header']['mytravel_top_navbar_skin'] : '';
			} else {
				$classes = 'bg-' . get_theme_mod( 'topbar_skin', 'violet' );
			}

			if ( 'v4' === $header_style ) {
				?>
				<div class="<?php echo esc_attr( $classes ); ?> u-header__hide-content u-header__topbar u-header__topbar-lg border-bottom border-color-white">
					<div class="container-fluid">
						<div class="d-flex align-items-center">
				<?php
			} else {
				?>
				<div class="container-fluid px-xl-4 px-wd-8 u-header__hide-content u-header__topbar u-header__topbar-lg border-bottom <?php echo esc_attr( mytravel_transparent_header_enable() ) ? 'border-color-white' : 'border-color-8'; ?>">
					<div class="d-flex align-items-center">
				<?php
			}
		endif;
	}
}

if ( ! function_exists( 'mytravel_top_navbar_end' ) ) {
	/**
	 * Top Navbar End.
	 */
	function mytravel_top_navbar_end() {

		$header_style = mytravel_get_header_style();
		if ( mytravel_top_navbar_enable() ) :
			if ( 'v4' === $header_style ) {
				?>
						</div>
					</div>
				</div>
				<?php
			} else {
				?>
					</div>
				</div>
				<?php
			}
		endif;
	}
}

if ( ! function_exists( 'mytravel_top_navbar_left' ) ) {
	/**
	 * Top Navbar End.
	 */
	function mytravel_top_navbar_left() {

		$header_style = mytravel_get_header_style();
		$menu_classes = '';
		if ( mytravel_transparent_header_enable() ) {
			$menu_classes = 'list-inline u-header__topbar-nav-divider mb-0';
		} else {
			$menu_classes = 'list-inline list-inline-dark u-header__topbar-nav-divider--dark mb-0';
		}

		if ( 'v4' === $header_style ) {
			$menu_classes = 'list-inline list-inline-dark u-header__topbar-nav-divider mb-0';
		}

		if ( has_nav_menu( 'topbar_left' ) && mytravel_top_navbar_enable() ) {
			$args = apply_filters(
				'mytravel_topbar_left_menu_args',
				array(
					'theme_location' => 'topbar_left',
					'walker'         => new WP_Bootstrap_Navwalker(),
					'container'      => false,
					'menu_id_prefix' => 'topbar-left',
					'menu_class'     => $menu_classes,
					'item_class'     => 'list-inline-item mr-0',
					'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
					'anchor_class'   => array( 'u-header__navbar-link' ),
				)
			);
			wp_nav_menu( $args );
		}
	}
}

if ( ! function_exists( 'mytravel_top_navbar_right' ) ) {
	/**
	 * Top Navbar right in Header v1.
	 */
	function mytravel_top_navbar_right() {

		$header_style = mytravel_get_header_style();
		if ( mytravel_top_navbar_enable() ) :
			?>
			<div class="ml-auto d-flex align-items-center">
				<?php
					mytravel_top_navbar_social_icons();
					mytravel_header_navbar_account();
					mytravel_top_navbar_language_dropdown();
				?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_top_navbar_social_icons' ) ) {
	/**
	 * Top Navbar Social Icon in Header v1.
	 */
	function mytravel_top_navbar_social_icons() {

		$header_style   = mytravel_get_header_style();
		$nav_link_class = '';

		if ( mytravel_transparent_header_enable() && 'v4' !== $header_style && 'v8' !== $header_style ) {
			$nav_link_class = 'btn btn-sm btn-icon btn-pill btn-soft-white btn-bg-transparent transition-3d-hover';
		} elseif ( 'v8' === $header_style ) {
			$nav_link_class = 'btn btn-xs btn-icon btn-pill btn-soft-dark btn-bg-transparent transition-3d-hover';
		} else {
			$nav_link_class = 'btn btn-sm btn-icon btn-pill btn-soft-dark btn-bg-transparent transition-3d-hover ';
		}

		if ( has_nav_menu( 'social_media' ) ) {
			$args = apply_filters(
				'mytravel_topbar_social_menu_args',
				array(
					'theme_location' => 'social_media',
					'container'      => false,
					'depth'          => 1,
					'menu_class'     => 'list-inline mb-0 mr-2 pr-1',
					'item_class'     => 'list-inline-item',
					'icon_class'     => 'btn-icon__inner',
					'icon_txt_class' => 'sr-only',
					'walker'         => new WP_Bootstrap_Navwalker(),
					'classes'        => array(
						'nav-link' => $nav_link_class,
					),
				)
			);
			wp_nav_menu( $args );
		}
	}
}

if ( ! function_exists( 'mytravel_header_signin_enable' ) ) {
	/**
	 * My Account Enable / Disable.
	 */
	function mytravel_header_signin_enable() {

		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}

		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$signin_enable = isset( $myt_page_options['header']['mytravel_signin_enable'] ) ? $myt_page_options['header']['mytravel_signin_enable'] : 'yes';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() ) ) ) {
			$signin_enable = get_theme_mod( 'mytravel_shop_enable_signin', 'no' );
		} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
			$signin_enable = get_theme_mod( 'mytravel_404_enable_signin', 'no' );
		} else {
			$signin_enable = get_theme_mod( 'mytravel_enable_signin', 'no' );
		}

		return apply_filters( 'mytravel_header_my_account', filter_var( $signin_enable, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_header_navbar_account' ) ) {
	/**
	 * Header Navbar Acoount.
	 */
	function mytravel_header_navbar_account() {

		$header_style = mytravel_get_header_style();
		if ( mytravel_header_signin_enable() ) {

			$myt_page_options = array();

			if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
				$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
				$_myt_page_options = maybe_unserialize( $clean_meta_data );

				if ( is_array( $_myt_page_options ) ) {
					$myt_page_options = $_myt_page_options;
				}
			}
			if ( mytravel_has_custom_header( $myt_page_options ) ) {
				$signin_button_color   = isset( $myt_page_options['header']['mytravel_navbar_signin_button_skin'] ) ? $myt_page_options['header']['mytravel_navbar_signin_button_skin'] : 'white';
				$signin_button_size    = isset( $myt_page_options['header']['mytravel_navbar_signin_button_size'] ) ? 'btn-' . $myt_page_options['header']['mytravel_navbar_signin_button_size'] : 'wide';
				$signin_button_shape   = isset( $myt_page_options['header']['mytravel_navbar_signin_button_shape'] ) ? $myt_page_options['header']['mytravel_navbar_signin_button_shape'] : 'rounded-sm';
				$signin_button_variant = isset( $myt_page_options['header']['mytravel_navbar_signin_button_variant'] ) ? $myt_page_options['header']['mytravel_navbar_signin_button_variant'] : 'outline';
				$button_url            = isset( $myt_page_options['header']['mytravel_navbar_signin_button_link'] ) ? $myt_page_options['header']['mytravel_navbar_signin_button_link'] : '';
				$button_css            = isset( $myt_page_options['header']['mytravel_navbar_signin_button_css'] ) ? $myt_page_options['header']['mytravel_navbar_signin_button_css'] : '';

			} else {
				$signin_button_color   = get_theme_mod( 'header_navbar_signin_button_color', 'white' );
				$signin_button_size    = 'btn-' . get_theme_mod( 'header_navbar_signin_button_size', 'wide' );
				$signin_button_shape   = get_theme_mod( 'header_signin_button_shape', 'rounded-sm' );
				$signin_button_variant = get_theme_mod( 'header_navbar_signin_button_variant', 'outline' );
				$button_url            = get_theme_mod( 'header_navbar_signin_button_url', '' );
				$button_css            = get_theme_mod( 'header_navbar_signin_button_css' );
			}
			$signin_button_variant = ! empty( $signin_button_variant ) ? 'btn-' . $signin_button_variant . '-' . $signin_button_color : 'btn-' . $signin_button_color;
			$text_color            = ( mytravel_transparent_header_enable() ? 'text-white' : 'text-dark' );

			if ( 'link' === $signin_button_color ) {
				'btn-outline-' . $signin_button_color;
			} else {
				'btn-' . $signin_button_color;
			}

			$signin_button_class = 'btn ' . $signin_button_shape . ' ' . $signin_button_size . ' ' . $signin_button_variant . ' ' . $button_css . ' border-width-2 transition-3d-hover';
			$button_class        = 'btn ' . $signin_button_shape . ' ' . $signin_button_size . ' ' . $signin_button_variant . ' ' . $button_css . ' transition-3d-hover';

			if ( 'v2' === $header_style ) {
				$text_color = 'text-primary';
			}

			if ( 'v4' === $header_style || 'v8' === $header_style ) {
				$text_color = 'u-header__topbar-divider--dark text-dark';
			}

			$divider = '';
			if ( mytravel_transparent_header_enable() ) {
				$divider = 'u-header__topbar-divider';
			} else {
				$divider = 'u-header__topbar-divider--dark';
			}
			$signin_url = '';
			if ( ! empty( $button_url ) ) {
				$signin_url = $button_url;
			} else {
				$signin_url = 'javascript:;';
			}

			$classes      = '';
			$icon_classes = '';
			if ( 'v1' === $header_style ) {
				$classes      = 'position-relative px-3 u-header__login-form dropdown-connector-xl ' . $divider;
				$icon_classes = 'flaticon-user mr-2 ml-1 font-size-18';
			} elseif ( 'v2' === $header_style ) {
				$classes      = 'position-relative pl-4 pr-xl-4 ml-auto ml-md-0 u-header__divider-xl ';
				$icon_classes = 'flaticon-user mx-xl-2';
			} elseif ( 'v3' === $header_style || 'v4' === $header_style ) {
				$classes      = 'position-relative u-header__login-form px-3 ' . $divider;
				$icon_classes = 'flaticon-user mr-2 ml-1';
			} elseif ( 'v5' === $header_style ) {
				$classes      = 'pl-4 ml-1 u-header__last-item-btn u-header__last-item-btn-xl';
				$icon_classes = 'flaticon-user font-size-16 mr-2';
			} elseif ( 'v6' === $header_style ) {
				$classes      = 'position-relative u-header__login-form u-header__hide-content d-none d-lg-block';
				$icon_classes = 'flaticon-user font-size-18 mx-xl-2';
			} else {
				$classes      = 'u-header__login-form pl-4 ml-1 u-header__last-item-btn u-header__last-item-btn-lg';
				$icon_classes = 'flaticon-user font-size-16 mr-2';
			}

			$anchor_classes = '';

			if ( 'v1' === $header_style ) {
				$anchor_classes = $text_color . ' d-flex align-items-center py-3';
			} elseif ( 'v3' === $header_style ) {
				$anchor_classes = $text_color . ' d-flex align-items-center py-2';
			} elseif ( 'v5' === $header_style ) {
				$anchor_classes = $signin_button_class;
			} elseif ( 'v7' === $header_style ) {
				$anchor_classes = $text_color . ' ' . $button_class;
			} else {
				$anchor_classes = $text_color . ' d-flex align-items-center';
			}

			$span_class = '';
			if ( 'v2' === $header_style ) {
				$span_class = 'd-none d-xl-inline-block mr-1';
			} elseif ( 'v5' === $header_style || 'v7' === $header_style ) {
				$span_class = 'd-inline-block';
			} elseif ( 'v2' === $header_style || 'v6' === $header_style ) {
				$span_class = 'd-none d-xl-inline-block mr-1';
			} else {
				$span_class = 'd-inline-block font-size-14 mr-1';
			}

			if ( 'v8' === $header_style ) {
				$classes        = 'position-relative px-3 u-header__login-form dropdown-connector-xl u-header__topbar-divider--dark';
				$icon_classes   = 'flaticon-user mr-2 ml-1 font-size-18';
				$anchor_classes = 'd-flex align-items-center text-dark py-3';
				$span_class     = 'd-inline-block font-size-14 mr-1';
			}

			?>
			<div class="<?php echo esc_attr( $classes ); ?>">
			<?php
			if ( is_user_logged_in() && mytravel_is_woocommerce_activated() ) :
				?>
					<a class="<?php echo esc_attr( $text_color ); ?>" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>">
					<?php echo get_avatar( wp_get_current_user(), 36, '', '', [ 'class' => 'avatar-sm rounded-circle mr-2' ] ); ?>
					<?php
					$user = wp_get_current_user();
					echo esc_html( $user->display_name );
					?>
					</a>
					<?php
				else :
					?>
					<a id="signUpDropdownInvoker"  href="<?php echo esc_url( $signin_url ); ?>" class="<?php echo esc_attr( $anchor_classes ); ?>" aria-controls="signUpDropdown" aria-haspopup="true" aria-expanded="true" data-unfold-event="click" data-unfold-target="#signUpDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
						<i class="<?php echo esc_attr( $icon_classes ); ?>"></i>
						<span class="<?php echo esc_attr( $span_class ); ?>"><?php echo esc_html_x( 'Sign in or Register', 'front-end', 'mytravel' ); ?></span>
					</a>
					<?php
				endif;
				mytravel_wc_registration_form();
				?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_wc_registration_form' ) ) {
	/**
	 * Navbar Signin.
	 */
	function mytravel_wc_registration_form() {

		if ( mytravel_is_woocommerce_activated() && mytravel_header_signin_enable() && ! is_user_logged_in() ) {

			$is_registration_enabled = false;

			if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) {
				$is_registration_enabled = true;
			}

			?>
			<div id="signUpDropdown" class="dropdown-menu dropdown-unfold dropdown-menu-right py-0 mt-0" aria-labelledby="signUpDropdownInvoker" style="min-width: 500px;">
				<div class="card rounded-xs">
					<form class="js-validate" novalidate="novalidate" method="post">
						<!-- Login -->
						<div id="login" style="opacity: 1;" data-target-group="idForm" class="animated fadeIn">
							<!-- Header -->
							<div class="card-header text-center">
								<h3 class="h5 mb-0 font-weight-semi-bold"><?php echo esc_html_e( 'Login', 'mytravel' ); ?></h3>
							</div>
							<!-- End Header -->
							<div class="card-body pt-6 pb-4">
								<!-- Form Group -->
								<div class="form-group pb-1">
									<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
										<label class="sr-only" for="signinSrEmail"><?php echo esc_html_e( 'Email', 'mytravel' ); ?></label>
										<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
											<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="signinSrEmail" autocomplete="username" placeholder="<?php esc_attr_e( 'Email or username', 'mytravel' ); ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php //phpcs:ignore ?>
											<div class="input-group-append">
												<span class="input-group-text" id="signinEmail">
													<span class="far fa-envelope font-size-20"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
								<!-- End Form Group -->
								<!-- Form Group -->
								<div class="form-group pb-1">
									<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
										<label class="sr-only" for="signinSrPassword"><?php esc_html_e( 'Password', 'mytravel' ); ?></label>
										<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
											<input class="woocommerce-Input5 woocommerce-Input--text5 input-text form-control" type="password" name="password" id="signinSrPassword" placeholder="<?php esc_attr_e( 'Password', 'mytravel' ); ?>" autocomplete="current-password" />
											<div class="input-group-prepend">
												<span class="input-group-text" id="signinPassword">
													<span class="flaticon-password font-size-20"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
								<!-- End Form Group -->
								<div class="mb-3 pb-1">
									<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
									<button type="submit" class="woocommerce-Button woocommerce-button btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover" name="login" value="<?php esc_attr_e( 'Sign in', 'mytravel' ); ?>"><?php esc_html_e( 'Login', 'mytravel' ); ?></button>
								</div>
								<div class="d-flex justify-content-between mb-1">
									<div class="custom-control custom-checkbox custom-control-inline">
										<input type="checkbox" id="customCheckboxInline1" class="woocommerce-form__input woocommerce-form__input-checkbox form-check-input custom-control-input" name="customCheckboxInline1"/>
										<label class="custom-control-label" for="customCheckboxInline1"><?php esc_html_e( 'Remember me', 'mytravel' ); ?></label>
									</div>
									<a class="js-animation-link text-primary font-size-14" href="<?php echo esc_url( wp_lostpassword_url() ); ?>" data-target="#forgotPassword" data-link-group="idForm" data-animation-in="fadeIn"><u><?php esc_html_e( 'Forgot Password?', 'mytravel' ); ?></u></a>
								</div>
							</div>
							<?php if ( $is_registration_enabled ) { ?>
								<div class="card-footer p-0">
									<div class="card-footer__bottom p-4 text-center font-size-14">
										<span class="text-gray-1"><?php echo esc_html__( 'Do not have an account?', 'mytravel' ); ?></span>
										<a class="js-animation-link font-weight-bold" href="javascript:;" data-target="#signup" data-link-group="idForm" data-animation-in="fadeIn"><?php echo esc_html__( 'Sign Up', 'mytravel' ); ?></a>
									</div>
								</div>
								<?php
							}
							?>
						</div>
						<!-- End Login -->
						<?php if ( $is_registration_enabled ) { ?>
						<!-- Signup -->
							<div id="signup" style="opacity: 0; display: none;" data-target-group="idForm">
								<!-- Header -->
								<div class="card-header text-center">
									<h3 class="h5 mb-0 font-weight-semi-bold"><?php echo esc_html__( 'Register', 'mytravel' ); ?></h3>
								</div>
								<!-- End Header -->
								<div class="card-body pt-5 pb-4">

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
										<!-- Form Group -->
										<div class="form-group pb-1">
											<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
												<label class="sr-only" for="uname"><?php esc_html_e( 'Username', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
												<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
													<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" placeholder="<?php esc_attr_e( 'Username', 'mytravel' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php //phpcs:ignore ?>
													<div class="input-group-append">
														<span class="input-group-text" id="username">
															<span class="flaticon-user font-size-20"></span>
														</span>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
										<!-- End Form Group -->

										<!-- Form Group -->
										<div class="form-group pb-1">
											<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
												<label class="sr-only" for="name"><?php esc_html_e( 'Full Name', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
												<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
													<input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_attr_e( 'Full Name', 'mytravel' ); ?>" aria-label="Full Name" aria-describedby="normalname" required="" data-msg="Please enter a valid name." data-error-class="u-has-error" data-success-class="u-has-success">
													<div class="input-group-append">
														<span class="input-group-text" id="normalname">
															<span class="flaticon-browser-1 font-size-20"></span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<!-- End Form Group -->

										<!-- Form Group -->
										<div class="form-group pb-1">
											<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
												<label class="sr-only" for="signupSrEmail"><?php esc_html_e( 'Email address', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
												<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
													<input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="signupSrEmail" placeholder="<?php esc_attr_e( 'Email', 'mytravel' ); ?>" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php //phpcs:ignore ?>
													<div class="input-group-append">
														<span class="input-group-text" id="signupEmail">
															<span class="far fa-envelope font-size-20"></span>
														</span>
													</div>
												</div>
											</div>
										</div>
										<!-- End Form Group -->
									<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
										<!-- Form Group -->
										<div class="form-group pb-1">
											<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
												<label class="sr-only" for="signupSrPassword"><?php esc_html_e( 'Password', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
												<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
													<input type="password" class="woocommerce-Input6 woocommerce-Input--text6 input-text form-control" name="password" id="reg_password" placeholder="<?php esc_attr_e( 'Password', 'mytravel' ); ?>" autocomplete="new-password" />
													<div class="input-group-prepend">
														<span class="input-group-text" id="signupPassword">
															<span class="flaticon-password font-size-20"></span>
														</span>
													</div>
												</div>
											</div>
										</div>
									<?php else : ?>
										<p><?php esc_html_e( 'A password will be sent to your email address.', 'mytravel' ); ?></p>
									<?php endif; ?>
										<!-- End Form Group -->
										<div class="mb-3 pb-1">
											<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
												<button type="submit" class="btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover" name="register" value="<?php esc_attr_e( 'Register', 'mytravel' ); ?>"><?php esc_html_e( 'Register', 'mytravel' ); ?></button>
										</div>
										<div class="d-flex justify-content-between mb-1">
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" id="customCheckboxInline2" name="customCheckboxInline2" class="custom-control-input">
												<label class="custom-control-label" for="customCheckboxInline2"><?php esc_html_e( 'I have read and accept the', 'mytravel' ); ?> <a href="#"><?php esc_html_e( 'Terms and Privacy Policy', 'mytravel' ); ?></a></label>
											</div>
										</div>
								</div>
								<div class="card-footer p-0">
									<div class="card-footer__bottom p-4 text-center font-size-14">
										<span class="text-gray-1"><?php echo esc_html__( 'Already have an account?', 'mytravel' ); ?></span>
										<a class="js-animation-link font-weight-bold" href="javascript:;" data-target="#login" data-link-group="idForm" data-animation-in="fadeIn"><?php echo esc_html__( 'Log In', 'mytravel' ); ?></a>
									</div>
								</div>
							</div>
							<?php
						}
						?>
						<!-- End Signup -->

							<!-- Forgot Passwrd -->
							<div id="forgotPassword" style="opacity: 0; display: none;" data-target-group="idForm">
								<!-- Header -->
								<div class="card-header bg-light text-center py-3 px-5">
									<h3 class="h6 mb-0 font-weight-semi-bold"><?php esc_html_e( 'Recover password', 'mytravel' ); ?></h3>
								</div>
								<!-- End Header -->
								<div class="card-body px-10 py-5">
									<!-- Form Group -->
									<div class="form-group">
										<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
											<label class="sr-only" for="recoverSrEmail"><?php esc_html_e( 'Your email', 'mytravel' ); ?></label>
											<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
												<input class="woocommerce-Input woocommerce-Input--text input-text form-control height-50" type="text" name="user_login" id="recoverSrEmail" autocomplete="username" placeholder="<?php esc_attr_e( 'Your email', 'mytravel' ); ?>"/>
												<div class="input-group-append">
													<span class="input-group-text" id="recoverEmail">
														<span class="far fa-envelope font-size-20"></span>
													</span>
												</div>
											</div>
										</div>
									</div>
									<!-- End Form Group -->
									<div class="mb-2">
										<button type="submit" class="btn btn-sm btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover" value="<?php esc_attr_e( 'Reset password', 'mytravel' ); ?>"><?php esc_html_e( 'Recover Password', 'mytravel' ); ?></button>
									</div>
									<div class="text-center font-size-14">
										<span class="text-gray-1"><?php esc_html_e( 'Remember your password?', 'mytravel' ); ?></span>
										<a class="js-animation-link font-weight-bold" href="javascript:;" data-target="#login" data-link-group="idForm" data-animation-in="fadeIn"><?php esc_html_e( 'Log In', 'mytravel' ); ?></a>
									</div>
								</div>
							</div>
						<!-- End Forgot Passwrd -->
					</form>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_header_language_dropdown_enable' ) ) {
	/**
	 * Language Dropdown Enable / Disable.
	 */
	function mytravel_header_language_dropdown_enable() {

		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$enable_language_dropdown = isset( $myt_page_options['header']['mytravel_enable_language_dropdown'] ) ? $myt_page_options['header']['mytravel_enable_language_dropdown'] : '';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() ) ) ) {
			$enable_language_dropdown = get_theme_mod( 'mytravel_shop_language_dropdown_enable', 'no' );
		} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
			$enable_language_dropdown = get_theme_mod( 'mytravel_404_language_dropdown_enable', 'no' );
		} else {
			$enable_language_dropdown = get_theme_mod( 'mytravel_language_dropdown_enable', 'no' );
		}
		return apply_filters( 'mytravel_language_dropdown', filter_var( $enable_language_dropdown, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_top_navbar_language_dropdown' ) ) {
	/**
	 * Top Navbar Language Dropdown.
	 */
	function mytravel_top_navbar_language_dropdown() {

		$header_style = mytravel_get_header_style();
		$divider      = '';
		if ( mytravel_transparent_header_enable() || 'v4' === $header_style ) {
			$divider = 'u-header__topbar-divider';
		} else {
			$divider = 'u-header__topbar-divider--dark';
		}

		if ( 'v3' === $header_style || 'v4' === $header_style ) {
			$padding = 'py-2';
		} else {
			$padding = 'py-3';
		}

		$nav_link = 'dropdown-nav-link dropdown-toggle d-flex align-items-center ml-1 ' . $padding;

		if ( 'v8' === $header_style ) {
			$divider  = 'u-header__topbar-divider--dark';
			$nav_link = 'dropdown-nav-link dropdown-toggle d-flex align-items-center ml-1';
		}

		if ( 'v4' === $header_style ) {
			$nav_link .= ' dropdown-nav-link-dark';
		}

		if ( mytravel_header_language_dropdown_enable() ) :
			?>
			<div class="position-relative pl-3 language-switcher dropdown-connector-xl <?php echo esc_attr( $divider ); ?>">
				<?php
				if ( has_nav_menu( 'topbar_right' ) ) {
					$args = apply_filters(
						'mytravel_topbar_right_menu_args',
						array(
							'theme_location' => 'topbar_right',
							'walker'         => new WP_Bootstrap_Navwalker(),
							'container'      => false,
							'menu_class'     => 'list-unstyled mb-0 pl-0',
							'classes'        => array(
								'nav-link'      => $nav_link,
								'dropdown'      => '',
								'dropdown-menu' => array( 'dropdown-menu', 'dropdown-unfold', 'dropdown-menu-right', 'mt-0' ),
							),
						)
					);
					wp_nav_menu( $args );
				}
				?>
			</div>
			<?php
		endif;
	}
}



if ( ! function_exists( 'mytravel_responsive_toggler' ) ) {
	/**
	 * Displays Responsive Toggler in Header.
	 *
	 * @return void
	 */
	function mytravel_responsive_toggler() {
		$header_style = mytravel_get_header_style();

		if ( has_nav_menu( 'primary' ) ) :
			$toggler = '';

			if ( ! class_exists( 'MAS_Travels' ) ) {
				$toggler = 'u-hamburger--white';
			} elseif ( mytravel_transparent_header_enable() && 'v2' !== $header_style && 'v4' !== $header_style && 'v8' !== $header_style ) {
				$toggler = 'u-hamburger--white';
			} else {
				$toggler = 'u-hamburger--primary';
			}
			?>
			<button type="button" class="navbar-toggler btn u-hamburger <?php echo esc_attr( $toggler ); ?> order-2 ml-3" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'mytravel' ); ?>" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
				<span id="hamburgerTrigger" class="u-hamburger__box">
					<span class="u-hamburger__inner"></span>
				</span>
			</button>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_header_primary_menu' ) ) {
	/**
	 * Displays Navbar in Header v1
	 *
	 * @return void
	 */
	function mytravel_header_primary_menu() {

		$header_style = mytravel_get_header_style();
		$classes      = '';

		if ( 'v2' === $header_style ) {
			$classes = 'navbar-collapse u-header__navbar-collapse u-header-left-aligned-nav collapse order-2 order-xl-0 pt-4 pt-xl-0';
		} elseif ( 'v4' === $header_style ) {
			$classes = 'navbar-collapse u-header__navbar-collapse u-header-left-aligned-nav collapse order-2 order-xl-0 pt-4 pt-xl-0 pl-xl-6';
		} elseif ( 'v6' === $header_style ) {
			$classes = 'navbar-collapse u-header__navbar-collapse u-header-left-aligned-nav collapse order-2 order-xl-0 pt-4 pt-xl-0 pl-xl-4';
		} else {
			$classes = 'navbar-collapse u-header__navbar-collapse collapse order-2 order-xl-0 pt-4 p-xl-0 position-relative';
		}

		$menu_class = '';
		if ( 'v2' === $header_style || 'v4' === $header_style || 'v6' === $header_style ) {
			$menu_class = 'navbar-nav u-header__navbar-nav position-relative flex-wrap';
		} else {
			$menu_class = 'navbar-nav u-header__navbar-nav flex-wrap';
		}

		if ( has_nav_menu( 'primary' ) ) :
			?>
			<div id="navBar" class="<?php echo esc_attr( $classes ); ?>">
				<?php
					wp_nav_menu(
						array(
							'theme_location'     => 'primary',
							'walker'             => new WP_Bootstrap_Navwalker(),
							'container'          => false,
							'menu_class'         => $menu_class,
							'sub_menu_min_width' => '230px',
							'classes'            => array(
								'nav-link'        => 'nav-link u-header__nav-link u-header__nav-link-border',
								'dropdown-toggle' => 'u-header__nav-link-toggle',
								'dropdown-item'   => 'nav-link u-header__sub-menu-nav-link',
								'dropdown-menu'   => array( 'hs-sub-menu', 'u-header__sub-menu', 'u-header__sub-menu-rounded', 'u-header__sub-menu-bordered', 'hs-sub-menu-right', 'u-header__sub-menu--spacer' ),
							),
						)
					);
				?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_navbar_search_enable' ) ) {
	/**
	 * Navbar Search Enable / Disable.
	 */
	function mytravel_navbar_search_enable() {

		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();
		$myt_page_options = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$search_enable = isset( $myt_page_options['header']['mytravel_enable_search'] ) ? $myt_page_options['header']['mytravel_enable_search'] : 'yes';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
			$search_enable = get_theme_mod( 'mytravel_shop_enable_search', 'yes' );
		} else {
			$search_enable = get_theme_mod( 'mytravel_navbar_enable_search', 'yes' );
		}

		return apply_filters( 'mytravel_navbar_search', filter_var( $search_enable, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_navbar_search' ) ) {
	/**
	 * Primary Navbar Search.
	 */
	function mytravel_navbar_search() {

		$header_style = mytravel_get_header_style();
		$classes      = '';
		$span_classes = '';
		$add_classes  = '';

		if ( ! class_exists( 'MAS_Travels' ) ) {
			if ( mytravel_transparent_header_enable() && ! class_exists( 'MAS_Travels' ) ) {
				$span_classes = 'text-white';
				$add_classes  = 'd-flex align-items-center text-white';
			}
		} else {
			if ( mytravel_transparent_header_enable() && 'v8' !== $header_style && 'v2' !== $header_style ) {
				$span_classes = 'text-white';
				$add_classes  = 'd-flex align-items-center text-white';
			} else {
				$span_classes = 'text-dark';
				$add_classes  = 'd-flex align-items-center text-dark';
			}
		}

		if ( 'v1' === $header_style ) {
			$classes       = ' position-relative u-header__hide-content u-header__search-lg pl-2 ml-2 d-xl-none d-wd-block';
			$span_classes .= ' min-width-220';
			$add_classes  .= ' p-0';
		} elseif ( 'v5' === $header_style ) {
			$classes       = ' position-relative u-header__hide-content u-header__search-lg pl-4 d-xl-none d-wd-block';
			$span_classes .= ' min-width-254';
			$add_classes  .= ' p-0';
		} else {
			$classes       = ' position-relative u-header__hide-content u-header__search-lg';
			$span_classes .= ' font-size-14 min-width-178';
			$add_classes  .= ' pl-2 ml-2';
		}
		if ( mytravel_navbar_search_enable() ) :
			if ( class_exists( 'MAS_Travels' ) ) {
				$search_label = esc_html__( 'Destination, tour, hotel, etc', 'mytravel' );
			} else {
				$search_label = esc_html__( 'Search', 'mytravel' );
			}

			?>
			<div class="<?php echo esc_attr( $classes ); ?>">
				<a id="searchSlideDownInvoker" class="d-block u-search-slide-down-trigger" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false" aria-controls="searchSlideDown" data-unfold-type="css-animation" data-unfold-hide-on-scroll="false" data-unfold-target="#searchSlideDown" data-unfold-animation-in="active" data-unfold-animation-out="fadeOutUp" data-unfold-delay="0" data-unfold-duration="800" data-unfold-overlay='{ "className": "u-search-slide-down-bg-overlay", "background": "rgba(59, 68, 79, 0.851)", "animationSpeed": 400 }'>
					<div class="d-flex align-items-center">
						<span class="<?php echo esc_attr( $span_classes ); ?>"><?php echo esc_html( $search_label ); ?></span>
						<span class="<?php echo esc_attr( $add_classes ); ?>">
							<span class="flaticon-magnifying-glass font-size-20"></span>
						</span>
					</div>
				</a>
				<!-- Search Content -->
				<div id="searchSlideDown" class="dropdown-unfold u-search-slide-down" aria-labelledby="searchSlideDownInvoker">
					<?php if ( class_exists( 'MAS_Travels' ) ) { ?>
						<form role="search" method="get" class="rounded-xs overflow-hidden" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<!-- Input Group -->
							<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless u-search-slide-down__input rounded-0 px-1">
								<input type="search" class="form-control" placeholder="<?php echo esc_attr_x( 'Destination, tour, hotel, etc', 'placeholder', 'mytravel' ); ?>" aria-label="Destination, tour, hotel, etc" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
								<input type="hidden" class="form-control" name="post_type" value="product">

								<div class="input-group-append">
									<button type="submit" class="btn py-0">
										<span class="flaticon-magnifying-glass font-size-20"></span>
									</button>
								</div>
							</div>
							<!-- End Input Group -->
						</form>
						<?php
					} else {
						get_search_form();
					}
					?>
				</div>
				<!-- End Search Content -->
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_search_dropdown' ) ) {
	/**
	 * Display search form as a dropdown.
	 */
	function mytravel_search_dropdown() {

		$header_style   = mytravel_get_header_style();
		$classes        = 'position-relative';
		$anchor_classes = '';
		if ( 'v4' === $header_style ) {
			$classes       .= ' u-header__search-xl';
			$anchor_classes = 'btn-text-dark';
		} else {
			$classes       .= ' u-header__search-lg pl-xl-4 ml-xl-1';
			$anchor_classes = 'btn-text-secondary';
		}

		if ( mytravel_navbar_search_enable() ) :
			?>
			<div class="<?php echo esc_attr( $classes ); ?>">
				<a id="searchClassicInvoker" class="<?php echo esc_attr( $anchor_classes ); ?>" href="javascript:;" role="button" aria-controls="searchClassic" aria-haspopup="true" aria-expanded="false" data-unfold-target="#searchClassic" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
					<span class="flaticon-magnifying-glass-1 font-size-20"></span>
				</a>
				<!-- Input -->
				<div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right u-unfold--css-animation u-unfold--hidden" aria-labelledby="searchClassicInvoker">
					<form class="js-focus-state input-group px-3" style="width: 370px;">
						<input class="form-control" type="search" placeholder="<?php printf( esc_html( 'Search' ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
						<div class="input-group-append">
							<button class="btn btn-primary" type="submit"><?php printf( esc_html( 'search' ) ); ?></button>
						</div>
					</form>
				</div>
				<!-- End Input -->
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_enable_navbar_button' ) ) {
	/**
	 * Check Header Navbar Button Enable or Disable.
	 *
	 * @return bool
	 */
	function mytravel_enable_navbar_button() {

		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}

		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$navbar_button_enable = isset( $myt_page_options['header']['mytravel_navbar_button_enable'] ) ? $myt_page_options['header']['mytravel_navbar_button_enable'] : '';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
			$navbar_button_enable = get_theme_mod( 'mytravel_shop_enable_navbar_button', 'no' );
		} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
			$navbar_button_enable = get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' );
		} else {
			$navbar_button_enable = get_theme_mod( 'mytravel_enable_header_navbar_button', 'no' );
		}

		return apply_filters( 'mytravel_navbar_button', filter_var( $navbar_button_enable, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_navbar_button' ) ) {
	/**
	 * Primary Navbar Button.
	 */
	function mytravel_navbar_button() {

		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}

		$header_style = mytravel_get_header_style();
		$classes      = '';
		if ( 'v1' === $header_style || 'v5' === $header_style || 'v6' === $header_style || 'v8' === $header_style ) {
			$classes = 'pl-4 ml-1 u-header__last-item-btn u-header__last-item-btn-xl';
		} elseif ( 'v2' === $header_style ) {
			$classes = 'u-header__last-item-btn u-header__last-item-btn-xl';
		} elseif ( 'v4' === $header_style ) {
			$classes = 'pl-4 ml-2 u-header__last-item-btn u-header__last-item-btn-lg';
		} elseif ( 'v7' === $header_style ) {
			$classes = 'pl-4 ml-1 u-header__last-item-btn u-header__last-item-btn-lg';
		}

		if ( mytravel_enable_navbar_button() ) :
			if ( mytravel_has_custom_header( $myt_page_options ) ) {
				$button_text    = isset( $myt_page_options['header']['mytravel_navbar_button_text'] ) ? $myt_page_options['header']['mytravel_navbar_button_text'] : 'Become Local Expert';
				$button_url     = isset( $myt_page_options['header']['mytravel_navbar_button_link'] ) ? $myt_page_options['header']['mytravel_navbar_button_link'] : '#';
				$button_color   = isset( $myt_page_options['header']['mytravel_navbar_button_skin'] ) ? $myt_page_options['header']['mytravel_navbar_button_skin'] : 'white';
				$button_size    = isset( $myt_page_options['header']['mytravel_navbar_button_size'] ) ? $myt_page_options['header']['mytravel_navbar_button_size'] : 'wide';
				$button_shape   = isset( $myt_page_options['header']['mytravel_navbar_button_shape'] ) ? $myt_page_options['header']['mytravel_navbar_button_shape'] : 'rounded-xs';
				$button_variant = isset( $myt_page_options['header']['mytravel_navbar_button_variant'] ) ? $myt_page_options['header']['mytravel_navbar_button_variant'] : '';
				$button_css     = isset( $myt_page_options['header']['mytravel_navbar_button_css'] ) ? $myt_page_options['header']['mytravel_navbar_button_css'] : '';

			} elseif ( $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
				$button_text    = get_theme_mod( 'mytravel_shop_header_navbar_button_text', 'Become Local Expert' );
				$button_url     = get_theme_mod( 'mytravel_shop_header_navbar_button_url', '#' );
				$button_color   = get_theme_mod( 'mytravel_shop_header_navbar_button_color', 'primary' );
				$button_size    = get_theme_mod( 'mytravel_shop_header_navbar_button_size', 'wide' );
				$button_shape   = get_theme_mod( 'mytravel_shop_header_navbar_button_shape', 'rounded-xs' );
				$button_variant = get_theme_mod( 'mytravel_shop_header_navbar_button_variant', '' );
				$button_css     = get_theme_mod( 'mytravel_shop_header_button_css' );

			} elseif ( is_404() ) {
				$button_text    = get_theme_mod( 'mytravel_404_header_navbar_button_text', 'Become Local Expert' );
				$button_url     = get_theme_mod( 'mytravel_404_header_navbar_button_url', '#' );
				$button_color   = get_theme_mod( 'mytravel_404_header_navbar_button_color', 'primary' );
				$button_size    = get_theme_mod( 'mytravel_404_header_navbar_button_size', 'wide' );
				$button_shape   = get_theme_mod( 'mytravel_404_header_navbar_button_shape', 'rounded-xs' );
				$button_variant = get_theme_mod( 'mytravel_404_header_navbar_button_variant', '' );
				$button_css     = get_theme_mod( 'mytravel_404_header_button_css' );

			} else {
				$button_text    = get_theme_mod( 'header_navbar_button_text', 'Become Local Expert' );
				$button_url     = get_theme_mod( 'header_navbar_button_url', '#' );
				$button_color   = get_theme_mod( 'header_navbar_button_color', 'white' );
				$button_size    = get_theme_mod( 'header_navbar_button_size', 'wide' );
				$button_shape   = get_theme_mod( 'header_navbar_button_shape', 'rounded-xs' );
				$button_variant = get_theme_mod( 'header_navbar_link_button_variant', '' );
				$button_css     = get_theme_mod( 'mytravel_header_button_css' );
			}

			$button_variant = ! empty( $button_variant ) ? 'btn-' . $button_variant . '-' . $button_color : 'btn-' . $button_color;

			if ( 'link' === $button_color ) {
				'btn-outline-' . $button_color;
			} else {
				'btn-' . $button_color;
			}

			$button_class = array(
				'mytravel-header-navbar-button',
				'btn',
				$button_shape,
				'btn-' . $button_size,
				$button_css,
				$button_variant,
				'transition-3d-hover',
			);
			?>
			<div class="<?php echo esc_attr( $classes ); ?>">
				<a 
					<?php
					mytravel_render_attr(
						'header_navbar_button',
						array(
							'href'  => $button_url,
							'class' => join(
								' ',
								$button_class
							),
						)
					);
					?>
				>
					<?php echo esc_html( $button_text ); ?>
				</a>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_header_v3_top_navbar_starts' ) ) {
	/**
	 * Topbar <div> Starts.
	 */
	function mytravel_header_v3_top_navbar_starts() {

		$myt_page_options = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_top_navbar_enable() ) :

			if ( mytravel_has_custom_header( $myt_page_options ) ) {
				$classes = isset( $myt_page_options['header']['mytravel_top_navbar_skin'] ) ? 'bg-' . $myt_page_options['header']['mytravel_top_navbar_skin'] : '';
			} else {
				$classes = 'bg-' . get_theme_mod( 'topbar_skin', 'violet' );
			}
			?>
			<div class="<?php echo esc_attr( $classes ); ?> u-header__hide-content u-header__topbar u-header__topbar-lg py-1">
				<div class="container">
					<div class="d-flex align-items-center">
						<?php
							mytravel_navbar_search();
							mytravel_header_v3_topbar_right();

		endif;
	}
}

if ( ! function_exists( 'mytravel_header_v3_top_navbar_end' ) ) {
	/**
	 * Topbar </div> End.
	 */
	function mytravel_header_v3_top_navbar_end() {
		if ( mytravel_top_navbar_enable() ) :
			?>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'mytravel_header_v3_topbar_button' ) ) {
	/**
	 * Topbar Button For Header v3.
	 */
	function mytravel_header_v3_topbar_button() {

		if ( mytravel_enable_navbar_button() ) {

			$button_text = get_theme_mod( 'header_navbar_button_text', 'Become Local Expert' );
			$button_url  = get_theme_mod( 'header_navbar_button_url', '#' );
			$button_css  = get_theme_mod( 'mytravel_header_button_css' );
			$color       = ( mytravel_transparent_header_enable() ) ? 'text-white' : 'text-dark';

			$button_class = array(
				'mytravel-header-navbar-button',
				'btn',
				'btn-text',
				'font-size-14',
				$color,
				$button_css,
			);
			?>
			<div class="mr-1">
				<a 
					<?php
					mytravel_render_attr(
						'header_navbar_button',
						array(
							'href'  => $button_url,
							'class' => join(
								' ',
								$button_class
							),
						)
					);
					?>
				>
					<?php echo esc_html( $button_text ); ?>
				</a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_header_v3_topbar_right' ) ) {
	/**
	 * Topbar For Header v3.
	 */
	function mytravel_header_v3_topbar_right() {

		?>
		<div class="ml-auto d-flex align-items-center">
			<?php
			mytravel_header_v3_topbar_button();
			mytravel_header_navbar_account();
			mytravel_top_navbar_language_dropdown();
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_navbar_is_sticky' ) ) {
	/**
	 * Enable Sticky
	 */
	function mytravel_navbar_is_sticky() {
		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$enable_sticky = isset( $myt_page_options['header']['mytravel_enable_sticky_header'] ) ? $myt_page_options['header']['mytravel_enable_sticky_header'] : 'no';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
			$enable_sticky = get_theme_mod( 'mytravel_shop_enable_sticky', 'no' );
		} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
			$enable_sticky = get_theme_mod( 'mytravel_404_enable_sticky', 'no' );
		} else {
			$enable_sticky = get_theme_mod( 'enable_sticky', 'no' );
		}

		return apply_filters( 'mytravel_enable_sticky', filter_var( $enable_sticky, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_navbar_enable_minicart' ) ) {
	/**
	 * Navbar Minicart Enable / Disable.
	 */
	function mytravel_navbar_enable_minicart() {

		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$enable_minicart = isset( $myt_page_options['header']['mytravel_mini_cart_enable'] ) ? $myt_page_options['header']['mytravel_mini_cart_enable'] : 'yes';
		} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
			$enable_minicart = get_theme_mod( 'mytravel_shop_enable_mini_cart', 'yes' );
		} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
			$enable_minicart = get_theme_mod( 'mytravel_404_enable_mini_cart', 'no' );
		} else {
			$enable_minicart = get_theme_mod( 'mytravel_enable_mini_cart', 'yes' );
		}
		return apply_filters( 'mytravel_enable_minicart', filter_var( $enable_minicart, FILTER_VALIDATE_BOOLEAN ) );
	}
}

if ( ! function_exists( 'mytravel_navbar_cart_toggle' ) ) {
	/**
	 * Outputs the mini cart toggle
	 *
	 * Applicable for headers.
	 *
	 * @since 1.0.0
	 */
	function mytravel_navbar_cart_toggle() {
		$header_style = mytravel_get_header_style();
		if ( mytravel_is_woocommerce_activated() && mytravel_navbar_enable_minicart() ) {
			$header_style   = mytravel_get_header_style();
			$anchor_classes = 'py-4 position-relative';
			if ( 'v2' === $header_style ) {
				$anchor_classes .= ' btn-text-primary';
			} elseif ( 'v4' === $header_style ) {
				$anchor_classes .= ' btn-text-dark';
			} elseif ( 'v7' === $header_style ) {
				$anchor_classes = ' btn btn-xs btn-icon btn-text-secondary';
			} else {
				$anchor_classes .= ' btn-text-secondary';
			}
			if ( ! class_exists( 'MAS_Travels' ) || mytravel_transparent_header_enable() ) {
				$color = 'text-white-max-lg';
			} else {
				$color = 'text-primary-max-lg';
			}

			if ( 'v1' === $header_style ) {
				$classes = 'flaticon-shopping-basket font-size-25';
			} elseif ( 'v2' === $header_style ) {
				$classes = ' flaticon-shopping-basket font-size-22 ' . $color;
			} elseif ( 'v7' === $header_style ) {
				$classes = 'flaticon-shopping-basket btn-icon__inner font-size-25 ' . $color;
			} elseif ( 'v3' === $header_style || 'v5' === $header_style || 'v6' === $header_style ) {
				$classes = 'flaticon-shopping-basket font-size-25 ' . $color;
			} elseif ( 'v4' === $header_style ) {
				$classes = 'flaticon-shopping-basket font-size-25 text-primary-max-lg';
			} else {
				$classes = 'flaticon-shopping-basket font-size-25 ' . $color;
			}

			?>
			<a id="shoppingCartDropdownInvoker" class="<?php echo esc_attr( $anchor_classes ); ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" role="button" aria-controls="shoppingCartDropdown" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#shoppingCartDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
				<span class="<?php echo esc_attr( $classes ); ?>"></span>
				<span class="badge rounded-circle position-absolute right-end"><?php mytravel_cart_link_count(); ?></span>
			</a>
			<?php

			$cart_classes = 'dropdown-menu dropdown-unfold dropdown-menu-right ';
			if ( mytravel_enable_navbar_button() ) {
				$cart_attr = 'dropdown-menu-right-fix-wd-10 p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16';
				$attr      = 'dropdown-menu-right-fix-wd-10 text-center p-0';
			} else {
				$cart_attr = 'p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16 p-0';
				$attr      = 'text-center';
			}
			if ( 'v1' === $header_style ) {
				$cart_classes .= ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ? $cart_attr : $attr;
			} elseif ( 'v4' === $header_style ) {
				$cart_classes .= ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ? ' dropdown-menu-right-fix-wd-10 p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16' : ' dropdown-menu-right-fix-wd-10 text-center p-0';
			} elseif ( 'v2' === $header_style ) {
				$cart_classes .= ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ? 'dropdown-menu-right-fix-wd-20 dropdown-menu-right-fix-xl-10 p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16 p-0' : ' dropdown-menu-right-fix-wd-20 dropdown-menu-right-fix-xl-10 text-center';
			} elseif ( 'v3' === $header_style ) {
				$cart_classes .= ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ? ' p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16 p-0' : ' text-center';
			} elseif ( 'v7' === $header_style ) {
				$cart_classes .= ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ? ' dropdown-menu-right-fix-xl-15 dropdown-menu-right-fix-wd-10 p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16 p-0' : ' dropdown-menu-right-fix-xl-15 dropdown-menu-right-fix-wd-10 text-center';
			} else {
				$cart_classes .= ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ? ' dropdown-menu-right-fix-wd-10 p-0 mt-0 w-max-sm-100 u-unfold--css-animation font-size-16' : ' dropdown-menu-right-fix-wd-10 text-center p-0';
			}

			if ( ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ) {
				?>
				<div id="shoppingCartDropdown" class="<?php echo esc_attr( $cart_classes ); ?>" aria-labelledby="shoppingCartDropdownInvoker" style="width: 500px; animation-duration: 300ms; right: 0px;">
				<?php
			} else {
				?>
				<div id="shoppingCartDropdown" class="<?php echo esc_attr( $cart_classes ); ?>" aria-labelledby="shoppingCartDropdownInvoker" style="width: 250px; animation-duration: 300ms; right: 0px;">
				<?php
			}
			if ( ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ) {
				?>
				<div class="card">
					<div class="card-header border-color-8 py-3 px-5">
						<span class="font-weight-semi-bold"><?php echo esc_html_x( 'Your Cart', 'front-end', 'mytravel' ); ?></span>
					</div>
					<?php
			}
					mytravel_mini_cart_content();
			?>
			</div>
			<?php
			if ( ( is_a( WC()->cart, 'WC_Cart' ) && ! WC()->cart->is_empty() ) ) {
				?>
				</div>
				<?php
			}
		}
	}
}



if ( ! function_exists( 'mytravel_navbar_mini_cart' ) ) {
	/**
	 *
	 * Mini cart function.
	 */
	function mytravel_navbar_mini_cart() {

		if ( mytravel_is_woocommerce_activated() && mytravel_navbar_enable_minicart() ) {

			$header_style = mytravel_get_header_style();
			$classes      = 'shopping-cart position-relative';
			if ( 'v1' === $header_style ) {
				$classes .= ' pl-2 pl-md-4 ml-auto d-none d-xl-block';
			} elseif ( 'v2' === $header_style ) {
				$classes .= ' pr-xl-4 mr-xl-1 ml-auto d-none d-md-block';
			} elseif ( 'v5' === $header_style ) {
				$classes .= ' pl-md-4 ml-auto';
			} elseif ( 'v7' === $header_style ) {
				$classes .= ' pl-md-4 ml-xl-1 ml-auto';
			} else {
				$classes .= ' pl-2 pl-md-4 ml-auto';
			}

			?>
			<div class="<?php echo esc_attr( $classes ); ?>">
				<?php mytravel_navbar_cart_toggle(); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_sticky_header_logo' ) ) {
	/**
	 * Returns a logo for sticky.
	 *
	 * @since 1.0.0
	 * @param bool  $echo Echo the string or return it.
	 * @param class $classes variable.
	 * @return string
	 */
	function mytravel_sticky_header_logo( $echo = true, $classes = array() ) {

		$myt_page_options = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}

		$defaults = array(
			'custom-logo-link' => 'navbar-brand u-header__navbar-brand u-header__navbar-brand-center u-header__navbar-brand-on-scroll ',
			'custom-logo'      => 'navbar-brand-img',
			'site-title'       => 'navbar-brand u-header__navbar-brand u-header__navbar-brand-center u-header__navbar-brand-on-scroll',
		);
		$classes  = wp_parse_args( $classes, $defaults );

		$sticky_logo_id['id'] = get_theme_mod( 'sticky_logo' );

		$enable_elementor_logo    = isset( $myt_page_options['header']['mytravel_use_custom_logo'] ) ? $myt_page_options['header']['mytravel_use_custom_logo'] : 'no';
		$elementor_logo_id        = isset( $myt_page_options['header']['mytravel_sticky_logo'] ) ? $myt_page_options['header']['mytravel_sticky_logo'] : array( 'id' => get_theme_mod( 'sticky_logo' ) );
		$enable_sticky_header     = isset( $myt_page_options['header']['mytravel_enable_sticky_header'] ) ? $myt_page_options['header']['mytravel_enable_sticky_header'] : 'no';
		$logo_title               = isset( $myt_page_options['header']['mytravel_custom_logo_title'] ) ? $myt_page_options['header']['mytravel_custom_logo_title'] : get_bloginfo( 'name' );
		$elementor_custom_logo_id = isset( $myt_page_options['header']['mytravel_custom_logo'] ) ? $myt_page_options['header']['mytravel_custom_logo'] : array( 'id' => get_theme_mod( 'custom_logo' ) );
		$custom_title = '';
		if ( mytravel_has_custom_header( $myt_page_options ) && ! empty( $logo_title ) ) {
			$custom_title = $logo_title;
		}
		if ( mytravel_has_custom_header( $myt_page_options ) && 'yes' === $enable_sticky_header && ! empty( $elementor_logo_id['id'] ) ) {
			$html = sprintf(
				'<a href="%1$s" class="navbar-brand u-header__navbar-brand u-header__navbar-brand-center u-header__navbar-brand-on-scroll mytravel-elementor-sticky-logo" rel="home">%2$s<span class="u-header__navbar-brand-text">%3$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $elementor_logo_id['id'], 'full', false ),
				$custom_title
			);
		} elseif ( mytravel_has_custom_header( $myt_page_options ) && 'yes' === $enable_sticky_header && ! empty( $elementor_custom_logo_id['id'] ) && ( 'yes' === $enable_elementor_logo || empty( $elementor_logo_id['id'] ) ) ) {
			$html = sprintf(
				'<a href="%1$s" class="navbar-brand u-header__navbar-brand u-header__navbar-brand-center u-header__navbar-brand-on-scroll" rel="home">%2$s<span class="u-header__navbar-brand-text">%3$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $elementor_custom_logo_id['id'], 'full', false ),
				$custom_title
			);
		} elseif ( mytravel_navbar_is_sticky() && ! empty( $sticky_logo_id['id'] ) ) {
			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s<span class="u-header__navbar-brand-text">%3$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $sticky_logo_id['id'], 'full', false ),
				esc_html( get_bloginfo( 'name' ) )
			);
		} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() && empty( $sticky_logo_id['id'] ) && mytravel_navbar_is_sticky() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$html           = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s<span class="u-header__navbar-brand-text">%3$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_id, 'full', false ),
				esc_html( get_bloginfo( 'name' ) )
			);
		} else {
			$html = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="site-title u-header__navbar-brand-text ml-0">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
		}
		foreach ( $classes as $search => $replace ) {
			$html = str_replace( $search, $replace, $html );
		}

		if ( ! $echo ) {
			return $html;
		}

		$logo_html = apply_filters( 'mytravel_sticky_logo', $html );

		echo wp_kses( $logo_html, 'logo-html' );
	}
}

if ( ! function_exists( 'mytravel_navbar_my_account_responsive' ) ) {
	/**
	 * Navbar My Account Responsive Page.
	 */
	function mytravel_navbar_my_account_responsive() {

		$text_color = '';
		if ( mytravel_transparent_header_enable() ) {
			$text_color = 'text-white';
		}
		?>
		<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="<?php echo esc_attr( $text_color ); ?> d-xl-none font-size-20 scroll-icon order-2 mr-2 mr-lg-3 ml-auto">
			<i class="flaticon-user"></i>
		</a>
		<?php
	}
}

if ( ! function_exists( 'mytravel_navbar_container_css' ) ) {
	/**
	 * Navbar Container Css Control.
	 */
	function mytravel_navbar_container_css() {
		$myt_page_options = array();
		$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$container_css = isset( $myt_page_options['header']['mytravel_primary_navbar_css'] ) ? $myt_page_options['header']['mytravel_primary_navbar_css'] : '';
		} elseif ( 'yes' === get_theme_mod( 'shop_enable_separate_header' ) ) {
			$container_css = get_theme_mod( 'mytravel_shop_header_navbar_css' );
		} elseif ( 'yes' === get_theme_mod( '404_enable_separate_header' ) ) {
			$container_css = get_theme_mod( 'mytravel_404_header_navbar_css' );
		} else {
			$container_css = get_theme_mod( 'mytravel_header_navbar_css' );
		}
		return apply_filters( 'header_navbar_css', $container_css );
	}
}
