<?php
/**
 * Header v1
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

$header_classes = 'header-v1 u-header u-header--show-hide';

if ( ! class_exists( 'MAS_Travels' ) ) {
	if ( mytravel_transparent_header_enable() && ! class_exists( 'MAS_Travels' ) ) {
		$header_classes .= ' u-header--white-nav-links-xl u-header--bg-transparent border-color-white u-header u-header--abs-top border-bottom border-xl-bottom-0';
	}
} else {
	if ( mytravel_transparent_header_enable() ) {
		$header_classes .= ' u-header--white-nav-links-xl u-header--bg-transparent border-color-white u-header u-header--abs-top border-bottom border-xl-bottom-0';
	} else {
		$header_classes .= ' u-header--dark-nav-links-xl border-color-8 border-xl-bottom u-header--static';
	}
}

if ( mytravel_navbar_is_sticky() ) {
	$header_classes .= ' navbar-stuck';
}

if ( 'yes' !== mytravel_top_navbar_enable() ) {
	$header_classes .= ' border-bottom-0';
}

if ( 'yes' !== mytravel_top_navbar_enable() && empty( $container_classes ) ) {
	$container_classes = 'py-2';
}

?>
<header id="header" class="<?php echo esc_attr( $header_classes ); ?>" data-header-fix-moment="500" data-header-fix-effect="slide">
	<div class="u-header__section u-header__shadow-on-show-hide">
		<?php
			do_action( 'mytravel_header_v1_top' );
		?>
		<div id="logoAndNav" class="container-fluid <?php echo esc_attr( $container_classes ); ?>">
			<nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">
				<?php
				do_action( 'mytravel_header_v1' );
				?>
			</nav>
		</div>
	</div>
</header>
<?php
