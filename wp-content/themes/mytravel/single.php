<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mytravel
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php

			while ( have_posts() ) :
				the_post();

				/**
				 * Fires before the single post content
				 */
				do_action( 'mytravel_single_post_before' );

				get_template_part( 'templates/contents/content', 'single' );

				/**
				 * Fires after the single post content
				 */
				do_action( 'mytravel_single_post_after' );

			endwhile;
			do_action( 'mytravel_site_main_before' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'mytravel_sidebar' );
get_footer();

