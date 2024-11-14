<?php
namespace BwdModalPopup\PageSettings;

use Elementor\Controls_Manager;
use Elementor\Core\DocumentTypes\PageBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Page_Settings {

	const PANEL_TAB = 'new-tab';

	public function __construct() {
		add_action( 'elementor/init', [ $this, 'bwdmp_modal_popup_add_panel_tab' ] );
		add_action( 'elementor/documents/register_controls', [ $this, 'bwdmp_modal_popup_register_document_controls' ] );
	}

	public function bwdmp_modal_popup_add_panel_tab() {
		Controls_Manager::add_tab( self::PANEL_TAB, esc_html__( 'New Tab', 'bwdmp-modal-popup' ) );
	}

	public function bwdmp_modal_popup_register_document_controls( $document ) {
		if ( ! $document instanceof PageBase || ! $document::get_property( 'has_elements' ) ) {
			return;
		}

		$document->start_controls_section(
			'bwdmp_modal_popup_new_section',
			[
				'label' => esc_html__( 'Settings', 'bwdmp-modal-popup' ),
				'tab' => self::PANEL_TAB,
			]
		);

		$document->add_control(
			'bwdmp_modal_popup_text',
			[
				'label' => esc_html__( 'Title', 'bwdmp-modal-popup' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'bwdmp-modal-popup' ),
			]
		);

		$document->end_controls_section();
	}
}
