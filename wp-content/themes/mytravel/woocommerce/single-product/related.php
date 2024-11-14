<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$wrap_class = '';
if ( ! class_exists( 'MAS_Travels' ) ) {
	$wrap_class = ' default_related_products';
}

if ( $related_products ) :
	$sidebar = mytravel_get_archive_sidebar();
	?>

	<section class="related products product-card-block product-card-v3<?php echo esc_attr( $wrap_class ); ?>">
		<div class="space-1">
			<div class="container">
				<?php
				if ( ! class_exists( 'MAS_Travels' ) && ( ! is_active_sidebar( 'sidebar-shop' ) || 'no-sidebar' === $sidebar ) ) {
					?>
					<div class="row">
						<div class="col-lg-9 mx-auto">
				<?php } ?>

				<?php
				$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'mytravel' ) );

				if ( $heading ) :
					?>
					<div class="w-md-80 w-lg-50 text-center mx-md-auto pb-4">
						<h2 class="section-title text-black font-size-30 font-weight-bold mb-0"><?php echo esc_html( $heading ); ?></h2>
					</div>
				<?php endif; ?>
				
				<?php woocommerce_product_loop_start(); ?>

					<?php foreach ( $related_products as $related_product ) : ?>

							<?php
							$post_object = get_post( $related_product->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

							wc_get_template_part( 'content', 'product' );
							?>

					<?php endforeach; ?>

				<?php woocommerce_product_loop_end(); ?>
				<?php
				if ( ! class_exists( 'MAS_Travels' ) && ( ! is_active_sidebar( 'sidebar-shop' ) || 'no-sidebar' === $sidebar ) ) {
					?>
					</div>
						</div>
				<?php } ?>
			</div>
		</div>

	</section>
	<?php
endif;

wp_reset_postdata();
