<?php
/**
 * Template Hooks used in Review
 */

remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
add_action( 'woocommerce_review_before', 'mytravel_wc_review_display_gravatar', 10 );

remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );

add_action( 'woocommerce_review_meta', 'mytravel_wc_review_display_meta_secondary', 20 );

remove_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );
add_action( 'woocommerce_review_comment_text', 'mytravel_wc_review_display_comment_text', 10 );
