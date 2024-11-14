<?php

/**
 * Template Hooks used in WooCommerce
 */

require get_template_directory() . '/inc/woocommerce/template-hooks/archive.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/loop.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/single.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/review.php';
require get_template_directory() . '/inc/woocommerce/template-hooks/wc_pages.php';
add_action( 'mytravel_page_before', 'mytravel_wc_page_header', 5 );
