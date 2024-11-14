<?php
/**
 * Gallery v1 for Tour
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$fancybox_id    = 'fancebox-' . $product->get_id();
$attachment_ids = $product->get_gallery_image_ids();
$main_images    = '';
$thumbnails     = '';
$main_image_id  = $product->get_image_id();
$image          = wp_get_attachment_image_src( $main_image_id, 'full' );

?>

<div class="mb-4 mb-lg-8 mt-n7">
	<?php
	if ( $main_image_id ) {
		echo wp_get_attachment_image( $main_image_id, 'full', false, [ 'class' => 'img-fluid' ] );
	} else {
		echo '<div class="mytravel-wc-product-gallery__image--placeholder">';
		echo sprintf( '<img src="%s" alt="%s" class="wp-post-image img-fluid d-block mx-auto" style="height: 595px;"/>', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_attr__( 'Awaiting product image', 'mytravel' ) );
		echo '</div>';
	}

	$video = mytravel_get_field( 'video' );

	if ( $attachment_ids || $video ) :
		?>
	<div class="container">
		<div class="position-relative">
			<div class="position-absolute right-0 mt-md-n11 mt-n9">
				<div class="flex-horizontal-center">

					<?php if ( $video ) : ?>
						<!-- Video -->
						<a class="js-fancybox btn btn-white transition-3d-hover py-2 px-md-5 px-3 shadow-6 mr-1" href="javascript:;" data-src="<?php echo esc_attr( $video ); ?>" data-speed="700">
							<i class="flaticon-movie mr-md-2 font-size-18 text-primary"></i><span class="d-none d-md-inline"><?php echo esc_html( 'Video', 'mytravel' ); ?></span>
						</a>
						<!-- End Video -->
						<?php
					endif;

					$count = 1;
					foreach ( $attachment_ids as $attachment_id ) :

						$image_att = wp_get_attachment_image_src( $attachment_id, 'full', false );
						$caption   = _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
						$image_src = $image_att[0];

						if ( 1 == $count ) :
							?>
							<a class="js-fancybox btn btn-white transition-3d-hover ml-2 py-2 px-md-5 px-3 shadow-6 text" href="javascript:;"
							data-src="<?php echo esc_attr( $image_src ); ?>"
							data-fancybox="<?php echo esc_attr( $fancybox_id ); ?>"
							data-caption="<?php echo esc_attr( $caption ); ?>"
								data-speed="700">
								<i class="flaticon-gallery mr-md-2 font-size-18 text-primary"></i><span class="d-none d-md-inline"><?php echo esc_html__( 'Gallery', 'mytravel' ); ?></span>
							</a>    

						<?php elseif ( $count > 1 ) : ?>

							<img class="js-fancybox d-none" alt="<?php echo esc_attr( $caption ); ?>"
							data-fancybox="<?php echo esc_attr( $fancybox_id ); ?>"
							data-src="<?php echo esc_attr( $image_src ); ?>"
							src="<?php echo esc_attr( $image_src ); ?>"
							data-caption="<?php echo esc_attr( $caption ); ?>"
							data-speed="700">

							<?php
						endif;
						$count++;

					endforeach;
					?>
				

				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
