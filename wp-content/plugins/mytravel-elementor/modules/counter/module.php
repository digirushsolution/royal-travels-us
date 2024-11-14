<?php
namespace MyTravelElementor\Modules\Counter;

use MyTravelElementor\Base\Module_Base;
use MyTravelElementor\Modules\Counter\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Counter module class.
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
		return 'override-Counter';
	}

	/**
	 * Add actions to the widget
	 */
	public function add_actions() {
		add_action( 'elementor/widget/counter/skins_init', [ $this, 'init_skins' ], 10 );
	}

	/**
	 * Initialize skins for the widget
	 *
	 * @param Elementor\Widget_Base $widget The button widget.
	 */
	public function init_skins( $widget ) {
		$widget->add_skin( new Skins\Counter_Skin( $widget ) );
	}
}
