<?php
/**
 * Template Hooks used in Single Yacht
 */

add_action( 'mytravel_before_single_yacht', 'mytravel_before_single_yacht', 10 );

add_action( 'mytravel_before_single_yacht_v1', 'mytravel_single_yacht_gallery_v1', 10 );
add_action( 'mytravel_before_single_yacht_v2', 'woocommerce_breadcrumb', 5 );

add_action( 'mytravel_before_single_yacht_v2', 'mytravel_single_yacht_v2_hooks', 10 );


add_action( 'mytravel_single_yacht', 'mytravel_single_yacht_header', 10 );
add_action( 'mytravel_single_yacht', 'mytravel_hotel_map', 15 );
add_action( 'mytravel_single_yacht', 'mytravel_yacht_snapshot_preview', 20 );
add_action( 'mytravel_single_yacht', 'mytravel_single_hotel_description', 50 );

add_action( 'mytravel_single_yacht', 'mytravel_single_hotel_specification', 70 );
add_action( 'mytravel_single_yacht', 'mytravel_single_hotel_location_map', 80 );

add_action( 'mytravel_single_yacht', 'mytravel_single_hotel_review', 100 );

add_action( 'mytravel_single_yacht_sidebar', 'mytravel_single_product_sidebar', 10 );

add_action( 'mytravel_after_single_yacht', 'mytravel_output_related_hotels', 10 );

add_filter( 'mytravel_yacht_tabs', 'mytravel_default_yacht_tabs' );
add_filter( 'mytravel_yacht_tabs', 'woocommerce_sort_product_tabs', 99 );
