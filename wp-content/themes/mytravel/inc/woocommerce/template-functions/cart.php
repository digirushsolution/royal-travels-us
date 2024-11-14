<?php
/**
 * Template functions used in cart.php
 */

if ( ! function_exists( 'mytravel_empty_cart_message' ) ) {
	/**
	 * Empty Cart Message
	 */
	function mytravel_empty_cart_message() {
		echo '<p class="cart-empty font-size-40 mb-4 text-dark">' . esc_html( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'mytravel' ) ) ) . '</p>';

	}
}

if ( ! function_exists( 'mytravel_cart_content_wrap' ) ) {
	/**
	 *  Output cart content wrap start
	 */
	function mytravel_cart_content_wrap() {
		if ( is_cart() || is_checkout() || ( is_account_page() && ! is_user_logged_in() ) ) {
			?><div class="bg-gray space-2">
			<?php
		}
	}
}


if ( ! function_exists( 'mytravel_cart_content_wrap_end' ) ) {
	/**
	 *  Output cart content wrap end
	 */
	function mytravel_cart_content_wrap_end() {
		if ( is_cart() || is_checkout() ) {
			?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_cart_wrapper_start' ) ) {
	/**
	 *  Output cart wrapper start
	 */
	function mytravel_cart_wrapper_start() {
		?>
		<div class="row">
			<div id="cart-primary" class="content-area col-lg-8">
			<?php
	}
}

if ( ! function_exists( 'mytravel_cart_wrapper_end' ) ) {
	/**
	 *  Output cart wrapper end
	 */
	function mytravel_cart_wrapper_end() {
		?>
		</div><!-- /#primary -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_cart_collaterals_wrapper_start' ) ) {
	/**
	 *  Output cart collaterals wrapper start
	 */
	function mytravel_cart_collaterals_wrapper_start() {
		?>
		<div id="secondary" class="sidebar col-lg-4">
			<div class="shadow-soft bg-white rounded-sm">
			<?php
	}
}

if ( ! function_exists( 'mytravel_cart_collaterals_wrapper_end' ) ) {
	/**
	 *  Output cart collaterals wrapper end
	 */
	function mytravel_cart_collaterals_wrapper_end() {
		?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_output_cross_sell_products' ) ) {
	/**
	 * Cross sell products display count
	 */
	function mytravel_output_cross_sell_products() {
		if ( apply_filters( 'mytravel_enable_cross_sell_products', true ) ) {
			woocommerce_cross_sell_display( 4, 4 );
		}
	}
}

if ( ! function_exists( 'mytravel_wc_cart_totals_coupon_html' ) ) {
	/**
	 * Override coupons HTML
	 *
	 * @param string           $coupon_html Coupon HTML.
	 * @param string|WC_Coupon $coupon Coupon data or code.
	 * @param string           $discount_amount_html Discount price HTML.
	 */
	function mytravel_wc_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {

		$coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '"><i class="fas fa-trash"></i></a>';

		echo wp_kses( $coupon_html, array_replace_recursive( wp_kses_allowed_html( 'post' ), array( 'a' => array( 'data-coupon' => true ) ) ) );
	}
}

/* Checkout */

if ( ! function_exists( 'mytravel_payment_method_wrap_start' ) ) {
	/**
	 *  Output checkout payment method wrapper start
	 */
	function mytravel_payment_method_wrap_start() {
		?>
		<div class="row">
		<?php
	}
}

if ( ! function_exists( 'mytravel_payment_method_wrap_end' ) ) {
	/**
	 *  Output checkout payment method wrapper end
	 */
	function mytravel_payment_method_wrap_end() {
		?>
		</div>
		<?php
	}
}

/* My Account */

if ( ! function_exists( '_wc_account_wrapper_start' ) ) {
	/**
	 *  Output my account wrapper start
	 */
	function mytravel_wc_account_wrapper_start() {
		?>
		<div class="row space-2">
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_account_nav_wrapper_start' ) ) {
	/**
	 *  Output my account navigation wrapper start
	 */
	function mytravel_wc_account_nav_wrapper_start() {
		?>
		<div class="col-md-4">
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_account_nav_wrapper_close' ) ) {
	/**
	 *  Output my account navigation wrapper end
	 */
	function mytravel_wc_account_nav_wrapper_close() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_account_content_wrapper_start' ) ) {
	/**
	 *  Output my account content wrapper start
	 */
	function mytravel_wc_account_content_wrapper_start() {
		?>
		<div class="col-md-8"><div class="pl-lg-3 pt-3 wc-account-content-inner">
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_account_content_wrapper_close' ) ) {
	/**
	 *  Output my account content wrapper end
	 */
	function mytravel_wc_account_content_wrapper_close() {
		?>
		</div></div>
		<?php
	}
}
