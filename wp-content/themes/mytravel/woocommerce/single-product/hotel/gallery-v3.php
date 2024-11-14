<?php
/**
 * Gallery v3 for Hotel
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();

array_unshift( $attachment_ids, $main_image_id );

if ( $attachment_ids || $main_image_id ) :

	?><div class="mb-8 mt-n7">
		<!-- Images Carousel -->
		<div class="js-slick-carousel u-slick u-slick__img-overlay"
			data-arrows-classes="d-none d-md-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
			data-arrow-left-classes="flaticon-back u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-md-4 ml-xl-8"
			data-arrow-right-classes="flaticon-next u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-md-4 mr-xl-8"
			data-infinite="true"
			data-slides-show="1"
			data-slides-scroll="1"
			data-center-mode="true"
			data-pagi-classes="d-md-none text-center u-slick__pagination mt-5 mb-0"
			data-center-padding="450px"
			data-responsive='[{
				"breakpoint": 1480,
				"settings": {
					"centerPadding": "300px"
				}
			}, {
				"breakpoint": 1199,
				"settings": {
					"centerPadding": "200px"
				}
			}, {
				"breakpoint": 992,
				"settings": {
					"centerPadding": "120px"
				}
			}, {
				"breakpoint": 554,
				"settings": {
					"centerPadding": "20px"
				}
			}]'>
			<?php

			foreach ( $attachment_ids as $attachment_id ) :

				$image_atts = wp_get_attachment_image_src(
					$attachment_id,
					'full',
					false
				);

				if ( $image_atts ) :

					$image_src = $image_atts[0];
				else :
					$image_src = esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) );

				endif;

				?>
				<div class="js-slide bg-img-hero min-height-550" style="background-image: url(<?php echo esc_attr( $image_src ); ?>);"></div>
				<?php



			endforeach;

			?>
		</div>
		<!-- End Images Carousel -->
	</div>
	<?php

endif;
