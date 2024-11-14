<?php
/**
 * Hooks for content-product.php
 */

add_action( 'woocommerce_before_shop_loop_item', 'mytravel_output_card_wrapper', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'mytravel_output_card_wrapper_end', 99 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_output_card_header_wrapper', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_wc_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_wc_template_loop_hotel_display_location', 20 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_template_loop_categories_wrap', 20 );

add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_output_card_header_wrapper_end', 90 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_output_card_body_wrapper', 95 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_wc_template_loop_star_rating', 99 );

add_action( 'woocommerce_shop_loop_item_title', 'mytravel_wc_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'mytravel_wc_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'mytravel_wc_template_loop_product_price_wrap', 9 );
add_action( 'woocommerce_after_shop_loop_item_title', 'mytravel_wc_template_loop_product_price_wrap_end', 11 );

add_action( 'woocommerce_after_shop_loop_item', 'mytravel_output_card_body_wrapper_end', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'mytravel_loop_badges', 'mytravel_wc_template_loop_featured_badge', 10 );
add_action( 'mytravel_loop_badges', 'mytravel_wc_template_loop_onsale_badge', 20 );

add_action( 'woocommerce_after_shop_loop', 'mytravel_wc_results_count', 5 );

add_filter( 'woocommerce_add_to_cart_fragments', 'mytravel_cart_link_fragment', 10 );

add_filter( 'woocommerce_layered_nav_term_html', 'mytravel_wc_layered_nav_term_html', 10, 4 );
add_filter( 'woocommerce_product_query_meta_query', 'show_only_products_with_gold_star_rating', 10, 2 );
add_filter( 'woocommerce_product_get_rating_html', 'mytravel_wc_get_star_rating_html', 10, 3 );
add_filter( 'woocommerce_get_star_rating_html', 'mytravel_wc_get_star_rating_html', 10, 3 );
add_filter( 'woocommerce_rating_filter_count', 'mytravel_wc_rating_filter_count_html', 10, 2 );

add_filter( 'woocommerce_product_categories_widget_args', 'mytravel_modify_wc_product_cat_widget_args', 10 );
add_filter( 'woocommerce_get_breadcrumb', 'mytravel_wc_get_breadcrumb', 99, 2 );
add_filter( 'wp_dropdown_cats', 'mytravel_dropdown_cats' );
add_action( 'mytravel_before_header', 'mytravel_product_geolocations', 5 );

require get_template_directory() . '/inc/woocommerce/template-hooks/loop-tour.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/loop-activity.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/loop-rental.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/loop-car-rental.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/loop-yacht.php';


