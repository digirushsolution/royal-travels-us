<?php
/**
 * Select Room
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' );

?><h5 class="font-size-21 font-weight-bold text-dark mb-4">
<?php
	esc_html_e( 'Select your room', 'mytravel' );
?>
</h5>
<?php

$quantites_required      = false;
$previous_post           = $post;
$grouped_product_columns = apply_filters(
	'woocommerce_grouped_product_columns',
	array(
		'quantity',
		'label',
		'price',
	),
	$product
);
$show_add_to_cart_button = false;

foreach ( $grouped_products as $grouped_product_child ) :

	$post_object        = get_post( $grouped_product_child->get_id() );
	$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
	$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	setup_postdata( $post );

	if ( $grouped_product_child->is_in_stock() ) {
		$show_add_to_cart_button = true;
	}

	?>
	<div class="card border-color-7 mb-5 overflow-hidden">
	<?php

	mytravel_room_badge_html();

	?>
	<div class="product-item__outer w-100">
		<div class="row">
			<div class="col-md-5 col-lg-5 col-xl-3dot5">
				<div class="pt-5 pb-md-5 pl-4 pr-4 pl-md-5 pr-md-2 pr-xl-2">
					<div class="product-item__header mt-2 mt-md-0">
						<div class="position-relative">
						<?php
							echo wp_kses( $grouped_product_child->get_image( 'full', array( 'class' => 'img-fluid rounded-sm' ) ), 'image' );
						?>
						</div>
					</div>
				</div>
			</div>
			<div class="col col-md-7 col-lg-7 col-xl-5 flex-horizontal-center pl-xl-0">
				<div class="w-100 position-relative m-4 m-md-0">
					<div class="mb-2 font-weight-bold font-size-17 text-dark text-dark">
					<?php
						echo esc_html( $grouped_product_child->get_name() );
					?>
					</div>
					<div class="mt-1 pt-2">
					<?php

						mytravel_room_amenities_preview();

						mytravel_room_photos_and_details();

					?>
					</div>
				</div>
			</div>
			<div class="col col-xl-3dot5 align-self-center py-4 py-xl-0 border-top border-xl-top-0">
				<div class="flex-content-center border-xl-left py-xl-5 ml-4 ml-xl-0 justify-content-start justify-content-xl-center">
					<div class="text-center my-xl-1">
						<div class="font-size-14 mb-2 pb-1">
						<?php
							$price_html = str_replace( 'woocommerce-Price-amount font-size-24 text-gray-6 font-weight-bold ml-1', 'woocommerce-Price-amount font-weight-bold font-size-22 ml-1', $grouped_product_child->get_price_html() );
							echo wp_kses( $price_html, 'price-html' );
						?>
						</div>
						<?php

						mytravel_room_book_now( $grouped_product_child, $product );

						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php

endforeach;

$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
setup_postdata( $post );
