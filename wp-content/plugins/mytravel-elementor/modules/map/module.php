<?php
namespace MyTravelElementor\Modules\Map;

use MyTravelElementor\Base\Module_Base;
use MyTravelElementor\Modules\Map\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Map module class.
 */
class Module extends Module_Base {

	/**
	 * Instantiate the module object.
	 */
	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	/**
	 * Get the module name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'override-maps';
	}

	/**
	 * Add actions to the widget
	 */
	public function add_actions() {
		add_action( 'elementor/widget/google_maps/skins_init', [ $this, 'init_skins' ], 10 );
	}

	/**
	 * Initialize skins for the widget
	 *
	 * @param Elementor\Widget_Base $widget The button widget.
	 */
	public function init_skins( $widget ) {
		$widget->add_skin( new Skins\Skin_Map_Mytravel( $widget ) );
	}
}
