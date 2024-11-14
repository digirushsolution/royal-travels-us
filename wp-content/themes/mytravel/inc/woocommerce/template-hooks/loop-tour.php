<?php
/**
 * Hooks for content-tour.php
 */

add_action( 'mytravel_tour_before_shop_loop_item', 'mytravel_output_card_wrapper', 5 );
add_action( 'mytravel_tour_after_shop_loop_item', 'mytravel_output_card_wrapper_end', 99 );

add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_output_card_header_wrapper', 5 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_wc_template_loop_product_thumbnail', 10 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_wc_template_loop_badges', 20 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_tour_loop_product_price_wrap', 30 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_tour_loop_product_categories', 35 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'woocommerce_template_loop_price', 40 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_tour_loop_product_price_wrap_end', 50 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_output_card_header_wrapper_end', 60 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_output_card_body_wrapper', 70 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_wc_template_loop_tour_display_location', 80 );

add_action( 'mytravel_tour_shop_loop_item_title', 'mytravel_wc_template_loop_product_link_open', 5 );
add_action( 'mytravel_tour_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'mytravel_tour_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

add_action( 'mytravel_tour_after_shop_loop_item_title', 'mytravel_tour_loop_rating_wrap', 5 );
add_action( 'mytravel_tour_after_shop_loop_item_title', 'mytravel_wc_template_loop_tour_time_duration', 70 );


add_action( 'mytravel_tour_after_shop_loop_item', 'mytravel_output_card_body_wrapper_end', 5 );



