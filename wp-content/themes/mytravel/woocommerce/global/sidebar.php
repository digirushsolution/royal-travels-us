<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( mytravel_wc_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) ) { ?>
	<div class="navbar-expand-lg navbar-expand-lg-collapse-block">
		<button class="btn d-lg-none mb-5 p-0 collapsed" type="button" data-toggle="collapse" data-target="#shop-sidebar"aria-expanded="false" aria-label="Toggle navigation">
			<i class="far fa-caret-square-down text-primary font-size-20 card-btn-arrow ml-0"></i>
			<span class="text-primary ml-2">Sidebar</span>
		</button>

		<div id="shop-sidebar" class="collapse navbar-collapse">
			<div class="mb-6 w-100">
				<?php dynamic_sidebar( 'sidebar-shop' ); ?>
			</div>
		</div>
	</div>
	<?php
}

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
