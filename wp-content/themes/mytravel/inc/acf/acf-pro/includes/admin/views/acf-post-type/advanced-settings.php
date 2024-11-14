<?php

global $acf_post_type;

foreach ( acf_get_combined_post_type_settings_tabs() as $tab_key => $tab_label ) {
	acf_render_field_wrap(
		array(
			'type'  => 'tab',
			'label' => $tab_label,
			'key'   => 'acf_post_type_tabs',
		)
	);

	$wrapper_class = str_replace( '_', '-', $tab_key );

	echo '<div class="acf-post-type-advanced-settings acf-post-type-' . esc_attr( $wrapper_class ) . '-settings">';

	switch ( $tab_key ) {
		case 'general':
			$acf_available_supports = array(
				'title'           => __( 'Title', 'mytravel' ),
				'author'          => __( 'Author', 'mytravel' ),
				'comments'        => __( 'Comments', 'mytravel' ),
				'trackbacks'      => __( 'Trackbacks', 'mytravel' ),
				'editor'          => __( 'Editor', 'mytravel' ),
				'excerpt'         => __( 'Excerpt', 'mytravel' ),
				'revisions'       => __( 'Revisions', 'mytravel' ),
				'page-attributes' => __( 'Page Attributes', 'mytravel' ),
				'thumbnail'       => __( 'Featured Image', 'mytravel' ),
				'custom-fields'   => __( 'Custom Fields', 'mytravel' ),
				'post-formats'    => __( 'Post Formats', 'mytravel' ),
			);
			$acf_available_supports = apply_filters( 'acf/post_type/available_supports', $acf_available_supports, $acf_post_type );
			$acf_selected_supports  = is_array( $acf_post_type['supports'] ) ? $acf_post_type['supports'] : array();

			acf_render_field_wrap(
				array(
					'type'                      => 'checkbox',
					'name'                      => 'supports',
					'key'                       => 'supports',
					'label'                     => __( 'Supports', 'mytravel' ),
					'instructions'              => __( 'Enable various features in the content editor.', 'mytravel' ),
					'prefix'                    => 'acf_post_type',
					'value'                     => array_unique( array_filter( $acf_selected_supports ) ),
					'choices'                   => $acf_available_supports,
					'allow_custom'              => true,
					'class'                     => 'acf_post_type_supports',
					'custom_choice_button_text' => __( 'Add Custom', 'mytravel' ),
				),
				'div'
			);

			acf_render_field_wrap( array( 'type' => 'seperator' ) );

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'description',
					'key'          => 'description',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['description'],
					'label'        => __( 'Description', 'mytravel' ),
					'instructions' => __( 'A descriptive summary of the post type.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap( array( 'type' => 'seperator' ) );

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'active',
					'key'          => 'active',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['active'],
					'label'        => __( 'Active', 'mytravel' ),
					'instructions' => __( 'Active post types are enabled and registered with WordPress.', 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			break;
		case 'labels':
			echo '<div class="acf-field acf-regenerate-labels-bar">';
			echo '<span class="acf-btn acf-btn-sm acf-btn-clear acf-regenerate-labels"><i class="acf-icon acf-icon-regenerate"></i>' . __( 'Regenerate', 'mytravel' ) . '</span>';
			echo '<span class="acf-btn acf-btn-sm acf-btn-clear acf-clear-labels"><i class="acf-icon acf-icon-trash"></i>' . __( 'Clear', 'mytravel' ) . '</span>';
			echo '<span class="acf-tip acf-labels-tip"><i class="acf-icon acf-icon-help acf-js-tooltip" title="' . esc_attr__( 'Regenerate all labels using the Singular and Plural labels', 'mytravel' ) . '"></i></span>';
			echo '</div>';

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'menu_name',
					'key'          => 'menu_name',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['menu_name'],
					'data'         => array(
						'label'   => '%s',
						'replace' => 'plural',
					),
					'label'        => __( 'Menu Name', 'mytravel' ),
					'instructions' => __( 'Admin menu name for the post type.', 'mytravel' ),
					'placeholder'  => __( 'Posts', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'all_items',
					'key'          => 'all_items',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['all_items'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'All %s', 'mytravel' ),
						'replace' => 'plural',
					),
					'label'        => __( 'All Items', 'mytravel' ),
					'instructions' => __( 'In the post type submenu in the admin dashboard.', 'mytravel' ),
					'placeholder'  => __( 'All Posts', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'edit_item',
					'key'          => 'edit_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['edit_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Edit %s', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Edit Item', 'mytravel' ),
					'instructions' => __( 'At the top of the editor screen when editing an item.', 'mytravel' ),
					'placeholder'  => __( 'Edit Post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'view_item',
					'key'          => 'view_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['view_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'View %s', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'View Item', 'mytravel' ),
					'instructions' => __( 'In the admin bar to view item when editing it.', 'mytravel' ),
					'placeholder'  => __( 'View Post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'view_items',
					'key'          => 'view_items',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['view_items'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( 'View %s', 'mytravel' ),
						'replace' => 'plural',
					),
					'label'        => __( 'View Items', 'mytravel' ),
					'instructions' => __( 'Appears in the admin bar in the \'All Posts\' view, provided the post type supports archives and the home page is not an archive of that post type.', 'mytravel' ),
					'placeholder'  => __( 'View Posts', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'add_new_item',
					'key'          => 'add_new_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['add_new_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Add New %s', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Add New Item', 'mytravel' ),
					'instructions' => __( 'At the top of the editor screen when adding a new item.', 'mytravel' ),
					'placeholder'  => __( 'Add New Post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'add_new',
					'key'          => 'add_new',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['add_new'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Add New %s', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Add New', 'mytravel' ),
					'instructions' => __( 'In the post type submenu in the admin dashboard.', 'mytravel' ),
					'placeholder'  => __( 'Add New Post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'new_item',
					'key'          => 'new_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['new_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'New %s', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'New Item', 'mytravel' ),
					'instructions' => __( 'In the post type submenu in the admin dashboard.', 'mytravel' ),
					'placeholder'  => __( 'New Post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'parent_item_colon',
					'key'          => 'parent_item_colon',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['parent_item_colon'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Parent %s:', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Parent Item Prefix', 'mytravel' ),
					'instructions' => __( 'For hierarchical types in the post type list screen.', 'mytravel' ),
					'placeholder'  => __( 'Parent Page:', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'search_items',
					'key'          => 'search_items',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['search_items'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( 'Search %s', 'mytravel' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Search Items', 'mytravel' ),
					'instructions' => __( 'At the top of the items screen when searching for an item.', 'mytravel' ),
					'placeholder'  => __( 'Search Posts', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'not_found',
					'key'          => 'not_found',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['not_found'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'     => __( 'No %s found', 'mytravel' ),
						'replace'   => 'plural',
						'transform' => 'lower',
					),
					'label'        => __( 'No Items Found', 'mytravel' ),
					'instructions' => __( 'At the top of the post type list screen when there are no posts to display.', 'mytravel' ),
					'placeholder'  => __( 'No posts found', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'not_found_in_trash',
					'key'          => 'not_found_in_trash',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['not_found_in_trash'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'     => __( 'No %s found in Trash', 'mytravel' ),
						'replace'   => 'plural',
						'transform' => 'lower',
					),
					'label'        => __( 'No Items Found in Trash', 'mytravel' ),
					'instructions' => __( 'At the top of the post type list screen when there are no posts in the trash.', 'mytravel' ),
					'placeholder'  => __( 'No posts found in Trash', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'archives',
					'key'          => 'archives',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['archives'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s Archives', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Archives Nav Menu', 'mytravel' ),
					'instructions' => __( "Adds 'Post Type Archive' items with this label to the list of posts shown when adding items to an existing menu in a CPT with archives enabled. Only appears when editing menus in 'Live Preview' mode and a custom archive slug has been provided.", 'mytravel' ),
					'placeholder'  => __( 'Post Archives', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'attributes',
					'key'          => 'attributes',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['attributes'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s Attributes', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Attributes Meta Box', 'mytravel' ),
					'instructions' => __( 'In the editor used for the title of the post attributes meta box.', 'mytravel' ),
					'placeholder'  => __( 'Post Attributes', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'featured_image',
					'key'          => 'featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['featured_image'],
					'label'        => __( 'Featured Image Meta Box', 'mytravel' ),
					'instructions' => __( 'In the editor used for the title of the featured image meta box.', 'mytravel' ),
					'placeholder'  => __( 'Featured image', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'set_featured_image',
					'key'          => 'set_featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['set_featured_image'],
					'label'        => __( 'Set Featured Image', 'mytravel' ),
					'instructions' => __( 'As the button label when setting the featured image.', 'mytravel' ),
					'placeholder'  => __( 'Set featured image', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'remove_featured_image',
					'key'          => 'remove_featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['remove_featured_image'],
					'label'        => __( 'Remove Featured Image', 'mytravel' ),
					'instructions' => __( 'As the button label when removing the featured image.', 'mytravel' ),
					'placeholder'  => __( 'Remove featured image', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'use_featured_image',
					'key'          => 'use_featured_image',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['use_featured_image'],
					'label'        => __( 'Use Featured Image', 'mytravel' ),
					'instructions' => __( 'As the button label for selecting to use an image as the featured image.', 'mytravel' ),
					'placeholder'  => __( 'Use as featured image', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'insert_into_item',
					'key'          => 'insert_into_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['insert_into_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( 'Insert into %s', 'mytravel' ),
						'replace'   => 'singular',
						'transform' => 'lower',
					),
					'label'        => __( 'Insert Into Media Button', 'mytravel' ),
					'instructions' => __( 'As the button label when adding media to content.', 'mytravel' ),
					'placeholder'  => __( 'Insert into post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'uploaded_to_this_item',
					'key'          => 'uploaded_to_this_item',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['uploaded_to_this_item'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( 'Uploaded to this %s', 'mytravel' ),
						'replace'   => 'singular',
						'transform' => 'lower',
					),
					'label'        => __( 'Uploaded To This Item', 'mytravel' ),
					'instructions' => __( 'In the media modal showing all media uploaded to this item.', 'mytravel' ),
					'placeholder'  => __( 'Uploaded to this post', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'filter_items_list',
					'key'          => 'filter_items_list',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['filter_items_list'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'     => __( 'Filter %s list', 'mytravel' ),
						'replace'   => 'plural',
						'transform' => 'lower',
					),
					'label'        => __( 'Filter Items List', 'mytravel' ),
					'instructions' => __( 'Used by screen readers for the filter links heading on the post type list screen.', 'mytravel' ),
					'placeholder'  => __( 'Filter posts list', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'filter_by_date',
					'key'          => 'filter_by_date',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['filter_by_date'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'     => __( 'Filter %s by date', 'mytravel' ),
						'replace'   => 'plural',
						'transform' => 'lower',
					),
					'label'        => __( 'Filter Items By Date', 'mytravel' ),
					'instructions' => __( 'Used by screen readers for the filter by date heading on the post type list screen.', 'mytravel' ),
					'placeholder'  => __( 'Filter posts by date', 'mytravel' ),
				),
				'div',
				'field'
			);


			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'items_list_navigation',
					'key'          => 'items_list_navigation',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['items_list_navigation'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( '%s list navigation', 'mytravel' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Items List Navigation', 'mytravel' ),
					'instructions' => __( 'Used by screen readers for the filter list pagination on the post type list screen.', 'mytravel' ),
					'placeholder'  => __( 'Posts list navigation', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'items_list',
					'key'          => 'items_list',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['items_list'],
					'data'         => array(
						/* translators: %s Plural form of post type name */
						'label'   => __( '%s list', 'mytravel' ),
						'replace' => 'plural',
					),
					'label'        => __( 'Items List', 'mytravel' ),
					'instructions' => __( 'Used by screen readers for the items list on the post type list screen.', 'mytravel' ),
					'placeholder'  => __( 'Posts list', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_published',
					'key'          => 'item_published',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_published'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s published.', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Published', 'mytravel' ),
					'instructions' => __( 'In the editor notice after publishing an item.', 'mytravel' ),
					'placeholder'  => __( 'Post published.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_published_privately',
					'key'          => 'item_published_privately',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_published_privately'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s published privately.', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Published Privately', 'mytravel' ),
					'instructions' => __( 'In the editor notice after publishing a private item.', 'mytravel' ),
					'placeholder'  => __( 'Post published privately.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_reverted_to_draft',
					'key'          => 'item_reverted_to_draft',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_reverted_to_draft'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s reverted to draft.', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Reverted To Draft', 'mytravel' ),
					'instructions' => __( 'In the editor notice after reverting an item to draft.', 'mytravel' ),
					'placeholder'  => __( 'Post reverted to draft.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_scheduled',
					'key'          => 'item_scheduled',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_scheduled'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s scheduled.', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Scheduled', 'mytravel' ),
					'instructions' => __( 'In the editor notice after scheduling an item.', 'mytravel' ),
					'placeholder'  => __( 'Post scheduled.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_updated',
					'key'          => 'item_updated',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_updated'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s updated.', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Updated', 'mytravel' ),
					'instructions' => __( 'In the editor notice after an item is updated.', 'mytravel' ),
					'placeholder'  => __( 'Post updated.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_link',
					'key'          => 'item_link',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_link'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'   => __( '%s Link', 'mytravel' ),
						'replace' => 'singular',
					),
					'label'        => __( 'Item Link', 'mytravel' ),
					'instructions' => __( 'Title for a navigation link block variation.', 'mytravel' ),
					'placeholder'  => __( 'Post Link', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'item_link_description',
					'key'          => 'item_link_description',
					'prefix'       => 'acf_post_type[labels]',
					'value'        => $acf_post_type['labels']['item_link_description'],
					'data'         => array(
						/* translators: %s Singular form of post type name */
						'label'     => __( 'A link to a %s.', 'mytravel' ),
						'replace'   => 'singular',
						'transform' => 'lower',
					),
					'label'        => __( 'Item Link Description', 'mytravel' ),
					'instructions' => __( 'Description for a navigation link block variation.', 'mytravel' ),
					'placeholder'  => __( 'A link to a post.', 'mytravel' ),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'enter_title_here',
					'key'          => 'enter_title_here',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['enter_title_here'],
					'label'        => __( 'Title Placeholder', 'mytravel' ),
					'instructions' => __( 'In the editor used as the placeholder of the title.', 'mytravel' ),
					'placeholder'  => __( 'Add title', 'mytravel' ),
				),
				'div',
				'field'
			);

			break;
		case 'visibility':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_ui',
					'key'          => 'show_ui',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_ui'],
					'label'        => __( 'Show In UI', 'mytravel' ),
					'instructions' => __( 'Items can be edited and managed in the admin dashboard.', 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_menu',
					'key'          => 'show_in_menu',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_menu'],
					'label'        => __( 'Show In Admin Menu', 'mytravel' ),
					'instructions' => __( 'Admin editor navigation in the sidebar menu.', 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'show_ui',
						'operator' => '==',
						'value'    => 1,
					),
				)
			);

			$acf_dashicon_class_name = __( 'Dashicon class name', 'mytravel' );
			$acf_dashicon_link       = '<a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">' . $acf_dashicon_class_name . '</a>';

			$acf_menu_icon_instructions = sprintf(
				/* translators: %s = "dashicon class name", link to the WordPress dashicon documentation. */
				__( 'The icon used for the post type menu item in the admin dashboard. Can be a URL or %s to use for the icon.', 'mytravel' ),
				$acf_dashicon_link
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'admin_menu_parent',
					'key'          => 'admin_menu_parent',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['admin_menu_parent'],
					'placeholder'  => 'edit.php?post_type={parent_page}',
					'label'        => __( 'Admin Menu Parent', 'mytravel' ),
					'instructions' => __( 'By default the post type will get a new top level item in the admin menu. If an existing top level item is supplied here, the post type will be added as a submenu item under it.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'show_in_menu',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'number',
					'name'         => 'menu_position',
					'key'          => 'menu_position',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['menu_position'],
					'label'        => __( 'Menu Position', 'mytravel' ),
					'instructions' => __( 'The position in the sidebar menu in the admin dashboard.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'show_in_menu',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'menu_icon',
					'key'          => 'menu_icon',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['menu_icon'],
					'label'        => __( 'Menu Icon', 'mytravel' ),
					'placeholder'  => 'dashicons-admin-post',
					'instructions' => $acf_menu_icon_instructions,
					'conditions'   => array(
						'field'    => 'show_in_menu',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'register_meta_box_cb',
					'key'          => 'register_meta_box_cb',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['register_meta_box_cb'],
					'label'        => __( 'Custom Meta Box Callback', 'mytravel' ),
					'instructions' => __( 'A PHP function name to be called when setting up the meta boxes for the edit screen.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'show_ui',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'       => 'seperator',
					'conditions' => array(
						'field'    => 'show_ui',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_admin_bar',
					'key'          => 'show_in_admin_bar',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_admin_bar'],
					'label'        => __( 'Show In Admin Bar', 'mytravel' ),
					'instructions' => __( "Appears as an item in the 'New' menu in the admin bar.", 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'show_ui',
						'operator' => '==',
						'value'    => 1,
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_nav_menus',
					'key'          => 'show_in_nav_menus',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_nav_menus'],
					'label'        => __( 'Appearance Menus Support', 'mytravel' ),
					'instructions' => __( "Allow items to be added to menus in the 'Appearance' > 'Menus' screen. Must be turned on in 'Screen options'.", 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'exclude_from_search',
					'key'          => 'exclude_from_search',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['exclude_from_search'],
					'label'        => __( 'Exclude From Search', 'mytravel' ),
					'instructions' => __( 'Sets whether posts should be excluded from search results and taxonomy archive pages.', 'mytravel' ),
					'ui'           => true,
				)
			);

			break;
		case 'permissions':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'rename_capabilities',
					'key'          => 'rename_capabilities',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rename_capabilities'],
					'label'        => __( 'Rename Capabilities', 'mytravel' ),
					'instructions' => __( "By default the capabilities of the post type will inherit the 'Post' capability names, eg. edit_post, delete_posts. Enable to use post type specific capabilities, eg. edit_{singular}, delete_{plural}.", 'mytravel' ),
					'default'      => false,
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'singular_capability_name',
					'key'          => 'singular_capability_name',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['singular_capability_name'],
					'label'        => __( 'Singular Capability Name', 'mytravel' ),
					'instructions' => __( 'Choose another post type to base the capabilities for this post type.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'rename_capabilities',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'plural_capability_name',
					'key'          => 'plural_capability_name',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['plural_capability_name'],
					'label'        => __( 'Plural Capability Name', 'mytravel' ),
					'instructions' => __( 'Optionally provide a plural to be used in capabilities.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'rename_capabilities',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'       => 'seperator',
					'conditions' => array(
						'field'    => 'rename_capabilities',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'can_export',
					'key'          => 'can_export',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['can_export'],
					'label'        => __( 'Can Export', 'mytravel' ),
					'instructions' => __( "Allow the post type to be exported from 'Tools' > 'Export'.", 'mytravel' ),
					'default'      => 1,
					'ui'           => 1,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'delete_with_user',
					'key'          => 'delete_with_user',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['delete_with_user'],
					'label'        => __( 'Delete With User', 'mytravel' ),
					'instructions' => __( 'Delete items by a user when that user is deleted.', 'mytravel' ),
					'ui'           => 1,
				),
				'div'
			);
			break;
		case 'urls':
			acf_render_field_wrap(
				array(
					'type'         => 'select',
					'name'         => 'permalink_rewrite',
					'key'          => 'permalink_rewrite',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => isset( $acf_post_type['rewrite']['permalink_rewrite'] ) ? $acf_post_type['rewrite']['permalink_rewrite'] : 'post_type_key',
					'label'        => __( 'Permalink Rewrite', 'mytravel' ),
					/* translators: this string will be appended with the new permalink structure. */
					'instructions' => __( 'Rewrite the URL using the post type key as the slug. Your permalink structure will be', 'mytravel' ) . ' {slug}.',
					'choices'      => array(
						'post_type_key'    => __( 'Post Type Key', 'mytravel' ),
						'custom_permalink' => __( 'Custom Permalink', 'mytravel' ),
						'no_permalink'     => __( 'No Permalink (prevent URL rewriting)', 'mytravel' ),
					),
					'default'      => 'post_type_key',
					'hide_search'  => true,
					'data'         => array(
						/* translators: this string will be appended with the new permalink structure. */
						'post_type_key_instructions'    => __( 'Rewrite the URL using the post type key as the slug. Your permalink structure will be', 'mytravel' ) . ' {slug}.',
						/* translators: this string will be appended with the new permalink structure. */
						'custom_permalink_instructions' => __( 'Rewrite the URL using a custom slug defined in the input below. Your permalink structure will be', 'mytravel' ) . ' {slug}.',
						'no_permalink_instructions'     => __( 'Permalinks for this post type are disabled.', 'mytravel' ),
						'site_url'                      => get_site_url(),
					),
					'class'        => 'permalink_rewrite',
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'slug',
					'key'          => 'slug',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => isset( $acf_post_type['rewrite']['slug'] ) ? $acf_post_type['rewrite']['slug'] : '',
					'label'        => __( 'URL Slug', 'mytravel' ),
					'instructions' => __( 'Customize the slug used in the URL.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'permalink_rewrite',
						'operator' => '==',
						'value'    => 'custom_permalink',
					),
					'class'        => 'rewrite_slug_field',
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'with_front',
					'key'          => 'with_front',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => isset( $acf_post_type['rewrite']['with_front'] ) ? $acf_post_type['rewrite']['with_front'] : true,
					'label'        => __( 'Front URL Prefix', 'mytravel' ),
					'instructions' => __( 'Alters the permalink structure to add the `WP_Rewrite::$front` prefix to URLs.', 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'permalink_rewrite',
						'operator' => '!=',
						'value'    => 'no_permalink',
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'feeds',
					'key'          => 'feeds',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => isset( $acf_post_type['rewrite']['feeds'] ) ? $acf_post_type['rewrite']['feeds'] : $acf_post_type['has_archive'],
					'label'        => __( 'Feed URL', 'mytravel' ),
					'instructions' => __( 'RSS feed URL for the post type items.', 'mytravel' ),
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'permalink_rewrite',
						'operator' => '!=',
						'value'    => 'no_permalink',
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'pages',
					'key'          => 'pages',
					'prefix'       => 'acf_post_type[rewrite]',
					'value'        => isset( $acf_post_type['rewrite']['pages'] ) ? $acf_post_type['rewrite']['pages'] : true,
					'label'        => __( 'Pagination', 'mytravel' ),
					'instructions' => __( 'Pagination support for the items URLs such as the archives.', 'mytravel' ),
					'ui'           => true,
					'default'      => 1,
					'conditions'   => array(
						'field'    => 'permalink_rewrite',
						'operator' => '!=',
						'value'    => 'no_permalink',
					),
				)
			);

			acf_render_field_wrap( array( 'type' => 'seperator' ) );

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'has_archive',
					'key'          => 'has_archive',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['has_archive'],
					'label'        => __( 'Archive', 'mytravel' ),
					'instructions' => __( 'Has an item archive that can be customized with an archive template file in your theme.', 'mytravel' ),
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'has_archive_slug',
					'key'          => 'has_archive_slug',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['has_archive_slug'],
					'label'        => __( 'Archive Slug', 'mytravel' ),
					'instructions' => __( 'Custom slug for the Archive URL.', 'mytravel' ),
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'has_archive',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap( array( 'type' => 'seperator' ) );

			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'publicly_queryable',
					'key'          => 'publicly_queryable',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['publicly_queryable'],
					'label'        => __( 'Publicly Queryable', 'mytravel' ),
					'instructions' => __( 'URLs for an item and items can be accessed with a query string.', 'mytravel' ),
					'default'      => 1,
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'       => 'seperator',
					'conditions' => array(
						'field'    => 'publicly_queryable',
						'operator' => '==',
						'value'    => 1,
					),
				)
			);

			acf_render_field_wrap(
				array(
					'type'         => 'select',
					'name'         => 'query_var',
					'key'          => 'query_var',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['query_var'],
					'label'        => __( 'Query Variable Support', 'mytravel' ),
					'instructions' => __( 'Items can be accessed using the non-pretty permalink, eg. {post_type}={post_slug}.', 'mytravel' ),
					'choices'      => array(
						'post_type_key'    => __( 'Post Type Key', 'mytravel' ),
						'custom_query_var' => __( 'Custom Query Variable', 'mytravel' ),
						'none'             => __( 'No Query Variable Support', 'mytravel' ),
					),
					'default'      => 1,
					'hide_search'  => true,
					'class'        => 'query_var',
					'conditions'   => array(
						'field'    => 'publicly_queryable',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'query_var_name',
					'key'          => 'query_var_name',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['query_var_name'],
					'label'        => __( 'Query Variable', 'mytravel' ),
					'instructions' => __( 'Customize the query variable name.', 'mytravel' ),
					'ui'           => true,
					'conditions'   => array(
						'field'    => 'query_var',
						'operator' => '==',
						'value'    => 'custom_query_var',
					),
				),
				'div',
				'field'
			);

			break;
		case 'rest_api':
			acf_render_field_wrap(
				array(
					'type'         => 'true_false',
					'name'         => 'show_in_rest',
					'key'          => 'show_in_rest',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['show_in_rest'],
					'label'        => __( 'Show In REST API', 'mytravel' ),
					'instructions' => __( 'Exposes this post type in the REST API. Required to use the block editor.', 'mytravel' ),
					'default'      => 1,
					'ui'           => true,
				),
				'div'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'rest_base',
					'key'          => 'rest_base',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rest_base'],
					'label'        => __( 'Base URL', 'mytravel' ),
					'instructions' => __( 'The base URL for the post type REST API URLs.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'show_in_rest',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'rest_namespace',
					'key'          => 'rest_namespace',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rest_namespace'],
					'label'        => __( 'Namespace Route', 'mytravel' ),
					'instructions' => __( 'The namespace part of the REST API URL.', 'mytravel' ),
					'conditions'   => array(
						'field'    => 'show_in_rest',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);

			acf_render_field_wrap(
				array(
					'type'         => 'text',
					'name'         => 'rest_controller_class',
					'key'          => 'rest_controller_class',
					'prefix'       => 'acf_post_type',
					'value'        => $acf_post_type['rest_controller_class'],
					'label'        => __( 'Controller Class', 'mytravel' ),
					'instructions' => __( 'Optional custom controller to use instead of `WP_REST_Posts_Controller`.', 'mytravel' ),
					'default'      => 'WP_REST_Posts_Controller',
					'conditions'   => array(
						'field'    => 'show_in_rest',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'div',
				'field'
			);
			break;
	}

	do_action( "acf/post_type/render_settings_tab/{$tab_key}", $acf_post_type );

	echo '</div>';
}
