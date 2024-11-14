<?php
/**
 * Mytravel OCDI Class
 *
 * @package mytavel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Mytravel_OCDI' ) ) :
	/**
	 * The one click demo import class.
	 */
	class Mytravel_OCDI {

		/**
		 * Stores the assets URL.
		 *
		 * @var string
		 */
		public $assets_url;

		/**
		 * Stores the demo URL.
		 *
		 * @var string
		 */
		public $demo_url;

		/**
		 * Instantiate the class.
		 */
		public function __construct() {

			$this->assets_url = 'https://transvelo.github.io/mytravel/assets/';
			$this->demo_url   = 'https://mytravel.madrasthemes.com/';

			add_filter( 'pt-ocdi/confirmation_dialog_options', [ $this, 'confirmation_dialog_options' ], 10, 1 );

			add_action( 'pt-ocdi/import_files', [ $this, 'import_files' ] );

			add_action( 'pt-ocdi/after_import', [ $this, 'import_wpforms' ] );
			add_action( 'pt-ocdi/after_import', [ $this, 'import_acf_fields' ] );
			add_action( 'pt-ocdi/enable_wp_customize_save_hooks', '__return_true' );
			add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
			add_action( 'pt-ocdi/after_import', [ $this, 'replace_uploads_dir' ] );
			add_action( 'pt-ocdi/after_import', [ $this, 'set_site_options' ] );
			add_filter( 'ocdi/register_plugins', [ $this, 'register_plugins' ] );

		}

		/**
		 * Register plugins in OCDI.
		 *
		 * @param array $plugins List of plugins.
		 */
		public function register_plugins( $plugins ) {
			global $mytravel;

			$profile = 'default';

			if ( isset( $_GET['import'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$demo_id = absint( $_GET['import'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				switch ( $demo_id ) {
					case 7:
						$profile = 'static';
						break;
					case 8:
						$profile = 'portfolio';
						break;
					case 9:
						$profile = 'static';
						break;
					case 13:
						$profile = 'static';
						break;
					case 14:
						$profile = 'portfolio';
						break;
					case 16:
						$profile = 'static';
						break;
					case 17:
						$profile = 'contact';
						break;
				}
			}

			return $mytravel->plugin_install->get_demo_plugins( $profile );
		}

		/**
		 * Confirmation dialog box options.
		 *
		 * @param array $options The dialog options.
		 * @return array
		 */
		public function confirmation_dialog_options( $options ) {
			return array_merge(
				$options,
				array(
					'width' => 410,
				)
			);
		}

		/**
		 * Trigger after import
		 */
		public function trigger_ocdi_after_import() {
			$import_files    = $this->import_files();
			$selected_import = end( $import_files );
			do_action( 'pt-ocdi/after_import', $selected_import ); //phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
		}

		/**
		 * Replace uploads Dir.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function replace_uploads_dir( $selected_import ) {
			if ( isset( $selected_import['uploads_dir'] ) ) {
				$from = $selected_import['uploads_dir'] . '/';
			} else {
				$from = 'https://mytraveldemos.madrasthemes.com/';
			}

			$site_upload_dir = wp_get_upload_dir();
			$to              = $site_upload_dir['baseurl'] . '/';
			\Elementor\Utils::replace_urls( $from, $to );
		}

		/**
		 * Clear default widgets.
		 */
		public function clear_default_widgets() {
			$sidebars_widgets = get_option( 'sidebars_widgets' );
			$all_widgets      = array();

			array_walk_recursive(
				$sidebars_widgets,
				function ( $item, $key ) use ( &$all_widgets ) {
					if ( ! isset( $all_widgets[ $key ] ) ) {
						$all_widgets[ $key ] = $item;
					} else {
						$all_widgets[] = $item;
					}
				}
			);

			if ( isset( $all_widgets['array_version'] ) ) {
				$array_version = $all_widgets['array_version'];
				unset( $all_widgets['array_version'] );
			}

			$new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

			$new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
			if ( isset( $array_version ) ) {
				$new_sidebars_widgets['array_version'] = $array_version;
			}

			update_option( 'sidebars_widgets', $new_sidebars_widgets );
		}

		/**
		 * Set site options.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function set_site_options( $selected_import ) {
			if ( isset( $selected_import['set_pages'] ) && $selected_import['set_pages'] ) {
				$front_page_title  = isset( $selected_import['front_page_title'] ) ? $selected_import['front_page_title'] : 'Home v1';
				$front_page_id     = get_page_by_title( $front_page_title );
				$blog_page_id      = get_page_by_title( 'Blog' );
				$shop_page_id      = get_page_by_title( 'Shop' );
				$cart_page_id      = get_page_by_title( 'Cart' );
				$checkout_page_id  = get_page_by_title( 'Checkout' );
				$myaccount_page_id = get_page_by_title( 'My account' );
				$wishlist_page_id  = get_page_by_title( 'Wishlist' );

				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $front_page_id->ID );
				update_option( 'page_for_posts', $blog_page_id->ID );
				update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
				update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
				update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
				update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
				update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id->ID );
			}
			update_option( 'woocommerce_catalog_columns', 3 );
			update_option( 'wceb_calendar_theme', 'default' );
			update_option( 'posts_per_page', 9 );
		}

		/**
		 * Set the nav menus.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function set_nav_menus( $selected_import ) {
			if ( isset( $selected_import['set_nav_menus'] ) && $selected_import['set_nav_menus'] ) {
				$primary      = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
				$social_media = get_term_by( 'name', 'Social Media', 'nav_menu' );
				$topbar_left  = get_term_by( 'name', 'Topbar Left', 'nav_menu' );
				$topbar_right = get_term_by( 'name', 'Topbar Right', 'nav_menu' );
				$footer_links = get_term_by( 'name', 'Footer Links', 'nav_menu' );
				$locations    = [
					'social_media' => $social_media->term_id,
					'topbar_left'  => $topbar_left->term_id,
					'topbar_right' => $topbar_right->term_id,
					'primary'      => $primary->term_id,
					'footer_links' => $footer_links->term_id,
				];

				set_theme_mod( 'nav_menu_locations', $locations );
			}
		}

		/**
		 * Import WPForms.
		 */
		public function import_wpforms() {

			$ocdi_host = 'https://transvelo.github.io/mytravel';
			$dd_url    = $ocdi_host . '/assets/wpforms/';

			if ( ! function_exists( 'wpforms' ) || get_option( 'mytravel_wpforms_imported', false ) ) {
				return;
			}

			$wpform_file_url = $dd_url . 'all.json';
			$response        = wp_remote_get( $wpform_file_url );

			if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
				return;
			}

			$form_json = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $form_json ) ) {
				return;
			}

			$forms = json_decode( $form_json, true );

			foreach ( $forms as $form_data ) {
				$form_title = $form_data['settings']['form_title'];

				if ( ! empty( $form_data['id'] ) ) {
					$form_content = array(
						'field_id' => '0',
						'settings' => array(
							'form_title' => sanitize_text_field( $form_title ),
							'form_desc'  => '',
						),
					);

					// Merge args and create the form.
					$form = array(
						'import_id'    => (int) $form_data['id'],
						'post_title'   => esc_html( $form_title ),
						'post_status'  => 'publish',
						'post_type'    => 'wpforms',
						'post_content' => wpforms_encode( $form_content ),
					);

					$form_id = wp_insert_post( $form );
				} else {
					// Create initial form to get the form ID.
					$form_id = wpforms()->form->add( $form_title );
				}

				if ( empty( $form_id ) ) {
					continue;
				}

				$form_data['id'] = $form_id;
				// Save the form data to the new form.
				wpforms()->form->update( $form_id, $form_data );
			}

			update_option( 'mytravel_wpforms_imported', true );
		}

		/**
		 * Import WPForms.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function import_acf_fields( $selected_import ) {

			if ( ! mytravel_is_acf_activated() ) {
				return;
			}

			// $ocdi_host   = 'https://transvelo.github.io/mytravel';
			$ocdi_host = get_template_directory_uri();
			$acf_url   = $ocdi_host . '/assets/acf/full.json';

			// Read JSON.
			$json = file_get_contents( $acf_url );
			$json = json_decode( $json, true );

			// Check if empty.
			if ( ! $json || ! is_array( $json ) ) {
				return acf_add_admin_notice( __( 'Import file empty', 'mytravel' ), 'warning' );
			}

			// Ensure $json is an array of groups.
			if ( isset( $json['key'] ) ) {
				$json = array( $json );
			}

			// Remeber imported field group ids.
			$ids = array();

			// Loop over json.
			foreach ( $json as $field_group ) {

				// Search database for existing field group.
				$post = acf_get_field_group_post( $field_group['key'] );
				if ( $post ) {
					$field_group['ID'] = $post->ID;
				}

				// Import field group.
				$field_group = acf_import_field_group( $field_group );

				// append message.
				$ids[] = $field_group['ID'];
			}
		}


		/**
		 * Import Files from each demo.
		 */
		public function import_files() {
			$ocdi_host   = 'https://transvelo.github.io/mytravel';
			$dd_url      = $ocdi_host . '/assets/xml/';
			$widget_url  = $ocdi_host . '/assets/widgets/';
			$preview_url = $ocdi_host . '/assets/img/ocdi/';
			/* translators: %1$s - The demo name. %2$s - Minutes. */
			$notice  = esc_html__( 'This demo will import %1$s. It may take %2$s', 'mytravel' );
			$notice .= '<br><br>' . esc_html__( 'Menus, Widgets and Settings will not be imported. Content imported already will not be imported.', 'mytravel' );

			return apply_filters(
				'mytravel_ocdi_files_args',
				array(
					array(
						'import_file_name'         => 'Full Demo',
						'categories'               => array( 'Full Demo' ),
						'import_file_url'          => $dd_url . 'full.xml',
						'import_preview_image_url' => $preview_url . 'full.jpg',
						'import_widget_file_url'   => $widget_url . 'full.wie',
						'import_notice'            => esc_html__( 'It imports the entire demo. It may take upto 10 minutes', 'mytravel' ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/',
						'plugin_profile'           => 'all',
						'set_nav_menus'            => true,
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',
					),
					array(
						'import_file_name'         => 'Blog',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'blog.xml',
						'import_preview_image_url' => $preview_url . 'blog.jpg',
						'import_widget_file_url'   => $widget_url . 'blog.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '19 posts, 2 static-contents & 33 images', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/blog/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/blog-pages/wp-content/uploads/sites/8',
					),
					array(
						'import_file_name'         => 'Hotel',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'hotel.xml',
						'import_preview_image_url' => $preview_url . 'hotel.jpg',
						'import_widget_file_url'   => $widget_url . 'hotel.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '24 products including 21 hotels and 3 rooms, 1 home page, 2 static content, 3 posts & 38 images', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/product-category/hotel/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/hotel/wp-content/uploads/sites/2',
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',

					),
					array(
						'import_file_name'         => 'Tour',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'tour.xml',
						'import_preview_image_url' => $preview_url . 'tour.jpg',
						'import_widget_file_url'   => $widget_url . 'tour.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '12 products, 1 home page, 2 static content & 3 posts', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/product-category/tour/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/tour/wp-content/uploads/sites/3',
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',

					),
					array(
						'import_file_name'         => 'Rental',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'rental.xml',
						'import_preview_image_url' => $preview_url . 'rental.jpg',
						'import_widget_file_url'   => $widget_url . 'rental.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '12 products with 1 home page', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/shop',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/rental/wp-content/uploads/sites/5',
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',

					),
					array(
						'import_file_name'         => 'Car Rental',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'car-rental.xml',
						'import_preview_image_url' => $preview_url . 'car.jpg',
						'import_widget_file_url'   => $widget_url . 'rental.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '12 products with 1 home page, 3 posts & 2 static content', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/shop',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/car-rental/wp-content/uploads/sites/6',
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',

					),
					array(
						'import_file_name'         => 'Activity',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'activity.xml',
						'import_preview_image_url' => $preview_url . 'activity.jpg',
						'import_widget_file_url'   => $widget_url . 'activity.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '18 items with 1 home page & 2 static-content', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/shop',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/activity/wp-content/uploads/sites/4',
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',

					),
					array(
						'import_file_name'         => 'Yacht',
						'categories'               => array( 'Templates' ),
						'import_file_url'          => $dd_url . 'yacht.xml',
						'import_preview_image_url' => $preview_url . 'yacht.jpg',
						'import_widget_file_url'   => $widget_url . 'yacht.wie',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '12 products with 1 home page & 2 static content', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/shop',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/yacht/wp-content/uploads/sites/7',
						'set_pages'                => true,
						'front_page_title'         => 'Home v1',

					),
					array(
						'import_file_name'         => 'Destination',
						'categories'               => array( 'Pages' ),
						'import_file_url'          => $dd_url . 'destination.xml',
						'import_preview_image_url' => $preview_url . 'destination.jpg',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '29 items including 5 pages, 4 posts, 1 static-content & 11 images', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/destination/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/destination/wp-content/uploads/sites/13',
					),
					array(
						'import_file_name'         => 'About us',
						'categories'               => array( 'Pages' ),
						'import_file_url'          => $dd_url . 'about-us.xml',
						'import_preview_image_url' => $preview_url . 'about.jpg',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '22 items including 2 pages & 19 images', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/about/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/about/wp-content/uploads/sites/10',
					),
					array(
						'import_file_name'         => 'Contact',
						'categories'               => array( 'Pages' ),
						'import_file_url'          => $dd_url . 'contact.xml',
						'import_preview_image_url' => $preview_url . 'contact.jpg',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '46 items including 2 pages & 44 images', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/contact/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/contact/wp-content/uploads/sites/11',
					),
					array(
						'import_file_name'         => 'Terms and Conditions',
						'categories'               => array( 'Pages' ),
						'import_file_url'          => $dd_url . 'terms.xml',
						'import_preview_image_url' => $preview_url . 'term.jpg',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 Terms page', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/terms-and-condition/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/terms-conditions/wp-content/uploads/sites/14',
					),
					array(
						'import_file_name'         => 'FAQ',
						'categories'               => array( 'Pages' ),
						'import_file_url'          => $dd_url . 'faq.xml',
						'import_preview_image_url' => $preview_url . 'faq.jpg',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 faq page item', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/faqs/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/faq/wp-content/uploads/sites/15',
					),
					array(
						'import_file_name'         => 'Become Expert',
						'categories'               => array( 'Pages' ),
						'import_file_url'          => $dd_url . 'expert.xml',
						'import_preview_image_url' => $preview_url . 'expert.jpg',
						'import_notice'            => sprintf( $notice, '<strong>' . esc_html__( '1 home page, 2 static-content & 8 images', 'mytravel' ) . '</strong>', esc_html__( 'upto a minute', 'mytravel' ) ),
						'preview_url'              => 'https://mytravel.madrasthemes.com/become-expert/',
						'plugin_profile'           => 'default',
						'uploads_dir'              => 'https://mytraveldemos.madrasthemes.com/become-expert/wp-content/uploads/sites/12',
					),
					array(
						'import_file_name'         => 'Menus and Footer Widgets',
						'categories'               => array( 'Misc' ),
						'import_file_url'          => $dd_url . 'menu.xml',
						'import_preview_image_url' => $preview_url . 'menus.jpeg',
						'import_widget_file_url'   => $widget_url . 'footer.wie',
						'plugin_profile'           => 'static',
					),
					array(
						'import_file_name'         => 'WP Forms',
						'categories'               => array( 'Others' ),
						'import_file_url'          => $dd_url . 'wpforms.xml',
						'import_preview_image_url' => $preview_url . 'wpforms.jpg',
						'plugin_profile'           => 'contact',
					),
					array(
						'import_file_name'         => 'ACF',
						'categories'               => array( 'Others' ),
						'import_file_url'          => $dd_url . 'wpforms.xml',
						'import_preview_image_url' => $preview_url . 'acf.jpeg',
						'plugin_profile'           => 'default',
					),
					array(
                        'import_file_name'         => 'Hubspot',
                        'categories'               => array( 'CRM & Live Chat' ),
                        'import_preview_image_url' => $preview_url . 'hubspot.png',
                        'plugin_profile'           => 'recommended_plugins', 
                    ),
				)
			);
		}
	}

endif;

return new Mytravel_OCDI();
