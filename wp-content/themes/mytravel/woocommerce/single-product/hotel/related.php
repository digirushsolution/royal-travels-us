<?php
/**
 * Related Hotels
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product_format = mytravel_get_product_format();

if ( $related_products ) :
	if ( 'hotel' === $product_format ) {
		$heading = esc_html__( 'Similar Hotels', 'mytravel' );
	} else {
		$heading = esc_html__( 'You might also like...', 'mytravel' );
	}

	?><div class="border-bottom border-gray-33 related product-card-block product-card-v3 
	<?php
	if ( 'hotel' === $product_format ) :
		?>
	related-hotel<?php endif; ?>">
	<div class="space-1">
		<div class="container">
		<?php

		if ( $heading ) :

			?>
			<div class="w-md-80 w-lg-50 text-center mx-md-auto pb-4">
				<h2 class="section-title text-black font-size-30 font-weight-bold mb-0"><?php echo esc_html( apply_filters( 'mytravel_hotel_related_hotels_heading', $heading ) ); ?></h2>
			</div>
			<?php

			endif;

		?>
			<div class="js-slick-carousel u-slick u-slick--equal-height u-slick--gutters-3"
				data-slides-show="4"
				data-slides-scroll="1"
				data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic v1 u-slick__arrow-classic--v1 u-slick__arrow-centered--y rounded-circle"
				data-arrow-left-classes="fas fa-chevron-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left"
				data-arrow-right-classes="fas fa-chevron-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right"
				data-pagi-classes="d-lg-none text-center u-slick__pagination mt-4"
				data-responsive='[{
					"breakpoint": 1025,
					"settings": {
						"slidesToShow": 3
					}
				}, {
					"breakpoint": 992,
					"settings": {
						"slidesToShow": 2
					}
				}, {
					"breakpoint": 768,
					"settings": {
						"slidesToShow": 1
					}
				}, {
					"breakpoint": 554,
					"settings": {
						"slidesToShow": 1
					}
				}]'>
				<?php

				foreach ( $related_products as $related_product ) :

					?>
				<div class="js-slide py-3">
					<?php

					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					if ( 'rental' === $product_format ) {
						mytravel_rental_content_product_actions();
					} elseif ( 'car_rental' === $product_format ) {
						mytravel_car_rental_content_product_actions();
					} elseif ( 'yacht' === $product_format ) {
						mytravel_yacht_content_product_actions();
					} else {
						mytravel_content_product_actions();
					}

					?>
				</div><!-- /.js-slide -->
					<?php

				endforeach;

				?>
			</div><!-- /.js-slick-carousel -->
		</div><!-- /.container -->
	</div><!-- /.space-1 -->
</div><!-- /.product-card-block -->
	<?php

endif;
