<?php
/**
 * Template part for displaying a post tile in grid layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytravel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mb-4 mb-lg-0 text-md-center text-lg-left">
		<?php
		/**
		 * Functions hooked in to mytravel_loop_post action.
		 *
		 * @hooked mytravel_loop_post_thumbnail          - 10
		 * @hooked mytravel_loop_post_title              - 20
		 * @hooked mytravel_loop_post_meta               - 30
		 * @hooked mytravel_loop_post_excerpt            - 40
		 */
		do_action( 'mytravel_loop_post_grid' );
		?>
	</div>
</article><!-- #post-## -->
