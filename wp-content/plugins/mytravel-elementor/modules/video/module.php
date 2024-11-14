<?php

namespace MyTravelElementor\Modules\Video;

use MyTravelElementor\Base\Module_Base;
use MyTravelElementor\Modules\Video\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Video module class.
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
	 * Add actions to the widget
	 */
	public function add_actions() {
		add_action( 'elementor/widget/video/skins_init', [ $this, 'init_skins' ], 10 );
	}

	/**
	 * Initialize skins for the widget
	 *
	 * @param Elementor\Widget_Base $widget The button widget.
	 */
	public function init_skins( $widget ) {
		$widget->add_skin( new Skins\Skin_Video( $widget ) );
	}

	/**
	 * Get the module name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'video';
	}

}
