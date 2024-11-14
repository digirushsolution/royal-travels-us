<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item-data.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="variation">
	<?php
	foreach ( $item_data as $data ) :
		$variation_name = 'd-xl-inline-flex';
		if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
			$variation_name = ' variation-date ml-0';
		}

		if ( isset( $data['date'] ) && 'start' === $data['date'] ) {
			?>
				<div class="ml-0 booking-dates w-100">
			<?php } ?>
				<div class="align-items-center<?php echo esc_attr( $variation_name ); ?>">
					<span class="dt text-nowrap label <?php echo sanitize_html_class( 'variation-' . $data['key'] ); ?>"><?php echo wp_kses_post( $data['key'] ); ?>:</span>
					<span class="text-gray-1 font-weight-normal dd value <?php echo sanitize_html_class( 'variation-' . $data['key'] ); ?>"><?php echo wp_kses_post( $data['display'] ); ?></span> 
				</div>     
			<?php
			if ( isset( $data['date'] ) && 'end' === $data['date'] ) {
				?>
				</div>
				<?php } ?>
			
	<?php endforeach; ?>
</div>
