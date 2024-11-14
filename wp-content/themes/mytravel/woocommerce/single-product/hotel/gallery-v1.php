<?php
/**
 * Gallery v1 for Hotel
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

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



	?><div class="pb-4 mb-2">
	<div class="position-relative">
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
</div>
<?php } ?>
