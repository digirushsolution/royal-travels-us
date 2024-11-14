<?php
/**
 * Get term post ID for acf get_field param
 *
 * @param WP_Term $term The WP Term.
 * @return string
 */

if ( ! function_exists( 'mytravel_get_field' ) ) {
	/**
	 * Wrapper for ACF's get_field function.
	 *
	 * @param string   $field custom field key.
	 * @param int|bool $post_id ID of the post.
	 * @param bool     $format_value should format the meta value or not.
	 * @return mixed
	 */
	function mytravel_get_field( $field, $post_id = false, $format_value = true ) {
		if ( function_exists( 'get_field' ) ) {
			return get_field( $field, $post_id, $format_value );
		}

		return false;
	}
}

/**
 * Get term post ID for acf get_field param
 *
 * @param WP_Term $term The WP Term.
 * @return string
 */
function mytravel_get_taxonomy_post_id( $term ) {
	return $term->taxonomy . '_' . $term->term_id;
}

if ( ! function_exists( 'mytravel_acf_main_category' ) ) {
	/**
	 * Replace the category list with just one main category.
	 *
	 * @param string $category_list Category list for a post.
	 * @return string
	 */
	function mytravel_acf_main_category( $category_list ) {
		global $wp_rewrite;
		$term = mytravel_get_field( 'main_category' );
		if ( $term && mytravel_is_woocommerce_activated() ) {
			$rel           = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="tag"' : 'rel="category"';
			$category_list = '<span class="woocommerce-loop-product__categories text-truncate d-block"><a class="font-weight-normal font-size-14 text-white" href="' . esc_url( get_term_link( $term ) ) . '"  ' . $rel . '>' . $term->name . '</a></span>';
		}
		return $category_list;
	}
}


require get_template_directory() . '/inc/acf/functions/hotel.php';
require get_template_directory() . '/inc/acf/functions/color.php';
require get_template_directory() . '/inc/acf/functions/tour.php';
require get_template_directory() . '/inc/acf/functions/blog-post.php';
require get_template_directory() . '/inc/acf/functions/product-category.php';
require get_template_directory() . '/inc/acf/functions/room.php';


