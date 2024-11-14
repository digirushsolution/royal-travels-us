<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! mytravel_wc_has_sidebar() ) {
	?>
	<form class="woocommerce-ordering" method="get">
		<select name="orderby" class="orderby js-select selectpicker dropdown-select bootstrap-select__custom-nav w-100 w-md-auto my-1 mb-3 mb-md-0 mt-3 mt-md-1" data-style="btn-sm px-4 font-size-16 text-gray-1 d-flex align-items-center py-2" aria-label="<?php esc_attr_e( 'Shop order', 'mytravel' ); ?>">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html__( 'Sort by ', 'mytravel' ); ?><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
	<?php
} else {
	?>
	<div class="sort-bar mb-5">
		<ul class="nav flex-nowrap border border-radius-3 tab-nav align-items-center py-2 px-0">
		<?php

		$count = 0;

		foreach ( $catalog_orderby_options as $id => $name ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

			?>
		<li class="nav-item d-flex align-items-center flex-shrink-0 flex-xl-shrink-1
			<?php
			if ( 0 !== $count ) :
				?>
			border-left<?php endif; ?>">
			<a href="<?php echo esc_url( add_query_arg( 'orderby', $id ) ); ?>" class="nav-link font-weight-normal text-gray-1 text-lh-1dot6 py-1 px-4 px-wd-5 font-weight-normal font-size-15 "><?php echo esc_html( $name ); ?></a>
		</li>
			<?php

			$count++;

		endforeach;

		?>
		</ul>
	</div>
	<?php
}
