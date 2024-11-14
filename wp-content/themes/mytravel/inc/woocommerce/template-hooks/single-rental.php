<?php
/**
 * Template Hooks used in Single Rental
 */

add_action( 'mytravel_before_single_rental', 'mytravel_before_single_rental', 10 );

add_action( 'mytravel_before_single_rental_v1', 'mytravel_single_rental_gallery_v1', 10 );
add_action( 'mytravel_before_single_rental_v2', 'woocommerce_breadcrumb', 5 );
add_action( 'mytravel_before_single_rental_v2', 'mytravel_single_rental_v2_hooks', 10 );

add_action( 'mytravel_single_rental', 'mytravel_single_rental_header', 10 );
add_action( 'mytravel_single_rental', 'mytravel_hotel_map', 15 );
add_action( 'mytravel_single_rental', 'mytravel_rental_snapshot_preview', 20 );
add_action( 'mytravel_single_rental', 'mytravel_single_hotel_description', 50 );
add_action( 'mytravel_single_rental_0', 'mytravel_single_hotel_select_room', 55 );
add_action( 'mytravel_single_rental', 'mytravel_single_hotel_amenities', 60 );

add_action( 'mytravel_single_rental', 'mytravel_single_rental_details', 70 );
add_action( 'mytravel_single_rental', 'mytravel_single_hotel_location_map', 80 );

add_action( 'mytravel_single_rental', 'mytravel_single_rental_video', 90 );
add_action( 'mytravel_single_rental', 'mytravel_single_hotel_review', 100 );

add_action( 'mytravel_single_rental_sidebar', 'mytravel_single_rental_sidebar', 10 );
add_action( 'mytravel_single_rental_sidebar_0', 'mytravel_single_product_sidebar', 10 );

add_action( 'mytravel_room_simple_book_now', 'mytravel_room_simple_book_now', 30, 2 );
add_action( 'mytravel_room_variable_book_now', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'mytravel_room_external_book_now', 'mytravel_room_external_book_now', 30, 2 );

add_action( 'mytravel_after_single_rental', 'mytravel_output_related_hotels', 10 );

add_filter( 'mytravel_rental_tabs', 'mytravel_default_rental_tabs' );
add_filter( 'mytravel_rental_tabs', 'woocommerce_sort_product_tabs', 99 );
