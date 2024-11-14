<?php
/**
 * Template functions related to Footer.
 *
 * @package mytravel/TemplateFunctions/Footer
 */

if ( ! function_exists( 'mytravel_footer_social_media_links' ) ) {
	/**
	 * Displays social media links.
	 */
	function mytravel_footer_social_media_links() {

		if ( has_nav_menu( 'social_media' ) ) {
			$args = apply_filters(
				'mytravel_topbar_social_menu_args',
				array(
					'theme_location' => 'social_media',
					'container'      => false,
					'depth'          => 1,
					'menu_class'     => 'list-inline mb-0',
					'item_class'     => 'list-inline-item mr-2',
					'icon_class'     => 'btn-icon__inner',
					'icon_txt_class' => 'sr-only',
					'walker'         => new WP_Bootstrap_Navwalker(),
					'classes'        => array(
						'nav-link' => 'btn btn-icon btn-social btn-bg-transparent',
					),
				)
			);
			wp_nav_menu( $args );
		}
	}
}

if ( ! function_exists( 'mytravel_footer_contact_wrap_starts' ) ) {
	/**
	 * Footer wrap starts from here.
	 */
	function mytravel_footer_contact_wrap_starts() {

		?>
		<div class="space-bottom-2 space-top-1">
			<div class="container">
				<div class="row justify-content-xl-between">
		<?php
	}
}

if ( ! function_exists( 'mytravel_footer_contact_wrap_end' ) ) {
	/**
	 * Footer wrap end here.
	 */
	function mytravel_footer_contact_wrap_end() {

		?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_footer_static' ) ) {
	/**
	 * MyTravel Footer Static.
	 */
	function mytravel_footer_static() {

		$myt_page_options = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data  = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}

		if ( mytravel_has_custom_footer( $myt_page_options ) ) {
			$footer_content = isset( $myt_page_options['footer']['mytravel_footer_static_widgets'] ) ? $myt_page_options['footer']['mytravel_footer_static_widgets'] : '';
			$footer_variant = isset( $myt_page_options['footer']['mytravel_footer_variant'] ) ? $myt_page_options['footer']['mytravel_footer_variant'] : 'v1';
		} else {
			$footer_content = get_theme_mod( 'footer_static_content', '' );
			$footer_variant = get_theme_mod( 'mytravel_footer_version', 'v1' );
		}

		if ( mytravel_is_mas_static_content_activated() && ! empty( $footer_content ) && 'static' === $footer_variant ) {
			print( mytravel_render_content( $footer_content, false ) ); //phpcs:ignore
		}
	}
}

if ( ! function_exists( 'mytravel_footer_widgets' ) ) {
	/**
	 * Display Footer widget.
	 */
	function mytravel_footer_widgets() {

		$rows    = intval( apply_filters( 'mytravel_footer_widget_rows', 1 ) );
		$regions = intval( apply_filters( 'mytravel_footer_widget_columns', 5 ) );

		if ( class_exists( 'MAS_Travels' ) ) {
			$col_classes = [
				'col-12 col-lg-4 col-xl-3dot1 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-1dot8 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-1dot8 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-1dot8 mb-6 mb-md-0',
				'col-12 col-md-6 col-lg col-xl-3dot1',
			];
		} else {
			$col_classes = [
				'col-12 col-md-6 col-lg-4 col-xl-2dot2 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-2dot2 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-2dot2 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-2dot2 mb-6 mb-md-10 mb-xl-0',
				'col-12 col-md-6 col-lg-4 col-xl-2dot2',
			];
		}

		for ( $row = 1; $row <= $rows; $row++ ) :

			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( 'footer-' . esc_attr( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				}
			}

			if ( isset( $columns ) ) :

				for ( $column = 1; $column <= $columns; $column++ ) :
					$footer_n = $column + $regions * ( $row - 1 );

					if ( is_active_sidebar( 'footer-' . esc_attr( $footer_n ) ) ) :
						$footer_widget_class = 'footer-widget-' . $column . ' mb-4 mb-0-last-child';
						if ( isset( $col_classes[ $column - 1 ] ) ) {
							$footer_widget_class .= ' ' . $col_classes[ $column - 1 ];
						}
						?>
					<div class="<?php echo esc_attr( $footer_widget_class ); ?>">
						<?php dynamic_sidebar( 'footer-' . esc_attr( $footer_n ) ); ?>
					</div>
						<?php
					endif;

				endfor;
				unset( $columns );
			endif;
		endfor;
	}
}

if ( ! function_exists( 'mytravel_footer_content' ) ) {
	/**
	 * Display Footer Content.
	 */
	function mytravel_footer_content() {
		?>
		<div class="space-bottom-2 space-top-1">
			<div class="container">
				<div class="row justify-content-xl-between">
					<?php mytravel_footer_widgets(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_footer_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 */
	function mytravel_footer_site_branding() {

		if ( mytravel_get_footer_logo() ) {
			mytravel_footer_logo();

		}
	}
}

if ( ! function_exists( 'mytravel_footer_logo' ) ) {
	/**
	 * Displays footer logo from  mytravel_get_footer_logo().
	 *
	 * @param bool  $echo Echo the string or return it.
	 * @param class $classes variable.
	 * @return string.
	 */
	function mytravel_footer_logo( $echo = true, $classes = array() ) {

		$footer_logo_id = mytravel_get_footer_logo();

		if ( ! empty( $footer_logo_id ) ) {
			// If the logo alt attribute is empty, get the site title.
			$footer_logo_alt = get_post_meta( $footer_logo_id, '_wp_attachment_image_alt', true );
			if ( empty( $footer_logo_alt ) ) {
				$footer_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
			}
			$html = wp_sprintf(
				'<a href="%1$s" class="footer-logo-link d-inline-flex align-items-center" rel="home">%2$s<span class="brand brand-dark">%3$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $footer_logo_id, 'thumbnail', false, $footer_logo_attr ),
				esc_html( get_bloginfo( 'name' ) )
			);
		} else {
			$html = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home" class="brand brand-dark">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
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

/**
 * Check if a page has custom footer
 *
 * @param array $options Page meta options.
 */
function mytravel_has_custom_footer( $options ) {

	$has_custom_footer = false;

	if ( isset( $options['footer'] ) && isset( $options['footer']['mytravel_enable_custom_footer'] ) && 'yes' === $options['footer']['mytravel_enable_custom_footer'] ) {
		$has_custom_footer = true;
	}
	return $has_custom_footer;
}

if ( ! function_exists( 'mytravel_scroll_to_top' ) ) {
	/**
	 * Display scroll to top button
	 *
	 * @hooked mytravel_footer_after 100
	 */
	function mytravel_scroll_to_top() {
		if ( apply_filters( 'mytravel_scroll_to_top', filter_var( get_theme_mod( 'enable_scroll_to_top', 'yes' ), FILTER_VALIDATE_BOOLEAN ) ) ) {
			?>
			<a class="js-go-to u-go-to-modern" href="#" data-position='{"bottom": 15, "right": 15 }' data-type="fixed" data-offset-top="400" data-compensation="#header" data-show-effect="slideInUp" data-hide-effect="slideOutDown">
				<span class="flaticon-arrow u-go-to-modern__inner"></span>
			</a>
			<?php
		}
	}
}
