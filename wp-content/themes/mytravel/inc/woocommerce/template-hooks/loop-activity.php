<?php
/**
 * Hooks for content-activity.php
 */

add_action( 'mytravel_activity_before_shop_loop_item', 'mytravel_output_card_wrapper', 5 );
add_action( 'mytravel_activity_after_shop_loop_item', 'mytravel_output_card_wrapper_end', 99 );

add_action( 'mytravel_activity_before_shop_loop_item_title', 'mytravel_output_card_header_wrapper', 5 );
add_action( 'mytravel_activity_before_shop_loop_item_title', 'mytravel_wc_template_loop_product_thumbnail', 10 );
add_action( 'mytravel_activity_before_shop_loop_item_title', 'mytravel_wc_template_loop_hotel_display_location', 20 );
add_action( 'mytravel_activity_before_shop_loop_item_title', 'mytravel_output_card_header_wrapper_end', 90 );
add_action( 'mytravel_activity_before_shop_loop_item_title', 'mytravel_output_card_body_wrapper', 95 );

add_action( 'mytravel_activity_shop_loop_item_title', 'mytravel_wc_template_loop_product_link_open', 5 );
add_action( 'mytravel_activity_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'mytravel_activity_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

add_action( 'mytravel_activity_after_shop_loop_item_title', 'mytravel_wc_template_loop_rating', 5 );
add_action( 'mytravel_activity_after_shop_loop_item_title', 'mytravel_wc_template_loop_product_price_wrap', 9 );
add_action( 'mytravel_activity_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'mytravel_activity_after_shop_loop_item_title', 'mytravel_wc_template_loop_product_price_wrap_end', 11 );

add_action( 'mytravel_activity_after_shop_loop_item', 'mytravel_output_card_body_wrapper_end', 5 );




