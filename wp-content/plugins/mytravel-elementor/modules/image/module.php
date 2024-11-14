<?php

namespace MyTravelElementor\Modules\Image;

use MyTravelElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Files\Assets\Files_Upload_Handler;
use Elementor\Core\Schemes;
use Elementor\Utils;
use Elementor\Plugin;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Image module class
 */
class Module extends Module_Base {
	/**
	 * Instantiate the class.
	 */
	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}
	/**
	 * Add Actions
	 *
	 * @return void
	 */
	public function add_actions() {
		add_action( 'elementor/element/image/section_image/before_section_end', [ $this, 'add_css_classes_controls' ], 10 );
		add_filter( 'elementor/image_size/get_attachment_image_html', [ $this, 'image_html' ], 10, 4 );
		add_action( 'elementor/widget/image/skins_init', [ $this, 'init_skins' ], 10 );

	}

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'override-image';
	}

	/**
	 * Add Action.
	 *
	 * @param array $widget The widget.
	 * @return void
	 */
	public function init_skins( $widget ) {
		$widget->add_skin( new Skins\Skin_Image_V1( $widget ) );
	}
	/**
	 * Add CSS classes controls
	 *
	 * @param array $element The widget.
	 * @return void
	 */
	public function add_css_classes_controls( $element ) {

		$element->add_control(
			'image_class',
			[
				'label'       => esc_html__( 'Image Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class for <img> tag  without the dot. e.g: my-class', 'mytravel-elementor' ),
				'default'     => 'img-fluid',
				'label_block' => true,
				'description' => esc_html__( 'Additional CSS class that you want to apply to the img tag', 'mytravel-elementor' ),
			]
		);
	}
	/**
	 * Output Image HTML
	 *
	 * @param array $html Image HTML.
	 * @param array $settings Image settings.
	 * @param array $image_size_key Image size key.
	 * @param array $image_key Image key.
	 */
	public function image_html( $html, $settings, $image_size_key, $image_key ) {
		$enabled = Plugin::$instance->uploads_manager->are_unfiltered_uploads_enabled();

		if ( $enabled && isset( $settings['inline_svg'] ) && 'yes' === $settings['inline_svg'] && isset( $settings['image']['url'] ) ) {

			if ( isset( $settings['image_class'] ) && ! empty( $settings['image_class'] ) ) {
				$html = '<div class="mytravel-elementor-svg-wrapper ' . esc_attr( $settings['image_class'] ) . '">';
			} else {
				$html = '<div class="mytravel-elementor-svg-wrapper">';
			}

			$html .= file_get_contents( $settings['image']['url'] );
			$html .= '</div>';

		} else {

			if ( isset( $settings['image_class'] ) && ! empty( $settings['image_class'] ) ) {

				if ( strpos( $html, 'class="' ) !== false ) {
					$html = str_replace( 'class="', 'class="' . esc_attr( $settings['image_class'] ) . ' ', $html );
				} else {
					$html = str_replace( '<img', '<img class="' . esc_attr( $settings['image_class'] ) . '"', $html );
				}
			}
		}

		return $html;
	}
}
