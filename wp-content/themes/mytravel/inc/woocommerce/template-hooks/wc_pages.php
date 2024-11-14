<?php
/**
 * Template hooks used in WC pages
 */

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

add_filter( 'woocommerce_cart_totals_coupon_html', 'mytravel_wc_cart_totals_coupon_html', 10, 3 );

add_action( 'woocommerce_cart_is_empty', 'mytravel_empty_cart_message', 10 );
add_action( 'woocommerce_after_cart', 'mytravel_output_cross_sell_products', 20 );

add_action( 'mytravel_page_before', 'mytravel_cart_content_wrap', 10 );
add_action( 'woocommerce_before_cart', 'mytravel_cart_wrapper_start', 20 );
add_action( 'woocommerce_before_cart_collaterals', 'mytravel_cart_wrapper_end', 10 );

add_action( 'woocommerce_before_cart_collaterals', 'mytravel_cart_collaterals_wrapper_start', 20 );
add_action( 'woocommerce_after_cart', 'mytravel_cart_collaterals_wrapper_end', 10 );

add_action( 'mytravel_page_content_after', 'mytravel_cart_content_wrap_end', 20 );

add_filter( 'woocommerce_add_to_cart_fragments', 'mytravel_cart_link_fragment' );


/**
 * Checkout
 */

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 10 );

add_action( 'woocommerce_credit_card_form_start', 'mytravel_payment_method_wrap_start', 10 );
add_action( 'woocommerce_credit_card_form_end', 'mytravel_payment_method_wrap_end', 10 );


/**
 * MyAccount
 */
add_action( 'woocommerce_account_navigation', 'mytravel_wc_account_wrapper_start', 5 );
add_action( 'woocommerce_before_account_navigation', 'mytravel_wc_account_nav_wrapper_start', 5 );

add_action( 'woocommerce_after_account_navigation', 'mytravel_wc_account_nav_wrapper_close', 5 );
add_action( 'woocommerce_after_account_navigation', 'mytravel_wc_account_content_wrapper_start', 10 );
add_action( 'woocommerce_account_content', 'mytravel_wc_account_content_wrapper_close', 15 );
