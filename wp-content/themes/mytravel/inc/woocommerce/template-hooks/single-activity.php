<?php
/**
 * Template Hooks used in Single Activity
 */

add_action( 'mytravel_before_single_activity', 'mytravel_before_single_activity', 10 );

add_action( 'mytravel_before_single_activity_v1', 'mytravel_single_activity_gallery', 10 );
add_action( 'mytravel_before_single_activity_v2', 'mytravel_woocommerce_breadcrumb_wrapper', 5 );
add_action( 'mytravel_before_single_activity_v2', 'mytravel_single_activity_v2_hooks', 10 );


add_action( 'mytravel_single_activity', 'mytravel_single_activity_header', 10 );
add_action( 'mytravel_single_activity', 'mytravel_hotel_map', 15 );

add_action( 'mytravel_single_activity', 'mytravel_single_activity_amenities', 20 );
add_action( 'mytravel_single_activity', 'mytravel_single_hotel_description', 50 );

add_action( 'mytravel_single_activity', 'mytravel_single_activity_experience', 60 );

add_action( 'mytravel_single_activity', 'mytravel_single_hotel_location_map', 70 );

add_action( 'mytravel_single_activity', 'mytravel_single_activity_faq', 80 );
add_action( 'mytravel_single_activity', 'mytravel_single_hotel_review', 90 );

add_action( 'mytravel_single_activity_sidebar', 'mytravel_single_product_sidebar', 10 );


add_action( 'mytravel_after_single_activity', 'mytravel_output_related_hotels', 10 );

add_filter( 'mytravel_activity_tabs', 'mytravel_default_activity_tabs' );
add_filter( 'mytravel_activity_tabs', 'woocommerce_sort_product_tabs', 99 );
