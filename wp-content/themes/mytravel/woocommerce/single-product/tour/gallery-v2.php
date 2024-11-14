<?php
/**
 * Gallery v2 for Tour
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
array_unshift( $attachment_ids, $main_image_id );

if ( $attachment_ids || $main_image_id ) {
	foreach ( $attachment_ids as $attachment_id ) {
		if ( $attachment_id ) {
			$image = wp_get_attachment_image(
				$attachment_id,
				'full',
				false,
				array(
					'title'        => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
					'data-caption' => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
					'class'        => esc_attr( 'img-fluid border-radius-3 mx-auto' ),
				)
			);
		} else {

			$image  = '<div class="woocommerce-product-gallery__image--placeholder single-v1-wp-image-placeholder">';
			$image .= sprintf( '<img src="%s" alt="%s" class="wp-post-image img-fluid" />', esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) ), esc_html__( 'Awaiting product image', 'mytravel' ) );
			$image .= '</div>';

		}

		$image_thumbnail = str_replace( 'img-fluid border-radius-3', 'img-fluid border-radius-3 height-110 mx-auto', $image );

		$main_images .= '<div class="js-slide">' . $image . '</div>';
		$thumbnails  .= '<div class="js-slide" style="cursor: pointer;">' . $image_thumbnail . '</div>';
	}

	$product_format = mytravel_get_product_format();

	if ( 'car_rental' === $product_format || 'rental' === $product_format || 'yacht' === $product_format ) {
		$wrap_class = 'pb-4';
	} elseif ( 'activity' === $product_format ) {
		$wrap_class = 'pb-3';
	} else {
		$wrap_class = 'pb-2';
	}
	?>
<div class="position-relative mb-4 <?php echo esc_attr( $wrap_class ); ?>">
	<!-- Images Carousel -->
	<div id="sliderSyncingNav" class="js-slick-carousel u-slick mb-2"
		data-infinite="true"
		data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
		data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
		data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
		data-nav-for="#sliderSyncingThumb">
		<?php

			echo wp_kses( $main_images, 'image-html' );

		?>
	</div>

	<?php
	$video = mytravel_get_field( 'video' );

	if ( $attachment_ids || $video ) :
		?>
		<div class="position-absolute right-0 mr-3 mt-md-n11 mt-n9">
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

					if ( $image_att ) {
						$image_src = $image_att[0];
					} else {
						$image_src = esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) );

					}

					if ( 1 == $count ) :
						?>
						<a class="js-fancybox btn btn-white transition-3d-hover ml-2 py-2 px-md-5 px-3 shadow-6" href="javascript:;"
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
	<?php endif; ?>

	<div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--gutters-4 u-slick--transform-off"
		data-infinite="true"
		data-slides-show="6"
		data-is-thumbs="true"
		data-nav-for="#sliderSyncingNav"
		data-responsive='[{
			"breakpoint": 992,
			"settings": {
				"slidesToShow": 4
			}
		}, {
			"breakpoint": 768,
			"settings": {
				"slidesToShow": 3
			}
		}, {
			"breakpoint": 554,
			"settings": {
				"slidesToShow": 2
			}
		}]'>
		<?php

			echo wp_kses( $thumbnails, 'image-html' );

		?>
	</div>
	<!-- End Images Carousel -->
</div>

<?php } ?>
