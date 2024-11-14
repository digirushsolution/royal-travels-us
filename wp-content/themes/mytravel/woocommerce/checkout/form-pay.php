<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.2.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
?>
<form id="order_review" method="post">
	<div class="row justify-content-center">
		<div class="col-lg-8 col-md-12 col-12">
			<div class="mb-5 shadow-soft bg-white rounded-sm">
				<table class="shop_table">
					<thead>
						<tr>
							<th class="product-name pt-3"><?php esc_html_e( 'Product', 'mytravel' ); ?></th>
							<th class="product-quantity pt-3"><?php esc_html_e( 'Qty', 'mytravel' ); ?></th>
							<th class="product-total pt-3"><?php esc_html_e( 'Totals', 'mytravel' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ( count( $order->get_items() ) > 0 ) : ?>
							<?php foreach ( $order->get_items() as $item_id => $item ) : ?>
								<?php
								if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
									continue;
								}
								?>
								<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
									<td class="product-name">
										<?php
											echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

											do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

											wc_display_item_meta( $item );

											do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
										?>
									</td>
									<td class="product-quantity"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', esc_html( $item->get_quantity() ) ) . '</strong>', $item ); ?></td><?php // @codingStandardsIgnoreLine ?>
									<td class="product-subtotal"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></td><?php // @codingStandardsIgnoreLine ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
					<tfoot>
						<?php if ( $totals ) : ?>
							<?php foreach ( $totals as $total ) : ?>
								<tr>
									<th scope="row" colspan="2"><?php echo esc_html( $total['label'] ); ?></th><?php // @codingStandardsIgnoreLine ?>
									<td class="product-total"><?php echo esc_html( $total['value'] ); ?></td><?php // @codingStandardsIgnoreLine ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tfoot>
				</table>

				<div id="payment" class="mytravel-checkout-payment pt-4 pb-5 px-5">
					<?php if ( $order->needs_payment() ) : ?>

						<?php if ( ! empty( $available_gateways ) ) : ?>
							<ul class="d-block d-md-flex nav nav-classic nav-choose border-0 nav-justified border mx-n3">
								<?php foreach ( $available_gateways as $gateway ) : ?>
								<li class="nav-item mx-3 mb-4 mb-md-0">
									<input id="mytravel_payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" name="payment_method" class="form-check-input d-inline" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>">
									<?php
									$form_label_class = 'form-check-label rounded py-5 border-width-2 border nav-link font-weight-medium';
									if ( $gateway->chosen ) {
										$form_label_class .= ' active';
									}
									?>
									<label for="mytravel_payment_method_<?php echo esc_attr( $gateway->id ); ?>" class="<?php echo esc_attr( $form_label_class ); ?>" data-toggle="tab" data-target="#payment_method_<?php echo esc_attr( $gateway->id ); ?>">
										<div class="height-25 width-25 flex-content-center bg-primary rounded-circle position-absolute left-0 top-0 ml-2 mt-2">
											<i class="flaticon-tick text-white font-size-15"></i>
										</div>

										<div class="d-md-flex justify-content-md-center align-items-md-center flex-wrap">
											<div class="w-100 text-dark"><?php echo esc_html( $gateway->get_title() ); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></div>
										</div>
									</label>
								</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<div class="wc_payment_methods payment_methods methods list-unstyled tab-content pt-7">
							<?php
							if ( ! empty( $available_gateways ) ) {
								foreach ( $available_gateways as $gateway ) {
									wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
								}
							} else {
								echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'mytravel' ) ) . '</li>'; // @codingStandardsIgnoreLine
							}
							?>
						</div>
					<?php endif; ?>
					<div class="form-row">
						<input type="hidden" name="woocommerce_pay" value="1" />

						<?php wc_get_template( 'checkout/terms.php' ); ?>

						<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

						<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

						<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

						<?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
