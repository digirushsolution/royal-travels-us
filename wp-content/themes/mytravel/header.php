<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package mytravel
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'mytravel_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php
		$header_version = function_exists( 'mytravel_get_header_style' ) ? mytravel_get_header_style() : 'v1';
		do_action( 'mytravel_before_header' );
		get_template_part( 'templates/headers/header', $header_version );
	?>

	<?php do_action( 'mytravel_before_content' ); ?>

	<div id="content" class="site-content text-break" tabindex="-1">

		<?php do_action( 'mytravel_content_top' ); ?>
