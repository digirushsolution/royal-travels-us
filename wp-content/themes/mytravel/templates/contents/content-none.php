<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytravel
 */

$display_search_form = true;

if ( is_home() && current_user_can( 'publish_posts' ) ) {
	$get_started_link = '<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">' . esc_html__( 'Get started here', 'mytravel' ) . '</a>';
	/* translators: 1: URL */
	$lead                = sprintf( wp_kses( __( 'Ready to publish your first post? %s.', 'mytravel' ), array( 'a' => array( 'href' => array() ) ) ), $get_started_link );
	$display_search_form = false;
} elseif ( is_search() ) {
	$lead = esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mytravel' );
} else {
	$lead = esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mytravel' );
}

?>

<div class="no-results not-found">	
	<header class="entry-header bg-img-hero text-center mb-5 mb-lg-8 bg-dark" style="<?php mytravel_header_styles(); ?>">
		<div class="container space-top-xl-3 py-6 py-xl-0">
			<div class="row justify-content-center py-xl-4">
				<div class="py-xl-10 py-5">
					<h1 class="entry-title font-size-40 font-size-xs-30 text-white font-weight-bold mb-0"><?php echo esc_html__( 'Nothing Found', 'mytravel' ); ?></h1>
				</div>
			</div>
		</div>
	</header>

	<div class="container pt-5 pb-10">
		<div class="row justify-content-center">
			<div class="col-lg-8 col-md-12 col-12">
				<div class="text-center">
					<?php if ( isset( $lead ) && ! empty( $lead ) ) : ?>
						<p class="lead px-2 px-lg-8 text-gray-1"><?php echo wp_kses_post( $lead ); ?></p>
					<?php endif; ?>
					<?php
					if ( isset( $display_search_form ) && $display_search_form ) {
						get_search_form();
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
