<?php
/**
 * Template hooks used in single-product.php
 */

add_action( 'woocommerce_before_single_product', 'mytravel_toggle_single_product_hooks', 1 );

remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );


add_action( 'mytravel_standard_single_product_sidebar', 'mytravel_single_product_sidebar', 20 );

add_filter( 'woocommerce_output_related_products_args', 'mytravel_output_related_products_args' );

require get_template_directory() . '/inc/woocommerce/template-hooks/single-hotel.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/single-tour.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/single-activity.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/single-rental.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/single-car-rental.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/single-yacht.php';
