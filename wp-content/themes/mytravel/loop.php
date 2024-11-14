<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package mytravel
 */

$sidebar              = function_exists( 'mytravel_post_sidebar' ) ? mytravel_post_sidebar() : 'right-sidebar';
$has_sidebar          = mytravel_blog_has_sidebar();
$is_header_image      = get_header_image();
$container_wrap_class = 'container mb-5 mb-lg-9 pb-lg-1';

if ( $is_header_image ) {
	$container_wrap_class .= ' pt-lg-1';
}

if ( $has_sidebar ) {
	$content_area_class = 'col-lg-8 col-xl-9';
	if ( 'left-sidebar' === $sidebar ) {
		$content_area_class .= ' order-lg-1';
	}
} else {
	if ( class_exists( 'MAS_Travels' ) ) {
		$content_area_class = 'col-lg-12';
	} else {
		$content_area_class = 'col-lg-9 mx-auto';
	}
}

do_action( 'mytravel_loop_before' ); ?>
	<div class="<?php echo esc_attr( $container_wrap_class ); ?>">
		<?php do_action( 'mytravel_posts_content_before' ); ?>

		<div class="row">
			<div class="<?php echo esc_attr( $content_area_class ); ?>">
				<div class="mb-5 pb-1">
					<?php

					while ( have_posts() ) :
						the_post();

						/**
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'templates/contents/content', '' );

					endwhile;
					?>
				</div>
				<?php do_action( 'mytravel_loop_after' ); ?>
			</div>

			<?php if ( $has_sidebar ) : ?>
			<aside class="col-lg-4 col-xl-3">
				<?php get_sidebar(); ?>
			</aside>
			<?php endif; ?>
		</div>
		<?php do_action( 'mytravel_posts_content_after' ); ?>

	</div>
