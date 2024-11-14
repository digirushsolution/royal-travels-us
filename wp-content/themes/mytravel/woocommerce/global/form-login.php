<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     7.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login mb-3 px-md-4" method="post" <?php echo isset( $hidden ) && $hidden ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ! empty( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<div class="mb-3 form-row form-row-first rounded-sm pb-1 mx-0">
		<label class="form-label sr-only" for="username"><?php esc_html_e( 'Username or email', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
		<div class="input-group">
			<input type="text" class="input-text form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e( 'Email Or Username', 'mytravel' ); ?>"/>
			<div class="input-group-append">
				<span class="input-group-text" id="signinEmail">
					<span class="far fa-envelope font-size-20"></span>
				</span>
			</div>
		</div>
	</div>

	<div class="mb-3 form-row form-row-last rounded-sm pb-1 mx-0">
		<label class="form-label sr-only" for="password"><?php esc_html_e( 'Password', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
		<div class="input-group">
			<input class="input-text form-control" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e( 'Password', 'mytravel' ); ?>" />
			<div class="input-group-prepend">
				<span class="input-group-text py-1" id="signinPassword">
					<span class="flaticon-password font-size-20"></span>
				</span>
			</div>
		</div>
	</div>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="mb-3 pb-1 login-button">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
		<button type="submit" class="woocommerce-button button woocommerce-form-login__submit btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Login', 'mytravel' ); ?>"><?php esc_html_e( 'Login', 'mytravel' ); ?></button>
	</div>

	<div class="remember-me d-md-flex justify-content-between mb-1">
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" id="customCheckboxInline1" name="rememberme" class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox">
			<label class="custom-control-label woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme font-size-14 text-gray-1" for="customCheckboxInline1"><?php esc_html_e( 'Remember me', 'mytravel' ); ?></label>
		</div>
		<a class="text-primary font-size-14" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><u><?php esc_html_e( 'Lost your password?', 'mytravel' ); ?></u></a>
	</div>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
