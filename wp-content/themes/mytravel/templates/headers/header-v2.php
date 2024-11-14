<?php
/**
 * Header v2
 *
 * @since v1.0.0
 */

$header_classes    = 'header-v2 u-header u-header--nav-links-normal u-header--static u-header--show-hide u-header--dark-nav-links-xl';
$container_classes = 'container-fluid py-1';


if ( mytravel_navbar_is_sticky() ) {
	$header_classes .= ' navbar-stuck';
}
?>
<header id="header" class="<?php echo esc_attr( $header_classes ); ?>" data-header-fix-moment="500" data-header-fix-effect="slide">
	<div class="u-header__section u-header__shadow-on-show-hide py-3 py-xl-0">
		<div id="logoAndNav" class="<?php echo esc_attr( $container_classes ); ?>">
			<nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">
				<?php
					do_action( 'mytravel_header_v2' );
				?>
			</nav>
		</div>
	</div>
</header>
<?php
