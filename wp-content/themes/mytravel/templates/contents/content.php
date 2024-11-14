<?php
/**
 * Template part for displaying a post tile in list layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytravel
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-7 position-relative' ); ?>>

	<?php
	/**
	 * Functions hooked in to mytravel_loop_post action.
	 *
	 * @hooked mytravel_loop_post_thumbnail          - 10
	 * @hooked mytravel_loop_post_title              - 20
	 * @hooked mytravel_loop_post_meta               - 30
	 * @hooked mytravel_loop_post_excerpt            - 40
	 */
	do_action( 'mytravel_loop_post' );
	?>

</article><!-- #post-## -->
