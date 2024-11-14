<?php
/**
 * Product Category ACF Functions
 */

/**
 * Set Product Category Sidebar
 *
 * @param string $layout The sidebar.
 * @return string
 */
function mytravel_acf_product_cat_sidebar( $layout ) {
	$term = get_queried_object();

	if ( mytravel_is_woocommerce_activated() && is_product_category() ) {
		$layout = mytravel_get_field( 'sidebar', $term );
	}

	return $layout;
}

/**
 * Set Product Category columns
 *
 * @param string $column Products per row.
 * @return string
 */
function mytravel_acf_product_cat_column( $column ) {
	$term = get_queried_object();

	if ( mytravel_is_woocommerce_activated() && is_product_category() ) {
		$column = mytravel_get_field( 'products_per_row', $term );
	}

	return $column;
}
