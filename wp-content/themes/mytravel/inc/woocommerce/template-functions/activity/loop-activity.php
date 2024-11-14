<?php
if ( ! function_exists( 'mytravel_activity_loop_list_view_title' ) ) {
	/**
	 *  Output activity loop list view title
	 */
	function mytravel_activity_loop_list_view_title() {
		global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		?><a href="<?php echo esc_url( $link ); ?>" class="mr-xl-5 d-block text-dark">
			<span class="font-weight-bold font-size-17 mr-xl-9 d-block"><?php the_title(); ?></span>
		</a>
		<?php
	}
}
