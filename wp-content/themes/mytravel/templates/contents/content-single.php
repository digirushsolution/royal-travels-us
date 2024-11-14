<?php
/**
 * Template for displaying single post with sidebar
 *
 * This is a fallback template.
 *
 * @see single.php
 *
 * @package mytravel
 */

$blog_layout = function_exists( 'mytravel_post_sidebar' ) ? mytravel_post_sidebar() : 'right-sidebar';
$has_sidebar = mytravel_blog_has_sidebar();


$post_class  = $has_sidebar ? 'col-lg-8 col-xl-9' : 'col-lg-9 mx-auto';
$post_class .= ' article__content space-y-6';
if ( 'left-sidebar' === $blog_layout ) {
	$post_class .= ' order-lg-1';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

	<?php
	do_action( 'mytravel_single_post_top', $blog_layout );

	/**
	 * Functions hooked into mytravel_single_post add_action
	 *
	 * @hooked mytravel_post_header          - 10
	 * @hooked mytravel_post_meta            - 20
	 * @hooked mytravel_single_post_content         - 30
	 */
	do_action( 'mytravel_single_post', $blog_layout );

	/**
	 * Functions hooked in to mytravel_single_post_bottom action
	 *
	 * @hooked mytravel_post_nav         - 10
	 * @hooked mytravel_display_comments - 20
	 */
	do_action( 'mytravel_single_post_bottom', $blog_layout );
	?>

</article><!-- #post-## -->
