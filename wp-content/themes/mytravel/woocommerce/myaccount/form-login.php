<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$is_registration_enabled = false;

if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) {
	$is_registration_enabled = true;
}
?>
<div class="space-1">
	<div class="row align-items-center justify-content-center">
		<div class="col-xl-5 col-md-8 py-8 py-xl-0">
			<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

			<div class="card rounded-xs u-header__login-form">

				<div id="view-login" class="view show" data-view-default>
					<form name="woocommerce-form woocommerce-form-login login" method="post">
						<div class="card-header text-center">
							<h3 class="h5 mb-0 font-weight-semi-bold"><?php echo esc_html__( 'Login', 'mytravel' ); ?></h3>
						</div>

						<div class="card-body px-4 px-md-10 py-5">

							<?php do_action( 'woocommerce_login_form_start' ); ?>

							<div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group pb-1">
								<div class="border border-width-2 border-color-8 rounded-sm">
									<label class="sr-only form-label" for="username"><?php esc_html_e( 'Username or email', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
									<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
										<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_attr_e( 'Email or username', 'mytravel' ); ?>" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php //phpcs:ignore ?>
										<div class="input-group-append">
											<span class="input-group-text" id="signinEmail">
												<span class="far fa-envelope font-size-20"></span>
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="woocommerce-form-row woocommerce-form-row--wide form-row-wide form-group pb-1">
								<div class="border border-width-2 border-color-8 rounded-sm">
									<label class="sr-only form-label" for="password"><?php esc_html_e( 'Password', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
									<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
										<input class="woocommerce-Input5 woocommerce-Input--text5 input-text form-control" type="password" name="password" id="password" placeholder="<?php esc_attr_e( 'Password', 'mytravel' ); ?>" autocomplete="current-password" />
										<div class="input-group-prepend">
											<span class="input-group-text py-1" id="signinPassword">
												<span class="flaticon-password font-size-20"></span>
											</span>
										</div>
									</div>
								</div>
							</div>

							<?php do_action( 'woocommerce_login_form' ); ?>
							<div class="mb-3 pb-1">
								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
								<button type="submit" class="btn btn-primary woocommerce-button button woocommerce-form-login__submit btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Sign in', 'mytravel' ); ?>"><?php esc_html_e( 'Sign in', 'mytravel' ); ?></button>
							</div>

							<div class="d-md-flex justify-content-between mb-1">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input type="checkbox" id="rememberme" class="woocommerce-form__input woocommerce-form__input-checkbox form-check-input custom-control-input" name="rememberme"/>
									<label class="custom-control-label form-check-label woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme font-size-14 text-gray-1" for="rememberme"><?php esc_html_e( 'Remember me', 'mytravel' ); ?></label>
								</div>
								<a class="d-block d-md-inline-block text-primary font-size-14" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'mytravel' ); ?></a>

							</div>

						</div>

					</form>
					<?php if ( $is_registration_enabled ) { ?>
						<div class="card-footer p-0">
							<div class="card-footer__bottom p-4 text-center font-size-14">
								<span class="text-gray-1"><?php echo esc_html__( 'Do not have an account?', 'mytravel' ); ?></span>
								<a class="font-weight-bold" href="#view-signup" data-view="#view-signup"><?php echo esc_html__( 'Sign Up', 'mytravel' ); ?></a>
							</div>
						</div>
						<?php
					}

					do_action( 'woocommerce_login_form_end' );
					?>

				</div><!-- /.card -->

				<?php if ( $is_registration_enabled ) { ?>

					<div id="view-signup" class="view">	
						<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
							<div class="card-header text-center">
								<h3 class="h5 mb-0 font-weight-semi-bold"><?php echo esc_html__( 'Register', 'mytravel' ); ?></h3>
							</div>

							<div class="card-body px-4 px-md-10 py-5">

								<?php do_action( 'woocommerce_register_form_start' ); ?>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

									<div class="form-group pb-1 woocommerce-form-row woocommerce-form-row--wide form-row-wide">
										<div class="border border-width-2 border-color-8 rounded-sm">
											<label class="sr-only form-label" for="reg_username"><?php esc_html_e( 'Username', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
											<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
												<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" placeholder="<?php esc_attr_e( 'Username', 'mytravel' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php //phpcs:ignore ?>
												<div class="input-group-append">
													<span class="input-group-text" id="username">
														<span class="flaticon-user font-size-20"></span>
													</span>
												</div>
											</div>
										</div>
									</div>

								<?php endif; ?>

								<div class="form-group pb-1 woocommerce-form-row woocommerce-form-row--wide form-row-wide">
									<div class="border border-width-2 border-color-8 rounded-sm">
										<label class="sr-only form-label" for="reg_email"><?php esc_html_e( 'Email address', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
										<div class="input-group input-group-tranparent input-group-borderless input-group-radiusless">
											<input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email" placeholder="<?php esc_attr_e( 'Email', 'mytravel' ); ?>" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php //phpcs:ignore ?>
											<div class="input-group-append">
												<span class="input-group-text" id="signupEmail">
													<span class="far fa-envelope font-size-20"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

									<div class="form-group mb-0 position-relative woocommerce-form-row woocommerce-form-row--wide form-row-wide">

										<label class="sr-only form-label" for="reg_password"><?php esc_html_e( 'Password', 'mytravel' ); ?>&nbsp;<span class="required">*</span></label>
										<input type="password" class="woocommerce-Input6 woocommerce-Input--text6 input-text form-control" name="password" id="reg_password" placeholder="<?php esc_attr_e( 'Password', 'mytravel' ); ?>" autocomplete="new-password" />
										<div class="password-icon input-group-append position-absolute">
											<span class="input-group-text border-0" id="username">
												<span class="flaticon-user font-size-20"></span>
											</span>
										</div>
									</div>
								<?php else : ?>
								<p><?php esc_html_e( 'A password will be sent to your email address.', 'mytravel' ); ?></p>
								<?php endif; ?>
								<?php do_action( 'woocommerce_register_form' ); ?>
									<div class="woocommerce-form-row mb-3 pb-1">
										<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
										<button type="submit" class="btn btn-primary woocommerce-Button woocommerce-button button woocommerce-form-register__submit btn btn-md btn-block btn-blue-1 rounded-xs font-weight-bold transition-3d-hover<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="register" value="<?php esc_attr_e( 'Register', 'mytravel' ); ?>"><?php esc_html_e( 'Register', 'mytravel' ); ?></button>
									</div>
								<?php do_action( 'woocommerce_register_form_end' ); ?>
							</div>
							<div class="card-footer p-0">
								<div class="card-footer__bottom p-4 text-center font-size-14">
									<span class="text-gray-1"><?php echo esc_html__( 'Already have an account?', 'mytravel' ); ?></span>
									<a class="font-weight-bold" href="#view-login" data-view="#view-login"><?php echo esc_html__( 'Log In', 'mytravel' ); ?></a>
								</div>
							</div>
						</form>
					</div>
					<?php

				}
				?>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
