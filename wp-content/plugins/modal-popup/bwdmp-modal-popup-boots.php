<?php
namespace BwdModalPopup;

use BwdModalPopup\PageSettings\Page_Settings;

define('BWDMP_MODAL_POPUP_PUBLIC_ASSETS_ALL', plugin_dir_url(__FILE__) . 'assets/public');
define('BWDMP_MODAL_POPUP_ASSETS_ADMIN_DIR_FILE', plugin_dir_url(__FILE__) . 'assets/admin');

class BWDMPModalPopupCreator {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function bwdmp_admin_editor_scripts() {
		add_filter( 'script_loader_tag', [ $this, 'bwdmp_admin_editor_scripts_as_a_module' ], 10, 2 );
	}

	public function bwdmp_admin_editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'bwdmp_modal_popup_editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/bwdmp-modal-popup-widget.php' );

	}


	public function bwdmp_register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files(); 

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\BWDModalPopupWidget() );

	}


	private function add_page_settings_controls() {
		require_once( __DIR__ . '/page-settings/bwdmp-modal-popup-manager.php' );
		new Page_Settings();
	}

	// Register Category
	function bwdmp_add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'bwdmp-modal-popup-category',
			[
				'title' => esc_html__( 'BWD Modal popup', 'bwdmp-modal-popup' ),
				'icon' => 'eicon-person',
			]
		);
	}
	public function bwdmp_all_assets_for_the_public(){

		//font awesome css
		wp_enqueue_style( 'bwdmp-fs-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css', array(), '5.8.2', 'all' );

		//bs css
		wp_enqueue_style( 'bwdmp-bs-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', array(), '5.0.0', 'all' );


		//bs js cdn
		wp_enqueue_script( 'bwdmp_logo_bs_js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.bundle.min.js', array('jquery'), '1.0', true );


		//main js
		wp_enqueue_script( 'bwdmp_modal_popup_main_js', plugin_dir_url( __FILE__ ) . 'assets/public/js/main.js', array('jquery'), '1.0', true );

		$all_css_js_file = array(
			'bwdmp_modal_popup_main_css' => array('bwdmp_path_define_with_modal_popup'=>BWDMP_MODAL_POPUP_PUBLIC_ASSETS_ALL . '/css/modal-style.css'),

        );

        foreach($all_css_js_file as $handle => $fileinfo){
            wp_enqueue_style( $handle, $fileinfo['bwdmp_path_define_with_modal_popup'], null, '1.0', 'all');
        }

		
	}
	public function bwdmp_all_assets_for_elementor_editor_admin(){
		$all_css_js_file = array(
            'bwdmp_modal_popup_admin_main_css' => array('bwdmp_path_admin_define'=>BWDMP_MODAL_POPUP_ASSETS_ADMIN_DIR_FILE . '/icon.css'),
        );
        foreach($all_css_js_file as $handle => $fileinfo){
            wp_enqueue_style( $handle, $fileinfo['bwdmp_path_admin_define'], null, '1.0', 'all');
        }
	}

	public function __construct() {


		// For public assets
		add_action('wp_enqueue_scripts', [$this, 'bwdmp_all_assets_for_the_public']);

		// For Elementor Editor
		add_action('elementor/editor/before_enqueue_scripts', [$this, 'bwdmp_all_assets_for_elementor_editor_admin']);

		// Register Category
		add_action( 'elementor/elements/categories_registered', [ $this, 'bwdmp_add_elementor_widget_categories' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'bwdmp_register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'bwdmp_admin_editor_scripts' ] );
		
		$this->add_page_settings_controls();
	}
}

// Instantiate Plugin Class
BWDMPModalPopupCreator::instance();
