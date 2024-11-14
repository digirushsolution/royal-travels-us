<?php
/**
 * MyTravel WooCommerce Class
 *
 * @package  mytravel
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyTravel_WooCommerce' ) ) :

	/**
	 * The MyTravel WooCommerce Integration class
	 */
	class MyTravel_WooCommerce {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );

			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_show_page_title', '__return_false' );
			add_filter( 'mytravel_sidebar_args', array( $this, 'sidebar_args' ) );
			add_filter( 'mytravel_sidebar_args', array( $this, 'product_filter_siider_args' ) );
			add_filter( 'woocommerce_form_field_args', [ $this, 'form_field_args' ] );
			add_filter( 'woocommerce_default_address_fields', [ $this, 'address_fields' ] );
			add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_wc_shop_sidebar_params' ) );
			add_filter( 'mytravel_is_header_transparent', array( $this, 'is_header_transparent' ) );
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'breadcrumb_defaults' ) );
			add_filter( 'woocommerce_product_loop_title_classes', array( $this, 'product_loop_title_classes' ) );
			add_filter( 'woocommerce_post_class', array( $this, 'post_class' ) );
			add_filter( 'wc_price', array( $this, 'format_price' ) );
			add_filter( 'woocommerce_product_price_class', array( $this, 'product_price_class' ) );
			add_filter( 'body_class', [ $this, 'body_classes' ] );
			add_filter( 'mytravel_is_page_prose_enabled', array( $this, 'set_not_prose' ) );

		}


		/**
		 * Override title.
		 *
		 * @param string $title Title of the masthead.
		 * @return string
		 */
		public function override_title( $title ) {
			if ( is_shop() ) {
				$title = esc_html__( 'shop', 'mytravel' );
			} elseif ( is_product() ) {
				$title = get_the_title();
			}

			return $title;
		}


		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 2.4.0
		 * @return void
		 */
		public function setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'mytravel_woocommerce_args',
					array(
						'single_image_width'    => 960,
						'thumbnail_image_width' => 300,
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 6,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						),
					)
				)
			);

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

			/**
			 * Add 'mytravel_woocommerce_setup' action.
			 *
			 * @since  2.4.0
			 */
			do_action( 'mytravel_woocommerce_setup' );
		}
		/**
		 * Register shop sidebar widget area.
		 *
		 * @param array $args sidebar arguments.
		 */
		public function sidebar_args( $args ) {
			$args['sidebar_shop'] = array(
				'name'          => esc_html__( 'Shop Sidebar', 'mytravel' ),
				'id'            => 'sidebar-shop',
				'before_widget' => '<div id="%1$s" class="widget %2$s pb-4 mb-2"><div class="sidenav border border-color-8 rounded-xs p-4">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h4 class="widget-title font-weight-bold font-size-17 mb-2 mb-xl-4">',
				'after_title'   => '</h4>',
			);

			return $args;
		}
		/**
		 * Register product filter widget area.
		 *
		 * @param array $args sidebar arguments.
		 */
		public function product_filter_siider_args( $args ) {

			$args['product_filters'] = array(
				'name'          => esc_html__( 'Product Filters', 'mytravel' ),
				'id'            => 'product-filters-widgets',
				'before_widget' => '<div id="%1$s" class="widget %2$s accordion rounded-0 shadow-none border-bottom"><div class="border-0">',

			);

			return $args;
		}

		/**
		 * Include Collapse Args on Shop Dynamic Sidebar
		 *
		 * @link https://developer.wordpress.org/reference/functions/dynamic_sidebar/
		 * @param array $params Paramaters for product filter widget.
		 */
		public function dynamic_wc_shop_sidebar_params( $params ) {
			if ( isset( $params[0] ) && isset( $params[0]['id'] ) && 'product-filters-widgets' === $params[0]['id'] ) {
				global $wp_registered_widgets;

				$widget_id       = $params[0]['widget_id'];
				$settings_getter = $wp_registered_widgets[ $widget_id ]['callback'][0];
				$get_settings    = $settings_getter->get_settings();
				$settings        = $get_settings[ $params[1]['number'] ];

				if ( isset( $settings['title'] ) && ! empty( $settings['title'] ) ) {
					$params[0]['before_title'] = '<div class="card-collapse" id="widgetHeading-' . esc_attr( $widget_id ) . '"><h3 class="widget-title mb-0"><button type="button" class="btn btn-link btn-block card-btn py-2 px-5 text-lh-3" data-toggle="collapse" data-target="#widget-collapse-' . esc_attr( $widget_id ) . '" aria-expanded="true" aria-controls="widget-collapse-' . esc_attr( $widget_id ) . '"><span class="row align-items-center"><span class="col-9"><span class="font-weight-bold font-size-17 text-dark mb-3">';
					$params[0]['after_title']  = '</span></span><span class="col-3 text-right"><span class="card-btn-arrow"><span class="fas fa-chevron-up small"></span></span></span></span></button></h3></div><div id="widget-collapse-' . esc_attr( $widget_id ) . '" class="collapse show" aria-labelledby="widgetHeading-' . esc_attr( $widget_id ) . '"><div class="card-body pt-0 mt-1 px-5 pb-4">';

					$params[0]['after_widget'] = '</div></div></div></div>';
				}
			}

			return $params;
		}
		/**
		 * Transpaent header condition
		 *
		 * @param bool $is_transparent Transparent enable or not.
		 */
		public function is_header_transparent( $is_transparent ) {

			if ( is_woocommerce() || is_cart() || is_checkout() ) {
				$is_transparent = false;
			}

			return $is_transparent;
		}
		/**
		 * Output the Mytravel Breadcrumb.
		 *
		 * @param array $args Arguments.
		 */
		public function breadcrumb_defaults( $args ) {

			if ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) {
				$bc_wrap       = 'border-bottom mb-7';
				$bc_inner_wrap = 'py-3';
				$bc_nav_class  = 'flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble';
				$bc_item_class = 'flex-shrink-0 flex-xl-shrink-1';
			} else {
				$bc_wrap       = 'border-0';
				$bc_inner_wrap = '';
				$bc_nav_class  = 'justify-content-center';
				$bc_item_class = 'font-size-14 text-white';
			}

			$args['wrap_before'] = '<div class="border-bottom mb-7"><div class="container"><nav class="woocommerce-breadcrumb py-3" aria-label="' . esc_attr__( 'breadcrumb', 'mytravel' ) . '"><ol class="breadcrumb breadcrumb-no-gutter mb-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">';
			$args['wrap_after']  = '</ol></nav></div></div>';
			$args['before']      = '<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1">';
			$args['after']       = '</li>';
			$args['delimiter']   = false;

			return $args;
		}
		/**
		 * Adds custom classes to the array of archive product title classes.
		 *
		 * @param array $classes Classes for the product title element.
		 * @return array
		 */
		public function product_loop_title_classes( $classes ) {
			$layout = mytravel_get_product_format();
			if ( 'yacht' === $layout ) {
				$price_class = ( is_product() ? 'text-dark font-weight-bold' : 'text-white font-weight-bold' );
			} elseif ( 'rental' === $layout || 'car_rental' === $layout ) {
				$price_class = ( is_product() ? 'text-dark font-weight-bold' : 'text-white font-weight-bold' );
			} elseif ( 'tour' === $layout ) {
				$price_class = 'font-weight-bold';
			} else {
				$price_class = 'font-weight-medium';
			}

			$classes .= ' font-size-17 ' . $price_class;
			return $classes;
		}
		/**
		 * Adds custom classes to the array of product classes.
		 *
		 * @param array $classes Classes for the product element.
		 * @return array
		 */
		public function post_class( $classes ) {

			$should_add_class = true;

			if ( is_product() ) {
				$should_add_class = false;

				if ( ! empty( wc_get_loop_prop( 'name' ) ) ) {
					$should_add_class = true;
				}
			} else {

				$view = mytravel_get_hotel_archive_view();

				if ( 'list-view' === $view ) {
					$should_add_class = false;
				}
			}

			if ( $should_add_class ) {

				$classes[] = 'mb-3';
				$classes[] = 'mb-md-4';
				$classes[] = 'pb-1';
				$columns   = wc_get_loop_prop( 'columns' );

				wc_set_loop_prop( 'columns', apply_filters( 'mytravel_shop_loop_columns', $columns ) );
			}

			return $classes;
		}
		/**
		 * Override price HTML
		 *
		 * @param string $price Price HTML.
		 */
		public function format_price( $price ) {

			$layout = mytravel_get_product_format();

			$replace = 'woocommerce-Price-amount font-weight-bold';

			if ( is_archive() ) {
				$class = 'text-white';
			} else {
				$class = 'text-dark';
			}

			if ( 'yacht' === $layout ) {
				$replace .= ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? ' font-size-22' : ' font-size-19 text-white';
			} elseif ( 'tour' === $layout ) {
				$replace .= ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? ' font-size-22' : ' h5 mb-0 text-white';
			} elseif ( 'activity' === $layout ) {
				$replace .= ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? ' font-size-22' : '';
			} elseif ( 'rental' === $layout || 'car_rental' === $layout ) {
				$replace .= ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? ' font-size-22' : ' font-size-19 mb-2 d-inline-block text-white';
			}

			if ( is_product() && empty( wc_get_loop_prop( 'name' ) ) ) {
				$replace = 'woocommerce-Price-amount font-size-24 text-gray-6 font-weight-bold ml-1';
			}

			return str_replace( 'woocommerce-Price-amount', $replace, $price );
		}
		/**
		 * Additional class for product price
		 *
		 * @param string $class Price class.
		 */
		public function product_price_class( $class ) {
			return $class . ' mb-0';
		}
		/**
		 * Set address fields
		 *
		 * @param array $fields Address fields.
		 */
		public function address_fields( $fields ) {
			$fields['city']['class'][]     = 'col-md-4';
			$fields['state']['class'][]    = 'col-md-4';
			$fields['postcode']['class'][] = 'col-md-4';
			return $fields;
		}

		/**
		 * Set Form field arguments
		 *
		 * @param array $args form field arguments.
		 */
		public function form_field_args( $args ) {
			$args['label_class'][] = 'form-label text-dark';
			$args['input_class'][] = 'form-control';
			$args['class'][]       = 'col-12 mb-4';

			if ( in_array( 'form-row-first', $args['class'], true ) ) {
				$args['class'][] = 'col-md-6 mb-4';
			}

			if ( in_array( 'form-row-last', $args['class'], true ) ) {
				$args['class'][] = 'col-md-6 mb-4';
			}

			return $args;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function body_classes( $classes ) {
			$product_format = mytravel_get_product_format();

			if ( is_product() ) {
				if ( 'tour' === $product_format || 'activity' === $product_format ) {
					$classes[] = 'single-product-v1';
				}

				if ( 'rental' === $product_format ) {
					$classes[] = 'single-product-rental';
				}

				if ( 'standard' === $product_format || 'room' === $product_format ) {
					$classes[] = 'single-product-standard';
				}
			}

			return $classes;
		}

		/**
		 * Set not prose for WooCommerce Pages.
		 *
		 * @param bool $enabled Prose enabled or disabled.
		 * @return bool
		 */
		public function set_not_prose( $enabled ) {
			if ( is_cart() || is_checkout() || is_account_page() ) {
				$enabled = false;
			}
			return $enabled;
		}
	}

endif;

return new MyTravel_WooCommerce();
