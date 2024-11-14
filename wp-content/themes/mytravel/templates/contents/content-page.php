<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package mytravel
 */

?>

<article id="post-<?php the_ID(); ?>">
	<?php
	/**
	 * Functions hooked in to mytravel_page add_action
	 *
	 * @hooked mytravel_page_header          - 10
	 * @hooked mytravel_page_content         - 20
	 */
	do_action( 'mytravel_page' );
	?>
</article><!-- #post-## -->
