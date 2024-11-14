<?php
/**
 * Mytravel hooks
 *
 * @package mytravel
 */

/**
 * General
 *
 * @see  storefront_header_widget_region()
 * @see  storefront_get_sidebar()
 */
add_action( 'wp_head', 'mytravel_pingback_header' );
add_filter( 'wp_kses_allowed_html', 'mytravel_kses_allowed_html', 10, 2 );

/**
 * Header
 *
 * @see  storefront_skip_links()
 * @see  storefront_secondary_navigation()
 * @see  storefront_site_branding()
 * @see  storefront_primary_navigation()
 */

// Header Variation.
add_action( 'mytravel_before_header', 'mytravel_get_header_style', 10 );

// Header v1.
add_action( 'mytravel_header_v1_top', 'mytravel_top_navbar_starts', 10 );
add_action( 'mytravel_header_v1_top', 'mytravel_top_navbar_left', 20 );
add_action( 'mytravel_header_v1_top', 'mytravel_top_navbar_right', 30 );
add_action( 'mytravel_header_v1_top', 'mytravel_top_navbar_end', 40 );
add_action( 'mytravel_header_v1', 'mytravel_navbar_my_account_responsive', 10 );
add_action( 'mytravel_header_v1', 'mytravel_site_branding', 20 );
add_action( 'mytravel_header_v1', 'mytravel_navbar_search', 30 );
add_action( 'mytravel_header_v1', 'mytravel_responsive_toggler', 40 );
add_action( 'mytravel_header_v1', 'mytravel_header_primary_menu', 50 );
add_action( 'mytravel_header_v1', 'mytravel_navbar_mini_cart', 60 );
add_action( 'mytravel_header_v1', 'mytravel_navbar_button', 70 );

add_action( 'storefront_header', 'storefront_site_branding', 20 );
add_action( 'storefront_header', 'storefront_secondary_navigation', 30 );
add_action( 'storefront_header', 'storefront_header_container_close', 41 );
add_action( 'storefront_header', 'storefront_primary_navigation_wrapper', 42 );
add_action( 'storefront_header', 'storefront_primary_navigation', 50 );
add_action( 'storefront_header', 'storefront_primary_navigation_wrapper_close', 68 );

// Header v2.
add_action( 'mytravel_header_v2', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v2', 'mytravel_responsive_toggler', 20 );
add_action( 'mytravel_header_v2', 'mytravel_header_primary_menu', 30 );
add_action( 'mytravel_header_v2', 'mytravel_navbar_mini_cart', 40 );
add_action( 'mytravel_header_v2', 'mytravel_header_navbar_account', 50 );
add_action( 'mytravel_header_v2', 'mytravel_navbar_button', 60 );

// Header v3.
add_action( 'mytravel_header_v3_top', 'mytravel_header_v3_top_navbar_starts', 10 );
add_action( 'mytravel_header_v3_top', 'mytravel_header_v3_top_navbar_end', 20 );
add_action( 'mytravel_header_v3', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v3', 'mytravel_responsive_toggler', 20 );
add_action( 'mytravel_header_v3', 'mytravel_header_primary_menu', 30 );
add_action( 'mytravel_header_v3', 'mytravel_navbar_mini_cart', 40 );

// Header v4.
add_action( 'mytravel_header_v4_top', 'mytravel_top_navbar_starts', 10 );
add_action( 'mytravel_header_v4_top', 'mytravel_top_navbar_left', 20 );
add_action( 'mytravel_header_v4_top', 'mytravel_top_navbar_right', 30 );
add_action( 'mytravel_header_v4_top', 'mytravel_top_navbar_end', 40 );
add_action( 'mytravel_header_v4', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v4', 'mytravel_responsive_toggler', 20 );
add_action( 'mytravel_header_v4', 'mytravel_header_primary_menu', 30 );
add_action( 'mytravel_header_v4', 'mytravel_search_dropdown', 40 );
add_action( 'mytravel_header_v4', 'mytravel_navbar_mini_cart', 40 );
add_action( 'mytravel_header_v4', 'mytravel_navbar_button', 60 );

// Header v5.
add_action( 'mytravel_header_v5', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v5', 'mytravel_navbar_search', 20 );
add_action( 'mytravel_header_v5', 'mytravel_responsive_toggler', 30 );
add_action( 'mytravel_header_v5', 'mytravel_header_primary_menu', 40 );
add_action( 'mytravel_header_v5', 'mytravel_navbar_mini_cart', 50 );
add_action( 'mytravel_header_v5', 'mytravel_header_navbar_account', 60 );

// Header v7.
add_action( 'mytravel_header_v6', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v6', 'mytravel_responsive_toggler', 30 );
add_action( 'mytravel_header_v6', 'mytravel_header_primary_menu', 40 );
add_action( 'mytravel_header_v6', 'mytravel_header_navbar_account', 50 );
add_action( 'mytravel_header_v6', 'mytravel_navbar_mini_cart', 60 );
add_action( 'mytravel_header_v6', 'mytravel_navbar_button', 70 );

// Header v7.
add_action( 'mytravel_header_v7', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v7', 'mytravel_responsive_toggler', 20 );
add_action( 'mytravel_header_v7', 'mytravel_header_primary_menu', 30 );
add_action( 'mytravel_header_v7', 'mytravel_search_dropdown', 40 );
add_action( 'mytravel_header_v7', 'mytravel_navbar_mini_cart', 50 );
add_action( 'mytravel_header_v7', 'mytravel_header_navbar_account', 60 );

// Shop page header.
add_action( 'mytravel_header_v8_top_bar', 'mytravel_top_navbar_left', 10 );
add_action( 'mytravel_header_v8_top_bar', 'mytravel_top_navbar_right', 20 );
add_action( 'mytravel_header_v8', 'mytravel_site_branding', 10 );
add_action( 'mytravel_header_v8', 'mytravel_navbar_search', 20 );
add_action( 'mytravel_header_v8', 'mytravel_responsive_toggler', 30 );
add_action( 'mytravel_header_v8', 'mytravel_header_primary_menu', 40 );
add_action( 'mytravel_header_v8', 'mytravel_navbar_mini_cart', 50 );
add_action( 'mytravel_header_v8', 'mytravel_navbar_button', 60 );

/**
 * Footer
 *
 * @see  mytravel_footer_widgets()
 * @see  mytravel_credit()
 */
add_action( 'mytravel_footer_v1', 'mytravel_credit', 20 );

add_action( 'mytravel_after_footer', 'mytravel_scroll_to_top', 10 );

// Footer v2.
add_action( 'mytravel_footer_v2', 'mytravel_footer_content', 10 );
add_action( 'mytravel_footer_v2', 'mytravel_site_info', 20 );
add_action( 'mytravel_footer_v2', 'mytravel_credit', 30 );

add_action( 'mytravel_site_info_right', 'mytravel_credit_card_img', 10 );
add_action( 'mytravel_after_footer', 'mytravel_scroll_to_top', 10 );

// Static Footer
add_action( 'mytravel_static_footer', 'mytravel_footer_static', 10 );
/**
 * Nav Menu Widget Handle Custom Fields
 */
add_filter( 'in_widget_form', 'mytravel_custom_widget_nav_menu_options', 10, 3 );
add_filter( 'widget_update_callback', 'mytravel_custom_widget_nav_menu_options_update', 10, 4 );
add_filter( 'widget_nav_menu_args', 'mytravel_custom_widget_nav_menu_args', 20, 4 );


/**
 * Homepage
 *
 * @see  storefront_homepage_content()
 */
add_action( 'homepage', 'storefront_homepage_content', 10 );

/**
 * Pages
 *
 * @see  storefront_page_header()
 * @see  storefront_page_content()
 * @see  storefront_display_comments()
 */
add_action( 'mytravel_page_before', 'mytravel_page_header', 10 );
add_action( 'mytravel_page', 'mytravel_page_content', 20 );
add_action( 'mytravel_page_after', 'mytravel_display_comments', 30 );

/**
 * Posts loop (WordPress home, posts listing)
 */
add_filter( 'excerpt_more', 'mytravel_excerpt_more', 10 );
add_filter( 'the_excerpt', 'mytravel_the_excerpt', 20 );
add_action( 'mytravel_loop_before', 'mytravel_archive_header', 50 );
add_action( 'mytravel_loop_after', 'mytravel_paging_nav', 20 );
add_filter( 'the_password_form', 'mytravel_post_protected_password_form' );


/**
 * Posts
 */
add_action( 'mytravel_loop_post', 'mytravel_loop_post_thumbnail', 10 );
add_action( 'mytravel_loop_post', 'mytravel_loop_post_title', 20 );
add_action( 'mytravel_loop_post', 'mytravel_loop_post_meta', 30 );
add_action( 'mytravel_loop_post', 'mytravel_loop_post_excerpt', 40 );

/**
 * Post Grid
 */
add_action( 'mytravel_loop_post_grid', 'mytravel_loop_post_grid_thumbnail', 10 );
add_action( 'mytravel_loop_post_grid', 'mytravel_loop_post_grid_title', 20 );
add_action( 'mytravel_loop_post_grid', 'mytravel_loop_post_grid_meta', 30 );

/**
 * Post List
 */
add_action( 'mytravel_loop_post_list', 'mytravel_loop_post_list_thumbnail_wrap', 10 );
add_action( 'mytravel_loop_post_list', 'mytravel_loop_post_list_content_wrap_start', 20 );
add_action( 'mytravel_loop_post_list', 'mytravel_loop_post_list_title', 30 );
add_action( 'mytravel_loop_post_list', 'mytravel_loop_post_excerpt', 40 );
add_action( 'mytravel_loop_post_list', 'mytravel_loop_post_list_content_wrap_end', 50 );

/**
 * Single post
 */
add_action( 'mytravel_single_post_before', 'mytravel_single_post_header', 10 );
add_action( 'mytravel_single_post_before', 'mytravel_single_post_container_start', 20 );
add_action( 'mytravel_single_post_before', 'mytravel_single_post_row_start', 30 );

add_action( 'mytravel_single_post', 'mytravel_single_post_media', 10 );
add_action( 'mytravel_single_post', 'mytravel_single_post_content', 40 );
add_action( 'mytravel_single_post', 'mytravel_post_navigation', 50 );
add_action( 'mytravel_single_post', 'mytravel_display_comments', 60 );
add_action( 'mytravel_single_post_after', 'mytravel_single_post_sidebar', 10 );
add_action( 'mytravel_single_post_after', 'mytravel_single_post_row_end', 20 );
add_action( 'mytravel_single_post_after', 'mytravel_single_post_container_end', 30 );

/**
 * Comments
 */
add_filter( 'comment_reply_link', 'mytravel_comment_reply_link', 20, 2 );
add_filter( 'comment_form_default_fields', 'mytravel_comment_form_default_fields', 20 );
