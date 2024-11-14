<?php
/**
 * Template Hooks used in Single Car Rental
 */

add_action( 'mytravel_before_single_car_rental', 'mytravel_before_single_rental', 10 );

add_action( 'mytravel_before_single_car_rental_v1', 'mytravel_single_rental_gallery_v1', 10 );

add_action( 'mytravel_before_single_car_rental_v2', 'mytravel_single_rental_v2_hooks', 10 );


add_action( 'mytravel_single_car_rental', 'mytravel_single_rental_header', 10 );
add_action( 'mytravel_single_car_rental', 'mytravel_hotel_map', 15 );
add_action( 'mytravel_single_car_rental', 'mytravel_car_rental_snapshot_preview', 20 );
add_action( 'mytravel_single_car_rental', 'mytravel_single_hotel_description', 50 );

add_action( 'mytravel_single_car_rental', 'mytravel_single_hotel_specification', 70 );
add_action( 'mytravel_single_car_rental', 'mytravel_single_hotel_location_map', 80 );

add_action( 'mytravel_single_car_rental', 'mytravel_single_hotel_review', 100 );

add_action( 'mytravel_single_car_rental_sidebar', 'mytravel_single_product_sidebar', 10 );

add_action( 'mytravel_after_single_car_rental', 'mytravel_output_related_hotels', 10 );


