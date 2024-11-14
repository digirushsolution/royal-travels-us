<?php
/**
 * Gallery v1 for Tour
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$main_image_id = $product->get_image_id();
$image         = wp_get_attachment_image_src( $main_image_id, 'full' );

?>

<div class="mb-4 mb-lg-8 mt-n7">
	<?php if ( $main_image_id ) { ?>
		<?php echo wp_get_attachment_image( $main_image_id, 'full', false, [ 'class' => 'img-fluid' ] ); ?>
		<?php
	} else {
		echo '<div class="mytravel-wc-product-gallery__image--placeholder">';
		echo sprintf( '<img src="%s" alt="%s" class="wp-post-image img-fluid d-block mx-auto" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_attr__( 'Awaiting product image', 'mytravel' ) );
		echo '</div>';
	}
	?>
</div>
