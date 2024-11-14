<?php
/**
 * Mytravel Plugin Install Class
 *
 * @package  mytravel
 * @since    2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Mytravel_Plugin_Install' ) ) :
	/**
	 * The Mytravel plugin install class
	 */
	class Mytravel_Plugin_Install {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'plugin_install_scripts' ) );
			add_action( 'tgmpa_register', [ $this, 'register_required_plugins' ] );
		}

		/**
		 * Wrapper around the core WP get_plugins function, making sure it's actually available.
		 *
		 * @since 2.5.0
		 *
		 * @param string $plugin_folder Optional. Relative path to single plugin folder.
		 * @return array Array of installed plugins with plugin information.
		 */
		public function get_plugins( $plugin_folder = '' ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			return get_plugins( $plugin_folder );
		}

		/**
		 * Helper function to extract the file path of the plugin file from the
		 * plugin slug, if the plugin is installed.
		 *
		 * @since 2.0.0
		 *
		 * @param string $slug Plugin slug (typically folder name) as provided by the developer.
		 * @return string Either file path for plugin if installed, or just the plugin slug.
		 */
		protected function get_plugin_basename_from_slug( $slug ) {
			$keys = array_keys( $this->get_plugins() );

			foreach ( $keys as $key ) {
				if ( preg_match( '|^' . $slug . '/|', $key ) ) {
					return $key;
				}
			}

			return $slug;
		}

		/**
		 * Check if all plugins profile are installed
		 *
		 * @param array $plugins Array of plugins and profiles.
		 * @return bool
		 */
		public function requires_install_plugins( $plugins ) {
			$requires = false;

			foreach ( $plugins as $plugin ) {
				$plugin['file_path']   = $this->get_plugin_basename_from_slug( $plugin['slug'] );
				$plugin['is_callable'] = '';

				if ( ! TGM_Plugin_Activation::is_active( $plugin ) ) {
					$requires = true;
					break;
				}
			}

			return $requires;
		}

		/**
		 * Load plugin install scripts
		 *
		 * @param string $hook_suffix the current page hook suffix.
		 * @return void
		 * @since  1.4.4
		 */
		public function plugin_install_scripts( $hook_suffix ) {
			global $mytravel, $mytravel_version;

			wp_enqueue_script( 'mytravel-plugin-install', get_template_directory_uri() . '/assets/js/admin/plugin-install.js', array( 'jquery', 'updates' ), $mytravel_version, 'all' );

			$params = [
				'tgmpa_url'   => admin_url( add_query_arg( 'page', 'tgmpa-install-plugins', 'themes.php' ) ),
				'txt_install' => esc_html__( 'Install Plugins', 'mytravel' ),
				'profiles'    => $this->get_profile_params(),
			];

			if ( mytravel_is_ocdi_activated() ) {
				$params['file_args'] = $mytravel->ocdi->import_files();
			}
			wp_localize_script( 'mytravel-plugin-install', 'ocdi_params', $params );
			wp_enqueue_script( 'mytravel-plugin-install' );

			wp_enqueue_style( 'mytravel-plugin-install', get_template_directory_uri() . '/assets/css/admin/plugin-install.css', array(), $mytravel_version, 'all' );
		}

		/**
		 * Determines whether a plugin is active.
		 *
		 * Only plugins installed in the plugins/ folder can be active.
		 *
		 * Plugins in the mu-plugins/ folder can't be "activated," so this function will
		 * return false for those plugins.
		 *
		 * For more information on this and similar theme functions, check out
		 * the {@link https://developer.wordpress.org/themes/basics/conditional-tags/
		 * Conditional Tags} article in the Theme Developer Handbook.
		 *
		 * @param string $plugin Path to the plugin file relative to the plugins directory.
		 * @return bool True, if in the active plugins list. False, not in the list.
		 */
		public static function is_active_plugin( $plugin ) {
			return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) || is_plugin_active_for_network( $plugin );
		}

		/**
		 * Output a button that will install or activate a plugin if it doesn't exist, or display a disabled button if the
		 * plugin is already activated.
		 *
		 * @param string $plugin_slug The plugin slug.
		 * @param string $plugin_file The plugin file.
		 * @param string $plugin_name The plugin name.
		 * @param string $classes CSS classes.
		 * @param string $activated Button activated text.
		 * @param string $activate Button activate text.
		 * @param string $install Button install text.
		 */
		public static function install_plugin_button( $plugin_slug, $plugin_file, $plugin_name, $classes = array(), $activated = '', $activate = '', $install = '' ) {
			if ( current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) ) {
				if ( self::is_active_plugin( $plugin_slug . '/' . $plugin_file ) ) {
					// The plugin is already active.
					$button = array(
						'message' => esc_attr__( 'Activated', 'mytravel' ),
						'url'     => '#',
						'classes' => array( 'mytravel-button', 'disabled' ),
					);

					if ( '' !== $activated ) {
						$button['message'] = esc_attr( $activated );
					}
				} elseif ( self::is_plugin_installed( $plugin_slug ) ) {
					$url = self::is_plugin_installed( $plugin_slug );

					// The plugin exists but isn't activated yet.
					$button = array(
						'message' => esc_attr__( 'Activate', 'mytravel' ),
						'url'     => $url,
						'classes' => array( 'activate-now' ),
					);

					if ( '' !== $activate ) {
						$button['message'] = esc_attr( $activate );
					}
				} else {
					// The plugin doesn't exist.
					$url    = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $plugin_slug,
							),
							self_admin_url( 'update.php' )
						),
						'install-plugin_' . $plugin_slug
					);
					$button = array(
						'message' => esc_attr__( 'Install now', 'mytravel' ),
						'url'     => $url,
						'classes' => array( 'sf-install-now', 'install-now', 'install-' . $plugin_slug ),
					);

					if ( '' !== $install ) {
						$button['message'] = esc_attr( $install );
					}
				}

				if ( ! empty( $classes ) ) {
					$button['classes'] = array_merge( $button['classes'], $classes );
				}

				$button['classes'] = implode( ' ', $button['classes'] );

				?>
				<span class="plugin-card-<?php echo esc_attr( $plugin_slug ); ?>">
					<a href="<?php echo esc_url( $button['url'] ); ?>" class="<?php echo esc_attr( $button['classes'] ); ?>" data-originaltext="<?php echo esc_attr( $button['message'] ); ?>" data-name="<?php echo esc_attr( $plugin_name ); ?>" data-slug="<?php echo esc_attr( $plugin_slug ); ?>" aria-label="<?php echo esc_attr( $button['message'] ); ?>"><?php echo esc_html( $button['message'] ); ?></a>
				</span> <?php echo /* translators: conjunction of two alternative options user can choose (in missing plugin admin notice). */ esc_html__( 'or', 'mytravel' ); ?>
				<a href="https://wordpress.org/plugins/<?php echo esc_attr( $plugin_slug ); ?>" target="_blank"><?php esc_html_e( 'learn more', 'mytravel' ); ?></a>
				<?php
			}
		}

		/**
		 * Check if a plugin is installed and return the url to activate it if so.
		 *
		 * @param string $plugin_slug The plugin slug.
		 */
		private static function is_plugin_installed( $plugin_slug ) {
			if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
				$plugins = get_plugins( '/' . $plugin_slug );
				if ( ! empty( $plugins ) ) {
					$keys        = array_keys( $plugins );
					$plugin_file = $plugin_slug . '/' . $keys[0];
					$url         = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'activate',
								'plugin' => $plugin_file,
							),
							admin_url( 'plugins.php' )
						),
						'activate-plugin_' . $plugin_file
					);
					return $url;
				}
			}
			return false;
		}

		/**
		 * Get profile parameters.
		 *
		 * @return array
		 */
		public function get_profile_params() {
			$profiles = $this->get_demo_profiles();
			$params   = [];
			foreach ( $profiles as $key => $profile ) {
				$plugins                            = $this->get_demo_plugins( $key );
				$params[ $key ]['requires_install'] = $this->requires_install_plugins( $plugins );
				if ( $params[ $key ]['requires_install'] ) {
					$params['all']['requires_install'] = true;
				}
			}
			return $params;
		}

		/**
		 * Get Demo Profiles
		 *
		 * @return array
		 */
		public function get_demo_profiles() {
			return array(
				'default' => array(
					array(
						'name'        => 'MAS Travels for WooCommerce',
						'slug'        => 'mas-travels',
						'source'      => 'https://transvelo.github.io/mytravel/assets/plugins/mas-travels.zip',
						'required'    => true,
						'description' => esc_html__( 'Page Builder used to build all our Mytravel Pages', 'mytravel' ),
					),
					array(
						'name'        => 'Elementor',
						'slug'        => 'elementor',
						'required'    => true,
						'description' => esc_html__( 'Page Builder used to build all our Mytravel Pages', 'mytravel' ),
					),
					array(
						'name'        => 'MyTravel Elementor',
						'slug'        => 'mytravel-elementor',
						'source'      => 'https://transvelo.github.io/mytravel/assets/plugins/mytravel-elementor.zip',
						'required'    => true,
						'description' => esc_html__( 'Additional modules for Elementor to build our Mytravel Pages', 'mytravel' ),
					),
					array(
						'name'        => 'Advanced Product Fields for WooCommerce',
						'slug'        => 'advanced-product-fields-for-woocommerce',
						'required'    => true,
						'description' => esc_html__( 'Additional options for Mytravel Product Pages', 'mytravel' ),
					),

					array(
						'name'        => 'One Click Demo Import',
						'slug'        => 'one-click-demo-import',
						'required'    => false,
						'description' => esc_html__( 'Import Mytravel demo content easily with just one click.', 'mytravel' ),
					),
					array(
						'name'     => 'Woocommerce',
						'slug'     => 'woocommerce',
						'required' => true,
					),
					array(
						'name'     => 'WooCommerce Easy Booking',
						'slug'     => 'woocommerce-easy-booking-system',
						'required' => true,
					),
					array(
						'name'       => 'YITH WooCommerce Wishlist',
						'slug'       => 'yith-woocommerce-wishlist',
						'required'   => true,
					),
					array(
						'name'        => 'MAS Static Content',
						'slug'        => 'mas-static-content',
						'required'    => false,
						'description' => esc_html__( 'Mytravel uses Static Contents for Footer and Megamenus.', 'mytravel' ),
					),

				),
				'static'  => array(
					array(
						'name'        => 'MAS Static Content',
						'slug'        => 'mas-static-content',
						'required'    => false,
						'description' => esc_html__( 'Mytravel uses Static Contents for Footer and Megamenus.', 'mytravel' ),
					),
				),
				'contact'   => array(
					array(
						'name'     => 'WPForms Lite',
						'slug'     => 'wpforms-lite',
						'required' => false,
						'description' => esc_html__( 'Use this plugin to replace HTML forms with a working form.', 'mytravel' ),
					),
				),
				'recommended_plugins'   => array(
					array(
						'name'               => 'HubSpot All-In-One Marketing - Forms, Popups, Live Chat',
						'slug'               => 'leadin',
						'required'           => false,
					),
				),

			);
		}

		/**
		 * Get plugins list for a given profile.
		 *
		 * @param string $demo The demo profile.
		 * @return array
		 */
		public function get_demo_plugins( $demo = 'default' ) {
			$profiles = $this->get_demo_profiles();
			$plugins  = [];

			foreach ( $profiles as $key => $profile ) {
				if ( 'all' === $demo || 'default' === $key || $key === $demo ) {
					$plugins = array_merge( $plugins, $profile );
				}
			}

			return $plugins;
		}

		/**
		 * Register the required plugins for this theme.
		 *
		 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
		 */
		public function register_required_plugins() {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */

			$profile = isset( $_GET['demo'] ) ? sanitize_text_field( wp_unslash( $_GET['demo'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			$plugins = $this->get_demo_plugins( $profile );

			$config = array(
				'id'           => 'mytravel', // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',        // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,      // Show admin notices or not.
				'dismissable'  => true,      // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',        // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,     // Automatically activate plugins after installation or not.
				'message'      => '',        // Message to output right before the plugins table.
			);

			tgmpa( $plugins, $config );
		}
	}

endif;

return new Mytravel_Plugin_Install();
