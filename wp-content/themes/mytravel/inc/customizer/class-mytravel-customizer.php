<?php
/**
 * MyTravel Customizer Class
 *
 * @package  mytravel
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MyTravel_Customizer' ) ) :

	/**
	 * The MyTravel Customizer class
	 */
	class MyTravel_Customizer {

		/**
		 * Static Contents.
		 *
		 * @var array
		 */
		protected $static_contents = array();

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_general' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_logos' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_404' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_header' ), 20 );
			add_action( 'customize_register', array( $this, 'customize_blog' ), 30 );
			add_action( 'customize_register', array( $this, 'customize_footer' ), 40 );
			add_action( 'customize_register', array( $this, 'customize_customcolor' ), 10 );
		}
		/**
		 * Returns an array of the desired default MyTravel Options
		 *
		 * @return array
		 */
		public function get_mytravel_default_setting_values() {
			return apply_filters(
				'mytravel_setting_default_values',
				$args = array(
					'mytravel_heading_color'               => '#333333',
					'mytravel_text_color'                  => '#6d6d6d',
					'mytravel_accent_color'                => '#96588a',
					'mytravel_hero_heading_color'          => '#000000',
					'mytravel_hero_text_color'             => '#000000',
					'mytravel_header_background_color'     => '#ffffff',
					'mytravel_header_text_color'           => '#404040',
					'mytravel_header_link_color'           => '#333333',
					'mytravel_footer_background_color'     => '#f0f0f0',
					'mytravel_footer_heading_color'        => '#333333',
					'mytravel_footer_text_color'           => '#6d6d6d',
					'mytravel_footer_link_color'           => '#333333',
					'mytravel_button_background_color'     => '#eeeeee',
					'mytravel_button_text_color'           => '#333333',
					'mytravel_button_alt_background_color' => '#333333',
					'mytravel_button_alt_text_color'       => '#ffffff',
					'mytravel_layout'                      => 'right',
					'background_color'                     => 'ffffff',
				)
			);
		}

		/**
		 * Adds a value to each MyTravel setting if one isn't already present.
		 *
		 * @uses get_mytravel_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( $this->get_mytravel_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value Theme modification value.
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_mytravel_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter mytravel_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_mytravel_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( $this->get_mytravel_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {

			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section  = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority = 20;

			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title    = __( 'Background', 'mytravel' );
			$wp_customize->get_section( 'background_image' )->priority = 30;

			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title    = __( 'Header', 'mytravel' );
			$wp_customize->get_section( 'header_image' )->priority = 25;

			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

				$wp_customize->selective_refresh->add_partial(
					'custom_logo',
					array(
						'selector'        => '.site-branding',
						'render_callback' => array( $this, 'get_site_logo' ),
					)
				);

				$wp_customize->selective_refresh->add_partial(
					'blogname',
					array(
						'selector'        => '.site-title.beta a',
						'render_callback' => array( $this, 'get_site_name' ),
					)
				);

				$wp_customize->selective_refresh->add_partial(
					'blogdescription',
					array(
						'selector'        => '.site-description',
						'render_callback' => array( $this, 'get_site_description' ),
					)
				);
			}

			/**
			 * Add the typography section
			 */
			$wp_customize->add_section(
				'mytravel_typography',
				array(
					'title'    => __( 'Typography', 'mytravel' ),
					'priority' => 45,
				)
			);

			/**
			 * Heading color
			 */
			$wp_customize->add_setting(
				'mytravel_heading_color',
				array(
					'default'           => apply_filters( 'mytravel_default_heading_color', '#484c51' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_heading_color',
					array(
						'label'    => __( 'Heading color', 'mytravel' ),
						'section'  => 'mytravel_typography',
						'settings' => 'mytravel_heading_color',
						'priority' => 20,
					)
				)
			);

			/**
			 * Text Color
			 */
			$wp_customize->add_setting(
				'mytravel_text_color',
				array(
					'default'           => apply_filters( 'mytravel_default_text_color', '#43454b' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_text_color',
					array(
						'label'    => __( 'Text color', 'mytravel' ),
						'section'  => 'mytravel_typography',
						'settings' => 'mytravel_text_color',
						'priority' => 30,
					)
				)
			);

			/**
			 * Accent Color
			 */
			$wp_customize->add_setting(
				'mytravel_accent_color',
				array(
					'default'           => apply_filters( 'mytravel_default_accent_color', '#96588a' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_accent_color',
					array(
						'label'    => __( 'Link / accent color', 'mytravel' ),
						'section'  => 'mytravel_typography',
						'settings' => 'mytravel_accent_color',
						'priority' => 40,
					)
				)
			);

			/**
			 * Hero Heading Color
			 */
			$wp_customize->add_setting(
				'mytravel_hero_heading_color',
				array(
					'default'           => apply_filters( 'mytravel_default_hero_heading_color', '#000000' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_hero_heading_color',
					array(
						'label'    => __( 'Hero heading color', 'mytravel' ),
						'section'  => 'mytravel_typography',
						'settings' => 'mytravel_hero_heading_color',
						'priority' => 50,
					)
				)
			);

			/**
			 * Hero Text Color
			 */
			$wp_customize->add_setting(
				'mytravel_hero_text_color',
				array(
					'default'           => apply_filters( 'mytravel_default_hero_text_color', '#000000' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_hero_text_color',
					array(
						'label'    => __( 'Hero text color', 'mytravel' ),
						'section'  => 'mytravel_typography',
						'settings' => 'mytravel_hero_text_color',
						'priority' => 60,
					)
				)
			);

			$wp_customize->add_control(
				new Arbitrary_MyTravel_Control(
					$wp_customize,
					'mytravel_header_image_heading',
					array(
						'section'  => 'header_image',
						'type'     => 'heading',
						'label'    => __( 'Header background image', 'mytravel' ),
						'priority' => 6,
					)
				)
			);

			/**
			 * Header Background
			 */
			$wp_customize->add_setting(
				'mytravel_header_background_color',
				array(
					'default'           => apply_filters( 'mytravel_default_header_background_color', '#2c2d33' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_header_background_color',
					array(
						'label'    => __( 'Background color', 'mytravel' ),
						'section'  => 'header_image',
						'settings' => 'mytravel_header_background_color',
						'priority' => 15,
					)
				)
			);

			/**
			 * Header text color
			 */
			$wp_customize->add_setting(
				'mytravel_header_text_color',
				array(
					'default'           => apply_filters( 'mytravel_default_header_text_color', '#9aa0a7' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_header_text_color',
					array(
						'label'    => __( 'Text color', 'mytravel' ),
						'section'  => 'header_image',
						'settings' => 'mytravel_header_text_color',
						'priority' => 20,
					)
				)
			);

			/**
			 * Header link color
			 */
			$wp_customize->add_setting(
				'mytravel_header_link_color',
				array(
					'default'           => apply_filters( 'mytravel_default_header_link_color', '#d5d9db' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_header_link_color',
					array(
						'label'    => __( 'Link color', 'mytravel' ),
						'section'  => 'header_image',
						'settings' => 'mytravel_header_link_color',
						'priority' => 30,
					)
				)
			);

			/**
			 * Footer section
			 */
			$wp_customize->add_section(
				'mytravel_footer',
				array(
					'title'       => __( 'Footer', 'mytravel' ),
					'priority'    => 28,
					'description' => __( 'Customize the look & feel of your website footer.', 'mytravel' ),
				)
			);

			/**
			 * Footer Background
			 */
			$wp_customize->add_setting(
				'mytravel_footer_background_color',
				array(
					'default'           => apply_filters( 'mytravel_default_footer_background_color', '#f0f0f0' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_footer_background_color',
					array(
						'label'    => __( 'Background color', 'mytravel' ),
						'section'  => 'mytravel_footer',
						'settings' => 'mytravel_footer_background_color',
						'priority' => 10,
					)
				)
			);

			/**
			 * Footer heading color
			 */
			$wp_customize->add_setting(
				'mytravel_footer_heading_color',
				array(
					'default'           => apply_filters( 'mytravel_default_footer_heading_color', '#494c50' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_footer_heading_color',
					array(
						'label'    => __( 'Heading color', 'mytravel' ),
						'section'  => 'mytravel_footer',
						'settings' => 'mytravel_footer_heading_color',
						'priority' => 20,
					)
				)
			);

			/**
			 * Footer text color
			 */
			$wp_customize->add_setting(
				'mytravel_footer_text_color',
				array(
					'default'           => apply_filters( 'mytravel_default_footer_text_color', '#61656b' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_footer_text_color',
					array(
						'label'    => __( 'Text color', 'mytravel' ),
						'section'  => 'mytravel_footer',
						'settings' => 'mytravel_footer_text_color',
						'priority' => 30,
					)
				)
			);

			/**
			 * Footer link color
			 */
			$wp_customize->add_setting(
				'mytravel_footer_link_color',
				array(
					'default'           => apply_filters( 'mytravel_default_footer_link_color', '#2c2d33' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_footer_link_color',
					array(
						'label'    => __( 'Link color', 'mytravel' ),
						'section'  => 'mytravel_footer',
						'settings' => 'mytravel_footer_link_color',
						'priority' => 40,
					)
				)
			);

			/**
			 * Buttons section
			 */
			$wp_customize->add_section(
				'mytravel_buttons',
				array(
					'title'       => __( 'Buttons', 'mytravel' ),
					'priority'    => 45,
					'description' => __( 'Customize the look & feel of your website buttons.', 'mytravel' ),
				)
			);

			/**
			 * Button background color
			 */
			$wp_customize->add_setting(
				'mytravel_button_background_color',
				array(
					'default'           => apply_filters( 'mytravel_default_button_background_color', '#96588a' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_button_background_color',
					array(
						'label'    => __( 'Background color', 'mytravel' ),
						'section'  => 'mytravel_buttons',
						'settings' => 'mytravel_button_background_color',
						'priority' => 10,
					)
				)
			);

			/**
			 * Button text color
			 */
			$wp_customize->add_setting(
				'mytravel_button_text_color',
				array(
					'default'           => apply_filters( 'mytravel_default_button_text_color', '#ffffff' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_button_text_color',
					array(
						'label'    => __( 'Text color', 'mytravel' ),
						'section'  => 'mytravel_buttons',
						'settings' => 'mytravel_button_text_color',
						'priority' => 20,
					)
				)
			);

			/**
			 * Button alt background color
			 */
			$wp_customize->add_setting(
				'mytravel_button_alt_background_color',
				array(
					'default'           => apply_filters( 'mytravel_default_button_alt_background_color', '#2c2d33' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_button_alt_background_color',
					array(
						'label'    => __( 'Alternate button background color', 'mytravel' ),
						'section'  => 'mytravel_buttons',
						'settings' => 'mytravel_button_alt_background_color',
						'priority' => 30,
					)
				)
			);

			/**
			 * Button alt text color
			 */
			$wp_customize->add_setting(
				'mytravel_button_alt_text_color',
				array(
					'default'           => apply_filters( 'mytravel_default_button_alt_text_color', '#ffffff' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_button_alt_text_color',
					array(
						'label'    => __( 'Alternate button text color', 'mytravel' ),
						'section'  => 'mytravel_buttons',
						'settings' => 'mytravel_button_alt_text_color',
						'priority' => 40,
					)
				)
			);

			/**
			 * Layout
			 */
			$wp_customize->add_section(
				'mytravel_layout',
				array(
					'title'    => __( 'Layout', 'mytravel' ),
					'priority' => 50,
				)
			);

			$wp_customize->add_setting(
				'mytravel_layout',
				array(
					'default'           => apply_filters( 'mytravel_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
					'sanitize_callback' => 'mytravel_sanitize_choices',
				)
			);

			$wp_customize->add_control(
				new MyTravel_Custom_Radio_Image_Control(
					$wp_customize,
					'mytravel_layout',
					array(
						'settings' => 'mytravel_layout',
						'section'  => 'mytravel_layout',
						'label'    => __( 'General Layout', 'mytravel' ),
						'priority' => 1,
						'choices'  => array(
							'right' => get_template_directory_uri() . '/assets/images/customizer/controls/2cr.png',
							'left'  => get_template_directory_uri() . '/assets/images/customizer/controls/2cl.png',
						),
					)
				)
			);

			/**
			 * More
			 */
			if ( apply_filters( 'mytravel_customizer_more', true ) ) {
				$wp_customize->add_section(
					'mytravel_more',
					array(
						'title'    => __( 'More', 'mytravel' ),
						'priority' => 999,
					)
				);

				$wp_customize->add_setting(
					'mytravel_more',
					array(
						'default'           => null,
						'sanitize_callback' => 'sanitize_text_field',
					)
				);

				$wp_customize->add_control(
					new More_MyTravel_Control(
						$wp_customize,
						'mytravel_more',
						array(
							'label'    => __( 'Looking for more options?', 'mytravel' ),
							'section'  => 'mytravel_more',
							'settings' => 'mytravel_more',
							'priority' => 1,
						)
					)
				);
			}
		}

		/**
		 * Customize all available site logos
		 *
		 * All logos located in title_tagline (Site Identity) section.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_logos( $wp_customize ) {
			$this->add_customize_logos( $wp_customize );
		}
		/**
		 *
		 * Customize Control For Logo.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_customize_logos( $wp_customize ) {
			$wp_customize->get_control( 'custom_logo' )->description = esc_html__(
				'Logo is optimized for retina displays, so the original image size should be twice
				as big as the final logo that appears on the website. For example, if you want logo to
				be 142x34 px you should upload image 284x68 px.',
				'mytravel'
			);

			// Update the "custom_logo" partial with a new render callback.
			// TODO: wrap into anonymous function with return context.
			$wp_customize->selective_refresh->get_partial( 'custom_logo' );

			$wp_customize->add_setting(
				'transparent_header_logo',
				[
					'transport'         => 'postMessage',
					'theme_supports'    => 'custom-logo',
					'sanitize_callback' => 'absint',
				]
			);

			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control(
					$wp_customize,
					'transparent_header_logo',
					[
						'section'         => 'title_tagline',
						'label'           => esc_html__( 'Transparent Header Logo', 'mytravel' ),
						'description'     => esc_html__( 'Upload logo for transparent header', 'mytravel' ),
						'priority'        => 9,
						'width'           => 60,
						'height'          => 60,
						'flex_width'      => true,
						'flex_height'     => true,
						'button_labels'   => [
							'select'       => esc_html__( 'Select logo', 'mytravel' ),
							'change'       => esc_html__( 'Change logo', 'mytravel' ),
							'remove'       => esc_html__( 'Remove', 'mytravel' ),
							'default'      => esc_html__( 'Default', 'mytravel' ),
							'placeholder'  => esc_html__( 'No logo selected', 'mytravel' ),
							'frame_title'  => esc_html__( 'Select logo', 'mytravel' ),
							'frame_button' => esc_html__( 'Choose logo', 'mytravel' ),
						],
						'active_callback' => function () {
							return 'v2' !== get_theme_mod( 'mytravel_header_version' ) && 'v4' !== get_theme_mod( 'mytravel_header_version' );
						},
					]
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'transparent_header_logo',
				[
					'selector'            => '.sticky-logo-link',
					'container_inclusive' => true,
					'render_callback'     => 'mytravel_sticky_header_logo',
				]
			);

			$wp_customize->add_setting(
				'sticky_logo',
				[
					'transport'         => 'postMessage',
					'theme_supports'    => 'custom-logo',
					'sanitize_callback' => 'absint',
				]
			);

			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control(
					$wp_customize,
					'sticky_logo',
					[
						'section'       => 'title_tagline',
						'label'         => esc_html__( 'Upload Scroll Logo', 'mytravel' ),
						'description'   => esc_html__( 'Scroll Logo is the Logo that you want to appear when the user scrolls down and the header sticks in transparent header.', 'mytravel' ),
						'priority'      => 9,
						'width'         => 60,
						'height'        => 60,
						'flex_width'    => true,
						'flex_height'   => true,
						'button_labels' => [
							'select'       => esc_html__( 'Select logo', 'mytravel' ),
							'change'       => esc_html__( 'Change logo', 'mytravel' ),
							'remove'       => esc_html__( 'Remove', 'mytravel' ),
							'default'      => esc_html__( 'Default', 'mytravel' ),
							'placeholder'  => esc_html__( 'No logo selected', 'mytravel' ),
							'frame_title'  => esc_html__( 'Select logo', 'mytravel' ),
							'frame_button' => esc_html__( 'Choose logo', 'mytravel' ),
						],
					]
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'sticky_logo',
				[
					'selector'            => '.sticky-logo-link',
					'container_inclusive' => true,
					'render_callback'     => 'mytravel_sticky_header_logo',
				]
			);
		}

		/**
		 * Customize site header
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_general( $wp_customize ) {
			$wp_customize->add_section(
				'mytravel_general',
				[
					'title'       => esc_html__( 'General', 'mytravel' ),
					'description' => esc_html__( 'This section contains settings related to general.', 'mytravel' ),
					'priority'    => 20,
				]
			);

			$this->add_general_section( $wp_customize );
		}
		/**
		 * Customize General Section
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_general_section( $wp_customize ) {
			$wp_customize->add_setting(
				'enable_scroll_to_top',
				[
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'enable_scroll_to_top',
				[
					'type'    => 'radio',
					'section' => 'mytravel_general',
					'label'   => esc_html__( 'Enable Scroll to Top', 'mytravel' ),
					'choices' => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
				]
			);
			$wp_customize->selective_refresh->add_partial(
				'enable_scroll_to_top',
				[
					'fallback_refresh' => true,
				]
			);
		}

		/**
		 * Customize site header
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_header( $wp_customize ) {

			$wp_customize->add_panel(
				'header_panel',
				array(
					'priority' => 70,
					'title'    => esc_html__( 'Header', 'mytravel' ),
				)
			);
			$this->add_mytravel_header_settings( $wp_customize );
		}

		/**
		 * Customize Header Variant
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_mytravel_header_settings( $wp_customize ) {

			$default = 'no';
			if ( ! class_exists( 'MAS_Travels' ) ) {
				$default = 'yes';
			}
			$wp_customize->add_section(
				'mytravel_header',
				array(
					'title'       => esc_html__( 'General', 'mytravel' ),
					'description' => esc_html__( 'Customize the theme header.', 'mytravel' ),
					'priority'    => 80,
					'panel'       => 'header_panel',
				)
			);

			$wp_customize->add_setting(
				'mytravel_header_version',
				array(
					'default'           => 'v1',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_header_version',
				array(
					'type'        => 'select',
					'section'     => 'mytravel_header',
					'label'       => esc_html__( 'Header Variant', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to choose your header type.', 'mytravel' ),
					'choices'     => array(
						'v1' => esc_html__( 'Header v1', 'mytravel' ),
						'v2' => esc_html__( 'Header v2', 'mytravel' ),
						'v3' => esc_html__( 'Header v3', 'mytravel' ),
						'v4' => esc_html__( 'Header v4', 'mytravel' ),
						'v5' => esc_html__( 'Header v5', 'mytravel' ),
						'v6' => esc_html__( 'Header v6', 'mytravel' ),
						'v8' => esc_html__( 'Header v7', 'mytravel' ),
					),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'mytravel_header_version',
				[
					'fallback_refresh' => true,
				]
			);

			$wp_customize->add_setting(
				'mytravel_header_navbar_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_header_navbar_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Container CSS Classes', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add primary navbar container css', 'mytravel' ),
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'mytravel_header_version' ),
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
				'mytravel_enable_transparent_header',
				array(
					'default'           => $default,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_enable_transparent_header',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Transparent Header ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'v2' !== get_theme_mod( 'mytravel_header_version' ) && 'v4' !== get_theme_mod( 'mytravel_header_version' ) && 'v8' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_enable_transparent_logo',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_enable_transparent_logo',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Transparent Logo ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_transparent_header', 'yes' ) && 'v2' !== get_theme_mod( 'mytravel_header_version' ) && 'v4' !== get_theme_mod( 'mytravel_header_version' ) && 'v8' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'enable_sticky',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);
			$wp_customize->add_control(
				'enable_sticky',
				array(
					'type'    => 'radio',
					'section' => 'mytravel_header',
					'label'   => esc_html__( 'Enable Sticky Header ?', 'mytravel' ),
					'choices' => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
				)
			);

			$wp_customize->add_setting(
				'mytravel_enable_top_navbar',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_enable_top_navbar',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Top Navbar ?  ', 'mytravel' ),
					'choices'         => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'mytravel_header_version' ),
							[
								'v1',
								'v3',
								'v4',
								'v8',
							],
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_language_dropdown_enable',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_language_dropdown_enable',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Language Dropdown ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'mytravel_header_version' ),
							[
								'v1',
								'v3',
								'v4',
								'v8',
							],
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'topbar_skin',
				[
					'default'           => 'dark',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'topbar_skin',
				[
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Topbar Skin', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your topbar skin.', 'mytravel' ),
					'choices'         => [
						'primary' => esc_html_x( 'Primary', 'topbar', 'mytravel' ),
						'success' => esc_html_x( 'Success', 'topbar', 'mytravel' ),
						'danger'  => esc_html_x( 'Danger', 'topbar', 'mytravel' ),
						'warning' => esc_html_x( 'Warning', 'topbar', 'mytravel' ),
						'info'    => esc_html_x( 'Info', 'topbar', 'mytravel' ),
						'dark'    => esc_html_x( 'Dark', 'topbar', 'mytravel' ),
						'white'   => esc_html_x( 'White', 'topbar', 'mytravel' ),
						'violet'  => esc_html_x( 'Violet', 'topbar', 'mytravel' ),
						'gray'    => esc_html_x( 'Gray', 'topbar', 'mytravel' ),
					],
					'active_callback' => function () {
						return filter_var( get_theme_mod( 'mytravel_enable_top_navbar' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v3',
								'v4',
							),
							true
						);
					},
				]
			);

			$wp_customize->selective_refresh->add_partial(
				'topbar_skin',
				[
					'fallback_refresh' => true,
				]
			);

			$wp_customize->add_setting(
				'header_navbar_skin',
				array(
					'default'           => 'violet',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_skin',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Skin Color', 'mytravel' ),
					'choices'         => array(
						'primary' => esc_html_x( 'Primary', 'navbar', 'mytravel' ),
						'success' => esc_html_x( 'Success', 'navbar', 'mytravel' ),
						'danger'  => esc_html_x( 'Danger', 'navbar', 'mytravel' ),
						'warning' => esc_html_x( 'Warning', 'navbar', 'mytravel' ),
						'info'    => esc_html_x( 'Info', 'navbar', 'mytravel' ),
						'dark'    => esc_html_x( 'Dark', 'navbar', 'mytravel' ),
						'white'   => esc_html_x( 'White', 'navbar', 'mytravel' ),
						'violet'  => esc_html_x( 'Violet', 'navbar', 'mytravel' ),
						'gray'    => esc_html_x( 'Gray', 'navbar', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'v7' === get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_navbar_enable_search',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_navbar_enable_search',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Search ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v1',
								'v3',
								'v4',
								'v5',
								'v7',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_enable_mini_cart',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_enable_mini_cart',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Minicart ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return mytravel_is_woocommerce_activated();
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'mytravel_enable_mini_cart',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'mytravel_enable_signin',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_enable_signin',
				array(
					'type'    => 'radio',
					'section' => 'mytravel_header',
					'label'   => esc_html__( 'Enable Signin ?  ', 'mytravel' ),
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
				)
			);

			$wp_customize->add_setting(
				'mytravel_enable_header_navbar_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_enable_header_navbar_button',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Enable Navbar Button ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_header_button_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_header_button_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Button CSS Class', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add  button css', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				]
			);

			$wp_customize->add_setting(
				'header_navbar_button_color',
				array(
					'default'           => 'white',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_button_color',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
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
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v3' !== get_theme_mod( 'mytravel_header_version' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_button_text',
				array(
					'default'           => esc_html__( 'Become Local Expert', 'mytravel' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'header_navbar_button_text',
				array(
					'type'            => 'text',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Button Text', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'header_navbar_button_text',
				array(
					'selector'         => '.mytravel-header-navbar-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'header_navbar_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'header_navbar_button_url',
				array(
					'type'            => 'url',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Button Link', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_button_size',
				array(
					'default'           => 'wide',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_button_size',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Button Size', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button size.', 'mytravel' ),
					'choices'         => array(
						'wide-normal' => esc_html__( 'Normal Wide', 'mytravel' ),
						'md-wide'     => esc_html__( 'Medium Wide', 'mytravel' ),
						'wide'        => esc_html__( 'Wide', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v3' !== get_theme_mod( 'mytravel_header_version' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_button_shape',
				array(
					'default'           => 'rounded-xs',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Button Shape', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button shape.', 'mytravel' ),
					'choices'         => array(
						''           => esc_html__( 'Default', 'mytravel' ),
						'rounded-xs' => esc_html__( 'Rounded-xs', 'mytravel' ),
						'rounded-sm' => esc_html__( 'Rounded-sm', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v3' !== get_theme_mod( 'mytravel_header_version' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},

				)
			);

			$wp_customize->add_setting(
				'header_navbar_link_button_variant',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_link_button_variant',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Button Variant', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your navbar button variant.', 'mytravel' ),
					'choices'         => array(
						''            => esc_html__( 'Default', 'mytravel' ),
						'outline'     => esc_html__( 'Outline', 'mytravel' ),
						'translucent' => esc_html__( 'Translucent', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_enable_header_navbar_button', 'yes' ) && 'v3' !== get_theme_mod( 'mytravel_header_version' ) && 'v5' !== get_theme_mod( 'mytravel_header_version' ) && 'v7' !== get_theme_mod( 'mytravel_header_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_signin_button_color',
				array(
					'default'           => 'white',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_signin_button_color',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Signin Button Color', 'mytravel' ),
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
						return filter_var( get_theme_mod( 'mytravel_enable_signin' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v5',
								'v7',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'header_signin_button_shape',
				array(
					'default'           => 'rounded-sm',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_signin_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar signin Button Shape', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header signin button shape.', 'mytravel' ),
					'choices'         => array(
						''           => esc_html__( 'Default', 'mytravel' ),
						'rounded-xs' => esc_html__( 'Rounded-xs', 'mytravel' ),
						'rounded-sm' => esc_html__( 'Rounded-sm', 'mytravel' ),
					),
					'active_callback' => function () {
						return filter_var( get_theme_mod( 'mytravel_enable_signin' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v5',
								'v7',
							),
							true
						);
					},

				)
			);

			$wp_customize->add_setting(
				'header_navbar_signin_button_variant',
				array(
					'default'           => 'outline',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_signin_button_variant',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Signin Button Variant', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your navbar signin button variant.', 'mytravel' ),
					'choices'         => array(
						''            => esc_html__( 'Default', 'mytravel' ),
						'outline'     => esc_html__( 'Outline', 'mytravel' ),
						'translucent' => esc_html__( 'Translucent', 'mytravel' ),
					),
					'active_callback' => function () {
						return filter_var( get_theme_mod( 'mytravel_enable_signin' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v5',
								'v7',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_signin_button_size',
				array(
					'default'           => 'wide',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_navbar_signin_button_size',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Signin Button Size', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header signin button size.', 'mytravel' ),
					'choices'         => array(
						'wide-normal' => esc_html__( 'Normal Wide', 'mytravel' ),
						'md-wide'     => esc_html__( 'Medium Wide', 'mytravel' ),
						'wide'        => esc_html__( 'Wide', 'mytravel' ),
					),
					'active_callback' => function () {
						return filter_var( get_theme_mod( 'mytravel_enable_signin' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v5',
								'v7',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_signin_button_url',
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'header_navbar_signin_button_url',
				array(
					'type'            => 'url',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Navbar Signin Button Link', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'mytravel' ),
					'active_callback' => function () {
						return filter_var( get_theme_mod( 'mytravel_enable_signin' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v5',
								'v7',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'header_navbar_signin_button_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'header_navbar_signin_button_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_header',
					'label'           => esc_html__( 'Signin Button CSS Class', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add  button css', 'mytravel' ),
					'active_callback' => function () {
						return filter_var( get_theme_mod( 'mytravel_enable_signin' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_header_version' ),
							array(
								'v5',
								'v7',
							),
							true
						);
					},
				]
			);
		}

		/**
		 * Customize 404 Page
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_404( $wp_customize ) {

			$wp_customize->add_section(
				'mytravel_404',
				array(
					'title'    => esc_html__( '404', 'mytravel' ),
					'priority' => 30,
				)
			);

			$this->add_404_section( $wp_customize );
		}

		/**
		 * Customize 404
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_404_section( $wp_customize ) {

			/**
			 * 404 page
			 */

			$wp_customize->add_section(
				'mytravel_404_header',
				array(
					'title'    => esc_html__( '404 Page Header', 'mytravel' ),
					'priority' => 50,
					'panel'    => '404',
				)
			);

			$wp_customize->add_setting(
				'404_enable_separate_header',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'404_enable_separate_header',
				array(
					'type'        => 'radio',
					'section'     => 'mytravel_404',
					'label'       => esc_html__( 'Enable Header for 404 Page', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to show or hide dashboard Header.', 'mytravel' ),
					'choices'     => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_version',
				array(
					'default'           => 'v8',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_version',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_404',
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
						return 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Container CSS Classes', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add primary navbar container css', 'mytravel' ),
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'mytravel_404_header_version' ),
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
				'mytravel_404_enable_sticky',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_enable_sticky',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Enable Sticky Header ?', 'mytravel' ),
					'choices'         => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
					'active_callback' => function () {
						return 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_enable_top_navbar',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_enable_top_navbar',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Enable Top Navbar ?  ', 'mytravel' ),
					'choices'         => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
					'active_callback' => function () {
						return 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_language_dropdown_enable',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_language_dropdown_enable',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Enable Language Dropdown ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return filter_var( get_theme_mod( '404_enable_separate_header' ), FILTER_VALIDATE_BOOLEAN ) && in_array(
							get_theme_mod( 'mytravel_404_header_version' ),
							[
								'v1',
								'v3',
								'v4',
								'v4',
								'v8',
							],
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_enable_mini_cart',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_enable_mini_cart',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Enable Minicart ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' ) && mytravel_is_woocommerce_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_enable_signin',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_enable_signin',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Enable Signin ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_enable_navbar_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_enable_navbar_button',
				array(
					'type'            => 'radio',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Enable Navbar Button ?  ', 'mytravel' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_button_css',
				[
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_404_header_button_css',
				[
					'type'            => 'text',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Button CSS Class', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to add  button css', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				]
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_button_color',
				array(
					'default'           => 'white',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_button_color',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_404',
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
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_button_text',
				array(
					'default'           => esc_html__( 'Become Local Expert', 'mytravel' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_button_text',
				array(
					'type'            => 'text',
					'section'         => 'mytravel_404_header',
					'label'           => esc_html__( 'Navbar Button Text', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'mytravel_404_header_navbar_button_text',
				array(
					'selector'         => '.mytravel-404-header-navbar-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_button_url',
				array(
					'type'            => 'url',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Navbar Button Link', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'mytravel' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_button_size',
				array(
					'default'           => 'wide',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_button_size',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Navbar Button Size', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button size.', 'mytravel' ),
					'choices'         => array(
						'wide-normal' => esc_html__( 'Normal Wide', 'mytravel' ),
						'md-wide'     => esc_html__( 'Medium Wide', 'mytravel' ),
						'wide'        => esc_html__( 'Wide', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_button_shape',
				array(
					'default'           => 'rounded-xs',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Navbar Button Shape', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button shape.', 'mytravel' ),
					'choices'         => array(
						''           => esc_html__( 'Default', 'mytravel' ),
						'rounded-xs' => esc_html__( 'Rounded-xs', 'mytravel' ),
						'rounded-sm' => esc_html__( 'Rounded-sm', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},

				)
			);

			$wp_customize->add_setting(
				'mytravel_404_header_navbar_button_variant',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_404_header_navbar_button_variant',
				array(
					'type'            => 'select',
					'section'         => 'mytravel_404',
					'label'           => esc_html__( 'Navbar Button Variant', 'mytravel' ),
					'description'     => esc_html__( 'This setting allows you to choose your navbar button variant.', 'mytravel' ),
					'choices'         => array(
						''            => esc_html__( 'Default', 'mytravel' ),
						'outline'     => esc_html__( 'Outline', 'mytravel' ),
						'translucent' => esc_html__( 'Translucent', 'mytravel' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'mytravel_404_enable_navbar_button', 'yes' ) && 'yes' === get_theme_mod( '404_enable_separate_header', 'yes' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'404_image_option',
				[
					'selector'        => '.404_image',
					'render_callback' => function () {
						return esc_html( get_theme_mod( '404_image_option' ) );
					},
				]
			);

			$wp_customize->add_setting(
				'404_image_option',
				[
					'transport'         => 'postMessage',
					'sanitize_callback' => 'absint',
				]
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'404_image_option',
					[
						'section'     => 'mytravel_404',
						'label'       => esc_html__( '404 Image Upload', 'mytravel' ),
						'description' => esc_html__(
							'This setting allows you to upload an image for 404 page.',
							'mytravel'
						),
						'mime_type'   => 'image',
					]
				)
			);

			$wp_customize->add_setting(
				'404_heading',
				array(
					'default'           => esc_html_x( '404', 'front-end', 'mytravel' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'404_heading',
				array(
					'type'    => 'text',
					'section' => 'mytravel_404',
					'label'   => esc_html__( '404 Heading', 'mytravel' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'404_heading',
				array(
					'render_callback' => function () {
						return esc_html( get_theme_mod( '404_heading' ) );
					},
				)
			);

			$wp_customize->add_setting(
				'404_title',
				array(
					'default'           => esc_html_x( 'Error 404', 'front-end', 'mytravel' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'404_title',
				array(
					'type'    => 'text',
					'section' => 'mytravel_404',
					'label'   => esc_html__( '404 Title', 'mytravel' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'404_title',
				array(
					'render_callback' => function () {
						return esc_html( get_theme_mod( '404_title' ) );
					},
				)
			);

			$wp_customize->add_setting(
				'404_desc',
				array(
					'default'           => esc_html_x( 'The page you are looking for was moved, removed or might never existed.', 'front-end', 'mytravel' ),
					'sanitize_callback' => 'sanitize_textarea_field',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'404_desc',
				array(
					'type'    => 'textarea',
					'section' => 'mytravel_404',
					'label'   => esc_html__( 'Description', 'mytravel' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'404_desc',
				array(
					'render_callback' => function () {
						return esc_html( get_theme_mod( '404_desc' ) );
					},
				)
			);

			$wp_customize->add_setting(
				'404_btn_text',
				array(
					'default'           => esc_html__( 'Go to home page', 'mytravel' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'404_btn_text',
				array(
					'type'        => 'text',
					'section'     => 'mytravel_404',
					'label'       => esc_html__( 'Action button text', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to change the button text', 'mytravel' ),

				)
			);

			$wp_customize->selective_refresh->add_partial(
				'404_btn_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'404_button_color',
				array(
					'default'           => 'primary',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'404_button_color',
				array(
					'type'    => 'select',
					'section' => 'mytravel_404',
					'label'   => esc_html__( 'Action button color', 'mytravel' ),
					'choices' => array(
						'primary'  => esc_html_x( 'Primary', 'button', 'mytravel' ),
						'success'  => esc_html_x( 'Success', 'button', 'mytravel' ),
						'danger'   => esc_html_x( 'Danger', 'button', 'mytravel' ),
						'warning'  => esc_html_x( 'Warning', 'button', 'mytravel' ),
						'info'     => esc_html_x( 'Info', 'button', 'mytravel' ),
						'dark'     => esc_html_x( 'Dark', 'button', 'mytravel' ),
						'gradient' => esc_html_x( 'Gradient', 'button', 'mytravel' ),
						'link'     => esc_html_x( 'Link', 'button', 'mytravel' ),
					),
				)
			);

			$wp_customize->add_setting(
				'404_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'404_button_url',
				array(
					'type'        => 'url',
					'section'     => 'mytravel_404',
					'label'       => esc_html__( 'Button Url', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to change button url.', 'mytravel' ),
				)
			);
		}

		/**
		 * Customize site footer
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_footer( $wp_customize ) {

			$wp_customize->add_panel(
				'footer_panel',
				array(
					'priority' => 70,
					'title'    => esc_html__( 'Footer', 'mytravel' ),
				)
			);
			$this->add_mytravel_footer_settings( $wp_customize );
		}

		/**
		 * Customize Footer Variant
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_mytravel_footer_settings( $wp_customize ) {

			$this->static_contents = mytravel_static_content_options();

			$wp_customize->add_section(
				'mytravel_footer',
				array(
					'title'       => esc_html__( 'General', 'mytravel' ),
					'description' => esc_html__( 'Customize the theme footer.', 'mytravel' ),
					'priority'    => 80,
					'panel'       => 'footer_panel',
				)
			);

			$wp_customize->add_setting(
				'mytravel_footer_version',
				array(
					'default'           => 'v1',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'mytravel_footer_version',
				array(
					'type'        => 'select',
					'section'     => 'mytravel_footer',
					'label'       => esc_html__( 'Footer Variant', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to choose your footer type.', 'mytravel' ),
					'choices'     => array(
						'v1' => esc_html__( 'Footer v1', 'mytravel' ),
						'v2' => esc_html__( 'Footer v2', 'mytravel' ),
						'static' => esc_html__( 'Static Footer', 'mytravel' ),
					),
				)
			);

			if ( function_exists( 'mytravel_is_mas_static_content_activated' ) && mytravel_is_mas_static_content_activated() ) {

				$wp_customize->add_setting(
					'footer_static_content',
					[
						'default'           => 'v1',
						'sanitize_callback' => 'sanitize_key',
					]
				);
				$wp_customize->add_control(
					'footer_static_content',
					[
						'type'            => 'select',
						'section'         => 'mytravel_footer',
						'label'           => esc_html__( 'Footer Static Content', 'mytravel' ),
						'description'     => esc_html__( 'This setting allows you to choose your footer type.', 'mytravel' ),
						'choices'         => $this->static_contents,
						'active_callback' => function () {
							return 'static' === get_theme_mod( 'mytravel_footer_version', 'v1' );
						},
					]
				);

				$wp_customize->selective_refresh->add_partial(
					'footer_static_content',
					[
						'fallback_refresh' => true,
					]
				);
			}

				$wp_customize->add_setting(
					'footer_logo',
					[
						'transport'         => 'postMessage',
						'theme_supports'    => 'custom-logo',
						'sanitize_callback' => 'absint',
					]
				);

			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control(
					$wp_customize,
					'footer_logo',
					[
						'section'       => 'title_tagline',
						'label'         => esc_html__( 'Upload Footer Logo', 'mytravel' ),
						'description'   => esc_html__( 'Upload logo for footer', 'mytravel' ),
						'priority'      => 9,
						'width'         => 60,
						'height'        => 60,
						'flex_width'    => true,
						'flex_height'   => true,
						'button_labels' => [
							'select'       => esc_html__( 'Select logo', 'mytravel' ),
							'change'       => esc_html__( 'Change logo', 'mytravel' ),
							'remove'       => esc_html__( 'Remove', 'mytravel' ),
							'default'      => esc_html__( 'Default', 'mytravel' ),
							'placeholder'  => esc_html__( 'No logo selected', 'mytravel' ),
							'frame_title'  => esc_html__( 'Select logo', 'mytravel' ),
							'frame_button' => esc_html__( 'Choose logo', 'mytravel' ),
						],
					]
				)
			);
			$wp_customize->selective_refresh->add_partial(
				'footer_logo',
				[
					'selector'            => '.footer-logo-link',
					'container_inclusive' => true,
					'render_callback'     => 'mytravel_footer_logo',
				]
			);

			$wp_customize->add_setting(
				'credit_card_image',
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'credit_card_image',
					array(
						'label'           => esc_html__( 'Upload a Credit Card Image', 'mytravel' ),
						'description'     => esc_html__( 'This setting allows you to change the credit card image', 'mytravel' ),
						'section'         => 'mytravel_footer',
						'priority'        => 20,
						'active_callback' => function () {
							return in_array(
								get_theme_mod( 'mytravel_footer_version' ),
								[
									'v2',

								],
								true
							);
						},
					)
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'credit_card_image',
				array(
					'selector'         => '.footer-credit-card',
					'fallback_refresh' => true,
				)
			);

			$default_copyright_text = '© 2022 MyTravel. All rights reserved';

			$wp_customize->add_setting(
				'footer_copyright',
				array(
					'default'           => $default_copyright_text,
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'footer_copyright',
				array(
					'type'        => 'text',
					'section'     => 'mytravel_footer',
					'label'       => esc_html__( 'Footer Copyright', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to change the copyright text', 'mytravel' ),
					'active_callback' => function () {
						return 'static' !== get_theme_mod( 'mytravel_footer_version', 'v1' );
					},

				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_copyright',
				array(
					'selector'         => '.footer-copyright',
					'fallback_refresh' => true,
				)
			);
		}

		/**
		 * Customize site blog
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_blog( $wp_customize ) {
			$wp_customize->add_section(
				'mytravel_blog',
				[
					/* translators: title of section in Customizer */
					'title'       => esc_html__( 'Blog', 'mytravel' ),
					'description' => esc_html__( 'This section contains settings related to posts listing archives and single post.', 'mytravel' ),
					'priority'    => 90,
				]
			);

			$this->add_blog_section( $wp_customize );
		}

		/**
		 * Customizer Controls For Blog.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_blog_section( $wp_customize ) {

			$wp_customize->add_setting(
				'blog_sidebar',
				[
					'default'           => 'right-sidebar',
					'sanitize_callback' => 'sanitize_key',
				]
			);
			$wp_customize->add_control(
				'blog_sidebar',
				[
					'type'        => 'select',
					'section'     => 'mytravel_blog',
					/* translators: label field of control in Customizer */
					'label'       => esc_html__( 'Blog Layout', 'mytravel' ),
					'description' => esc_html__( 'Choose the layout of your blog.', 'mytravel' ),
					'choices'     => [
						'no-sidebar'    => esc_html__( 'Full width', 'mytravel' ),
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'mytravel' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'mytravel' ),
					],
				]
			);

			$wp_customize->selective_refresh->add_partial(
				'blog_sidebar',
				[
					'fallback_refresh' => true,
				]
			);

			$wp_customize->add_setting(
				'enable_post_navigation',
				[
					'default'           => true,
					'sanitize_callback' => 'mytravel_sanitize_checkbox',
				]
			);

			$wp_customize->add_control(
				'enable_post_navigation',
				[
					'type'        => 'checkbox',
					'section'     => 'mytravel_blog',
					'label'       => esc_html__( 'Enable Post Navigation', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to enable post navigation', 'mytravel' ),
				]
			);

			$wp_customize->selective_refresh->add_partial(
				'enable_post_navigation',
				[
					'fallback_refresh' => true,
				]
			);

			$wp_customize->add_setting(
				'blog_single_title',
				[
					'default'           => esc_html__( 'Blog Single', 'mytravel' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage',
				]
			);
			$wp_customize->add_control(
				'blog_single_title',
				[
					'section'     => 'mytravel_blog',
					'type'        => 'text',
					/* translators: label field of setting responsible for keeping the page title of blog in posts listing (no Static Front Page). */
					'label'       => esc_html__( 'Blog Single Title', 'mytravel' ),
					'description' => esc_html__( 'This setting allows you to set blog single title', 'mytravel' ),
				]
			);
			$wp_customize->selective_refresh->add_partial(
				'blog_single_title',
				[
					'fallback_refresh' => true,
				]
			);

		}

		/**
		 * Get all of the MyTravel theme mods.
		 *
		 * @return array $mytravel_theme_mods The MyTravel Theme Mods.
		 */
		public function get_mytravel_theme_mods() {
			$mytravel_theme_mods = array(
				'background_color'            => mytravel_get_content_background_color(),
				'accent_color'                => get_theme_mod( 'mytravel_accent_color' ),
				'hero_heading_color'          => get_theme_mod( 'mytravel_hero_heading_color' ),
				'hero_text_color'             => get_theme_mod( 'mytravel_hero_text_color' ),
				'header_background_color'     => get_theme_mod( 'mytravel_header_background_color' ),
				'header_link_color'           => get_theme_mod( 'mytravel_header_link_color' ),
				'header_text_color'           => get_theme_mod( 'mytravel_header_text_color' ),
				'footer_background_color'     => get_theme_mod( 'mytravel_footer_background_color' ),
				'footer_link_color'           => get_theme_mod( 'mytravel_footer_link_color' ),
				'footer_heading_color'        => get_theme_mod( 'mytravel_footer_heading_color' ),
				'footer_text_color'           => get_theme_mod( 'mytravel_footer_text_color' ),
				'text_color'                  => get_theme_mod( 'mytravel_text_color' ),
				'heading_color'               => get_theme_mod( 'mytravel_heading_color' ),
				'button_background_color'     => get_theme_mod( 'mytravel_button_background_color' ),
				'button_text_color'           => get_theme_mod( 'mytravel_button_text_color' ),
				'button_alt_background_color' => get_theme_mod( 'mytravel_button_alt_background_color' ),
				'button_alt_text_color'       => get_theme_mod( 'mytravel_button_alt_text_color' ),
			);

			return apply_filters( 'mytravel_theme_mods', $mytravel_theme_mods );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_mytravel_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
			$mytravel_theme_mods = $this->get_mytravel_theme_mods();
			$brighten_factor     = apply_filters( 'mytravel_brighten_factor', 25 );
			$darken_factor       = apply_filters( 'mytravel_darken_factor', -25 );

			$styles = '
			.main-navigation ul li a,
			.site-title a,
			ul.menu li a,
			.site-branding h1 a,
			.site-footer .mytravel-handheld-footer-bar a:not(.button),
			button.menu-toggle,
			button.menu-toggle:hover,
			.handheld-navigation .dropdown-toggle {
				color: ' . $mytravel_theme_mods['header_link_color'] . ';
			}

			button.menu-toggle,
			button.menu-toggle:hover {
				border-color: ' . $mytravel_theme_mods['header_link_color'] . ';
			}

			.main-navigation ul li a:hover,
			.main-navigation ul li:hover > a,
			.site-title a:hover,
			.site-header ul.menu li.current-menu-item > a {
				color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['header_link_color'], 65 ) . ';
			}

			table:not( .has-background ) th {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -7 ) . ';
			}

			table:not( .has-background ) tbody td {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -2 ) . ';
			}

			table:not( .has-background ) tbody tr:nth-child(2n) td,
			fieldset,
			fieldset legend {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -4 ) . ';
			}

			.site-header,
			.secondary-navigation ul ul,
			.main-navigation ul.menu > li.menu-item-has-children:after,
			.secondary-navigation ul.menu ul,
			.mytravel-handheld-footer-bar,
			.mytravel-handheld-footer-bar ul li > a,
			.mytravel-handheld-footer-bar ul li.search .site-search,
			button.menu-toggle,
			button.menu-toggle:hover {
				background-color: ' . $mytravel_theme_mods['header_background_color'] . ';
			}

			p.site-description,
			.site-header,
			.mytravel-handheld-footer-bar {
				color: ' . $mytravel_theme_mods['header_text_color'] . ';
			}

			button.menu-toggle:after,
			button.menu-toggle:before,
			button.menu-toggle span:before {
				background-color: ' . $mytravel_theme_mods['header_link_color'] . ';
			}

			h1, h2, h3, h4, h5, h6, .wc-block-grid__product-title {
				color: ' . $mytravel_theme_mods['heading_color'] . ';
			}

			.widget h1 {
				border-bottom-color: ' . $mytravel_theme_mods['heading_color'] . ';
			}

			body,
			.secondary-navigation a {
				color: ' . $mytravel_theme_mods['text_color'] . ';
			}

			.widget-area .widget a,
			.hentry .entry-header .posted-on a,
			.hentry .entry-header .post-author a,
			.hentry .entry-header .post-comments a,
			.hentry .entry-header .byline a {
				color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['text_color'], 5 ) . ';
			}

			a {
				color: ' . $mytravel_theme_mods['accent_color'] . ';
			}

			a:focus,
			button:focus,
			.button.alt:focus,
			input:focus,
			textarea:focus,
			input[type="button"]:focus,
			input[type="reset"]:focus,
			input[type="submit"]:focus,
			input[type="email"]:focus,
			input[type="tel"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus {
				outline-color: ' . $mytravel_theme_mods['accent_color'] . ';
			}

			button, input[type="button"], input[type="reset"], input[type="submit"], .button, .widget a.button {
				background-color: ' . $mytravel_theme_mods['button_background_color'] . ';
				border-color: ' . $mytravel_theme_mods['button_background_color'] . ';
				color: ' . $mytravel_theme_mods['button_text_color'] . ';
			}

			button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .widget a.button:hover {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $mytravel_theme_mods['button_text_color'] . ';
			}

			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .widget-area .widget a.button.alt {
				background-color: ' . $mytravel_theme_mods['button_alt_background_color'] . ';
				border-color: ' . $mytravel_theme_mods['button_alt_background_color'] . ';
				color: ' . $mytravel_theme_mods['button_alt_text_color'] . ';
			}

			button.alt:hover, input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover, .button.alt:hover, .widget-area .widget a.button.alt:hover {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				border-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				color: ' . $mytravel_theme_mods['button_alt_text_color'] . ';
			}

			.pagination .page-numbers li .page-numbers.current {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], $darken_factor ) . ';
				color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['text_color'], -10 ) . ';
			}

			#comments .comment-list .comment-content .comment-text {
				background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -7 ) . ';
			}

			.site-footer {
				background-color: ' . $mytravel_theme_mods['footer_background_color'] . ';
				color: ' . $mytravel_theme_mods['footer_text_color'] . ';
			}

			.site-footer a:not(.button):not(.components-button) {
				color: ' . $mytravel_theme_mods['footer_link_color'] . ';
			}

			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6, .site-footer .widget .widget-title, .site-footer .widget .widgettitle {
				color: ' . $mytravel_theme_mods['footer_heading_color'] . ';
			}

			.page-template-template-homepage.has-post-thumbnail .type-page.has-post-thumbnail .entry-title {
				color: ' . $mytravel_theme_mods['hero_heading_color'] . ';
			}

			.page-template-template-homepage.has-post-thumbnail .type-page.has-post-thumbnail .entry-content {
				color: ' . $mytravel_theme_mods['hero_text_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.secondary-navigation ul.menu a:hover {
					color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['header_text_color'], $brighten_factor ) . ';
				}

				.secondary-navigation ul.menu a {
					color: ' . $mytravel_theme_mods['header_text_color'] . ';
				}

				.main-navigation ul.menu ul.sub-menu,
				.main-navigation ul.nav-menu ul.children {
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['header_background_color'], -15 ) . ';
				}

				.site-header {
					border-bottom-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['header_background_color'], -15 ) . ';
				}
			}';

			return apply_filters( 'mytravel_customizer_css', $styles );
		}

		/**
		 * Get Gutenberg Customizer css.
		 *
		 * @see get_mytravel_theme_mods()
		 * @return array $styles the css
		 */
		public function gutenberg_get_css() {
			$mytravel_theme_mods = $this->get_mytravel_theme_mods();
			$darken_factor       = apply_filters( 'mytravel_darken_factor', -25 );

			// Gutenberg.
			$styles = '
				.wp-block-button__link:not(.has-text-color) {
					color: ' . $mytravel_theme_mods['button_text_color'] . ';
				}

				.wp-block-button__link:not(.has-text-color):hover,
				.wp-block-button__link:not(.has-text-color):focus,
				.wp-block-button__link:not(.has-text-color):active {
					color: ' . $mytravel_theme_mods['button_text_color'] . ';
				}

				.wp-block-button__link:not(.has-background) {
					background-color: ' . $mytravel_theme_mods['button_background_color'] . ';
				}

				.wp-block-button__link:not(.has-background):hover,
				.wp-block-button__link:not(.has-background):focus,
				.wp-block-button__link:not(.has-background):active {
					border-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_background_color'], $darken_factor ) . ';
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_background_color'], $darken_factor ) . ';
				}

				.wp-block-quote footer,
				.wp-block-quote cite,
				.wp-block-quote__citation {
					color: ' . $mytravel_theme_mods['text_color'] . ';
				}

				.wp-block-pullquote cite,
				.wp-block-pullquote footer,
				.wp-block-pullquote__citation {
					color: ' . $mytravel_theme_mods['text_color'] . ';
				}

				.wp-block-image figcaption {
					color: ' . $mytravel_theme_mods['text_color'] . ';
				}

				.wp-block-separator.is-style-dots::before {
					color: ' . $mytravel_theme_mods['heading_color'] . ';
				}

				.wp-block-file a.wp-block-file__button {
					color: ' . $mytravel_theme_mods['button_text_color'] . ';
					background-color: ' . $mytravel_theme_mods['button_background_color'] . ';
					border-color: ' . $mytravel_theme_mods['button_background_color'] . ';
				}

				.wp-block-file a.wp-block-file__button:hover,
				.wp-block-file a.wp-block-file__button:focus,
				.wp-block-file a.wp-block-file__button:active {
					color: ' . $mytravel_theme_mods['button_text_color'] . ';
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['button_background_color'], $darken_factor ) . ';
				}

				.wp-block-code,
				.wp-block-preformatted pre {
					color: ' . $mytravel_theme_mods['text_color'] . ';
				}

				.wp-block-table:not( .has-background ):not( .is-style-stripes ) tbody tr:nth-child(2n) td {
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -2 ) . ';
				}

				.wp-block-cover .wp-block-cover__inner-container h1,
				.wp-block-cover .wp-block-cover__inner-container h2,
				.wp-block-cover .wp-block-cover__inner-container h3,
				.wp-block-cover .wp-block-cover__inner-container h4,
				.wp-block-cover .wp-block-cover__inner-container h5,
				.wp-block-cover .wp-block-cover__inner-container h6 {
					color: ' . $mytravel_theme_mods['hero_heading_color'] . ';
				}
			';

			return apply_filters( 'mytravel_gutenberg_customizer_css', $styles );
		}

		/**
		 * Enqueue dynamic colors to use editor blocks.
		 *
		 * @since 2.4.0
		 */
		public function block_editor_customizer_css() {
			$mytravel_theme_mods = $this->get_mytravel_theme_mods();

			$styles = '';

			if ( is_admin() ) {
				$styles .= '
				.editor-styles-wrapper table:not( .has-background ) th {
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -7 ) . ';
				}

				.editor-styles-wrapper table:not( .has-background ) tbody td {
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -2 ) . ';
				}

				.editor-styles-wrapper table:not( .has-background ) tbody tr:nth-child(2n) td,
				.editor-styles-wrapper fieldset,
				.editor-styles-wrapper fieldset legend {
					background-color: ' . mytravel_adjust_color_brightness( $mytravel_theme_mods['background_color'], -4 ) . ';
				}

				.editor-post-title__block .editor-post-title__input,
				.editor-styles-wrapper h1,
				.editor-styles-wrapper h2,
				.editor-styles-wrapper h3,
				.editor-styles-wrapper h4,
				.editor-styles-wrapper h5,
				.editor-styles-wrapper h6 {
					color: ' . $mytravel_theme_mods['heading_color'] . ';
				}

				.editor-styles-wrapper .editor-block-list__block {
					color: ' . $mytravel_theme_mods['text_color'] . ';
				}

				.editor-styles-wrapper a,
				.wp-block-freeform.block-library-rich-text__tinymce a {
					color: ' . $mytravel_theme_mods['accent_color'] . ';
				}

				.editor-styles-wrapper a:focus,
				.wp-block-freeform.block-library-rich-text__tinymce a:focus {
					outline-color: ' . $mytravel_theme_mods['accent_color'] . ';
				}

				body.post-type-post .editor-post-title__block::after {
					content: "";
				}';
			}

			$styles .= $this->gutenberg_get_css();

			wp_add_inline_style( 'mytravel-gutenberg-blocks', apply_filters( 'mytravel_gutenberg_block_editor_customizer_css', $styles ) );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			wp_add_inline_style( 'mytravel-style', $this->get_css() );
		}

		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'mytravel_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.5.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
			.customize-control-radio-image input[type=radio] {
				display: none;
			}

			.customize-control-radio-image label {
				display: block;
				width: 48%;
				float: left;
				margin-right: 4%;
			}

			.customize-control-radio-image label:nth-of-type(2n) {
				margin-right: 0;
			}

			.customize-control-radio-image img {
				opacity: .5;
			}

			.customize-control-radio-image input[type=radio]:checked + label img,
			.customize-control-radio-image img:hover {
				opacity: 1;
			}

			</style>
			<?php
		}

		/**
		 * Get site logo.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_logo() {
			return mytravel_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since 2.1.5
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}

		/**
		 * Check if current page is using the Homepage template.
		 *
		 * @since 2.3.0
		 * @return bool
		 */
		public function is_homepage_template() {
			$template = get_post_meta( get_the_ID(), '_wp_page_template', true );

			if ( ! $template || 'template-homepage.php' !== $template || ! has_post_thumbnail( get_the_ID() ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Setup the WordPress core custom header feature.
		 *
		 * @deprecated 2.4.0
		 * @return void
		 */
		public function custom_header_setup() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.4.0' );
			} else {
				_deprecated_function( __FUNCTION__, '2.4.0' );
			}
		}

		/**
		 * Get Customizer css associated with WooCommerce.
		 *
		 * @deprecated 2.4.0
		 * @return void
		 */
		public function get_woocommerce_css() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}

		/**
		 * Assign MyTravel styles to individual theme mods.
		 *
		 * @deprecated 2.3.1
		 * @return void
		 */
		public function set_mytravel_style_theme_mods() {
			if ( function_exists( 'wc_deprecated_function' ) ) {
				wc_deprecated_function( __FUNCTION__, '2.3.1' );
			} else {
				_deprecated_function( __FUNCTION__, '2.3.1' );
			}
		}

		/**
		 * Customize site Custom Theme Color
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_customcolor( $wp_customize ) {
			/*
			 * Custom Color Enable / Disble Toggle
			 */
			$wp_customize->add_setting(
				'mytravel_enable_custom_color',
				[
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'mytravel_enable_custom_color',
				[
					'type'        => 'radio',
					'section'     => 'colors',
					'label'       => esc_html__( 'Enable Custom Color?', 'mytravel' ),
					'description' => esc_html__(
						'This settings allow you to apply your custom color option.',
						'mytravel'
					),
					'choices'     => [
						'yes' => esc_html__( 'Yes', 'mytravel' ),
						'no'  => esc_html__( 'No', 'mytravel' ),
					],
				]
			);

			/**
			 * Primary Color
			 */
			$wp_customize->add_setting(
				'mytravel_primary_color',
				array(
					'default'           => apply_filters( 'mytravel_default_primary_color', '#297cbb' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'mytravel_primary_color',
					array(
						'label'           => esc_html__( 'Primary color', 'mytravel' ),
						'section'         => 'colors',
						'settings'        => 'mytravel_primary_color',
						'active_callback' => function () {
							return get_theme_mod( 'mytravel_enable_custom_color', 'no' ) === 'yes';
						},
					)
				)
			);
		}
	}

endif;

return new MyTravel_Customizer();
