<?php
/**
 * Template Hooks used in Single Tour
 */

add_action( 'mytravel_before_single_tour', 'mytravel_before_single_tour', 10 );

add_action( 'mytravel_before_single_tour_v1', 'mytravel_single_tour_v1_hooks', 10 );
add_action( 'mytravel_single_tour_v1', 'woocommerce_breadcrumb', 5 );
add_action( 'mytravel_single_tour_v1', 'mytravel_single_tour_gallery', 10 );
add_action( 'mytravel_before_single_tour_v2', 'woocommerce_breadcrumb', 5 );

add_action( 'mytravel_before_single_tour_v2', 'mytravel_single_tour_v2_hooks', 10 );


add_action( 'mytravel_single_tour', 'mytravel_single_tour_header', 10 );
add_action( 'mytravel_single_tour', 'mytravel_hotel_map', 15 );

add_action( 'mytravel_single_tour', 'mytravel_tour_info', 20 );

add_action( 'mytravel_single_tour', 'mytravel_single_hotel_description', 50 );

add_action( 'mytravel_single_tour', 'mytravel_single_tour_itinerary', 60 );
add_action( 'mytravel_single_tour', 'mytravel_single_hotel_location_map', 70 );
add_action( 'mytravel_single_tour', 'mytravel_single_tour_faq', 80 );
add_action( 'mytravel_single_tour', 'mytravel_single_hotel_review', 90 );

add_action( 'mytravel_single_tour_sidebar', 'mytravel_single_product_sidebar', 10 );

add_action( 'mytravel_after_single_tour', 'mytravel_output_related_hotels', 10 );

add_filter( 'mytravel_tour_tabs', 'mytravel_default_tour_tabs' );
add_filter( 'mytravel_tour_tabs', 'woocommerce_sort_product_tabs', 99 );
