<?php
/**
 * List view of Hotel
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
				<div class="col-md-7 col-xl-5 col-wd-4gdot5 flex-horizontal-center">
					<div class="w-100 position-relative m-4 m-md-0">
						<div class="mb-1 pb-1">
						<?php
							mytravel_hotel_loop_list_view_top_badge();
							mytravel_gold_star_rating_html( 'fas fa-star font-size-10', 'green-lighter', 'small', 'span' );
						?>
						</div>

						<?php
						if ( function_exists( 'mytravel_wc_template_loop_wishlist_button' ) ) {
							mytravel_wc_template_loop_wishlist_button();
						}
						?>

						<?php mytravel_hotel_loop_list_view_title(); ?>
						<div class="card-body p-0">
						<?php

							mytravel_hotel_loop_list_view_location();

							mytravel_hotel_loop_list_view_badges();

							mytravel_hotel_loop_list_view_bottom_badge();

						?>
						</div>
					</div>
				</div>
				<div class="col col-xl-3 col-wd-3gdot5 align-self-center py-4 py-xl-0 border-top border-xl-top-0">
					<div class="d-xl-flex flex-wrap flex-column border-xl-left ml-4 ml-xl-0 pr-xl-3 pr-wd-5 text-xl-right justify-content-xl-end">
					<?php

						mytravel_hotel_loop_list_view_user_rating();

						mytravel_hotel_loop_list_view_price();

					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
