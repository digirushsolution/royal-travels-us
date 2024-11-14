<?php
/**
 * Template hooks used in Product Archive page: archive-product.php
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_main_content', 'mytravel_toggle_page_header', 10 );

add_action( 'woocommerce_before_main_content', 'mytravel_output_archive_wrapper', 40 );

add_action( 'woocommerce_sidebar', 'mytravel_output_sidebar_wrapper', 9 );
add_action( 'woocommerce_sidebar', 'mytravel_output_sidebar_wrapper_end', 11 );

add_action( 'woocommerce_sidebar', 'mytravel_output_archive_wrapper_end', 20 );

add_action( 'woocommerce_before_shop_loop', 'mytravel_shop_control_bar', 20 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_filter( 'woocommerce_product_loop_start', 'mytravel_wc_product_loop_start', 10 );

add_action( 'mytravel_fullwidth_controls', 'woocommerce_catalog_ordering', 10 );

add_action( 'mytravel_fullwidth_controls', 'mytravel_wc_product_filter_sidebar_toggle', 20 );

add_action( 'mytravel_shop_control_bar_title', 'mytravel_wc_product_page_title', 10 );

