<?php
/**
 * Template Hooks used in Single Hotel
 */

add_action( 'mytravel_before_single_hotel', 'mytravel_before_single_hotel', 10 );

add_action( 'mytravel_before_single_hotel_v3', 'mytravel_single_hotel_v3_hooks', 10 );
add_action( 'mytravel_before_single_hotel_v3', 'woocommerce_breadcrumb', 5 );
add_action( 'mytravel_before_single_hotel_v3', 'mytravel_single_hotel_gallery', 10 );
add_action( 'mytravel_before_single_hotel_v1', 'woocommerce_breadcrumb', 10 );
add_action( 'mytravel_before_single_hotel_v2', 'woocommerce_breadcrumb', 10 );

add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_header', 10 );
add_action( 'mytravel_single_hotel', 'mytravel_hotel_map', 20 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_gallery', 30 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_description', 40 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_select_room', 50 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_amenities', 60 );

add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_nearest_essentials', 70 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_landmarks', 90 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_facts', 90 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_policy', 100 );
add_action( 'mytravel_single_hotel', 'mytravel_single_hotel_review', 110 );

add_action( 'mytravel_single_hotel_sidebar', 'mytravel_single_hotel_sidebar', 10 );

add_action( 'mytravel_room_simple_book_now', 'mytravel_room_simple_book_now', 30, 2 );
add_action( 'mytravel_room_variable_book_now', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'mytravel_room_external_book_now', 'mytravel_room_external_book_now', 30, 2 );

add_action( 'mytravel_before_book_now_button', 'mytravel_room_booking_dates', 30 );

add_action( 'mytravel_after_single_hotel', 'mytravel_output_related_hotels', 10 );

add_filter( 'mytravel_hotel_tabs', 'mytravel_default_hotel_tabs' );
add_filter( 'mytravel_hotel_tabs', 'woocommerce_sort_product_tabs', 99 );


add_action( 'mytravel_before_book_now_button_0', 'mytravel_wceb_single_product_html', 10 );
