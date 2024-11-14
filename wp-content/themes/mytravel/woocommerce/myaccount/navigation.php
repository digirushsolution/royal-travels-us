<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$default_icons = [
	'dashboard'       => 'fa-tachometer-alt',
	'orders'          => 'fa-shopping-basket',
	'downloads'       => 'fa-file-archive',
	'edit-address'    => 'fa-home',
	'edit-account'    => 'fa-user',
	'payment-methods' => 'fa-credit-card',
	'customer-logout' => 'fa-sign-out-alt',
];

?>

<nav class="woocommerce-MyAccount-navigation">
	<ul class="list-group list-group-flush list-group-borderless mb-0 border rounded">
		<?php
		foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
			$default_icon = isset( $default_icons[ $endpoint ] ) ? $default_icons[ $endpoint ] : '';
			$icon_class   = get_theme_mod( "mytravel_wc_endpoint_{$endpoint}_icon", $default_icon );
			?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">                    
				<a class="list-group-item list-group-item-action d-flex align-items-center justify-content-between p-3 border-bottom" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
					<?php
					echo esc_html( $label );
					if ( ! empty( $icon_class ) ) :
						?>
							<i class="fas <?php echo esc_attr( $icon_class ); ?> align-middle"></i>
						<?php endif; ?>
					</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
