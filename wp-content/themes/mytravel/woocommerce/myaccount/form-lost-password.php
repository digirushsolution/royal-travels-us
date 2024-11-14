<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
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
			<?php do_action( 'woocommerce_before_lost_password_form' ); ?>

			<div class="card rounded-xs u-header__login-form">
				<form method="post" class="woocommerce-ResetPassword lost_reset_password">
					<div class="card-header text-center">
						<h3 class="h5 mb-0 font-weight-semi-bold"><?php echo esc_html__( 'Recover Password', 'mytravel' ); ?></h3>
					</div>
					<div class="card-body px-4 px-md-10 py-5">
						<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'mytravel' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

						<div class="form-group woocommerce-form-row woocommerce-form-row--first form-row-first">
							<div class="js-form-message js-focus-state border border-width-2 border-color-8 rounded-sm">
								<label class="sr-only" for="user_login"><?php esc_html_e( 'Username or email', 'mytravel' ); ?></label>
								<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
									<input class="woocommerce-Input woocommerce-Input--text input-text form-control height-50" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_attr_e( 'Your email', 'mytravel' ); ?>"/>
									<div class="input-group-append">
										<span class="input-group-text" id="recoverEmail">
											<span class="far fa-envelope font-size-20"></span>
										</span>
									</div>
								</div>
							</div>
						</div>

						<div class="clear"></div>

						<?php do_action( 'woocommerce_lostpassword_form' ); ?>

						<div class="woocommerce-form-row mb-2">
							<input type="hidden" name="wc_reset_password" value="true" />
							<button type="submit" class="woocommerce-Button button btn btn-sm btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e( 'Reset password', 'mytravel' ); ?>"><?php esc_html_e( 'Reset password', 'mytravel' ); ?></button>
						</div>
						<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );
