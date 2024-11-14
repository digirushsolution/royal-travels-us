<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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

?>
<div class="bg-gray space-1">
	<div class="row align-items-center justify-content-center">
		<div class="col-lg-5 col-md-8 py-8 py-xl-0">
			<?php do_action( 'woocommerce_before_reset_password_form' ); ?>

			<div class="card rounded-xs u-header__login-form">
				<form method="post" class="woocommerce-ResetPassword lost_reset_password">
					<div class="card-body px-4 px-md-10 py-5">

						<p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'mytravel' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

						<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
							<label class="form-label" for="password_1"><?php esc_html_e( 'New password', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
							<input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" />
						</p>
						<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
							<label class="form-label" for="password_2"><?php esc_html_e( 'Re-enter new password', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
							<input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" />
						</p>

						<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
						<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

						<div class="clear"></div>

						<?php do_action( 'woocommerce_resetpassword_form' ); ?>

						<p class="woocommerce-form-row form-row">
							<input type="hidden" name="wc_reset_password" value="true" />
							<button type="submit" class="woocommerce-Button button btn btn-sm btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e( 'Save', 'mytravel' ); ?>"><?php esc_html_e( 'Save', 'mytravel' ); ?></button>
						</p>

						<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_reset_password_form' );

