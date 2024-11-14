<?php
/**
 * Integrate plugin "YITH WooCommerce Wishlist" into the theme.
 */

add_action( 'init', 'mytravel_yith_wcwl_integration' );
/**
 * Yith integration
 */
function mytravel_yith_wcwl_integration() {
	global $yith_wcwl;

	if ( property_exists( $yith_wcwl, 'wcwl_init' ) ) {
		remove_action( 'wp_enqueue_scripts', array( $yith_wcwl->wcwl_init, 'enqueue_styles_and_stuffs' ) );
	}
	remove_action( 'woocommerce_product_thumbnails', array( YITH_WCWL_Frontend(), 'print_button' ), 21 );
	remove_action( 'woocommerce_single_product_summary', array( YITH_WCWL_Frontend(), 'print_button' ), 31 );
	remove_action( 'woocommerce_after_single_product_summary', array( YITH_WCWL_Frontend(), 'print_button' ), 11 );
}
/**
 * Yith add to wishlist button
 */
function mytravel_add_to_wishlist_button() {
	$button_html = do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	$button_html = str_replace( 'single_add_to_wishlist button', 'single_add_to_wishlist button height-45 width-45 border rounded border-width-2 flex-content-center', $button_html );
	$button_html = str_replace( 'yith-wcwl-icon fa fa-heart-o', 'flaticon-like font-size-18 text-dark', $button_html );
	$button_html = str_replace( '<span>', '<span class="sr-only">', $button_html );

	echo wp_kses( $button_html, 'wishlist-button' );
}

add_action( 'mytravel_single_hotel_sidebar_buttons', 'mytravel_display_wishlist_button', 5 );
add_action( 'mytravel_single_tour_sidebar_buttons', 'mytravel_display_wishlist_button', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'mytravel_wc_template_loop_wishlist_button', 15 );
add_action( 'mytravel_tour_before_shop_loop_item_title', 'mytravel_wc_template_loop_wishlist_button', 25 );
add_action( 'mytravel_activity_before_shop_loop_item_title', 'mytravel_wc_template_loop_wishlist_button', 15 );
add_action( 'mytravel_rental_before_shop_loop_item_title', 'mytravel_wc_template_loop_wishlist_button', 15 );
add_action( 'mytravel_yacht_before_shop_loop_item_title', 'mytravel_wc_template_loop_wishlist_button', 15 );

if ( ! function_exists( 'mytravel_display_wishlist_button' ) ) {
	/**
	 * Display wishlist button
	 *
	 * @param string $buttons Button class.
	 */
	function mytravel_display_wishlist_button( $buttons ) {
		$buttons['wishlist'] = [
			'callback' => 'mytravel_add_to_wishlist_button',
		];
		return $buttons;
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_wishlist_button' ) ) {
	/**
	 * Display loop wishlist button
	 */
	function mytravel_wc_template_loop_wishlist_button() {

		$enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );
		$layout          = mytravel_get_product_format();

		$grid_view_wishlist_classes = '';

		if ( $enabled_on_loop ) {

			if ( 'rental' === $layout || 'car_rental' === $layout ) {
				$grid_view_wishlist_classes = ' pt-5 pr-3';
			} elseif ( 'tour' === $layout ) {
				$grid_view_wishlist_classes = ' pt-5 pr-3 tour-grid-view';
			} else {
				$grid_view_wishlist_classes = ' pt-3 pr-3';
			}

			$wishlist_class  = 'loop-wishlist position-absolute top-0 right-0';
			$wishlist_class .= ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? ' pr-md-3 d-none d-md-block' : $grid_view_wishlist_classes;

			?><div class="<?php echo esc_attr( $wishlist_class ); ?>">
			<?php
				mytravel_loop_add_to_wishlist_button();
			?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_wc_template_loop_map_view_wishlist_button' ) ) {
	/**
	 * Display loop map view wishlist button
	 */
	function mytravel_wc_template_loop_map_view_wishlist_button() {

		$enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );

		if ( $enabled_on_loop ) {

			?>
			<div class="position-absolute top-0 left-0 pt-3 pl-4">
			<?php
				mytravel_loop_add_to_wishlist_button();
			?>
			</div>
			<?php
		}
	}
}

add_filter( 'yith_wcwl_loop_positions', 'mytravel_wcwl_loop_positions', 20 );

/**
 * Get loop posiition
 *
 * @param string $positions Position of wishlist.
 */
function mytravel_wcwl_loop_positions( $positions ) {
	return [
		'on_image' => [
			'hook'     => 'woocommerce_before_shop_loop_item_title',
			'priority' => 10,
		],
	];
}

if ( ! function_exists( 'mytravel_loop_add_to_wishlist_button' ) ) {
	/**
	 * Get loop add to wishlist button
	 */
	function mytravel_loop_add_to_wishlist_button() {

		if ( 'list' === wc_get_loop_prop( 'tab-view' ) ) {
			$heart_icon = 'flaticon-heart-1';
			$btn_class  = 'btn btn-sm btn-icon rounded-circle';
		} else {
			$heart_icon = 'flaticon-valentine-heart';
			$btn_class  = 'btn btn-sm btn-icon text-white rounded-circle';
		}
		$button_html = do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		$button_html = str_replace( 'single_add_to_wishlist', 'single_add_to_wishlist ' . esc_attr( $btn_class ), $button_html );
		$button_html = str_replace( 'yith-wcwl-icon fa fa-heart-o', esc_attr( $heart_icon ) . ' font-size-20', $button_html );
		$button_html = str_replace( '<span>', '<span class="sr-only">', $button_html );
		$button_html = str_replace( 'rel="nofollow"', 'rel="nofollow" data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__( 'Save for later', 'mytravel' ) . '"', $button_html );
		echo wp_kses( $button_html, 'wishlist-button' );
	}
}
