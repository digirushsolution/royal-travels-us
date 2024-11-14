<?php

namespace MyTravelElementor\Modules\IconBox;

use MyTravelElementor\Base\Module_Base;
use MyTravelElementor\Modules\IconBox\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Module for Icon-Box.
 */
class Module extends Module_Base {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	/**
	 * Get Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-icon-box';
	}

	/**
	 * Add Action.
	 *
	 * @return void
	 */
	public function add_actions() {
		add_action( 'elementor/widget/icon-box/skins_init', [ $this, 'init_skins' ], 10 );
	}

	/**
	 * Add Action.
	 *
	 * @param array $widget The widget.
	 * @return void
	 */
	public function init_skins( $widget ) {
		$widget->add_skin( new Skins\Skin_Icon_Box_V1( $widget ) );
		$widget->add_skin( new Skins\Skin_Icon_Box_V2( $widget ) );
	}
}
