<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

$right_arrow = '<i class="flaticon-right-thin-chevron font-size-10 font-weight-bold"></i>';
$left_arrow  = '<i class="flaticon-left-direction-arrow font-size-10 font-weight-bold"></i>';
$next_text   = '<span class="sr-only">' . esc_html__( 'Next', 'mytravel' ) . '</span>';
$prev_text   = '<span class="sr-only">' . esc_html__( 'Previous', 'mytravel' ) . '</span>';

if ( is_rtl() ) {
	$next_text = $left_arrow . $next_text;
	$prev_text = $right_arrow . $prev_text;
} else {
	$next_text = $right_arrow . $next_text;
	$prev_text = $left_arrow . $prev_text;
}

$pages = paginate_links( // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	apply_filters(
		'woocommerce_pagination_args',
		array( // WPCS: XSS ok.
			'base'      => $base,
			'format'    => $format,
			'add_args'  => false,
			'current'   => max( 1, $current ),
			'total'     => $total,
			'prev_text' => $prev_text,
			'next_text' => $next_text,
			'type'      => 'array',
			'end_size'  => 3,
			'mid_size'  => 3,
		)
	)
);

mytravel_bootstrap_pagination( $pages, null, true, 'list-pagination-1 pagination border border-color-4 rounded-sm overflow-auto overflow-xl-visible justify-content-md-center align-items-center py-2 mb-0', 'font-size-14' );
