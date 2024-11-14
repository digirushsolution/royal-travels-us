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

$location     = mytravel_get_hotel_location();
$location_map = mytravel_get_hotel_location_map();
$rating       = mytravel_get_hotel_gold_star_rating();
$product_format = mytravel_get_product_format();

if ( empty( $location_map ) ) {
	return;
}

?><li <?php wc_product_class( 'col-12', $product ); ?>>
	<div class="hotel-list-view map-hotel-list-view card mb-4 overflow-hidden">
		<div class="product-item__outer w-100">
			<div class="row">
				<div class="col-md-6">
					<div class="product-item__header">
						<div class="position-relative">
						<?php
							mytravel_wc_template_loop_product_thumbnail( 'list' );
						?>
						</div>
						<?php
						if ( function_exists( 'mytravel_wc_template_loop_map_view_wishlist_button' ) ) {
							mytravel_wc_template_loop_map_view_wishlist_button();
						}
						if ( $location ) :
							?>
							<div class="position-absolute bottom-0 left-0 right-0">
								<div class="px-4 pb-3">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="d-block mb-3">
										<div class="d-flex align-items-center font-size-14 text-white">
											<i class="icon flaticon-pin-1 mr-2 font-size-20"></i> <?php mytravel_the_hotel_location(); ?>
										</div>
									</a>
								</div>
							</div>
							<?php
						endif;
						?>

					</div>
				</div>
				<div class="col-md-6 flex-horizontal-center">
					<div class="w-100 position-relative m-4 m-md-0">
						<?php
						if ( 'hotel' === $product_format ) {
							if ( $rating ) {
								?>
								<div class="mb-1 pb-1">
								<?php
									mytravel_gold_star_rating_html( 'fas fa-star font-size-10', 'green-lighter', 'small', 'span' );
								?>
								</div>
								<?php
							}
						}

						mytravel_hotel_loop_list_view_title();
						?>
						<div class="card-body p-0">
						<?php
							mytravel_wc_template_loop_rating();
							mytravel_hotel_loop_list_view_price();

						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
