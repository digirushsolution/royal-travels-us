<?php
/**
 * List view of Tour
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?><li <?php wc_product_class( 'col-12', $product ); ?>>
	<div class="card mb-5 overflow-hidden">
		<div class="product-item__outer w-100">
			<div class="row">
				<div class="col-md-5 col-xl-4">
					<div class="product-item__header">
						<div class="position-relative">
						<?php
							$attachment_ids = $product->get_gallery_image_ids();
							$main_image_id  = $product->get_image_id();

						if ( $attachment_ids && $main_image_id ) {
								mytravel_wc_template_loop_product_gallery();
						} else {
							mytravel_wc_template_loop_product_thumbnail( 'list' );
						}
						?>
												
						</div>
					</div>
				</div>
				<div class="col-md-7 col-xl-5 flex-horizontal-center">
					<div class="w-100 position-relative m-4 m-md-0">
						<?php
						if ( function_exists( 'mytravel_wc_template_loop_wishlist_button' ) ) {
							mytravel_wc_template_loop_wishlist_button();
						}
						mytravel_yacht_loop_list_view_title();
						?>
						<div class="card-body p-0">
							<?php
							mytravel_wc_template_loop_rental_display_location();
							mytravel_tour_loop_rating_wrap();
							mytravel_yacht_loop_room_snapshot_preview();
							?>
						</div>

					</div>
				</div>

				<div class="col col-xl-3 align-self-center py-4 py-xl-0 border-top border-xl-top-0">
					<div class="border-xl-left border-color-7 py-5">
						<div class="ml-md-4 ml-xl-0">
							<div class="text-center text-md-left text-xl-center d-flex flex-column mb-2 pb-1 ml-md-3 ml-xl-0">
								<?php mytravel_hotel_loop_list_view_price(); ?>
							</div>
							<?php mytravel_view_detail_button(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
