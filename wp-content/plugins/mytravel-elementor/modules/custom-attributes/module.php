<?php
namespace MyTravelElementor\Modules\CustomAttributes;

use Elementor\Controls_Stack;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use MyTravelElementor\Base\Module_Base;
use MyTravelElementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Custom Attributes.
 */
class Module extends Module_Base {

	/**
	 * Pugin activate.
	 */
	public static function is_active() {
		return ! class_exists( 'ElementorPro\Plugin' );
	}

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
		return 'custom-attributes';
	}

	/**
	 * Get back attributes.
	 */
	private function get_black_list_attributes() {
		static $black_list = null;

		if ( null === $black_list ) {
			$black_list = [ 'id', 'class', 'data-id', 'data-settings', 'data-element_type', 'data-widget_type', 'data-model-cid' ];

			/**
			 * Elementor attributes black list.
			 *
			 * Filters the attributes that won't be rendered in the wrapper element.
			 *
			 * By default Elementor doesn't render some attributes to prevent things
			 * from breaking down. But this list of attributes can be changed.
			 *
			 * @since 2.2.0
			 *
			 * @param array $black_list A black list of attributes.
			 */
			$black_list = apply_filters( 'elementor_pro/element/attributes/black_list', $black_list );
		}

		return $black_list;
	}

	/**
	 * Replace Custom Attributes.
	 *
	 * @param Element_Base $element element base.
	 */
	public function replace_go_pro_custom_attributes_controls( Element_Base $element ) {
		Plugin::elementor()->controls_manager->remove_control_from_stack( $element->get_unique_name(), [ 'section_custom_attributes_pro', 'custom_attributes_pro' ] );

		$this->register_custom_attributes_controls( $element );
	}

	/**
	 * Register Custom Attributes Controls.
	 *
	 * @param Element_Base $element element base.
	 */
	public function register_custom_attributes_controls( Element_Base $element ) {
		$element_name = $element->get_name();

		$element->start_controls_section(
			'_section_attributes',
			[
				'label' => __( 'Attributes', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'_attributes',
			[
				'label'       => __( 'Custom Attributes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => /* translators: %s: search term */__( 'key|value', 'mytravel-elementor' ),
				'description' => sprintf( __( 'Set custom attributes for the wrapper element. Each attribute in a separate line. Separate attribute key from the value using %s character.', 'mytravel-elementor' ), '<code>|</code>' ),
				'classes'     => 'elementor-control-direction-ltr',
			]
		);

		$element->end_controls_section();
	}

	/**
	 * Register Controls.
	 *
	 * @param Controls_Stack $element element Controls_Stack.
	 * @param section        $section_id string.
	 */
	public function register_controls( Controls_Stack $element, $section_id ) {
		if ( ! $element instanceof Element_Base ) {
			return;
		}

		// Remove Custom CSS Banner (From free version).
		if ( 'section_custom_attributes_pro' === $section_id ) {
			$this->replace_go_pro_custom_attributes_controls( $element );
		}
	}

	/**
	 * Render Attributes.
	 *
	 * @param Element_Base $element element base.
	 */
	public function render_attributes( Element_Base $element ) {
		$settings = $element->get_settings_for_display();

		if ( ! empty( $settings['_attributes'] ) ) {
			$attributes = $this->parse_custom_attributes( $settings['_attributes'], "\n" );

			$black_list = $this->get_black_list_attributes();

			foreach ( $attributes as $attribute => $value ) {
				if ( ! in_array( $attribute, $black_list, true ) ) {
					$element->add_render_attribute( '_wrapper', $attribute, $value );
				}
			}
		}
	}

	/**
	 * Custom Attributes.
	 *
	 * TODO: Remove, use \Elementor\Utils:parse_custom_attributes from Core >= 2.9.10.
	 *
	 * @param String    $attributes_string The attributes.
	 *
	 * @param Seperator $delimiter The attributes.
	 */
	private function parse_custom_attributes( $attributes_string, $delimiter = ',' ) {
		$attributes = explode( $delimiter, $attributes_string );
		$result     = [];

		foreach ( $attributes as $attribute ) {
			$attr_key_value = explode( '|', $attribute );

			$attr_key = mb_strtolower( $attr_key_value[0] );

			// Remove any not allowed characters.
			preg_match( '/[-_a-z0-9]+/', $attr_key, $attr_key_matches );

			if ( empty( $attr_key_matches[0] ) ) {
				continue;
			}

			$attr_key = $attr_key_matches[0];

			// Avoid Javascript events and unescaped href.
			if ( 'href' === $attr_key || 'on' === substr( $attr_key, 0, 2 ) ) {
				continue;
			}

			if ( isset( $attr_key_value[1] ) ) {
				$attr_value = trim( $attr_key_value[1] );
			} else {
				$attr_value = '';
			}

			$result[ $attr_key ] = $attr_value;
		}

		return $result;
	}
	/**
	 * Add control functions.
	 */
	protected function add_actions() {
		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/after_add_attributes', [ $this, 'render_attributes' ] );
	}
}
