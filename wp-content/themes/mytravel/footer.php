<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package mytravel
 */

?>
	</div><!-- /.site-content -->

	<?php
		$footer_version = function_exists( 'mytravel_get_footer_style' ) ? mytravel_get_footer_style() : 'v1';
		do_action( 'mytravel_before_footer' );
		get_template_part( 'templates/footer/footer', $footer_version );
		do_action( 'mytravel_after_footer' );
	?>

</div><!-- /#page -->

<?php wp_footer(); ?>

</body>
</html>
