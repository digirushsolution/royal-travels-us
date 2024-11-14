<?php
/**
 * MyTravel Class
 *
 * @since    1.0.0
 * @package  mytravel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyTravel' ) ) :

	/**
	 * The main MyTravel class
	 */
	class MyTravel {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_action( 'acf/init', array( $this, 'acf_init' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_assets' ) );
			add_action( 'after_setup_theme', array( $this, 'wpforms_scripts' ) );

		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function setup() {
			/*
			* Load Localisation files.
			*
			* Note: the first-loaded translation file overrides any following ones if the same translation is present.
			*/

			// Loads wp-content/languages/themes/mytravel-it_IT.mo.
			load_theme_textdomain( 'mytravel', trailingslashit( WP_LANG_DIR ) . 'themes' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'mytravel', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/mytravel/languages/it_IT.mo.
			load_theme_textdomain( 'mytravel', get_template_directory() . '/languages' );

			/**
			* Add default posts and comments RSS feed links to head.
			*/
			add_theme_support( 'automatic-feed-links' );

			/*
			* Enable support for Post Thumbnails on posts and pages.
			*
			* @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			*/
			add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );

			/**
			 * Enable support for site logo.
			 */
			$custom_logo_args = apply_filters(
				'mytravel_custom_logo_args',
				array(
					'height'      => 29,
					'width'       => 112,
					'flex-width'  => true,
					'flex-height' => true,
				)
			);
			add_theme_support( 'custom-logo', $custom_logo_args );

			/**
			* Register menu locations.
			*/
			register_nav_menus(
				apply_filters(
					'mytravel_register_nav_menus',
					array(
						'topbar_left'  => esc_html__( 'Topbar Left', 'mytravel' ),
						'topbar_right' => esc_html__( 'Topbar Right', 'mytravel' ),
						'primary'      => esc_html__( 'Primary Menu', 'mytravel' ),
						'social_media' => esc_html__( 'Social Media', 'mytravel' ),
						'footer_links' => esc_html__( 'Footer Links', 'mytravel' ),
					)
				)
			);

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			$html5_args = apply_filters(
				'mytravel_html5_args',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'widgets',
					'style',
					'script',
				)
			);
			add_theme_support( 'html5', $html5_args );

			/**
			* Setup the WordPress core custom header feature.
			*/
			$custom_header_args = apply_filters(
				'mytravel_custom_header_args',
				array(
					'default-image' => get_template_directory_uri() . '/assets/img/default-bg.jpeg',
					'header-text'   => false,
					'width'         => 1920,
					'height'        => 400,
					'flex-width'    => true,
					'flex-height'   => true,
				)
			);
			add_theme_support( 'custom-header', $custom_header_args );

			/**
			*  Add support for the Site Logo plugin and the site logo functionality in JetPack
			*  https://github.com/automattic/site-logo
			*  http://jetpack.me/
			*/
			add_theme_support(
				'site-logo',
				apply_filters(
					'mytravel_site_logo_args',
					array(
						'size' => 'full',
					)
				)
			);

			/**
			* Declare support for title theme feature.
			*/
			add_theme_support( 'title-tag' );

			/**
			* Add Theme Support for HivePress
			*/
			add_theme_support( 'hivepress' );

			/**
			 * Add support for Block Styles.
			 */
			add_theme_support( 'wp-block-styles' );

			/**
			 * Add support for full and wide align images.
			 */
			add_theme_support( 'align-wide' );

			/**
			 * Add support for editor styles.
			 */
			add_theme_support( 'editor-styles' );

			/**
			 * Enqueue editor styles.
			 */
			$editor_styles = [
				is_rtl() ? 'assets/css/gutenberg-editor-rtl.css' : 'assets/css/gutenberg-editor.css',
				$this->google_fonts(),

			];

			add_editor_style( $editor_styles );
			/**
			 * Add support for responsive embedded content.
			 */
			add_theme_support( 'responsive-embeds' );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {
			$sidebar_args['blog-sidebar'] = array(
				'name'          => esc_html__( 'Blog Sidebar', 'mytravel' ),
				'id'            => 'blog-sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title h6 font-weight-bold mb-2 mb-xl-4">',
				'after_title'   => '</h4>',
			);

			$rows    = intval( apply_filters( 'mytravel_footer_widget_rows', 1 ) );
			$regions = intval( apply_filters( 'mytravel_footer_widget_columns', 5 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $regions; $region++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer   = sprintf( 'footer_%d', $footer_n );

					if ( 1 === $rows ) {
						/* translators: 1: column number */
						$footer_region_name = sprintf( esc_html__( 'Footer Column %1$d', 'mytravel' ), $region );

						/* translators: 1: column number */
						$footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of the footer.', 'mytravel' ), $region );
					} else {
						/* translators: 1: row number, 2: column number */
						$footer_region_name = sprintf( esc_html__( 'Footer Row %1$d - Column %2$d', 'mytravel' ), $row, $region );

						/* translators: 1: column number, 2: row number */
						$footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'mytravel' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'         => $footer_region_name,
						'id'           => sprintf( 'footer-%d', $footer_n ),
						'description'  => $footer_region_description,
						'before_title' => '<h4 class="widget-title h6 font-weight-bold mb-2 mb-xl-4">',
					);
				}
			}

			$sidebar_args = apply_filters( 'mytravel_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				);

				/**
				* Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				*
				* 'mytravel_header_widget_tags'
				* 'mytravel_sidebar_widget_tags'
				*
				* 'mytravel_footer_1_widget_tags'
				* 'mytravel_footer_2_widget_tags'
				* 'mytravel_footer_3_widget_tags'
				* 'mytravel_footer_4_widget_tags'
				*/
				$filter_hook = sprintf( 'mytravel_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}
		}
		/**
		 * Enqueue scripts and styles.
		 *
		 * @since  1.0.0
		 */
		public function scripts() {
			global $mytravel_version;

			/**
			* Styles
			*/
			$vendors = apply_filters(
				'mytravel_vendor_styles',
				array(
					'fontawesome'              => 'font-awesome/css/fontawesome-all.min.css',
					'custombox'                => 'custombox/dist/custombox.min.css',
					'animate'                  => 'animate.css/animate.min.css',
					'megamenu'                 => 'hs-megamenu/src/hs.megamenu.css',
					'malihub-custom-scrollbar' => 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
					'fancybox'                 => 'fancybox/jquery.fancybox.css',
					'slick-carousel'           => 'slick-carousel/slick/slick.css',
					'flatpickr'                => 'flatpickr/dist/flatpickr.min.css',
					'bootstrap-select'         => 'bootstrap-select/dist/css/bootstrap-select.min.css',
					'dzsparallaxer'            => 'dzsparallaxer/dzsparallaxer.css',
					'ion-rangeslider'          => 'ion-rangeslider/css/ion.rangeSlider.css',
					'leaflet'                  => 'leaflet/dist/leaflet.css',

				)
			);

			foreach ( $vendors as $key => $vendor ) {
				wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $mytravel_version );

				if ( in_array( $key, array( 'megamenu' ), true ) ) {
					wp_style_add_data( $key, 'rtl', 'replace' );
				}
			}

			wp_enqueue_style( 'mytravel-style', get_template_directory_uri() . '/style.css', '', $mytravel_version );
			wp_style_add_data( 'mytravel-style', 'rtl', 'replace' );

			wp_enqueue_style( 'mytravel-icons', get_template_directory_uri() . '/assets/css/font-mytravel.css', '', $mytravel_version );
			wp_style_add_data( 'mytravel-icons', 'rtl', 'replace' );

			if ( apply_filters( 'mytravel_use_predefined_colors', true ) && filter_var( get_theme_mod( 'mytravel_enable_custom_color', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_style( 'mytravel-color', get_template_directory_uri() . '/assets/css/colors/color.css', '', $mytravel_version );
			}

			/**
			* Fonts
			*/
			wp_enqueue_style( 'mytravel-fonts', $this->google_fonts(), array(), $mytravel_version );

			/**
			 * Scripts
			 */
			self::register_scripts();

			// JS Global Compulsory.
			wp_enqueue_script( 'popper' );
			wp_enqueue_script( 'bootstrap' );
			wp_enqueue_script( 'hs-megamenu' );
			wp_enqueue_script( 'bootstrap-select' );
			wp_enqueue_script( 'appear' );
			wp_enqueue_script( 'slick-carousel' );
			wp_enqueue_script( 'flatpickr' );
			wp_enqueue_script( 'custombox' );
			wp_enqueue_script( 'custombox-legacy' );
			wp_enqueue_script( 'malihu-scrollbar' );
			wp_enqueue_script( 'leaflet' );
			wp_enqueue_script( 'video-player' );
			wp_enqueue_script( 'svg-injector' );
			wp_enqueue_script( 'dzsparallaxer' );

			wp_enqueue_script( 'hs-core' );
			wp_enqueue_script( 'hs-header' );
			wp_enqueue_script( 'hs-unfold' );
			wp_enqueue_script( 'hs-show-animation' );
			wp_enqueue_script( 'hs-range-datepicker' );
			wp_enqueue_script( 'hs-slick-carousel' );
			wp_enqueue_script( 'hs-sticky-block' );
			wp_enqueue_script( 'hs-quantity-counter' );
			wp_enqueue_script( 'hs-fancybox' );
			wp_enqueue_script( 'hs-modal-window' );
			wp_enqueue_script( 'hs-malihu-scrollbar' );
			wp_enqueue_script( 'hs-scroll-nav' );
			wp_enqueue_script( 'hs-video-player' );
			wp_enqueue_script( 'hs-svg-injector' );
			wp_enqueue_script( 'hs-counter' );
			wp_enqueue_script( 'hs-go-to' );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			$admin_ajax_url = admin_url( 'admin-ajax.php' );
			$current_lang   = apply_filters( 'wpml_current_language', null );
			if ( $current_lang ) {
				$admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
			}

			wp_enqueue_script( 'mytravel-book-now', get_template_directory_uri() . '/assets/js/frontend/book-now.js', array( 'hs-range-datepicker' ), $mytravel_version, true );
			wp_enqueue_script( 'mytravel-scripts', get_template_directory_uri() . '/assets/js/mytravel.js', array( 'hs-core' ), $mytravel_version, true );
			wp_enqueue_script( 'mytravel-single-product', get_template_directory_uri() . '/assets/js/frontend/single-product.js', array( 'jquery' ), $mytravel_version, true );

			$api_key = mytravel_get_google_api_key();
			wp_enqueue_script( 'googlemaps', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key, array(), $mytravel_version, true );
			wp_enqueue_script( 'mytravel-maps', get_template_directory_uri() . '/assets/js/frontend/maps.js', array( 'googlemaps' ), $mytravel_version, true );
			$params = array(
				'i18n_star_5_text' => esc_html__( 'Perfect', 'mytravel' ),
				'i18n_star_4_text' => esc_html__( 'Good', 'mytravel' ),
				'i18n_star_3_text' => esc_html__( 'Average', 'mytravel' ),
				'i18n_star_2_text' => esc_html__( 'Not that bad', 'mytravel' ),
				'i18n_star_1_text' => esc_html__( 'Very poor', 'mytravel' ),
			);

			wp_localize_script( 'mytravel-single-product', 'mytravel_single_product_params', $params );

			$mytravel_options = apply_filters(
				'mytravel_localize_script_data',
				array(
					'theme_url'       => MYTRAVEL_THEME_URI,
					'ajax_url'        => $admin_ajax_url,
					'ajax_loader_url' => get_template_directory_uri() . '/assets/img/ajax-loader.gif',
				)
			);
			wp_localize_script( 'mytravel-scripts', 'mytravel_options', $mytravel_options );

		}

		/**
		 * Get all Front scripts.
		 */
		private static function get_theme_scripts() {
			$vendors_path = get_template_directory_uri() . '/assets/vendor/';
			$js_vendors   = apply_filters(
				'mytravel_js_vendors',
				array(
					'popper'           => array(
						'src' => $vendors_path . 'popper.js/dist/umd/popper.min.js',
						'dep' => array( 'jquery' ),
					),
					'bootstrap'        => array(
						'src' => $vendors_path . 'bootstrap/bootstrap.min.js',
						'dep' => array( 'jquery', 'popper' ),
					),
					'hs-megamenu'      => array(
						'src' => $vendors_path . 'hs-megamenu/src/hs.megamenu.js',
						'dep' => array( 'jquery' ),
					),
					'bootstrap-select' => array(
						'src' => $vendors_path . 'bootstrap-select/dist/js/bootstrap-select.min.js',
						'dep' => array( 'jquery' ),
					),
					'slick-carousel'   => array(
						'src' => $vendors_path . 'slick-carousel/slick/slick.js',
						'dep' => array( 'jquery' ),
					),
					'flatpickr'        => array(
						'src' => $vendors_path . 'flatpickr/dist/flatpickr.min.js',
						'dep' => array( 'jquery' ),
					),
					'jquery-fancybox'  => array(
						'src' => $vendors_path . 'fancybox/jquery.fancybox.min.js',
						'dep' => array( 'jquery' ),
					),
					'custombox'        => array(
						'src' => $vendors_path . 'custombox/dist/custombox.min.js',
						'dep' => array( 'jquery' ),
					),
					'custombox-legacy' => array(
						'src' => $vendors_path . 'custombox/dist/custombox.legacy.min.js',
						'dep' => array( 'jquery', 'custombox' ),
					),
					'malihu-scrollbar' => array(
						'src' => $vendors_path . 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
						'dep' => array( 'jquery' ),
					),
					'leaflet'          => array(
						'src' => $vendors_path . 'leaflet/dist/leaflet.js',
						'dep' => array( 'jquery' ),
					),
					'video-player'     => array(
						'src' => $vendors_path . 'player.js/dist/player.min.js',
						'dep' => array( 'jquery' ),
					),
					'svg-injector'     => array(
						'src' => $vendors_path . 'svg-injector/dist/svg-injector.min.js',
						'dep' => array( 'jquery' ),
					),
					'dzsparallaxer'    => array(
						'src' => $vendors_path . 'dzsparallaxer/dzsparallaxer.js',
						'dep' => array( 'jquery' ),
					),
					'appear'           => array(
						'src' => $vendors_path . 'appear.js',
						'dep' => array( 'jquery' ),
					),
				)
			);

			$hs_components_path = get_template_directory_uri() . '/assets/js/components/';
			$hs_components      = apply_filters(
				'mytravel_hs_components',
				array(
					'hs-core'             => array(
						'src' => get_template_directory_uri() . '/assets/js/hs.core.js',
						'dep' => array( 'bootstrap' ),
					),
					'hs-header'           => array(
						'src' => $hs_components_path . 'hs.header.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-unfold'           => array(
						'src' => $hs_components_path . 'hs.unfold.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-show-animation'   => array(
						'src' => $hs_components_path . 'hs-show-animation.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-range-datepicker' => array(
						'src' => $hs_components_path . 'hs.range-datepicker.js',
						'dep' => array( 'hs-core', 'flatpickr' ),
					),
					'hs-slick-carousel'   => array(
						'src' => $hs_components_path . 'hs.slick-carousel.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-sticky-block'     => array(
						'src' => $hs_components_path . 'hs.sticky-block.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-quantity-counter' => array(
						'src' => $hs_components_path . 'hs.quantity-counter.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-fancybox'         => array(
						'src' => $hs_components_path . 'hs.fancybox.js',
						'dep' => array( 'hs-core', 'jquery-fancybox' ),
					),
					'hs-modal-window'     => array(
						'src' => $hs_components_path . 'hs.modal-window.js',
						'dep' => array( 'hs-core', 'bootstrap' ),
					),
					'hs-malihu-scrollbar' => array(
						'src' => $hs_components_path . 'hs.malihu-scrollbar.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-scroll-nav'       => array(
						'src' => $hs_components_path . 'hs.scroll-nav.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-video-player'     => array(
						'src' => $hs_components_path . 'hs.video-player.js',
						'dep' => array( 'hs-core' ),
					),
					'interactive-map'     => array(
						'src' => $hs_components_path . 'interactive-map.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-svg-injector'     => array(
						'src' => $hs_components_path . 'hs.svg-injector.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-counter'          => array(
						'src' => $hs_components_path . 'hs.counter.js',
						'dep' => array( 'hs-core' ),
					),
					'hs-go-to'            => array(
						'src' => $hs_components_path . 'hs.go-to.js',
						'dep' => array( 'hs-core' ),
					),

				)
			);

			return array_merge( $js_vendors, $hs_components );
		}

		/**
		 * Register all Front scripts.
		 */
		private static function register_scripts() {
			global $mytravel_version;

			$register_scripts = self::get_theme_scripts();
			foreach ( $register_scripts as $handle => $props ) {
				wp_register_script( $handle, $props['src'], $props['dep'], $mytravel_version, true );
			}
		}

		/**
		 * Register Google fonts.
		 *
		 * @since 1.0.0
		 * @return string Google fonts URL for the theme.
		 */
		public function google_fonts() {
			$google_fonts = apply_filters(
				'mytravel_google_font_families',
				array(
					'rubik' => 'Rubik:300,400,500,700,900',
				)
			);

			$query_args = array(
				'family'  => implode( '|', $google_fonts ),
				'subset'  => rawurlencode( 'latin,latin-ext' ),
				'display' => 'swap',
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			return $fonts_url;
		}

		/**
		 * Enqueue block assets.
		 *
		 * @since 1.0.0
		 */
		public function block_assets() {}

		/**
		 * Enqueue supplemental block editor assets.
		 *
		 * @since 1.0.0
		 */
		public function block_editor_assets() {
			global $mytravel_version;

			/**
			 * Styles
			 */
			$vendors = apply_filters(
				'mytravel_vendor_styles',
				array(
					'fontawesome'      => 'font-awesome/css/fontawesome-all.min.css',
					'bootstrap-select' => 'bootstrap-select/dist/css/bootstrap-select.min.css',
				)
			);

			foreach ( $vendors as $key => $vendor ) {
				wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $mytravel_version );

				if ( in_array( $key, array( 'megamenu' ), true ) ) {
					wp_style_add_data( $key, 'rtl', 'replace' );
				}
			}
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 *
		 * @since  1.0.0
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'mytravel-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
			}
		}

		/**
		 * WPForms script
		 */
		public function wpforms_scripts() {
			if ( function_exists( 'wpforms' ) && apply_filters( 'mytravel_wpforms_disable_css', true ) ) {
				$settings = get_option( 'wpforms_settings', array() );
				if ( 2 !== ! isset( $settings['disable-css'] ) || $settings['disable-css'] ) {
					$settings['disable-css'] = 2;
					update_option( 'wpforms_settings', $settings );
				}
			}
		}

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 */
		public function page_menu_args( $args ) {}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array $classes
		 */
		public function body_classes( $classes ) {
			global $post;

			// Add class if single post has sidebar.
			if ( is_single() && 'post' === get_post_type() && mytravel_blog_has_sidebar() ) {
				$classes[] = 'has-sidebar';
			}

			return $classes;
		}

		/**
		 * Initialize ACF for google API key
		 */
		public function acf_init() {
			$google_api_key = mytravel_get_google_api_key();
			acf_update_setting( 'google_api_key', $google_api_key );
		}
	}
endif;

return new MyTravel();
