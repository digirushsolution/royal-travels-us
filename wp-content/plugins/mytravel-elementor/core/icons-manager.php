<?php
namespace MyTravelElementor\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Utils;

/**
 * Icons Manager
 */
final class Icons_Manager {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'additional_tabs' ], 20 );
	}

	/**
	 * Adding $tabs ( boxicon tabs ) in the icon library.
	 *
	 * @param  array $tabs Adding additional tabs to the icon library.
	 *
	 * @return string
	 */
	public function additional_tabs( $tabs ) {
		$new_tabs = [
			'flaticon ' => [
				'name'          => 'flaticon',
				'label'         => esc_html__( 'Flaticon', 'mytravel-elementor' ),
				'url'           => get_template_directory_uri() . '/assets/css/font-mytravel.css',
				'enqueue'       => [],
				'prefix'        => 'flaticon-',
				'displayPrefix' => '',
				'labelIcon'     => 'flaticon-star',
				'ver'           => '4.24.1',
				'fetchJson'     => get_template_directory_uri() . '/assets/fonts/font-mytravel.js',
				'native'        => false,
			],

		];

		return array_merge( $tabs, $new_tabs );
	}
}
