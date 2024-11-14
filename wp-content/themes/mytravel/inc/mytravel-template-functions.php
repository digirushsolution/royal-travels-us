<?php
/**
 * MyTravel template functions.
 *
 * @package mytravel
 */

require get_template_directory() . '/inc/template-functions/global.php';
require get_template_directory() . '/inc/template-functions/header.php';
require get_template_directory() . '/inc/template-functions/footer.php';
require get_template_directory() . '/inc/template-functions/posts.php';
require get_template_directory() . '/inc/template-functions/single-post.php';
require get_template_directory() . '/inc/template-functions/global.php';

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mytravel_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}

if ( ! function_exists( 'mytravel_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function mytravel_credit() {

		$myt_page_options = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		if ( mytravel_has_custom_footer( $myt_page_options ) ) {

			$copyright = isset( $myt_page_options['footer']['mytravel_footer_copyright'] ) ? $myt_page_options['footer']['mytravel_footer_copyright'] : '';
		} else {
			$copyright = get_theme_mod( 'footer_copyright' );
		}

		if ( has_nav_menu( 'footer_links' ) ) {
			$copyright_text = 'text-left';
		} else {
			$copyright_text = 'text-center w-100';
		}

		?>
		<div class="site-credit space-1 border-top">
			<div class="container">
				<div class="d-lg-flex d-md-block justify-content-between align-items-center flex-wrap">
					<p class="mb-3 mb-lg-0 text-gray-1 <?php echo esc_attr( $copyright_text ); ?>">
						<?php
						if ( $copyright ) :
							echo wp_kses( $copyright, 'copyright' );
						else :
							/* translators: footer copy  rights*/
							echo esc_html( apply_filters( 'mytravel_copyright_text', $content = sprintf( __( '&copy; %1$s %2$s. All Rights Reserved', 'mytravel' ), gmdate( 'Y' ), get_bloginfo( 'name' ) ) ) );
						endif;
						?>
					</p>
					<?php
					if ( has_nav_menu( 'footer_links' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer_links',
								'container'      => false,
								'depth'          => 1,
								'menu_class'     => 'list-inline mb-0',
								'item_class'     => 'list-inline-item  pb-3 pb-md-0',
								'walker'         => new WP_Bootstrap_Navwalker(),
								'classes'        => array(
									'nav-link' => 'list-group-item-action text-decoration-on-hover pr-3',
								),
							)
						);
					}
					?>
				</div>
			</div>
		</div><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_get_footer_logo' ) ) {
	/**
	 * Footer Logo.
	 *
	 * @return string
	 */
	function mytravel_get_footer_logo() {
		global $post;
		$footer_logo = get_theme_mod( 'footer_logo', '' );

		return $footer_logo;
	}
}

if ( ! function_exists( 'mytravel_site_info' ) ) {
	/**
	 * Display the Site's Info.
	 *
	 * @return void
	 */
	function mytravel_site_info() {
		?>
			<div class="site-info border-top space-1">
				<div class="container">
					<div class="row d-block d-xl-flex align-items-md-center">
						<div class="col-xl-4 mb-4 mb-xl-0"><?php mytravel_footer_logo(); ?></div>
						<div class="col-xl-8 d-block d-lg-flex justify-content-xl-end align-items-center">
						<?php
						do_action( 'mytravel_site_info_right' );
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

/**
 * Sticky Header Logo
 *
 * @return bool
 */
function mytravel_has_sticky_header_logo() {
	global $post;
	$sticky_logo = get_theme_mod( 'sticky_logo', '' );

	if ( ! empty( $sticky_logo ) ) {
		return true;
	}
	return false;
}

if ( ! function_exists( 'mytravel_credit_card_img' ) ) {
	/**
	 * Displays Credit Card Image
	 *
	 * @return void
	 */
	function mytravel_credit_card_img() {
		$credit_card_image_url = apply_filters( 'mycredit_credit_card_img_url', get_template_directory_uri() . '/assets/img/credit-cards.png' );
		$myt_page_options      = array();

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}

		if ( mytravel_has_custom_header( $myt_page_options ) ) {
			$credit_card_img = isset( $myt_page_options['footer']['mytravel_footer_credit_card_image'] ) ? $myt_page_options['footer']['mytravel_footer_credit_card_image'] : '';
		} else {
			$credit_card_img = get_theme_mod( 'credit_card_image', $credit_card_image_url );
		}
		if ( empty( $credit_card_img ) ) {
			$credit_card_img = $credit_card_image_url;
		}
		?>
		<div class="mb-4 mb-lg-0">
			<img src="<?php echo esc_url( $credit_card_img ); ?>" alt="" />
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_site_branding' ) ) {
	/**
	 * Site branding wrapper and display.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function mytravel_site_branding() {

		$header_style = mytravel_get_header_style();

		mytravel_site_title_or_logo();
		if ( mytravel_navbar_is_sticky() ) :
			mytravel_sticky_header_logo();
		endif;
	}
}

if ( ! function_exists( 'mytravel_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo.
	 *
	 * @since 1.0.0
	 * @param bool  $echo Echo the string or return it.
	 * @param class $classes variable.
	 * @return string
	 */
	function mytravel_site_title_or_logo( $echo = true, $classes = array() ) {

		$header_style = mytravel_get_header_style();
		$logo_link    = '';
		$logo_text    = '';

		$transparent_logo_id['id'] = get_theme_mod( 'transparent_header_logo' );

		if ( mytravel_transparent_header_enable() ) {
			$logo_text = ' u-header__navbar-brand-text-white ';
		} else {
			$logo_text = ' u-header__navbar-brand-text-dark-xl ';
		}

		if ( ! class_exists( 'MAS_Travels' ) ) {
			if ( mytravel_transparent_header_enable() && ! class_exists( 'MAS_Travels' ) ) {
				$logo_link = 'navbar-brand u-header__navbar-brand-default u-header__navbar-brand-center u-header__navbar-brand-text-white mr-0 mr-xl-5';
			}
		} else {
			if ( 'v1' === $header_style ) {
				$logo_link = 'navbar-brand u-header__navbar-brand-default u-header__navbar-brand-center mr-0 mr-xl-5' . $logo_text;
			} elseif ( 'v2' === $header_style ) {
				$logo_link = 'navbar-brand u-header__navbar-brand-default u-header__navbar-brand-center u-header__navbar-brand-text-md u-header__navbar-brand-text-dark-xl u-header__divider-xl u-header__divider-right pr-xl-5';
			} elseif ( 'v4' === $header_style || 'v8' === $header_style || is_404() ) {
				$logo_link = 'navbar-brand u-header__navbar-brand-default u-header__navbar-brand-center u-header__navbar-brand-text-dark-xl';
			} else {
				$logo_link = 'navbar-brand u-header__navbar-brand-default u-header__navbar-brand-center ' . $logo_text;
			}
		}

		$defaults = array(
			'custom-logo-link' => $logo_link,
			'custom-logo'      => 'navbar-brand-img d-lg-block',
			'site-title'       => $logo_link,
		);

		$myt_page_options = array();
		$logo_attr        = [
			'class' => $defaults['custom-logo'],
		];

		if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
			$_myt_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_myt_page_options ) ) {
				$myt_page_options = $_myt_page_options;
			}
		}
		$enable_elementor_logo = isset( $myt_page_options['header']['mytravel_use_custom_logo'] ) ? $myt_page_options['header']['mytravel_use_custom_logo'] : 'no';

		$elementor_logo_id                 = isset( $myt_page_options['header']['mytravel_custom_logo'] ) ? $myt_page_options['header']['mytravel_custom_logo'] : array( 'id' => get_theme_mod( 'custom_logo' ) );
		$custom_logo_title                 = isset( $myt_page_options['header']['mytravel_custom_logo_title'] ) ? $myt_page_options['header']['mytravel_custom_logo_title'] : get_bloginfo( 'name' );
		$enable_transparent                = isset( $myt_page_options['header']['mytravel_enable_transparent_header'] ) ? $myt_page_options['header']['mytravel_enable_transparent_header'] : 'no';
		$elementor_transparent_logo_enable = isset( $myt_page_options['header']['mytravel_transparent_logo_enable'] ) ? $myt_page_options['header']['mytravel_transparent_logo_enable'] : 'no';
		$elementor_transparent_logo_id     = isset( $myt_page_options['header']['mytravel_transparent_logo'] ) ? $myt_page_options['header']['mytravel_transparent_logo'] : array( 'id' => get_theme_mod( 'transparent_header_logo' ) );
		
		$custom_title = '';
		if ( mytravel_has_custom_header( $myt_page_options ) && ! empty( $custom_logo_title ) ) {
			$custom_title = $custom_logo_title;
		}
		if ( mytravel_has_custom_header( $myt_page_options ) && 'yes' === $enable_transparent && 'yes' === $elementor_transparent_logo_enable && ! empty( $elementor_transparent_logo_id['id'] ) ) {
			$html = sprintf(
				'<a href="%1$s" class="%3$s" rel="home">%2$s<span class="u-header__navbar-brand-text">%4$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $elementor_transparent_logo_id['id'], 'full', false ),
				$defaults['custom-logo-link'],
				$custom_title
			);
		} elseif ( mytravel_has_custom_header( $myt_page_options ) && 'yes' === $enable_elementor_logo && ! empty( $elementor_logo_id['id'] ) && ( 'yes' !== $elementor_transparent_logo_enable || empty( $elementor_transparent_logo_id['id'] ) || 'yes' !== $enable_transparent ) ) {
			$html = sprintf(
				'<a href="%1$s" class="%3$s" rel="home">%2$s<span class="u-header__navbar-brand-text">%4$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $elementor_logo_id['id'], 'full', false ),
				$defaults['custom-logo-link'],
				$custom_title
			);
		} elseif ( mytravel_transparent_header_enable() && 'yes' === get_theme_mod( 'mytravel_enable_transparent_logo' ) && ! empty( $transparent_logo_id['id'] ) ) {
			// User uploads a transparent logo via Customizer.
			$transparent_logo_attr = [
				'class' => $defaults['custom-logo'],
			];
			// If the logo alt attribute is empty, get the site title.
			$transparent_logo_alt = get_post_meta( $transparent_logo_id, '_wp_attachment_image_alt', true );
			if ( empty( $transparent_logo_alt ) ) {
				$transparent_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
			}

			$transparent_logo_meta  = wp_get_attachment_metadata( $transparent_logo_id );
			$transparent_logo_width = isset( $transparent_logo_meta['width'] ) ? (int) $transparent_logo_meta['width'] : 161;
			$html                   = sprintf(
				'<a href="%1$s" class="%3$s" rel="home">%2$s<span class="u-header__navbar-brand-text">%4$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $transparent_logo_id['id'], 'full', false, $transparent_logo_attr ),
				$defaults['custom-logo-link'],
				esc_html( get_bloginfo( 'name' ) )
			);
		} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$html           = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home">%2$s<span class="u-header__navbar-brand-text">%3$s</span></a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $custom_logo_id, 'full', false ),
				esc_html( get_bloginfo( 'name' ) )
			);
		} else {
			$html = '<span class="u-header__navbar-brand-text ml-0">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
			$html = '<a href="' . esc_url( home_url( '/' ) ) . '" class="site-title" rel="home">' . $html . '</a>';
		}

		foreach ( $defaults as $search => $replace ) {
			$html = str_replace( $search, $replace, $html );
		}

		if ( ! $echo ) {
			return $html;
		}

		$logo_html = apply_filters( 'mytravel_logo', $html );

		echo wp_kses( $logo_html, 'logo-html' );
	}
}

if ( ! function_exists( 'mytravel_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function mytravel_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'mytravel' ); ?>">
			<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_html( apply_filters( 'mytravel_menu_toggle_text', __( 'Menu', 'mytravel' ) ) ); ?></span></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container_class' => 'primary-navigation',
				)
			);

			wp_nav_menu(
				array(
					'theme_location'  => 'handheld',
					'container_class' => 'handheld-navigation',
				)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_secondary_navigation' ) ) {
	/**
	 * Display Secondary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function mytravel_secondary_navigation() {
		if ( has_nav_menu( 'secondary' ) ) {
			?>
			<nav class="secondary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Secondary Navigation', 'mytravel' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'secondary',
						'fallback_cb'    => '',
					)
				);
				?>
			</nav>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @since  1.4.1
	 * @return void
	 */
	function mytravel_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'mytravel' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mytravel' ); ?></a>
		<?php
	}
}
if ( ! function_exists( 'mytravel_page_header' ) ) {
	/**
	 * Display the page header
	 *
	 * @since 1.0.0
	 */
	function mytravel_page_header() {
		if ( is_front_page() && is_page_template( 'template-fullwidth.php' ) ) {
			return;
		}

		if ( mytravel_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) ) {
			$title = woocommerce_page_title( false );
		} else {
			$title = get_the_title();
		}

		?>
		<header class="entry-header bg-img-hero text-center mb-5 mb-lg-8 bg-dark" style="<?php mytravel_header_styles(); ?>">
			<div class="container space-top-xl-3 py-6 py-xl-0">
				<div class="row justify-content-center py-xl-4">
					<div class="py-xl-10 py-5">
						<?php if ( ! empty( $title ) ) : ?>
							<h1 class="entry-title font-size-40 font-size-xs-30 text-white font-weight-bold mb-0"><?php echo esc_html( $title ); ?></h1>
						<?php endif; ?>
						<?php mytravel_breadcrumb(); ?>

					</div>
				</div>
			</div>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_page_content' ) ) {
	/**
	 * Display the post content
	 *
	 * @since 1.0.0
	 */
	function mytravel_page_content() {
		$is_prose_enabled   = apply_filters( 'mytravel_is_page_prose_enabled', true );
		$page_content_class = '';
		if ( class_exists( 'MAS_Travels' ) ) {
			$page_content_class .= ' max-w-none';
		} else {
			$page_content_class .= ' max-w-[75%] mx-auto';
		}

		if ( $is_prose_enabled ) {
			$page_content_class .= ' prose';
		} else {
			$page_content_class .= ' not-prose';
		}
		?>
		<div class="entry-content page-content">
			<div class="flex flex-col">
				<div class="<?php echo esc_attr( $page_content_class ); ?>">
					<?php
						the_content();

						$link_pages = wp_link_pages(
							array(
								'before'      => '<div class="page-links"><span class="d-block text-secondary mb-2">' . esc_html__( 'Pages:', 'mytravel' ) . '</span><nav class="pagination mb-0">',
								'after'       => '</nav></div>',
								'link_before' => '<span class="page-link">',
								'link_after'  => '</span>',
								'echo'        => 0,
							)
						);
						$link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
						$link_pages = str_replace( 'current', 'current active', $link_pages );
						echo wp_kses_post( $link_pages );
					?>
					</div>
			</div>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function mytravel_post_header() {
		?>
		<header class="entry-header">
			<?php

			/**
			 * Functions hooked in to mytravel_post_header_before action.
			 *
			 * @hooked mytravel_post_meta - 10
			 */
			do_action( 'mytravel_post_header_before' );

			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			}

			do_action( 'mytravel_post_header_after' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}


if ( ! function_exists( 'mytravel_edit_post_link' ) ) {
	/**
	 * Display the edit link
	 *
	 * @since 2.5.0
	 */
	function mytravel_edit_post_link() {
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="sr-only">%s</span>', 'mytravel' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<div class="edit-link">',
			'</div>',
			get_the_ID(),
			'text-white-70'
		);
	}
}


if ( ! function_exists( 'mytravel_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @deprecated 2.4.0
	 */
	function mytravel_posted_on() {
		_deprecated_function( 'mytravel_posted_on', '2.4.0' );
	}
}

if ( ! function_exists( 'mytravel_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function mytravel_homepage_content() {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'content', 'homepage' );

		} // end of the loop.
	}
}

if ( ! function_exists( 'mytravel_social_icons' ) ) {
	/**
	 * Display social icons
	 * If the subscribe and connect plugin is active, display the icons.
	 *
	 * @link http://wordpress.org/plugins/subscribe-and-connect/
	 * @since 1.0.0
	 */
	function mytravel_social_icons() {
		if ( class_exists( 'Subscribe_And_Connect' ) ) {
			echo '<div class="subscribe-and-connect-connect">';
			subscribe_and_connect_connect();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'mytravel_get_sidebar' ) ) {
	/**
	 * Display mytravel sidebar
	 *
	 * @uses get_sidebar()
	 * @since 1.0.0
	 */
	function mytravel_get_sidebar() {
		get_sidebar();
	}
}

if ( ! function_exists( 'mytravel_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.5.0
	 */
	function mytravel_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( $size );
		}
	}
}

if ( ! function_exists( 'mytravel_posts_layout' ) ) {
	/**
	 * Returns the template slug used for posts listing.
	 *
	 * @return string
	 *
	 * @see index.php
	 * @see archive.php
	 * @see templates/contents/content-*.php
	 */
	function mytravel_posts_layout() {
		$layout = get_theme_mod( 'blog_layout', 'list' );

		/**
		 * Filter the layout type
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the child theme you have to follow the file name convention.
		 * Your file should be named posts-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/templates/contents/content-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return sanitize_key( apply_filters( 'mytravel_posts_layout', $layout ) );
	}
}

if ( ! function_exists( 'mytravel_posts_not_found_layout' ) ) {
	/**
	 * Returns the template slug used for posts listing when posts not found
	 *
	 * @return string
	 *
	 * @see index.php
	 * @see archive.php
	 * @see templates/blog/none-*.php
	 */
	function mytravel_posts_not_found_layout() {
		$layout = mytravel_posts_sidebar();

		/**
		 * Filter the layout type
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the child theme you have to follow the file name convention.
		 * Your file should be named none[-{$layout}].php
		 *
		 * You can add your custom template part to
		 * /theme-child/templates/blog/none[-{$layout}].php
		 *
		 * @param string $layout
		 */
		return sanitize_key( apply_filters( 'mytravel_posts_not_found_layout', $layout ) );
	}
}

if ( ! function_exists( 'mytravel_posts_sidebar' ) ) {
	/**
	 * Returns the sidebar used for posts listing.
	 *
	 * @return string
	 *
	 * @see index.php
	 * @see archive.php
	 * @see templates/blog/posts-*.php
	 */
	function mytravel_posts_sidebar() {
		$sidebar = get_theme_mod( 'blog_sidebar', 'right-sidebar' );

		if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
			$sidebar = 'no-sidebar';
		}

		return sanitize_key( apply_filters( 'mytravel_posts_sidebar', $sidebar ) );
	}
}

if ( ! function_exists( 'mytravel_excerpt_more' ) ) {
	/**
	 * Returns  the string in the "more" link displayed after a trimmed excerpt
	 *
	 * @hooked excerpt_more 10
	 *
	 * @return string
	 */
	function mytravel_excerpt_more() {
		return '...';
	}
}

if ( ! function_exists( 'mytravel_the_excerpt' ) ) {
	/**
	 * Remove all HTML tags from the excerpt
	 *
	 * @hooked the_excerpt 20
	 *
	 * @param string $output The excerpt.
	 *
	 * @return string
	 */
	function mytravel_the_excerpt( $output ) {
		return wp_strip_all_tags( $output );
	}
}

if ( ! function_exists( 'mytravel_pagination' ) ) {
	/**
	 * Displays a paginated navigation to next/previous set of posts, when applicable.
	 *
	 * Used in blog (home), archives, search
	 *
	 * @since 1.0.0
	 */
	function mytravel_pagination() {
		$max_pages = isset( $GLOBALS['wp_query']->max_num_pages ) ? $GLOBALS['wp_query']->max_num_pages : 1;
		if ( $max_pages < 2 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
		$links = paginate_links(
			apply_filters(
				'mytravel_posts_pagination_args',
				[
					'type'      => 'array',
					'mid_size'  => 2,
					'prev_next' => false,
				]
			)
		);

		?>
		<nav class="" aria-label="
		<?php
		/* translators: aria-label for posts navigation wrapper */
		echo esc_attr_x( 'Posts navigation', 'front-end', 'mytravel' );
		?>
		">
			<ul class="list-pagination-1 pagination border border-color-4 rounded-sm mb-5 mb-lg-0 overflow-auto overflow-xl-visible justify-content-md-center align-items-center py-2">
				<?php if ( $paged && 1 < $paged ) : ?>
					<li class="page-item">
						<a class="page-link border-right rounded-0 text-gray-5" href="<?php echo esc_url( get_previous_posts_page_link() ); ?>">
							<i class="flaticon-left-direction-arrow font-size-10 font-weight-bold"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php foreach ( $links as $link ) : ?>
					<?php if ( false !== strpos( $link, 'current' ) ) : ?>
						<li class="page-item active">
							<?php echo wp_kses_post( str_replace( 'page-numbers', 'page-link font-size-14', $link ) ); ?>
						</li>
					<?php else : ?>
						<li class="page-item">
							<?php echo wp_kses_post( str_replace( 'page-numbers', 'page-link font-size-14', $link ) ); ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if ( $paged && $paged < $max_pages ) : ?>
					<li class="page-item">
						<a class="page-link border-left rounded-0 text-gray-5" href="<?php echo esc_url( get_next_posts_page_link() ); ?>">
							<i class="flaticon-right-thin-chevron font-size-10 font-weight-bold"></i>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'mytravel_site_content_bg_image' ) ) {
	/**
	 *  Get background image
	 */
	function mytravel_site_content_bg_image() {
		$bg_img = '';
		if ( 'post' === get_post_type() && is_single() ) {
			$bg_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

			if ( ! empty( $bg_url ) ) {
				$bg_img = 'background-image: url(' . esc_url( $bg_url ) . ');';
				$bg_img = 'style="' . esc_attr( $bg_img ) . '"';
			}
		}

		return $bg_img;
	}
}

if ( ! function_exists( 'mytravel_post_title' ) ) {
	/**
	 * Displays the Page Title for single post
	 *
	 * This function uses "mytravel_is_post_title" filter, which allows to control
	 * Page Title visibility. You can completely disable page title:
	 *
	 * @hooked mytravel_single_before 50
	 */
	function mytravel_post_title() {
		?>
		<div class="bg-img-hero text-center mb-5 mb-lg-8 bg-dark" <?php mytravel_site_content_bg_image(); ?>>
			<div class="container space-top-xl-3 py-6 py-xl-0">
				<div class="row justify-content-center py-xl-4">
					<div class="py-xl-10 py-5 container">
						<h1 class="font-size-40 font-size-xs-30 text-white font-weight-bold mb-0 text-break"><?php single_post_title(); ?></h1>
						<?php mytravel_breadcrumb(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_comments' ) ) {
	/**
	 * Load comments template
	 *
	 * This SHOULD be used within the loop.
	 *
	 * @since 1.0.0
	 */
	function mytravel_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'mytravel_single_post_sidebar' ) ) {
	/**
	 *  Get single post sidebar
	 */
	function mytravel_single_post_sidebar() {
		$blog_layout = function_exists( 'mytravel_post_layout' ) ? mytravel_post_layout() : 'right-sidebar';
		$has_sidebar = mytravel_blog_has_sidebar();
		?>
		<?php if ( $has_sidebar ) : ?>
			<aside class="col-lg-4 col-xl-3">
				<?php get_sidebar(); ?>
			</aside>
		<?php endif; ?>
		<?php
	}
}


if ( ! function_exists( 'mytravel_comment_form_default_fields' ) ) {
	/**
	 * Filters the default comment form fields.
	 *
	 * @param string[] $fields Array of the default comment fields.
	 *
	 * @return array
	 */
	function mytravel_comment_form_default_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$is_req    = (bool) get_option( 'require_name_email', 1 );

		// Remove url field.
		unset( $fields['url'] );

		// Update other fields.
		$fields['author'] = sprintf(
			'<div class="col-sm-6 form-group comment-form-author mb-5">
				<label class="form-label" for="author">%1$s%4$s</label>
				<input type="text" name="author" id="author" class="form-control" value="%2$s" maxlength="245" %3$s>
			</div>',
			/* translators: comment author name */
			esc_html_x( 'Name', 'front-end', 'mytravel' ),
			esc_attr( $commenter['comment_author'] ),
			$is_req ? 'required' : '',
			$is_req ? '<span class="text-danger">*</span>' : ''
		);

		$fields['email'] = sprintf(
			'<div class="col-sm-6 form-group comment-form-email mb-5">
				<label class="form-label" for="email">%1$s%4$s</label>
				<input type="email" name="email" id="email" class="form-control" value="%2$s" maxlength="100" aria-describedby="email-notes" %3$s>
			</div>',
			/* translators: comment author e-mail */
			esc_html_x( 'Email', 'front-end', 'mytravel' ),
			esc_attr( $commenter['comment_author_email'] ),
			$is_req ? 'required' : '',
			$is_req ? '<span class="text-danger">*</span>' : ''
		);

		if ( isset( $fields['cookies'] ) ) {
			$consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
			$fields['cookies'] = sprintf(
				'<div class="col-sm-12 mb-2"><div class="custom-control custom-checkbox mb-3 comment-form-cookies-consent text-muted">
					<input type="checkbox" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="custom-control-input" value="yes"' . $consent . '>
					<label class="custom-control-label" for="wp-comment-cookies-consent">%s</label>
				</div></div>',
				esc_html_x( 'Save my name and email in this browser for the next time I comment.', 'front-end', 'mytravel' )
			);
		}

		return $fields;
	}
}

if ( ! function_exists( 'mytravel_post_layout' ) ) {
	/**
	 * Returns the slug for a template used to display single post
	 *
	 * Single post layout is depends on Blog Layout setting in Customizer.
	 * If user wants one without a sidebar we should not load it no matter active it or not.
	 *
	 * @return string
	 *
	 * @see single.php
	 * @see templates/blog/post-*.php
	 */
	function mytravel_post_layout() {
		$blog_single_layout = get_theme_mod( 'blog_single_layout', 'right-sidebar' );

		if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
			$blog_single_layout = 'no-sidebar';
		}

		/**
		 * Filter the layout slug
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the child theme you have to follow the file name convention.
		 * Your file should be named post-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/templates/blog/post-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return sanitize_key( apply_filters( 'mytravel_post_layout', $blog_single_layout ) );
	}
}

if ( ! function_exists( 'mytravel_single_post_media' ) ) {
	/**
	 * Display single post featured image.
	 */
	function mytravel_single_post_media() {
		if ( has_post_thumbnail() ) :

			if ( empty( $attr ) ) {
				$attr = array( 'class' => 'img-fluid d-block mx-auto mb-4 rounded-xs' );
			}
			the_post_thumbnail( 'full', $attr );
		endif;
	}
}


/**
 * Sanitize Form HTML.
 *
 * @param string $input html.
 * @return string html.
 */
function mytravel_sanitize_html( $input ) {

	$allowed = array(
		'a'      => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array(),
			'class'  => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'p'      => array(
			'class' => array(),
		),
		'span'   => array(
			'class' => array(),
		),
		'i'      => array(
			'class' => array(),
		),
		'form'   => array(
			'accept-charset' => array(),
			'autocomplete'   => array(),
			'enctype'        => array(),
			'class'          => array(),
			'method'         => array(),
			'action'         => array(),
			'name'           => array(),
			'novalidate'     => array(),
			'rel'            => array(),
			'target'         => array(),
		),
		'label'  => array(
			'for'   => array(),
			'class' => array(),
		),
		'input'  => array(
			'id'             => array(),
			'type'           => array(),
			'class'          => array(),
			'placeholder'    => array(),
			'name'           => array(),
			'required'       => array(),
			'value'          => array(),
			'disabled'       => array(),
			'size'           => array(),
			'readonly'       => array(),
			'maxlength'      => array(),
			'min'            => array(),
			'max'            => array(),
			'multiple'       => array(),
			'title'          => array(),
			'pattern'        => array(),
			'form'           => array(),
			'formaction'     => array(),
			'formenctype'    => array(),
			'formmethod'     => array(),
			'formtarget'     => array(),
			'formnovalidate' => array(),
			'novalidate'     => array(),
		),
		'button' => array(
			'class' => array(),
			'type'  => array(),
			'name'  => array(),
		),
		'div'    => array(
			'class' => array(),
		),
	);

	return wp_kses( $input, $allowed );
}

if ( ! function_exists( 'mytravel_site_main_divider' ) ) {
	/**
	 * Display divider on botom of the page
	 */
	function mytravel_site_main_divider() {
		if ( mytravel_is_woocommerce_activated() && ( is_shop() || is_product() ) ) {
			$border_class = 'border-top border-gray-33';
		} else {
			$border_class = 'border border-color-8';
		}
		?>
		<div class="<?php echo esc_attr( $border_class ); ?>"></div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_custom_widget_nav_menu_options' ) ) :
	/**
	 * Display custom widget nav menu options.
	 *
	 * @param array $widget widget name.
	 * @param array $return return null.
	 * @param array $instance widget settings.
	 */
	function mytravel_custom_widget_nav_menu_options( $widget, $return, $instance ) {
		// Are we dealing with a nav menu widget?
		if ( 'nav_menu' === $widget->id_base ) {
			$is_social_icon_menu = isset( $instance['is_social_icon_menu'] ) ? $instance['is_social_icon_menu'] : '';
			?>
				<p>
					<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $widget->get_field_id( 'is_social_icon_menu' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'is_social_icon_menu' ) ); ?>" <?php checked( true, $is_social_icon_menu ); ?> />
					<label for="<?php echo esc_attr( $widget->get_field_id( 'is_social_icon_menu' ) ); ?>">
						<?php esc_html_e( 'Is Social Icon Menu', 'mytravel' ); ?>
					</label>
				</p>
			<?php
		}
	}
endif;

if ( ! function_exists( 'mytravel_custom_widget_nav_menu_options_update' ) ) :
	/**
	 * Display custom widget nav menu options.
	 *
	 * @param array $instance widget settings.
	 * @param array $new_instance widget settings.
	 * @param array $old_instance widget settings.
	 * @param array $widget widget name.
	 */
	function mytravel_custom_widget_nav_menu_options_update( $instance, $new_instance, $old_instance, $widget ) {
		if ( 'nav_menu' === $widget->id_base ) {
			if ( isset( $new_instance['is_social_icon_menu'] ) && ! empty( $new_instance['is_social_icon_menu'] ) ) {
				$instance['is_social_icon_menu'] = 1;
			}
		}

		return $instance;
	}
endif;

if ( ! function_exists( 'mytravel_custom_widget_nav_menu_args' ) ) :
	/**
	 * Display custom nav menu.
	 *
	 * @param array   $nav_menu_args An array of arguments passed to wp_nav_menu() to retrieve a navigation menu.
	 * @param WP_Term $nav_menu Nav menu object for the current menu.
	 * @param array   $args Display arguments including 'before_title', 'after_title','before_widget', and 'after_widget'.
	 * @param array   $instance      Array of settings for the current widget.
	 */
	function mytravel_custom_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
		if ( isset( $instance['is_social_icon_menu'] ) && ! empty( $instance['is_social_icon_menu'] ) ) {
			$social_nav_menu_args = array(
				'container'         => false,
				'menu_class'        => 'social-menu list-inline d-flex mb-0',
				'depth'             => 1,
				'item_class'        => 'list-inline-item mr-2 pl-1',
				'icon_class'        => 'btn-icon__inner',
				'walker'            => new WP_Bootstrap_Navwalker(),
				'disable_schema'    => true,
				'disable_data_attr' => true,
				'classes'           => array(
					'nav-link' => 'btn btn-icon btn-social btn-bg-transparent',
				),
			);
			$nav_menu_args        = array_merge( $nav_menu_args, $social_nav_menu_args );
		}

		return $nav_menu_args;
	}
endif;
