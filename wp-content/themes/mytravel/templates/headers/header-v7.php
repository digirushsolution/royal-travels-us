<?php
/**
 * Header v7
 *
 * @since v1.0.0
 */

$header_classes    = 'header-v7 u-header  u-header--static u-header--show-hide ';
$container_classes = 'container-fluid py-xl-3';

if ( mytravel_transparent_header_enable() ) {
	$header_classes .= ' u-header--white-nav-links-xl u-header--bg-violet-xl';
} else {
	$header_classes .= ' u-header--dark-nav-links-xl';
}

if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
	$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
	$_myt_page_options = maybe_unserialize( $clean_meta_data );

	if ( is_array( $_myt_page_options ) ) {
		$myt_page_options = $_myt_page_options;
	}
}
if ( isset( $myt_page_options['header'] ) && isset( $myt_page_options['header']['mytravel_enable_custom_header'] ) && 'yes' === $myt_page_options['header']['mytravel_enable_custom_header'] ) {
	$classes = isset( $myt_page_options['header']['mytravel_navbar_skin'] ) ? 'bg-' . $myt_page_options['header']['mytravel_navbar_skin'] : '';
} else {
	$classes = 'bg-' . get_theme_mod( 'header_navbar_skin', 'violet' );
}

if ( mytravel_navbar_is_sticky() ) {
	$header_classes .= ' navbar-stuck';
}
?>
<header id="header" class="<?php echo esc_attr( $header_classes ); ?>" data-header-fix-moment="500" data-header-fix-effect="slide">
	<div class="u-header__section u-header__shadow-on-show-hide py-xl-0 <?php echo esc_attr( $classes ); ?>">
		<div id="logoAndNav" class="<?php echo esc_attr( $container_classes ); ?>">
			<!-- Nav -->
			<nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">
				<?php do_action( 'mytravel_header_v7' ); ?>
			</nav>
		</div>
	</div>
</header>
<?php
