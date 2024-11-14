<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form role="search" method="get" class="woocommerce-product-search input-group input-group-borderless" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<!-- Input -->
	<div class="js-focus-state w-100">
		<div class="search-inner">
			<div class="mb-4">
				<div class="input-group border-bottom border-width-2 border-color-1">
					<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field form-control font-weight-medium font-size-15 shadow-none hero-form border-0 p-0" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'mytravel' ); ?>" value="<?php echo get_search_query(); ?>" name="s"
					title="<?php echo esc_attr_x( 'Search for:', 'label', 'mytravel' ); ?>">
					<input type="hidden" class="form-control" name="post_type" value="product">
				</div>
			</div>

			<div class="text-center">
				<button type="submit" class="btn btn-primary height-60 w-100 font-weight-bold mb-xl-0 mb-lg-1 transition-3d-hover<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ); ?>"><i class="flaticon-magnifying-glass mr-2 font-size-17"></i><?php echo esc_html__( 'Search', 'mytravel' ); ?></button>
			</div>		
		</div>
	</div>
	<!-- End Input -->
</form>
