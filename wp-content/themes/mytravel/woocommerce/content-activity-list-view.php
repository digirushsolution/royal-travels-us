<?php
/**
 * List view of Activity
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
				<div class="col-md-5 col-lg-6 col-xl-4">
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
				<div class="col-md-7 col-lg-6 col-xl-5 flex-horizontal-center">
					<div class="w-100 position-relative m-4 m-md-0">
						<?php
						if ( function_exists( 'mytravel_wc_template_loop_wishlist_button' ) ) {
							mytravel_wc_template_loop_wishlist_button();
						}

						if ( $product->is_featured() || $product->is_on_sale() ) {
							?>
							<div class="mb-1 flex-horizontal-center pb-1">
								<?php
								mytravel_wc_template_loop_featured_badge();
								mytravel_wc_template_loop_onsale_badge();
								?>
							</div>
							<?php
						}

						mytravel_activity_loop_list_view_title();
						mytravel_wc_template_loop_rating();
						?>

						<div class="card-body p-0 mt-2">
						<?php
							mytravel_hotel_loop_list_view_location();
						?>
						</div>
					</div>
				</div>

				<div class="col col-xl-3 align-self-center py-4 py-xl-0 border-top border-xl-top-0">
					<div class="flex-content-center border-xl-left py-xl-5 ml-4 ml-xl-0 justify-content-start justify-content-xl-center">
						<div class="text-center my-xl-1">
							<div class="mb-2 pb-1">
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
