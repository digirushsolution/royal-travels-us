<?php
namespace MyTravelElementor;

use Elementor\Core\Responsive\Files\Frontend as FrontendFile;
use Elementor\Core\Responsive\Responsive;
use Elementor\Utils;
use MyTravelElementor\Core\Modules_Manager;
use MyTravelElementor\Core\Controls_Manager;
use MyTravelElementor\Core\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class plugin
 */
class Plugin {

	/**
	 * Plugin
	 *
	 * @var Plugin
	 */
	private static $_instance;

	/**
	 * Modules Manager
	 *
	 * @var Modules_Manager
	 */
	public $modules_manager;

	/**
	 * Controls Manager
	 *
	 * @var Controls_Manager
	 */
	public $controls_manager;

	/**
	 * Icons Manager
	 *
	 * @var Icons_Manager
	 */
	public $icons_manager;

	/**
	 * Classes aliases
	 *
	 * @var array
	 */
	private $classes_aliases = [];

	/**
	 * Get classes aliases.
	 *
	 * @return array
	 */
	public static function get_classes_aliases() {
		if ( ! self::$classes_aliases ) {
			return self::init_classes_aliases();
		}

		return self::$classes_aliases;
	}

	/**
	 * Initialize classes aliases.
	 *
	 * @return array
	 */
	private static function init_classes_aliases() {
		$classes_aliases = [
			'MyTravelElementor\Modules\PanelPostsControl\Module' => 'MyTravelElementor\Modules\QueryControl\Module',
			'MyTravelElementor\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'MyTravelElementor\Modules\QueryControl\Controls\Group_Control_Posts',
			'MyTravelElementor\Modules\PanelPostsControl\Controls\Query' => 'MyTravelElementor\Modules\QueryControl\Controls\Query',
		];

		return $classes_aliases;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'mytravel-elementor' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'mytravel-elementor' ), '1.0.0' );
	}

	/**
	 * Elementor
	 *
	 * @return \Elementor\Plugin
	 */
	public static function elementor() {
		return \Elementor\Plugin::$instance;
	}

	/**
	 * Instance
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Autoload
	 *
	 * @param array $class Class.
	 * @return Plugin
	 */
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$has_class_alias = isset( $this->classes_aliases[ $class ] );

		// Backward Compatibility: Save old class name for set an alias after the new class is loaded.
		if ( $has_class_alias ) {
			$class_alias_name = $this->classes_aliases[ $class ];
			$class_to_load    = $class_alias_name;
		} else {
			$class_to_load = $class;
		}

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);
			$filename = MYTRAVEL_ELEMENTOR_PATH . $filename . '.php';
			$filename = str_replace( 'controls' . DIRECTORY_SEPARATOR . 'control-', 'controls' . DIRECTORY_SEPARATOR, $filename );
			$filename = str_replace( 'groups' . DIRECTORY_SEPARATOR . 'group-control-', 'groups' . DIRECTORY_SEPARATOR, $filename );

			if ( is_readable( $filename ) ) {
				include $filename;
			}
		}

		if ( $has_class_alias ) {
			class_alias( $class_alias_name, $class );
		}
	}

	/**
	 * Enqueue Styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {}

	/**
	 * Enqueue Frontend Scripts.
	 *
	 * @return void
	 */
	public function enqueue_frontend_scripts() {}

	/**
	 * Register Frontend Scripts.
	 *
	 * @return void
	 */
	public function register_frontend_scripts() {}

	/**
	 * Register Preview Scripts.
	 *
	 * @return void
	 */
	public function register_preview_scripts() {}

	/**
	 * Responsive Stylesheet Templates.
	 *
	 * @param array $templates Templates.
	 * @return array
	 */
	public function get_responsive_stylesheet_templates( $templates ) {
		return $templates;
	}

	/**
	 * Intialize Elementor.
	 *
	 * @return void
	 */
	public function on_elementor_init() {
		$this->modules_manager  = new Modules_Manager();
		$this->controls_manager = new Controls_Manager();
		$this->icons_manager    = new Icons_Manager();

		$this->setup_elementor();

		/**
		 * Mytravel Elementor init.
		 *
		 * Fires on Mytravel Elementor init, after Elementor has finished loading but
		 * before any headers are sent.
		 *
		 * @since 1.0.0
		 */
		do_action( 'mytravel_elementor/init' );
	}

	/**
	 * Document Save Version.
	 *
	 * @param \Elementor\Core\Base\Document $document Document.
	 */
	public function on_document_save_version( $document ) {
		$document->update_meta( '_mytravel_elementor_version', MYTRAVEL_ELEMENTOR_VERSION );
	}

	/**
	 * Get Responsive Templates Path.
	 *
	 * @return string
	 */
	private function get_responsive_templates_path() {
		return MYTRAVEL_ELEMENTOR_ASSETS_PATH . 'css/templates/';
	}

	/**
	 * Setup Hooks.
	 *
	 * @return void
	 */
	private function setup_hooks() {
		add_action( 'elementor/init', [ $this, 'on_elementor_init' ] );

		add_action( 'elementor/document/save_version', [ $this, 'on_document_save_version' ] );
		add_action( 'mytravel_setup_prose', [ $this, 'disable_setup_prose' ] );
	}

	/**
	 * Setup Elementor.
	 *
	 * @return void
	 */
	public function setup_elementor() {

		if ( is_admin() && ( apply_filters( 'mytravel_force_setup_elementor', false ) || 'completed' !== get_option( 'mytravel_setup_elementor' ) ) ) {

			update_option( 'elementor_disable_color_schemes', 'yes' );
			update_option( 'elementor_disable_typography_schemes', 'yes' );
			update_option( 'elementor_optimized_dom_output', 'enabled' );
			update_option( 'elementor_unfiltered_files_upload', '1' );
			update_option( 'elementor_cpt_support', [ 'post', 'page', 'mas_static_content', 'jetpack-portfolio', 'docs', 'job_listing' ] );

			\Elementor\Plugin::$instance->experiments->set_feature_default_state( 'e_dom_optimization', 'active' );

			// Get default/active kit.
			$active_kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();

			// Get and store current active kit settings in an array variable 'settings'.
			$kit_data['settings'] = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings();

			if ( function_exists( 'mytravel_get_global_colors' ) && $default_colors = mytravel_get_global_colors() ) { //phpcs:ignore
				$kit_data['settings']['system_colors'] = $default_colors;
			}

			// Save active kit new settings.
			$active_kit->save( $kit_data );

			update_option( 'mytravel_setup_elementor', 'completed' );
		}
	}

	/**
	 * Plugin constructor.
	 *
	 * @return void
	 */
	private function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );

		$this->setup_hooks();
	}

	/**
	 * Disable prose setup
	 *
	 * @param bool $enable Setup Prose.
	 * @return bool
	 */
	public function disable_setup_prose( $enable ) {
		global $post;
		$document = self::elementor()->documents->get( $post->ID );
		if ( $document->is_built_with_elementor() ) {
			$enable = false;
		}
		return $enable;
	}

	/**
	 * Get Title.
	 *
	 * @return string
	 */
	final public static function get_title() {
		return esc_html__( 'Mytravel Elementor', 'mytravel-elementor' );
	}
}

Plugin::instance();
