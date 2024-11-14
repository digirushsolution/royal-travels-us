<?php
namespace MyTravelElementor\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MyTravelElementor\Plugin;
/**
 * The Base module class
 */
final class Controls_Manager {

	// const AOS_ANIMATION = 'aos_animation';.
	const FONT_SIZE = 'font_size';
	/**
	 * Intantiate the controls.
	 *
	 * @var Controls_Manager
	 */
	private $controls = [];
	/**
	 * Instantiate the class.
	 */
	public function __construct() {
		$this->init_actions();
	}
	/**
	 * Instantiate the actions.
	 */
	public function init_actions() {
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
	}
	/**
	 * Instantiate the control names.
	 */
	public static function get_controls_names() {
		return [
			self::FONT_SIZE,
		];
	}
	/**
	 * Get groups names.
	 */
	public static function get_groups_names() {
		// Group name must use "-" instead of "_".
		return [];
	}
	/**
	 * Instantiate controls.
	 */
	public function init_controls() {
		foreach ( self::get_controls_names() as $control_id ) {
			$control_class_id = str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $control_id ) ) );
			$class_name       = 'MyTravelElementor\Includes\Controls\Control_' . $control_class_id;
			Plugin::elementor()->controls_manager->register( new $class_name() );
		}

		foreach ( self::get_groups_names() as $group_name ) {
			$group_class_id = str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $group_name ) ) );
			$class_name     = 'MyTravelElementor\Includes\Controls\Groups\Group_Control_' . $group_class_id;
			Plugin::elementor()->controls_manager->add_group_control( $group_name, new $class_name() );
		}
	}
}
