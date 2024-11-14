<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}
$image_size = apply_filters( 'mytravel_content_widget_product_thumbnail_size', 'woocommerce_thumbnail' );

?>
<li class="media align-items-center mb-3">
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
	<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="d-block width-80 mr-3 p-0">
		<?php echo wp_kses_post( $product->get_image( $image_size, array( 'class' => 'img-fluid rounded' ) ) ); ?>
	</a>

	<div class="media-body">
		<div class="w-100 position-relative">
			<span class="d-block widget-product-title font-weight-medium text-dark mb-1">
				<a class="p-0 text-dark" href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo wp_kses_post( $product->get_name() ); ?>
				</a>
			</span>
		
			<?php if ( ! empty( $show_rating ) ) : ?>
				<div class="text-lh-1 mb-1 font-size-1">
					<?php echo wc_get_rating_html( $product->get_average_rating() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>

			<div class="text-gray-1 font-size-1">
				<?php echo wp_kses_post( $product->get_price_html() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
