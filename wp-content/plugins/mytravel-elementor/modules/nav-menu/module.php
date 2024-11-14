<?php
namespace MyTravelElementor\Modules\NavMenu;

use MyTravelElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Module for Nav-Menu
 */
class Module extends Module_Base {

	/**
	 * Get Widgets.
	 *
	 * @return array
	 */
	public function get_widgets() {
		return [
			'Nav_Menu',
		];
	}

	/**
	 * Get Widgets Name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-nav-menu';
	}
}
