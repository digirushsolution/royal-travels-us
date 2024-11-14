<?php
namespace MyTravelElementor\Modules\HighlightedHeading;

use MyTravelElementor\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Highlighted module class
 */
class Module extends Module_Base {
	/**
	 * Return the widgets in this module.
	 *
	 * @return array
	 */
	public function get_widgets() {
		return [
			'Highlighted_Heading',
		];
	}
	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'highlighted-heading';
	}
}
