<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">
	<div class="row justify-content-center">
		<div class="col-lg-8 col-md-12 col-12">
			<div class="mb-5 shadow-soft bg-white rounded-sm">
				<?php
				if ( $order ) :

					do_action( 'woocommerce_before_thankyou', $order->get_id() );
					?>

					<?php if ( $order->has_status( 'failed' ) ) : ?>

						<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'mytravel' ); ?></p>

						<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
							<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'mytravel' ); ?></a>
							<?php if ( is_user_logged_in() ) : ?>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'mytravel' ); ?></a>
							<?php endif; ?>
						</p>

					<?php else : ?>
						<div class="py-6 px-2 px-md-5 border-bottom">
							<div class="flex-horizontal-center">
								<div class="height-50 width-50 flex-shrink-0 flex-content-center bg-primary rounded-circle">
									<i class="flaticon-tick text-white font-size-24"></i>
								</div>

								<div class="ml-3">
									<h3 class="font-size-18 font-weight-bold text-dark mb-0 text-lh-sm woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'mytravel' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
									<p class="mb-0"><?php echo esc_html__( 'A confirmation email has been sent to your provided email address.', 'mytravel' ); ?>

								</div>
							</div>
						</div>
						<div class="pt-4 pb-5 px-2 px-md-5 border-bottom">

							<ul class="list-unstyled font-size-1 mb-0 font-size-16 woocommerce-order-overview woocommerce-thankyou-order-details order_details">

								<li class="woocommerce-order-overview__order order d-flex justify-content-between py-2">
									<span class="font-weight-medium"><?php esc_html_e( 'Order number:', 'mytravel' ); ?></span>
									<span class="text-secondary text-right"><?php echo wp_kses_post( $order->get_order_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								</li>

								<li class="woocommerce-order-overview__date date d-flex justify-content-between py-2">
									<span class="font-weight-medium"><?php esc_html_e( 'Date:', 'mytravel' ); ?></span>
									<span class="text-secondary text-right"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								</li>

								<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
									<li class="woocommerce-order-overview__email email d-flex justify-content-between py-2">
										<span class="font-weight-medium"><?php esc_html_e( 'Email:', 'mytravel' ); ?></span>
										<span class="text-secondary text-right"><?php echo wp_kses_post( $order->get_billing_email() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
									</li>
								<?php endif; ?>

								<li class="woocommerce-order-overview__total total d-flex justify-content-between py-2">
									<span class="font-weight-medium"><?php esc_html_e( 'Total:', 'mytravel' ); ?></span>
									<span class="text-secondary text-right"><?php echo wp_kses_post( $order->get_formatted_order_total() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								</li>

								<?php if ( $order->get_payment_method_title() ) : ?>
									<li class="woocommerce-order-overview__payment-method method d-flex justify-content-between py-2">
										<span class="font-weight-medium"><?php esc_html_e( 'Payment method:', 'mytravel' ); ?></span>
										<span class="text-secondary text-right"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></span>
									</li>
								<?php endif; ?>

							</ul>
						</div>

					<?php endif; ?>
					<div class="px-2 px-md-5 mt-4">
						<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
					</div>
					<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

				<?php else : ?>

					<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'mytravel' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
