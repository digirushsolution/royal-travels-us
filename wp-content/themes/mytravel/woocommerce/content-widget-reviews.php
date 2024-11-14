<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-reviews.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
$image_size = apply_filters( 'mytravel_content_widget_reviews_product_thumbnail_size', 'woocommerce_thumbnail' );

?>
<li class="media align-items-center mb-3">
	<?php do_action( 'woocommerce_widget_product_review_item_start', $args ); ?>

	<?php
	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	?>

	<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="d-block width-80 mr-3 p-0">
		<?php echo wp_kses_post( $product->get_image( $image_size, array( 'class' => 'img-fluid rounded' ) ) ); ?>
	</a>

	<div class="media-body">
		<div class="w-100 position-relative">
			<span class="d-block widget-product-title font-weight-medium text-dark mb-1">
				<a class="p-0 text-dark" href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php echo wp_kses_post( $product->get_name() ); ?>
				</a>
			</span>

			<div class="text-lh-1 mb-1 font-size-1">
				<?php echo wc_get_rating_html( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) ); ?>
			</div>

			<span class="reviewer text-gray-1 font-size-1">
			<?php
			/* translators: %s: Comment author. */
			echo sprintf( esc_html__( 'by %s', 'mytravel' ), get_comment_author( $comment->comment_ID ) );
			?>
			</span>

			<?php
			// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
	</div

	<?php do_action( 'woocommerce_widget_product_review_item_end', $args ); ?>
	
</li>
