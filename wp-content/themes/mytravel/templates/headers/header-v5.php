<?php
/**
 * Header v5
 *
 * @since v1.0.0
 */

$myt_page_options = array();
if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
	$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
	$_myt_page_options = maybe_unserialize( $clean_meta_data );

	if ( is_array( $_myt_page_options ) ) {
		$myt_page_options = $_myt_page_options;
	}
}
if ( mytravel_has_custom_header( $myt_page_options ) ) {
	$container_classes = isset( $myt_page_options['header']['mytravel_primary_navbar_css'] ) ? $myt_page_options['header']['mytravel_primary_navbar_css'] : '';
} elseif ( 'yes' === get_theme_mod( 'shop_enable_separate_header' ) ) {
	$container_classes = get_theme_mod( 'mytravel_shop_header_navbar_css' );
} elseif ( 'yes' === get_theme_mod( '404_enable_separate_header' ) ) {
	$container_classes = get_theme_mod( 'mytravel_404_header_navbar_css' );
} else {
	$container_classes = get_theme_mod( 'mytravel_header_navbar_css' );
}


$header_classes    = 'header-v5 u-header u-header--abs-top u-header--show-hide';
if ( mytravel_transparent_header_enable() ) {
	$header_classes .= ' u-header--white-nav-links-xl u-header--bg-transparent';
} else {
	$header_classes .= ' u-header--dark-nav-links-xl';
}

if ( mytravel_navbar_is_sticky() ) {
	$header_classes .= ' navbar-stuck';
}
?>
<header id="header" class="<?php echo esc_attr( $header_classes ); ?>" data-header-fix-moment="500" data-header-fix-effect="slide">
	<div class="u-header__section u-header__shadow-on-show-hide py-4 py-xl-0">
		<div id="logoAndNav" class="container-fluid <?php echo esc_attr( $container_classes ); ?>">
			<nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">
				<?php
					do_action( 'mytravel_header_v5' );
				?>
			</nav>
		</div>
	</div>
</header>
<?php
