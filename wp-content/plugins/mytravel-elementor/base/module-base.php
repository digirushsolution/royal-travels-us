<?php
namespace MyTravelElementor\Base;

use MyTravelElementor;
use Elementor\Core\Base\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Base module class
 */
abstract class Module_Base extends Module {
	/**
	 * Return the widgets in this module.
	 *
	 * @return array
	 */
	public function get_widgets() {
		return [];
	}
	/**
	 * Instantiate the class.
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_widget_categories' ] );
	}
	/**
	 * Initialised widgets.
	 */
	public function init_widgets() {
		$widget_manager = MyTravelElementor\Plugin::elementor()->widgets_manager;

		foreach ( $this->get_widgets() as $widget ) {

			$class_name = $this->get_reflection()->getNamespaceName() . '\Widgets\\' . $widget;

			$widget_manager->register( new $class_name() );
		}
	}

	/**
	 * Add widget category name
	 *
	 * @param string $elements_manager Element.
	 */
	public function add_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'mytravel',
			[
				'title' => esc_html__( 'Mytravel', 'mytravel-elementor' ),
				'icon'  => 'fa fa-plug',
			]
		);
	}
}
