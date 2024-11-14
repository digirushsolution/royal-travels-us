<?php
/**
 * Template functions used globally
 */

if ( ! function_exists( 'mytravel_gold_star_rating_html' ) ) {
	/**
	 * Display gold star rating HTML
	 *
	 * @param string $star_class  Icon name.
	 * @param string $wrap_class  Wrapper name.
	 * @param string $star_tag  Star tag name.
	 * @param string $wrap_tag  Wrap tag name.
	 */
	function mytravel_gold_star_rating_html( $star_class = 'fas fa-star small', $wrap_class = 'green-lighter', $star_tag = 'div', $wrap_tag = 'div' ) {

		$star_rating = mytravel_get_golden_star_rating();

		$desc = esc_html__( 'Gold Star Rating are provided by the property to reflect the comfort, facilities and amenities you can expect.', 'mytravel' );
		/* translators: 1: Star rating */
		$desc = sprintf( esc_html__( '%s star.', 'mytravel' ), $star_rating ) . ' ' . $desc;

		?><<?php echo esc_html( $wrap_tag ); ?> class="<?php echo esc_attr( $wrap_class ); ?>" data-toggle="tooltip" data-title="<?php echo esc_attr( $desc ); ?>">
		<?php

		for ( $i = 1; $i <= $star_rating; $i++ ) :

			?>
				<<?php echo esc_html( $star_tag ); ?> class="<?php echo esc_attr( $star_class ); ?>"></<?php echo esc_html( $star_tag ); ?>>
							<?php
							echo "\n";

			endfor;

		?>
		</<?php echo esc_html( $wrap_tag ); ?>>
		<?php
	}
}

if ( ! function_exists( 'mytravel_container_open' ) ) {
	/**
	 *  Output container wrapper start
	 */
	function mytravel_container_open() {
		?>
		<div class="container">
		<?php
	}
}

if ( ! function_exists( 'mytravel_container_close' ) ) {
	/**
	 *  Output container wrapper end
	 */
	function mytravel_container_close() {
		?>
		</div><!-- /.container -->
		<?php
	}
}
