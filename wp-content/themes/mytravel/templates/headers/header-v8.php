<?php
/**
 * Header v8.
 *
 * @since v1.0.0
 */

$header_classes    = '';
$container_classes = '';
$main_classes      = '';

if ( ! class_exists( 'MAS_Travels' ) ) {
	if ( mytravel_transparent_header_enable() && ! class_exists( 'MAS_Travels' ) ) {
		$header_classes    = 'header-v8 u-header u-header--show-hide u-header--static u-header__navbar-brand-text-white u-header--white-nav-links-xl u-header--bg-transparent border-color-white u-header--abs-top';
		$container_classes = 'container-fluid u-header__hide-content u-header__topbar u-header__topbar-lg border-bottom border-color-white';
		$main_classes      = 'container-fluid py-xl-2';
	}
} else {
	if ( class_exists( 'MAS_Travels' ) ) {
		$header_classes    = 'header-v8 u-header u-header--show-hide u-header--static u-header--dark-nav-links-xl';
		$container_classes = 'container-fluid u-header__hide-content u-header__topbar u-header__topbar-lg border-bottom border-color-8';
		$main_classes      = 'container-fluid py-xl-2 border-bottom-xl';
	}
}

if ( mytravel_navbar_is_sticky() ) {
	$header_classes .= ' navbar-stuck';
}

?>
<header id="header" class="<?php echo esc_attr( $header_classes ); ?>" data-header-fix-moment="500" data-header-fix-effect="slide">
	<div class="u-header__section u-header__shadow-on-show-hide py-4 py-xl-0">
		<?php
		if ( mytravel_top_navbar_enable() ) {
			?>
			<div class="<?php echo esc_attr( $container_classes ); ?>">
				<div class="d-flex align-items-center">
					<?php do_action( 'mytravel_header_v8_top_bar' ); ?>
				</div>
			</div>
			<?php
		}
		?>
			<div id="logoAndNav" class="<?php echo esc_attr( $main_classes ); ?>">
			<!-- Nav -->
			<nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">
				<?php do_action( 'mytravel_header_v8' ); ?>
			</nav>
		</div>
	</div>
</header>
