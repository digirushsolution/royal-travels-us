<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.6.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details 
<?php
if ( ! is_account_page() ) :
	?>
	px-2 px-md-5 pb-4 pt-4
	<?php
else :
	?>
	mt-4<?php endif; ?>">
	<div class="row">
		<div class="col-md-6 col-12">
			<div class="border rounded-sm p-4 h-100">
				<h5 class="woocommerce-column__title "><?php esc_html_e( 'Billing address', 'mytravel' ); ?></h5>
				<address>
					<?php
						$address = '';
					if ( $order->has_billing_address() ) {
						$address = apply_filters( 'woocommerce_order_formatted_billing_address', $order->get_address( 'billing' ), $order );

						$address_title = '';
						if ( isset( $address['company'] ) && ! empty( $address['company'] ) ) {
							$address_title = $address['company'];
							unset( $address['company'] );
						} elseif ( isset( $address['first_name'], $address['last_name'] ) ) {
							$address_title = $address['first_name'] . ' ' . $address['last_name'];
							unset( $address['first_name'] );
							unset( $address['last_name'] );
						}

						if ( ! empty( $address_title ) ) {
							?>
								<h6 class="mb-1 text-capitalize"><?php echo esc_html( $address_title ); ?></h6>
								<?php
						}

						$address = WC()->countries->get_formatted_address( $address, '<br> ' );

						echo wp_kses_post( $address );
					} else {
						echo esc_html__( 'N/A', 'mytravel' );
					}

					?>

					<?php if ( $order->get_billing_phone() ) : ?>
						<span class="d-block woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></span>
					<?php endif; ?>

					<?php if ( $order->get_billing_email() ) : ?>
						<span class="d-block woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></span>
					<?php endif; ?>
				</address>
			</div>
		</div>

		<?php if ( $show_shipping ) : ?>

			<div class="col-md-6 col-12 mt-3 mt-md-0">
				<div class="border rounded-sm p-4 h-100">
					<h5 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'mytravel' ); ?></h5>
					<address>
						<?php
						$address = '';
						if ( $order->has_shipping_address() ) {
							$address = apply_filters( 'woocommerce_order_formatted_shipping_address', $order->get_address( 'shipping' ), $order );

							$address_title = '';
							if ( isset( $address['company'] ) && ! empty( $address['company'] ) ) {
								$address_title = $address['company'];
								unset( $address['company'] );
							} elseif ( isset( $address['first_name'], $address['last_name'] ) ) {
								$address_title = $address['first_name'] . ' ' . $address['last_name'];
								unset( $address['first_name'] );
								unset( $address['last_name'] );
							}

							if ( ! empty( $address_title ) ) {
								?>
								<h6 class="mb-1 text-capitalize"><?php echo esc_html( $address_title ); ?></h6>
								<?php
							}

							$address = WC()->countries->get_formatted_address( $address, '<br> ' );

							echo wp_kses_post( $address );
						} else {
							echo esc_html__( 'N/A', 'mytravel' );
						}

						?>
					</address>
				</div>		
			</div>
		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
