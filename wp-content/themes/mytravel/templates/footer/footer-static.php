<?php
/**
 * Template to display Static Footer.
 *
 * @package mytravel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<footer class="footer static-footer mt-4">
	<?php
		do_action( 'mytravel_static_footer' );
	?>
</footer>
