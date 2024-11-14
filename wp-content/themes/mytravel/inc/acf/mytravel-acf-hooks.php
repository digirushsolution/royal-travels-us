<?php
/**
 * Hooks when using ACF.
 */

add_filter( 'mytravel_template_loop_categories_html', 'mytravel_acf_main_category', 10 );
add_filter( 'mytravel_get_archive_sidebar', 'mytravel_acf_product_cat_sidebar' );
add_filter( 'mytravel_shop_loop_columns', 'mytravel_acf_product_cat_column' );
