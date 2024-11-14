<?php
/**
 * Template functions used in Review
 */

if ( ! function_exists( 'mytravel_wc_review_display_gravatar' ) ) {
	/**
	 * Display gravatar review
	 *
	 * @param array $comment the comment array.
	 */
	function mytravel_wc_review_display_gravatar( $comment ) {
		echo get_avatar( $comment, '85', '', '', array( 'class' => 'img-fluid mb-3 mb-md-0 rounded-circle' ) );
	}
}

if ( ! function_exists( 'mytravel_wc_review_display_meta_secondary' ) ) {
	/**
	 * Display review meta
	 *
	 * @param array $comment the comment array.
	 */
	function mytravel_wc_review_display_meta_secondary( $comment ) {

		$title  = get_comment_meta( $comment->comment_ID, 'comment_title', true );
		$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

		?><div class="d-flex align-items-center flex-column flex-md-row mb-2">
		<?php

		if ( $rating && wc_review_ratings_enabled() ) :

			$rating_text = sprintf( '%s /5', mytravel_format_rating( $rating ) );

			?>
			<button type="button" class="btn btn-xs btn-primary rounded-xs font-size-14 py-1 px-2 mr-2 mb-2 mb-md-0"><?php echo esc_html( $rating_text ); ?></button>
			<?php

			endif;

		if ( $title ) :

			?>
			<span class="font-weight-bold text-gray-3"><?php echo esc_html( $title ); ?></span>
			<?php

			endif;

		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_wc_review_display_comment_text' ) ) {
	/**
	 * Display comment text
	 */
	function mytravel_wc_review_display_comment_text() {
		?>
		<div class="description text-lh-1dot6 mb-0 pr-lg-5">
		<?php
			comment_text();
		?>
		</div>
		<?php
	}
}
