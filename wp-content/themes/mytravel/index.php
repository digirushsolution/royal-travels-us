<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytravel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :

			do_action( 'mytravel_index_before' );

			get_template_part( 'loop' );

			do_action( 'mytravel_index_after' );


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
