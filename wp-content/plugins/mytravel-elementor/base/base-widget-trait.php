<?php
namespace MyTravelElementor\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait Base_Widget_Trait {
	/**
	 * Condition to check editable
	 */
	public function is_editable() {
		return true;
	}
}
