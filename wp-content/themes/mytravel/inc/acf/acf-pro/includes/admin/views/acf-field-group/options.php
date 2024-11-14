<?php

// global
global $field_group;

// UI needs at lease 1 location rule
if ( empty( $field_group['location'] ) ) {
	$field_group['location'] = array(
		// Group 0.
		array(
			// Rule 0.
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'post',
			),
		),
	);

	$acf_use_post_type    = acf_get_post_type_from_request_args( 'add-fields' );
	$acf_use_taxonomy     = acf_get_taxonomy_from_request_args( 'add-fields' );
	$acf_use_options_page = acf_get_ui_options_page_from_request_args( 'add-fields' );

	if ( $acf_use_post_type && ! empty( $acf_use_post_type['post_type'] ) ) {
		$field_group['location'] = array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $acf_use_post_type['post_type'],
				),
			),
		);
	}

	if ( $acf_use_taxonomy && ! empty( $acf_use_taxonomy['taxonomy'] ) ) {
		$field_group['location'] = array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => $acf_use_taxonomy['taxonomy'],
				),
			),
		);
	}

	if ( $acf_use_options_page && ! empty( $acf_use_options_page['menu_slug'] ) ) {
		$field_group['location'] = array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => $acf_use_options_page['menu_slug'],
				),
			),
		);
	}
}

foreach ( acf_get_combined_field_group_settings_tabs() as $tab_key => $tab_label ) {
	acf_render_field_wrap(
		array(
			'type'          => 'tab',
			'label'         => $tab_label,
			'key'           => 'acf_field_group_settings_tabs',
			'settings-type' => $tab_key,
		)
	);

	switch ( $tab_key ) {
		case 'location_rules':
			echo '<div class="field-group-locations field-group-settings-tab">';
				acf_get_view( 'acf-field-group/locations' );
			echo '</div>';
			break;
		case 'presentation':
			echo '<div class="field-group-setting-split-container field-group-settings-tab">';
			echo '<div class="field-group-setting-split">';

			// style
			acf_render_field_wrap(
				array(
					'label'        => __( 'Style', 'mytravel' ),
					'instructions' => '',
					'type'         => 'button_group',
					'name'         => 'style',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['style'],
					'choices'      => array(
						'default'  => __( 'Standard (WP metabox)', 'mytravel' ),
						'seamless' => __( 'Seamless (no metabox)', 'mytravel' ),
					),
				)
			);


			// position
			acf_render_field_wrap(
				array(
					'label'         => __( 'Position', 'mytravel' ),
					'instructions'  => __( "'High' position not supported in the Block Editor", 'mytravel' ),
					'type'          => 'button_group',
					'name'          => 'position',
					'prefix'        => 'acf_field_group',
					'value'         => $field_group['position'],
					'choices'       => array(
						'acf_after_title' => __( 'High (after title)', 'mytravel' ),
						'normal'          => __( 'Normal (after content)', 'mytravel' ),
						'side'            => __( 'Side', 'mytravel' ),
					),
					'default_value' => 'normal',
				),
				'div',
				'field'
			);


			// label_placement
			acf_render_field_wrap(
				array(
					'label'        => __( 'Label Placement', 'mytravel' ),
					'instructions' => '',
					'type'         => 'button_group',
					'name'         => 'label_placement',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['label_placement'],
					'choices'      => array(
						'top'  => __( 'Top aligned', 'mytravel' ),
						'left' => __( 'Left aligned', 'mytravel' ),
					),
				)
			);


			// instruction_placement
			acf_render_field_wrap(
				array(
					'label'        => __( 'Instruction Placement', 'mytravel' ),
					'instructions' => '',
					'type'         => 'button_group',
					'name'         => 'instruction_placement',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['instruction_placement'],
					'choices'      => array(
						'label' => __( 'Below labels', 'mytravel' ),
						'field' => __( 'Below fields', 'mytravel' ),
					),
				)
			);


			// menu_order
			acf_render_field_wrap(
				array(
					'label'        => __( 'Order No.', 'mytravel' ),
					'instructions' => __( 'Field groups with a lower order will appear first', 'mytravel' ),
					'type'         => 'number',
					'name'         => 'menu_order',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['menu_order'],
				),
				'div',
				'field'
			);

			echo '</div>';
			echo '<div class="field-group-setting-split">';

			// hide on screen
			$choices = array(
				'permalink'       => __( 'Permalink', 'mytravel' ),
				'the_content'     => __( 'Content Editor', 'mytravel' ),
				'excerpt'         => __( 'Excerpt', 'mytravel' ),
				'custom_fields'   => __( 'Custom Fields', 'mytravel' ),
				'discussion'      => __( 'Discussion', 'mytravel' ),
				'comments'        => __( 'Comments', 'mytravel' ),
				'revisions'       => __( 'Revisions', 'mytravel' ),
				'slug'            => __( 'Slug', 'mytravel' ),
				'author'          => __( 'Author', 'mytravel' ),
				'format'          => __( 'Format', 'mytravel' ),
				'page_attributes' => __( 'Page Attributes', 'mytravel' ),
				'featured_image'  => __( 'Featured Image', 'mytravel' ),
				'categories'      => __( 'Categories', 'mytravel' ),
				'tags'            => __( 'Tags', 'mytravel' ),
				'send-trackbacks' => __( 'Send Trackbacks', 'mytravel' ),
			);
			if ( acf_get_setting( 'remove_wp_meta_box' ) ) {
				unset( $choices['custom_fields'] );
			}

			acf_render_field_wrap(
				array(
					'label'        => __( 'Hide on screen', 'mytravel' ),
					'instructions' => __( '<b>Select</b> items to <b>hide</b> them from the edit screen.', 'mytravel' ) . '<br /><br />' . __( "If multiple field groups appear on an edit screen, the first field group's options will be used (the one with the lowest order number)", 'mytravel' ),
					'type'         => 'checkbox',
					'name'         => 'hide_on_screen',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['hide_on_screen'],
					'toggle'       => true,
					'choices'      => $choices,
				),
				'div',
				'label',
				true
			);

			echo '</div>';
			echo '</div>';
			break;
		case 'group_settings':
			echo '<div class="field-group-settings field-group-settings-tab">';

			// active
			acf_render_field_wrap(
				array(
					'label'        => __( 'Active', 'mytravel' ),
					'instructions' => '',
					'type'         => 'true_false',
					'name'         => 'active',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['active'],
					'ui'           => 1,
				// 'ui_on_text'  => __('Active', 'mytravel'),
				// 'ui_off_text' => __('Inactive', 'mytravel'),
				)
			);

			// Show fields in REST API.
			if ( acf_get_setting( 'rest_api_enabled' ) ) {
				acf_render_field_wrap(
					array(
						'label'        => __( 'Show in REST API', 'mytravel' ),
						'instructions' => '',
						'type'         => 'true_false',
						'name'         => 'show_in_rest',
						'prefix'       => 'acf_field_group',
						'value'        => $field_group['show_in_rest'],
						'ui'           => 1,
					// 'ui_on_text'  => __('Active', 'mytravel'),
					// 'ui_off_text' => __('Inactive', 'mytravel'),
					)
				);
			}

			// description
			acf_render_field_wrap(
				array(
					'label'        => __( 'Description', 'mytravel' ),
					'instructions' => __( 'Shown in field group list', 'mytravel' ),
					'type'         => 'text',
					'name'         => 'description',
					'prefix'       => 'acf_field_group',
					'value'        => $field_group['description'],
				),
				'div',
				'field'
			);

			/* translators: 1: Post creation date 2: Post creation time */
			$acf_created_on = sprintf( __( 'Created on %1$s at %2$s', 'mytravel' ), get_the_date(), get_the_time() );
			?>
			<div class="acf-field-group-settings-footer">
				<span class="acf-created-on"><?php echo esc_html( $acf_created_on ); ?></span>
				<a href="<?php echo get_delete_post_link(); ?>" class="acf-btn acf-btn-tertiary  acf-delete-field-group">
					<i class="acf-icon acf-icon-trash"></i>
					<?php esc_html_e( 'Delete Field Group', 'mytravel' ); ?>
				</a>
			</div>
			<?php
			echo '</div>';
			break;
		default:
			echo '<div class="field-group-' . esc_attr( $tab_key ) . ' field-group-settings-tab">';
			do_action( 'acf/field_group/render_group_settings_tab/' . $tab_key, $field_group );
			echo '</div>';
			break;
	}
}

// 3rd party settings
do_action( 'acf/render_field_group_settings', $field_group );
?>

<div class="acf-hidden">
	<input type="hidden" name="acf_field_group[key]" value="<?php echo $field_group['key']; ?>" />
</div>
<script type="text/javascript">
if( typeof acf !== 'undefined' ) {

	acf.newPostbox({
		'id': 'acf-field-group-options',
		'label': 'top'
	});

}
</script>
