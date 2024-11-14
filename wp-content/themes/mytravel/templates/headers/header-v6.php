<?php
/**
 * Header v6
 *
 * @since v1.0.0
 */

$header_classes    = 'header-v6 u-header u-header--abs-top u-header--show-hide';
$container_classes = 'container-fluid py-xl-3';
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
		<div id="logoAndNav" class="<?php echo esc_attr( $container_classes ); ?>">
			<nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">
				<?php
					do_action( 'mytravel_header_v6' );
				?>
			</nav>
		</div>
	</div>
</header>
<?php
