<?php
/**
 * Icon Settings for Page
 *
 * @package Mytravel/ACF/Settings/Icon
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_60b79d84bbd2e',
		'title'                 => 'Icon',
		'fields'                => array(
			array(
				'key'               => 'field_60b79d9eb1916',
				'label'             => 'Icon Class',
				'name'              => 'icon_class',
				'type'              => 'text',
				'instructions'      => 'Enter the icon class for the amenity. For example: flaticon-alarm',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'all',
				),
			),
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'pa_room-amenities',
				),
			),
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'all',
				),
			),
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'pa_tour-amenities',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	)
);

