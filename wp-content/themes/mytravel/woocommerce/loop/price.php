<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

$price_html = $product->get_price_html();

$layout = mytravel_get_product_format();

if ( is_product() ) {
	$class = 'text-gray-1';
} else {
	$class = 'text-white';
}

if ( 'yacht' === $layout ) {
	$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'd-none' : 'font-size-14 ' . $class . '';
} elseif ( 'tour' === $layout ) {
	$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'mr-1 font-size-14 text-gray-1' : 'mr-1 ' . $class . '';
} elseif ( 'activity' === $layout ) {
	$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'mr-1 font-size-14' : 'mr-1 font-size-14 text-gray-1';
} elseif ( 'rental' === $layout || 'car_rental' === $layout ) {
	$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'd-none' : 'mr-1 font-size-14 mb-2 d-inline-block ' . $class . '';
} else {
	$price_class = 'mr-1 font-size-14 text-gray-1';
}


if ( $price_html ) : ?>
	<span class="price">
		<?php
		echo wp_kses( $price_html, 'price-html' );
		?>
	</span>
<?php endif; ?>
