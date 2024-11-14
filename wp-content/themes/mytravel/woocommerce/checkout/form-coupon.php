<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="py-4 px-5 mytravel-coupon shadow-soft bg-white rounded-sm mb-5">
	<div class="woocommerce-form-coupon-toggle">
		<?php echo wp_kses_post( apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'mytravel' ) . sprintf( '<a class="showcoupon" href="#">%s</a>', __( ' Click here to enter your code', 'mytravel' ) ) ) ); ?>
	</div>
   
	<form class="mx-0 checkout_coupon woocommerce-form-coupon row border-top mt-4" method="post" style="display:none">

		<p class="col-md-12 pt-3"><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'mytravel' ); ?></p>

		<p class="form-row form-row-first col-md-6">
			<input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'mytravel' ); ?>" id="coupon_code" value="" />
		</p>

		<p class="form-row form-row-last col-md-6">
			<button type="submit" class="btn btn-primary button btn-sm<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'mytravel' ); ?>"><?php esc_html_e( 'Apply coupon', 'mytravel' ); ?></button>
		</p>

		<div class="clear"></div>
	</form>
</div>
