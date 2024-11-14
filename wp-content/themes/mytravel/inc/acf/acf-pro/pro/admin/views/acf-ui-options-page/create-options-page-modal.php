<form id="acf-create-options-page-form">
	<?php

	$acf_options_page_prefilled_title = '';

	if ( ! empty( $field_group_title ) ) {
		$acf_options_page_prefilled_title = (string) apply_filters( 'acf/options_page_modal/prefill_title', '%s' );
		$acf_options_page_prefilled_title = sprintf(
			$acf_options_page_prefilled_title,
			$field_group_title
		);
	}

	acf_render_field_wrap(
		array(
			'label'       => __( 'Page Title', 'mytravel' ),
			/* translators: example options page name */
			'placeholder' => __( 'Site Settings', 'mytravel' ),
			'value'       => $acf_options_page_prefilled_title,
			'type'        => 'text',
			'name'        => 'page_title',
			'key'         => 'page_title',
			'class'       => 'acf_options_page_title acf_slugify_to_key',
			'prefix'      => 'acf_ui_options_page',
			'required'    => true,
		),
		'div',
		'field'
	);

	acf_render_field_wrap(
		array(
			'label'    => __( 'Menu Slug', 'mytravel' ),
			'type'     => 'text',
			'name'     => 'menu_slug',
			'key'      => 'menu_slug',
			'class'    => 'acf-options-page-menu_slug acf_slugified_key',
			'prefix'   => 'acf_ui_options_page',
			'required' => true,
		),
		'div',
		'field'
	);

	acf_render_field_wrap(
		array(
			'label'    => __( 'Parent Page', 'mytravel' ),
			'type'     => 'select',
			'name'     => 'parent_slug',
			'key'      => 'parent_slug',
			'class'    => 'acf-options-page-parent_slug',
			'prefix'   => 'acf_ui_options_page',
			'choices'  => $acf_parent_page_choices,
			'required' => true,
		),
		'div',
		'field'
	);
	?>

	<div class="acf-actions">
		<button type="button" class="acf-btn acf-btn-secondary acf-close-popup"><?php esc_html_e( 'Cancel', 'mytravel' ); ?></button>
		<button type="submit" class="acf-btn acf-btn-primary"><?php esc_html_e( 'Done', 'mytravel' ); ?></button>
	</div>

</form>
