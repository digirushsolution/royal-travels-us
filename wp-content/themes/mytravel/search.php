<?php
/**
 * The template for displaying search results pages.
 *
 * @package mytravel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
		if ( have_posts() ) :

			get_template_part( 'loop' );

		else :

			get_template_part( 'templates/contents/content', 'none' );

		endif;
		do_action( 'mytravel_site_main_before' );
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'mytravel_sidebar' );
get_footer();
