<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

$max_adults          = mytravel_room_get_max_adults();
$max_children        = mytravel_room_get_max_children();
$product_format      = mytravel_get_product_format();
$easy_booking        = mytravel_is_wceb_activated();
$product_is_bookable = $easy_booking ? wceb_is_bookable( $product ) : '';

if ( $product->is_in_stock() ) : ?>

	<div class="d-none"><?php do_action( 'woocommerce_before_add_to_cart_form' ); ?></div>

	<form class="cart mytravel-cart-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $hotel->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>


		<div class="d-none">

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<?php do_action( 'mytravel_before_book_now_button', $product, $hotel ); ?>


			<?php
			do_action( 'woocommerce_before_add_to_cart_quantity' );

			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Missing
				)
			);

			do_action( 'woocommerce_after_add_to_cart_quantity' );
			?>
		</div>

		<button type="submit" data-max-adults="<?php echo esc_attr( $max_adults ); ?>" data-max-children="<?php echo esc_attr( $max_children ); ?>" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt btn-book-now btn btn-primary d-flex align-items-center justify-content-center  height-60 w-100 mb-xl-0 mb-lg-1 transition-3d-hover font-weight-bold"><?php esc_html_e( 'Book Now', 'mytravel' ); ?></button>

		<div class="d-none">

		  <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		</div>
		<?php do_action( 'woocommerce_after_room_cart_form' ); ?>


	</form>

	<div class="d-none"><?php do_action( 'woocommerce_after_add_to_cart_form' ); ?></div>

<?php endif; ?>
