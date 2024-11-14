<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit; ?>

<?php
do_action( 'woocommerce_before_mini_cart' );
$image_size = apply_filters( 'mytravel_mini_cart_size', 'woocommerce_thumbnail' );

if ( ! WC()->cart->is_empty() ) :
	?>

	<div class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>

				<div class="woocommerce-mini-cart-item px-2 px-md-3 py-2 py-md-1 border-bottom border-color-8 <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">

					<div class="media p-2 p-md-3">
						<div class="u-avatar u-lg-avatar-md mr-2 mr-md-3">
							<?php if ( empty( $product_permalink ) ) : ?>
								<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php else : ?>
								<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( $image_size, array( 'class' => 'img-fluid rounded-pill width-80 height-80' ) ), $cart_item, $cart_item_key ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php endif; ?>
						</div>
						<div class="media-body position-relative pl-md-1">
							<div class="d-flex justify-content-between align-items-start mb-2 mb-md-3">
								<?php if ( ! empty( $product_name ) ) : ?>
									<span class="d-block text-dark font-weight-bold"><?php echo wp_kses_post( $product_name ); ?></span>
								<?php endif; ?>
								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="remove remove_from_cart_button close close-rounded right-0 ml-2" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="fas fa-trash"></i></a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_attr__( 'Remove this item', 'mytravel' ),
											esc_attr( $product_id ),
											esc_attr( $cart_item_key ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									);
								?>
							</div>
							<?php if ( ! empty( $product_price ) ) : ?>
								<span class="d-block text-gray-1"><?php esc_html_e( 'Price ', 'mytravel' ); ?><?php echo wp_kses_post( $product_price ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php
		}
		do_action( 'woocommerce_mini_cart_contents' );
		?>

	</div>

	<div class="card-footer border-0 p-3 px-md-5 py-md-4">
		<div class="mb-4 pb-md-1">
			<span class="d-block font-weight-semi-bold"><?php esc_html_e( 'Subtotal: ', 'mytravel' ); ?><?php echo WC()->cart->get_cart_subtotal(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		</div>
		<div class="d-md-flex button-inline-group-md mb-1">
			<a class="wc-forward btn btn-block btn-md btn-gray-1 rounded-xs font-weight-bold transition-3d-hover" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
				<?php echo esc_html_x( 'View cart', 'front-end', 'mytravel' ); ?>
			</a>
			<a class="checkout wc-forward btn btn-block btn-md btn-blue-1 rounded-xs font-weight-bold transition-3d-hover mt-md-0 ml-md-5" href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
				<?php echo esc_html_x( 'Checkout', 'front-end', 'mytravel' ); ?>
			</a>
		</div>
		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>

		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	<!-- End Footer -->
	<?php else : ?>
		<div class="cart-empty text-center p-7">            
			<span class="btn btn-icon btn-soft-primary rounded-circle mb-3">
				<span class="flaticon-shopping-basket btn-icon__inner"></span>
			</span>
			<span class="d-block"><?php esc_html_e( 'Your Cart is Empty', 'mytravel' ); ?></span>
		</div>
	<?php endif; ?>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
