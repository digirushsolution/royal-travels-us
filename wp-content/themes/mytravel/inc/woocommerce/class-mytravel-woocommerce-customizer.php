<?php
/**
 * MyTravel WooCommerce Customizer Class
 *
 * @package  koach
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyTravel_WooCommerce_Customizer' ) ) :

	/**
	 * The MyTravel WooCommerce Customizer class
	 */
	class MyTravel_WooCommerce_Customizer extends MyTravel_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_shop_settings' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_shop_header' ), 20 );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_shop_settings( $wp_customize ) {

			/**
			 * Shop page
			 */

			$wp_customize->add_section(
				'mytravel_shop',
				array(
					'title'    => esc_html__( 'Shop', 'mytravel' ),
					'priority' => 40,
					'panel'    => 'woocommerce',
				)
			);

			$wp_customize->add_setting(
				'product_archive_layout',
				array(
					'default'           => 'right-sidebar',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_key',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'product_archive_layout',
				array(
					'type'        => 'select',
					'section'     => 'mytravel_shop',
					/* translators: label field of control in Customizer */
					'label'       => esc_html__( 'Shop Sidebar', 'mytravel' ),
					'description' => esc_html__( 'Select from the three sidebar layouts for shop', 'mytravel' ),
					'choices'     => [
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'mytravel' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'mytravel' ),
						'no-sidebar'    => esc_html__( 'Full Width', 'mytravel' ),
					],
					'priority'    => 10,
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'product_archive_layout',
				[
					'fallback_refresh' => true,
				]
			);

			$wp_customize->add_setting(
				'mytravel_api_key',
				array(
					'default'           => 'hZ81IzfipCdWrayhLcUfv3KumG0',
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'mytravel_api_key',
				array(
					'type'    => 'text',
					'section' => 'mytravel_shop',
					'label'   => esc_html__( 'Enter Google Map API Key', 'mytravel' ),
				)
			);

			$wp_customize->add_setting(
				'mytravel_maptiler_api_key',
				array(
					'default'           => 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=OvBraDfNWQ0GqQ63gXSj',
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'mytravel_maptiler_api_key',
				array(
					'type'    => 'text',
					'section' => 'mytravel_shop',
					'label'   => esc_html__( 'Enter Maptiler API Key', 'mytravel' ),
				)
			);

		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_shop_header( $wp_customize ) {

			/**
			 * Shop page
			 */
			$default = '';
			if ( ! class_exists( 'MAS_Travels' ) ) {
				$default = 'yes';
			} else {
				$default = 'no';
			}

			$wp_customize->add_section(
				'mytravel_shop_header',
				array(
					'title'    => esc_html__( 'Shop Header', 'mytravel' ),
					'priority' => 50,
					'panel'    => 'woocommerce',
				)
			);

			$wp_customize->add_setting(
				'shop_enable_separate_header',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'shop_enable_separate_header',
				array(
					'type'        => 'radio',
					'section'     => 'mytravel_shop_header',
					'label'       => esc_html__( 'Enable Header for Shop Page', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to show or hide dashboard Header.', 'mytravel' ),
					'choices'     => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_version',
				array(
					'default'           => 'v1',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_version',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Header Variant', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header type.', 'mytravel' ),
					'choices'         => array(
						'v1' => esc_html__( 'Header v1', 'mytravel' ),
						'v2' => esc_html__( 'Header v2', 'mytravel' ),
						'v3' => esc_html__( 'Header v3', 'mytravel' ),
						'v4' => esc_html__( 'Header v4', 'mytravel' ),
						'v5' => esc_html__( 'Header v5', 'mytravel' ),
						'v6' => esc_html__( 'Header v6', 'mytravel' ),
						'v8' => esc_html__( 'Header v7', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Container CSS Classes', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add primary navbar container css', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' ) && in_array(
							get_theme_mod( 'mytravel_shop_header_version' ),
							[
								'v1',
								'v6',
							],
							true
						);
					},
				]
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_transparent_header',
				array(
					'default'           => $default,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_transparent_header',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Transparent Header ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' ) && ! class_exists( 'MAS_Travels' );
					},

				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_search',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_search',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Search ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},

				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_sticky',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_sticky',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Sticky Header ?', 'mytravel' ),
					'choices'         => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_top_navbar',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_top_navbar',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Top Navbar ?  ', 'mytravel' ),
					'choices'         => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_language_dropdown_enable',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_language_dropdown_enable',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Language Dropdown ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							[
								'v1',
								'v3',
								'v4',
								'v5',
								'v11',
							],
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_mini_cart',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_mini_cart',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Minicart ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' ) && mytravel_is_woocommerce_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_signin',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_signin',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Signin ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_enable_navbar_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_enable_navbar_button',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Enable Navbar Button ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_button_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_shop_header_button_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Button CSS Class', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add  button css', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				]
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_button_color',
				array(
					'default'           => 'white',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_button_color',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Navbar Button Color', 'mytravel' ),
					'choices'         => array(
						'primary' => esc_html_x( 'Primary', 'button', 'mytravel' ),
						'success' => esc_html_x( 'Success', 'button', 'mytravel' ),
						'danger'  => esc_html_x( 'Danger', 'button', 'mytravel' ),
						'warning' => esc_html_x( 'Warning', 'button', 'mytravel' ),
						'info'    => esc_html_x( 'Info', 'button', 'mytravel' ),
						'dark'    => esc_html_x( 'Dark', 'button', 'mytravel' ),
						'link'    => esc_html_x( 'Link', 'button', 'mytravel' ),
						'white'   => esc_html_x( 'White', 'button', 'mytravel' ),
						'purple'  => esc_html_x( 'Purple', 'button', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_button_text',
				array(
					'default'           => esc_html__( 'Become Local Expert', 'mytravel' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_button_text',
				array(
					'type'            => 'text',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Navbar Button Text', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'mytravel_shop_header_navbar_button_text',
				array(
					'selector'         => '.mytravel-shop-header-navbar-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_button_url',
				array(
					'type'            => 'url',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Navbar Button Link', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_button_size',
				array(
					'default'           => 'wide',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_button_size',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Navbar Button Size', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button size.', 'mytravel' ),
					'choices'         => array(
						'wide-normal' => esc_html__( 'Normal Wide', 'mytravel' ),
						'md-wide'     => esc_html__( 'Medium Wide', 'mytravel' ),
						'wide'        => esc_html__( 'Wide', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_button_shape',
				array(
					'default'           => 'rounded-xs',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Navbar Button Shape', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button shape.', 'mytravel' ),
					'choices'         => array(
						''           => esc_html__( 'Default', 'mytravel' ),
						'rounded-xs' => esc_html__( 'Rounded-xs', 'mytravel' ),
						'rounded-sm' => esc_html__( 'Rounded-sm', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},

				)
			);

			$wp_customize->add_setting(
				'mytravel_shop_header_navbar_button_variant',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_shop_header_navbar_button_variant',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_shop_header',
					'label'           => esc_html__( 'Navbar Button Variant', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your navbar button variant.', 'mytravel' ),
					'choices'         => array(
						''            => esc_html__( 'Default', 'mytravel' ),
						'outline'     => esc_html__( 'Outline', 'mytravel' ),
						'translucent' => esc_html__( 'Translucent', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_shop_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( 'shop_enable_separate_header', 'yes' );
					},
				)
			);

		}

	}

endif;

return new MyTravel_WooCommerce_Customizer();
