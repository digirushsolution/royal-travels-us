<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mytravel
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}

?>
<div class="blog-sidebar" id="blog-sidebar">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</div>
