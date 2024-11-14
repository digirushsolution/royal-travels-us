<?php
/**
 * Room Title and Price
 */

defined( 'ABSPATH' ) || exit;

global $product;

?><div class="border-bottom">
	<div class="px-4 py-4">
		<div class="font-weight-medium font-size-19"><?php echo esc_html( $product->get_name() ); ?></div>
		<div class="mt-2 font-size-14 text-gray-1">
		<?php
			$price_html = str_replace( 'woocommerce-Price-amount font-size-24 text-gray-6 font-weight-bold ml-1', 'woocommerce-Price-amount font-weight-bold font-size-24 ml-1', $product->get_price_html() );
			echo wp_kses( $price_html, 'room-price' );
		?>
		</div>
	</div>
</div>
