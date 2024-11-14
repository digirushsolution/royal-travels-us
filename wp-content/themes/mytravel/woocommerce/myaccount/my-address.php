<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
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

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => esc_html__( 'Billing address', 'mytravel' ),
			'shipping' => esc_html__( 'Shipping address', 'mytravel' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => esc_html__( 'Billing address', 'mytravel' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'mytravel' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="row woocommerce-Addresses addresses mb-3">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="col-lg-6 mb-4 mb-lg-0 woocommerce-Address">
		<div class="border rounded-sm p-4 h-100">
			<header class="woocommerce-Address-title title d-flex justify-content-between">
				<h3 class="h5"><?php echo esc_html( $address_title ); ?></h3>
				<?php
				if ( $address ) {
					$anchor_text = esc_html__( 'Edit', 'mytravel' );
				} else {
					$anchor_text = esc_html__( 'Add', 'mytravel' );
				}
				?>
				<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="btn btn-outline-white btn-sm edit"><?php echo esc_html( $anchor_text ); ?></a>
			</header>

			<address>
			<?php
				$getter  = 'get_billing';
				$address = array();

			if ( 0 === $customer_id ) {
				$customer_id = get_current_user_id();
			}

				$customer = new WC_Customer( $customer_id );

			if ( is_callable( array( $customer, $getter ) ) ) {
				$address = $customer->$getter();
				unset( $address['email'], $address['tel'] );
			}

				$address_title = '';
			if ( isset( $address['company'] ) ) {
				$address_title = $address['company'];
				unset( $address['company'] );
			} elseif ( isset( $address['first_name'], $address['last_name'] ) ) {
				$address_title = $address['first_name'] . ' ' . $address['last_name'];
				unset( $address['first_name'] );
				unset( $address['last_name'] );
			}

			if ( ! empty( $address_title ) ) {
				?>
					<span class="d-block h6 text-dark"><?php echo esc_html( $address_title ); ?></span>
					<?php
			}

				$address = WC()->countries->get_formatted_address( apply_filters( 'woocommerce_my_account_my_address_formatted_address', $address, $customer->get_id(), 'billing' ) );

			if ( $address ) {
				echo wp_kses_post( $address );
			} else {
				echo esc_html__( 'You have not set up this type of address yet.', 'mytravel' );
			}
			?>
			</address>
		</div>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
<?php endif; ?>
