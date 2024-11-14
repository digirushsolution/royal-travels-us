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

if ( $attachment_ids && $main_image_id ) {
	foreach ( $attachment_ids as $attachment_id ) {
		$image = wp_get_attachment_image(
			$attachment_id,
			'full',
			false,
			array(
				'title'        => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-caption' => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'class'        => esc_attr( 'img-fluid min-height-230 mx-auto' ),
			)
		);

		$main_images .= '<div class="js-slide"><div class="d-block gradient-overlay-half-bg-gradient-v5 w-100">' . $image . '</div></div>';
	}

	?>
	
	<!-- Images Carousel -->

		<div class="js-slick-carousel u-slick u-slick--equal-height "
			data-slides-show="1"
			data-slides-scroll="1"
			data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic v4 u-slick__arrow-classic--v4 u-slick__arrow-centered--y rounded-circle"
			data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left"
			data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right"
			data-pagi-classes="js-pagination text-center u-slick__pagination u-slick__pagination--white position-absolute right-0 bottom-0 left-0 mb-3 mb-0">
			<?php
			echo wp_kses( $main_images, 'image-html' );
			?>
		</div>
		
	<!-- End Images Carousel -->
	
<?php } ?>
