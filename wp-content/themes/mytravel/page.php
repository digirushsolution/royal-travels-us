<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package mytravel
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php do_action( 'mytravel_page_before' ); ?>

			<div class="container mb-5 mb-lg-8 space-y-6">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'templates/contents/content', 'page' );

					/**
					 * Functions hooked in to mytravel_page_after action
					 *
					 * @hooked mytravel_display_comments - 10
					 */
					do_action( 'mytravel_page_after' );

				endwhile; // End of the loop.
				?>

			</div><!-- #container -->
			<?php do_action( 'mytravel_site_main_before' ); ?>
			<?php do_action( 'mytravel_page_content_after' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'mytravel_sidebar' );
get_footer();
