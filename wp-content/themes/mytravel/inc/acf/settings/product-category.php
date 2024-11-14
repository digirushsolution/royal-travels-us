<?php
/**
 * Product Category Settings for Archive Page
 *
 * @package Mytravel/ACF/Settings/ProductCategory
 */

acf_add_local_field_group(
	array(
		'key'                   => 'group_6204ee8e0fabe',
		'title'                 => 'Product Layout',
		'fields'                => array(
			array(
				'key'               => 'field_6221b5f0476ec',
				'label'             => 'Sidebar',
				'name'              => 'sidebar',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					'left-sidebar'  => 'left-sidebar',
					'right-sidebar' => 'right-sidebar',
					'no-sidebar'    => 'no-sidebar',
				),
				'default_value'     => 'left-sidebar',
				'allow_null'        => 0,
				'multiple'          => 0,
				'ui'                => 0,
				'return_format'     => 'value',
				'ajax'              => 0,
				'placeholder'       => '',
			),
			array(
				'key'               => 'field_622243cebc8c1',
				'label'             => 'Products per row',
				'name'              => 'products_per_row',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				),
				'default_value'     => 3,
				'allow_null'        => 0,
				'multiple'          => 0,
				'ui'                => 0,
				'return_format'     => 'value',
				'ajax'              => 0,
				'placeholder'       => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'product_cat',
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
