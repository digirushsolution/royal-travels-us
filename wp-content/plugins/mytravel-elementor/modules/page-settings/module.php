<?php
namespace MyTravelElementor\Modules\PageSettings;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Elementor\Core\Base\Module as BaseModule;
use Elementor\Core\DocumentTypes\PageBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor page templates module.
 *
 * Elementor page templates module handler class is responsible for registering
 * and managing Elementor page templates modules.
 *
 * @since 1.0.0
 */
class Module extends BaseModule {

	/**
	 * Post Id,.
	 *
	 * @var Plugin
	 */
	protected $post_id = 0;
	/**
	 * Page Options.
	 *
	 * @var Plugin
	 */
	protected $myt_page_options = [];
	/**
	 * Static Content
	 *
	 * @var Plugin
	 */
	protected $static_contents = [];

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->myt_page_options = $this->myt_page_options();
		$this->static_contents  = function_exists( 'mytravel_static_content_options' ) ? mytravel_static_content_options() : [];
		add_action( 'elementor/documents/register_controls', [ $this, 'action_register_template_control' ] );
		add_action( 'elementor/element/wp-post/section_page_style/before_section_end', [ $this, 'add_body_style_controls' ] );
		add_filter( 'update_post_metadata', [ $this, 'filter_update_meta' ], 10, 5 );
	}

	/**
	 * Get Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'override-page-settings';
	}

	/**
	 * Add Body Styles Controls.
	 *
	 * @param array $document The Document.
	 * @return void
	 */
	public function add_body_style_controls( $document ) {

		$document->add_control(
			'enable_overflow',
			[
				'label'     => esc_html__( 'Enable Overflow?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'body' => 'overflow-x:visible !important;',
				],
			]
		);
	}

	/**
	 * Get Name.
	 *
	 * @return array
	 */
	public function get_special_settings_names() {
		return [
			// General..
			'general_body_classes',

			// Header.
			'header_mytravel_enable_custom_header',
			'header_header_variant',
			'header_mytravel_primary_navbar_css',
			'header_mytravel_use_custom_logo',
			'header_mytravel_custom_logo',
			'header_mytravel_custom_logo_title',
			'header_mytravel_enable_transparent_header',
			'header_mytravel_transparent_logo_enable',
			'header_mytravel_transparent_logo',
			'header_mytravel_enable_sticky_header',
			'header_mytravel_sticky_logo',
			'header_mytravel_enable_top_navbar',
			'header_mytravel_top_navbar_skin',
			'header_mytravel_enable_language_dropdown',
			'header_mytravel_navbar_skin',
			'header_mytravel_enable_search',
			'header_mytravel_mini_cart_enable',
			'header_mytravel_signin_enable',
			'header_mytravel_navbar_button_enable',
			'header_mytravel_navbar_button_skin',
			'header_mytravel_navbar_button_text',
			'header_mytravel_navbar_button_link',
			'header_mytravel_navbar_button_size',
			'header_mytravel_navbar_button_shape',
			'header_mytravel_navbar_button_variant',
			'header_mytravel_navbar_button_css',
			'header_mytravel_navbar_signin_button_skin',
			'header_mytravel_navbar_signin_button_text',
			'header_mytravel_navbar_signin_button_link',
			'header_mytravel_navbar_signin_button_size',
			'header_mytravel_navbar_signin_button_shape',
			'header_mytravel_navbar_signin_button_variant',
			'header_mytravel_navbar_signin_button_css',
			'header_mytravel_navbar_signin_button_icon',

			// Footer.
			'footer_mytravel_enable_custom_footer',
			'footer_mytravel_footer_variant',
			'footer_mytravel_footer_static_widgets',
			'footer_mytravel_footer_credit_card_image',
			'footer_mytravel_footer_copyright',

		];
	}

	/**
	 * Update Mytravel Page Options.
	 *
	 * @param array $object_id Id.
	 * @param array $special_settings settings.
	 * @return void
	 */
	public function update_myt_page_option( $object_id, $special_settings ) {
		$_myt_page_options = $this->myt_page_options( $object_id );
		$myt_page_options  = ! empty( $_myt_page_options ) ? $_myt_page_options : [];

		$general_option_key     = 'general';
		$header_option_key      = 'header';
		$footer_option_key      = 'footer';
		$len_general_option_key = strlen( $general_option_key . '_' );
		$len_header_option_key  = strlen( $header_option_key . '_' );
		$len_footer_option_key  = strlen( $footer_option_key . '_' );

		foreach ( $special_settings as $key => $value ) {
			if ( substr( $key, 0, $len_general_option_key ) === $general_option_key . '_' ) {
				if ( ! isset( $myt_page_options[ $general_option_key ] ) ) {
					$myt_page_options[ $general_option_key ] = [];
				}
				$myt_page_options[ $general_option_key ][ substr( $key, $len_general_option_key ) ] = $value;
			} elseif ( substr( $key, 0, $len_header_option_key ) === $header_option_key . '_' ) {
				if ( ! isset( $myt_page_options[ $header_option_key ] ) ) {
					$myt_page_options[ $header_option_key ] = [];
				}
				$myt_page_options[ $header_option_key ][ substr( $key, $len_header_option_key ) ] = $value;
			} elseif ( substr( $key, 0, $len_footer_option_key ) === $footer_option_key . '_' ) {
				if ( ! isset( $myt_page_options[ $footer_option_key ] ) ) {
					$myt_page_options[ $footer_option_key ] = [];
				}
				$myt_page_options[ $footer_option_key ][ substr( $key, $len_footer_option_key ) ] = $value;
			} else {
				$myt_page_options[ $key ] = $value;
			}
		}

		if ( ! empty( $myt_page_options ) ) {
			$this->myt_page_options = $myt_page_options;
			update_metadata( 'post', $object_id, '_myt_page_options', $myt_page_options );
		}
	}

	/**
	 * Get Page Options.
	 *
	 * @param array  $option_name name.
	 * @param string $option_group group.
	 * @param string $default default.
	 * @return array
	 */
	public function get_myt_page_options( $option_name, $option_group = '', $default = '' ) {
		$myt_page_options = $this->myt_page_options();

		if ( ! empty( $option_group ) && ! empty( $option_name ) ) {
			if ( isset( $myt_page_options[ $option_group ] ) && isset( $myt_page_options[ $option_group ][ $option_name ] ) ) {
				return $myt_page_options[ $option_group ][ $option_name ];
			}
		} elseif ( empty( $option_group ) && ! empty( $option_name ) ) {
			if ( isset( $myt_page_options[ $option_name ] ) ) {
				return $myt_page_options[ $option_name ];
			}
		}

		return $default;
	}

	/**
	 * Get Page Options.
	 *
	 * @param array $post_id post ID.
	 * @return array
	 */
	public function myt_page_options( $post_id = null ) {
		if ( ! empty( $this->myt_page_options ) ) {
			return $this->myt_page_options;
		}

		if ( ! $post_id ) {
			$post_id = $this->post_id;
		}

		$clean_meta_data  = get_post_meta( $post_id, '_myt_page_options', true );
		$myt_page_options = maybe_unserialize( $clean_meta_data );

		if ( empty( $myt_page_options ) ) {
			$myt_page_options = [];
		} elseif ( ! empty( $myt_page_options ) && ! is_array( $myt_page_options ) ) {
			$myt_page_options = [];
		}

		$this->myt_page_options = $myt_page_options;
		return $myt_page_options;
	}

	/**
	 * Register template control.
	 *
	 * Adds custom controls to any given document.
	 *
	 * Fired by `update_post_metadata` action.
	 *
	 * @since 1.0.0
	 *
	 * @param Document $document The document instance.
	 */
	public function action_register_template_control( $document ) {
		$post_types = function_exists( 'mytravel_option_enabled_post_types' ) ? mytravel_option_enabled_post_types() : [ 'post', 'page' ];
		if ( $document instanceof PageBase && is_a( $document->get_main_post(), 'WP_Post' ) && in_array( $document->get_main_post()->post_type, $post_types, true ) ) {
			$this->post_id = $document->get_main_post()->ID;
			$this->register_template_control( $document );
		}
	}

	/**
	 * Register template control.
	 *
	 * @param Document $page   The document instance.
	 */
	public function register_template_control( $page ) {
		$this->add_general_controls( $page, 'general' );
		$this->add_header_controls( $page, 'header' );
		$this->add_footer_controls( $page, 'footer' );
	}

	/**
	 * Add General Controls.
	 *
	 * @param Document $page Page.
	 * @param string   $option_group group.
	 * @return void
	 */
	public function add_general_controls( Document $page, $option_group = '' ) {
		$page->start_injection(
			[
				'of'       => 'post_status',
				'fallback' => [
					'of' => 'post_title',
				],
			]
		);

		$page->add_control(
			'general_body_classes',
			[
				'label'   => esc_html__( 'Body Classes', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => $this->get_myt_page_options( 'body_classes', $option_group ),
			]
		);

		$page->end_injection();
	}

	/**
	 * Add Header Controls.
	 *
	 * @param Document $page Page.
	 * @param string   $option_group group.
	 * @return void
	 */
	public function add_header_controls( Document $page, $option_group = '' ) {
		$myt_page_options = array();

		$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
		$_myt_page_options = maybe_unserialize( $clean_meta_data );

		if ( is_array( $_myt_page_options ) ) {
			$myt_page_options = $_myt_page_options;
		}
		$elementor_logo_id = isset( $myt_page_options['header']['mytravel_custom_logo'] ) ? $myt_page_options['header']['mytravel_custom_logo'] : array( 'id' => get_theme_mod( 'custom_logo' ) );

		$elementor_transparent_logo_id = isset( $myt_page_options['header']['mytravel_transparent_logo'] ) ? $myt_page_options['header']['mytravel_transparent_logo'] : array( 'id' => get_theme_mod( 'transparent_header_logo' ) );

		$elementor_sticky_logo_id = isset( $myt_page_options['header']['mytravel_sticky_logo'] ) ? $myt_page_options['header']['mytravel_sticky_logo'] : array( 'id' => get_theme_mod( 'sticky_logo' ) );

		$page->start_controls_section(
			'document_settings_header',
			[
				'label' => esc_html__( 'Headers', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$page->add_control(
			'header_mytravel_enable_custom_header',
			[
				'label'     => esc_html__( 'Custom Header', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_custom_header', 'header' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
			]
		);

		$page->add_control(
			'header_header_variant',
			[
				'label'     => esc_html__( 'Header Variant', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'v1' => esc_html__( 'Header v1', 'mytravel-elementor' ),
					'v2' => esc_html__( 'Header v2', 'mytravel-elementor' ),
					'v3' => esc_html__( 'Header v3', 'mytravel-elementor' ),
					'v4' => esc_html__( 'Header v4', 'mytravel-elementor' ),
					'v5' => esc_html__( 'Header v5', 'mytravel-elementor' ),
					'v6' => esc_html__( 'Header v6', 'mytravel-elementor' ),
					'v8' => esc_html__( 'Header v7', 'mytravel-elementor' ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
				],
				'default'   => $this->get_myt_page_options( 'header_variant', $option_group, 'v1' ),
			]
		);

		$page->add_control(
			'header_mytravel_primary_navbar_css',
			[
				'label'     => esc_html__( 'Container CSS', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_primary_navbar_css', $option_group ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant'                => [
						'v1',
						'v5',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_custom_logo_title',
			[
				'label'       => esc_html__( 'Site Title', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => $this->get_myt_page_options( 'mytravel_custom_logo_title', 'header', get_bloginfo( 'name' ) ),
				'description' => esc_html__( 'Site title applies only when custom logo or transparent logo is enabled', 'mytravel-elementor' ),
				'condition'   => [
					'header_mytravel_enable_custom_header' => 'yes',
				],
			]
		);

		$page->add_control(
			'header_mytravel_use_custom_logo',
			[
				'label'     => esc_html__( 'Enable Custom Logo?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_use_custom_logo', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
				],
			]
		);

		$page->add_control(
			'header_mytravel_custom_logo',
			[
				'label'     => esc_html__( 'Upload Logo', 'mytravel-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'id'  => $elementor_logo_id['id'],
					'url' => wp_get_attachment_url( $elementor_logo_id['id'] ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_use_custom_logo'      => 'yes',
				],
			]
		);

		$page->add_control(
			'header_mytravel_enable_transparent_header',
			[
				'label'     => esc_html__( 'Enable Transparent Header ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_transparent_header', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant!'               => [
						'v2',
						'v4',
						'v8',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_transparent_logo_enable',
			[
				'label'     => esc_html__( 'Enable Transparent Logo ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_transparent_logo_enable', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_enable_transparent_header' => 'yes',
					'header_header_variant!'               => [
						'v2',
						'v4',
						'v8',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_transparent_logo',
			[
				'label'     => esc_html__( 'Upload Tranparent Logo', 'mytravel-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'id'  => $elementor_transparent_logo_id['id'],
					'url' => wp_get_attachment_url( $elementor_transparent_logo_id['id'] ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_enable_transparent_header' => 'yes',
					'header_mytravel_transparent_logo_enable' => 'yes',
					'header_header_variant!'               => [
						'v2',
						'v4',
						'v8',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_enable_sticky_header',
			[
				'label'     => esc_html__( 'Enable Sticky Header ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_sticky_header', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
				],
			]
		);

		$page->add_control(
			'header_mytravel_sticky_logo',
			[
				'label'     => esc_html__( 'Upload Sticky Logo', 'mytravel-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'id'  => $elementor_sticky_logo_id['id'],
					'url' => wp_get_attachment_url( $elementor_sticky_logo_id['id'] ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_enable_sticky_header' => 'yes',
				],
			]
		);

		$page->add_control(
			'header_mytravel_enable_top_navbar',
			[
				'label'     => esc_html__( 'Enable Top Navbar ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_top_navbar', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant!'               => [
						'v2',
						'v5',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_top_navbar_skin',
			[
				'label'     => esc_html__( 'Topbar Skin', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => $this->get_myt_page_options( 'mytravel_top_navbar_skin', $option_group, 'violet' ),
				'options'   => [
					'primary'   => esc_html__( 'Primary', 'mytravel-elementor' ),
					'secondary' => esc_html__( 'Secondary', 'mytravel-elementor' ),
					'success'   => esc_html__( 'Success', 'mytravel-elementor' ),
					'danger'    => esc_html__( 'Danger', 'mytravel-elementor' ),
					'warning'   => esc_html__( 'Warning', 'mytravel-elementor' ),
					'info'      => esc_html__( 'Info', 'mytravel-elementor' ),
					'light'     => esc_html__( 'Light', 'mytravel-elementor' ),
					'dark'      => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'      => esc_html__( 'Link', 'mytravel-elementor' ),
					'violet'    => esc_html__( 'Violet', 'mytravel-elementor' ),
					'gray'      => esc_html__( 'Gray', 'mytravel-elementor' ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_enable_top_navbar'    => 'yes',
					'header_header_variant'                =>
					[
						'v3',
						'v4',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_enable_language_dropdown',
			[
				'label'     => esc_html__( 'Enable Language Dropdown ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_language_dropdown', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant'                => [
						'v1',
						'v3',
						'v4',
						'v8',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_skin',
			[
				'label'     => esc_html__( 'Navbar Skin', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_skin', $option_group, 'violet' ),
				'options'   => [
					'primary'   => esc_html__( 'Primary', 'mytravel-elementor' ),
					'secondary' => esc_html__( 'Secondary', 'mytravel-elementor' ),
					'success'   => esc_html__( 'Success', 'mytravel-elementor' ),
					'danger'    => esc_html__( 'Danger', 'mytravel-elementor' ),
					'warning'   => esc_html__( 'Warning', 'mytravel-elementor' ),
					'info'      => esc_html__( 'Info', 'mytravel-elementor' ),
					'light'     => esc_html__( 'Light', 'mytravel-elementor' ),
					'dark'      => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'      => esc_html__( 'Link', 'mytravel-elementor' ),
					'violet'    => esc_html__( 'Violet', 'mytravel-elementor' ),
					'gray'      => esc_html__( 'Gray', 'mytravel-elementor' ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant'                => [
						'v7',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_enable_search',
			[
				'label'     => esc_html__( 'Enable Search ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_search', $option_group, 'yes' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant'                => [
						'v1',
						'v3',
						'v4',
						'v5',
						'v7',
					],
				],
			]
		);

		if ( function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated() ) {
			$page->add_control(
				'header_mytravel_mini_cart_enable',
				[
					'label'     => esc_html__( 'Enable Minicart ?', 'mytravel-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => $this->get_myt_page_options( 'mytravel_mini_cart_enable', $option_group, 'yes' ),
					'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
					'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
					'condition' => [
						'header_mytravel_enable_custom_header' => 'yes',
					],
				]
			);
		}

		$page->add_control(
			'header_mytravel_signin_enable',
			[
				'label'     => esc_html__( 'Enable Signin ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_signin_enable', $option_group, 'yes' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_enable',
			[
				'label'     => esc_html__( 'Enable Navbar Button ?', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_enable', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_skin',
			[
				'label'     => esc_html__( 'Button Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_skin', $option_group, 'white' ),
				'options'   => [
					'primary' => esc_html__( 'Primary', 'mytravel-elementor' ),
					'success' => esc_html__( 'Success', 'mytravel-elementor' ),
					'danger'  => esc_html__( 'Danger', 'mytravel-elementor' ),
					'warning' => esc_html__( 'Warning', 'mytravel-elementor' ),
					'info'    => esc_html__( 'Info', 'mytravel-elementor' ),
					'dark'    => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'    => esc_html__( 'Link', 'mytravel-elementor' ),
					'white'   => esc_html__( 'White', 'mytravel-elementor' ),
					'purple'  => esc_html__( 'Purple', 'mytravel-elementor' ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_text',
			[
				'label'     => esc_html__( 'Button Text', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_text', $option_group, esc_html__( 'Become Local Expert', 'mytravel-elementor' ) ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_link',
			[
				'label'     => esc_html__( 'Button Link', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_link', $option_group, '#' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_size',
			[
				'label'     => esc_html__( 'Button Size', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html__( 'Default', 'mytravel-elementor' ),
					'wide-normal' => esc_html__( 'Normal Wide', 'mytravel-elementor' ),
					'md-wide'     => esc_html__( 'Medium Wide', 'mytravel-elementor' ),
					'wide'        => esc_html__( 'Wide', 'mytravel-elementor' ),
				],
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_size', $option_group, 'wide' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_shape',
			[
				'label'     => esc_html__( 'Button Shape', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'mytravel-elementor' ),
					'rounded-xs' => esc_html__( 'Rounded-xs', 'mytravel-elementor' ),
					'rounded-sm' => esc_html__( 'Rounded-sm', 'mytravel-elementor' ),
				],
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_shape', $option_group, 'rounded-xs' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_variant',
			[
				'label'     => esc_html__( 'Button Variant', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html__( 'Default', 'mytravel-elementor' ),
					'outline'     => esc_html__( 'Outline', 'mytravel-elementor' ),
					'translucent' => esc_html__( 'Translucent', 'mytravel-elementor' ),
				],
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_variant', $option_group ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_button_css',
			[
				'label'     => esc_html__( 'Button CSS', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_button_css', $option_group ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_navbar_button_enable' => 'yes',
					'header_header_variant!'               =>
					[
						'v5',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_signin_button_skin',
			[
				'label'     => esc_html__( 'Signin Button Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_signin_button_skin', $option_group, 'white' ),
				'options'   => [
					'primary' => esc_html__( 'Primary', 'mytravel-elementor' ),
					'success' => esc_html__( 'Success', 'mytravel-elementor' ),
					'danger'  => esc_html__( 'Danger', 'mytravel-elementor' ),
					'warning' => esc_html__( 'Warning', 'mytravel-elementor' ),
					'info'    => esc_html__( 'Info', 'mytravel-elementor' ),
					'dark'    => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'    => esc_html__( 'Link', 'mytravel-elementor' ),
					'white'   => esc_html__( 'White', 'mytravel-elementor' ),
					'purple'  => esc_html__( 'Purple', 'mytravel-elementor' ),
				],
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_signin_enable'        => 'yes',
					'header_header_variant!'               =>
					[
						'v1',
						'v2',
						'v3',
						'v4',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_signin_button_link',
			[
				'label'     => esc_html__( 'Signin Button Link', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_signin_button_link', $option_group ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_signin_enable'        => 'yes',
					'header_header_variant!'               =>
					[
						'v1',
						'v2',
						'v3',
						'v4',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_signin_button_size',
			[
				'label'     => esc_html__( 'Signin Button Size', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html__( 'Default', 'mytravel-elementor' ),
					'wide-normal' => esc_html__( 'Normal Wide', 'mytravel-elementor' ),
					'md-wide'     => esc_html__( 'Medium Wide', 'mytravel-elementor' ),
					'wide'        => esc_html__( 'Wide', 'mytravel-elementor' ),
				],
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_signin_button_size', $option_group, 'wide' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_signin_enable'        => 'yes',
					'header_header_variant!'               =>
					[
						'v1',
						'v2',
						'v3',
						'v4',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_signin_button_shape',
			[
				'label'     => esc_html__( 'Signin Button Shape', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'mytravel-elementor' ),
					'rounded-xs' => esc_html__( 'Rounded-xs', 'mytravel-elementor' ),
					'rounded-sm' => esc_html__( 'Rounded-sm', 'mytravel-elementor' ),
				],
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_signin_button_shape', $option_group, 'rounded-sm' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_signin_enable'        => 'yes',
					'header_header_variant!'               =>
					[
						'v1',
						'v2',
						'v3',
						'v4',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_signin_button_variant',
			[
				'label'     => esc_html__( 'Signin Button Variant', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html__( 'Default', 'mytravel-elementor' ),
					'outline'     => esc_html__( 'Outline', 'mytravel-elementor' ),
					'translucent' => esc_html__( 'Translucent', 'mytravel-elementor' ),
				],
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_signin_button_variant', $option_group, 'outline' ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_signin_enable'        => 'yes',
					'header_header_variant!'               =>
					[
						'v1',
						'v2',
						'v3',
						'v4',
						'v6',
					],
				],
			]
		);

		$page->add_control(
			'header_mytravel_navbar_signin_button_css',
			[
				'label'     => esc_html__( 'Signin Button CSS', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_navbar_signin_button_css', $option_group ),
				'condition' => [
					'header_mytravel_enable_custom_header' => 'yes',
					'header_mytravel_signin_enable'        => 'yes',
				],
			]
		);

		$page->end_controls_section();
	}

	/**
	 * Add Footer Controls
	 *
	 * @param Document $page         The Elementor document.
	 * @param string   $option_group The option group.
	 */
	public function add_footer_controls( Document $page, $option_group = '' ) {

		$page->start_controls_section(
			'document_settings_footer',
			[
				'label' => esc_html__( 'Footer', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$page->add_control(
			'footer_mytravel_enable_custom_footer',
			[
				'label'     => esc_html__( 'Custom Footer', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => $this->get_myt_page_options( 'mytravel_enable_custom_footer', $option_group, 'no' ),
				'label_on'  => esc_html__( 'Enable', 'mytravel-elementor' ),
				'label_off' => esc_html__( 'Disable', 'mytravel-elementor' ),
			]
		);

		$page->add_control(
			'footer_mytravel_footer_variant',
			[
				'label'     => esc_html__( 'Footer Variant', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'v1'     => esc_html__( 'Footer v1', 'mytravel-elementor' ),
					'v2'     => esc_html__( 'Footer v2', 'mytravel-elementor' ),
					'static' => esc_html__( 'Static Footer', 'mytravel-elementor' ),
				],
				'condition' => [
					'footer_mytravel_enable_custom_footer' => 'yes',
				],
				'default'   => $this->get_myt_page_options( 'mytravel_footer_variant', $option_group, 'v1' ),
			]
		);

		if ( function_exists( 'mytravel_is_mas_static_content_activated' ) && mytravel_is_mas_static_content_activated() ) {
			$page->add_control(
				'footer_mytravel_footer_static_widgets',
				[
					'label'     => esc_html__( 'Footer Static Widgets', 'mytravel-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => $this->static_contents,
					'condition' => [
						'footer_mytravel_footer_variant' => 'static',
						'footer_mytravel_enable_custom_footer'  => 'yes',
					],
					'default'   => $this->get_myt_page_options( 'mytravel_footer_static_widgets', $option_group, '' ),
				]
			);
		}

		$page->add_control(
			'footer_mytravel_footer_credit_card_image',
			[
				'label'     => esc_html__( 'Upload Credit Card Image', 'mytravel-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'id'  => $this->get_myt_page_options( 'mytravel_footer_credit_card_image', $option_group ),
					'url' => (string) wp_get_attachment_image_url( $this->get_myt_page_options( 'mytravel_footer_credit_card_image', $option_group ) ),
				],

				'condition' => [
					'footer_mytravel_enable_custom_footer' => 'yes',
					'footer_mytravel_footer_variant'       => 'v2',
				],
			]
		);

		$page->add_control(
			'footer_mytravel_footer_copyright',
			[
				'label'     => esc_html__( 'Copyright Text', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => $this->get_myt_page_options( 'mytravel_footer_copyright', $option_group, '© 2022 MyTravel. All rights reserved' ),
				'condition' => [
					'footer_mytravel_enable_custom_footer' => 'yes',
					'footer_mytravel_footer_variant!' => 'static',
				],
			]
		);

		$page->end_controls_section();
	}

	/**
	 * Filter metadata update.
	 *
	 * Filters whether to update metadata of a specific type.
	 *
	 * Elementor don't allow WordPress to update the parent page template
	 * during `wp_update_post`.
	 *
	 * Fired by `update_{$meta_type}_metadata` filter.
	 *
	 * @since 1.0.0
	 *
	 * @param bool   $check     Whether to allow updating metadata for the given type.
	 * @param int    $object_id Object ID.
	 * @param string $meta_key  Meta key.
	 * @param string $meta_value  Meta Value.
	 * @param string $prev_value  previous value.
	 *
	 * @return bool Whether to allow updating metadata of a specific type.
	 */
	public function filter_update_meta( $check, $object_id, $meta_key, $meta_value, $prev_value ) {
		if ( '_elementor_page_settings' === $meta_key ) {
			$current_check = $check;
			if ( ! empty( $meta_value ) && is_array( $meta_value ) ) {
				$special_settings_names = $this->get_special_settings_names();
				$special_settings       = [];
				foreach ( $special_settings_names as $name ) {
					if ( isset( $meta_value[ $name ] ) ) {
						$special_settings[ $name ] = $meta_value[ $name ];
						unset( $meta_value[ $name ] );
						$current_check = false;
					}
				}
				if ( false === $current_check ) {
					update_metadata( 'post', $object_id, $meta_key, $meta_value, $prev_value );
					$this->update_myt_page_option( $object_id, $special_settings );
					return $current_check;
				}
			}
		}

		return $check;
	}
}
