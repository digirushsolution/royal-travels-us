<?php

defined( 'ABSPATH' ) || exit;

$markers = array();

get_header( 'shop' );

?><div class="row no-gutters">
	<div class="col-lg-7 col-xl-8 col-wd-6 order-1 order-lg-0">
		<div class="pt-4 px-4 pt-xl-6 px-xl-8 js-scrollbar height-100vh-main">
		<?php

		if ( woocommerce_product_loop() ) :

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {

					the_post();

					wc_set_loop_prop( 'tab-view', 'list' );

					wc_get_template_part( 'content', 'hotel-list-view' );

					$location = mytravel_get_field( 'location_map' );

					if ( $location ) {
						$markers[] = [
							'location'    => $location,
							'title'       => get_the_title(),
							'description' => mytravel_get_field( 'display_location' ),
						];
					}
				}
			}

			woocommerce_product_loop_end();

			endif;

		?>
		</div>
	</div>
	<div class="col-lg-5 col-xl-4 col-wd-6 height-350-md-down">
	<?php

	if ( ! empty( $markers ) ) :

		?>
		<div class="acf-map" data-zoom="16">
		<?php

		foreach ( $markers as $marker ) :

			extract( $marker ); // @codingStandardsIgnoreLine

			?>
			<div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>" data-lng="<?php echo esc_attr( $location['lng'] ); ?>">
				<h3><?php echo esc_html( $title ); ?></h3>
				<p><em><?php echo esc_html( $location['address'] ); ?></em></p>
				<p><?php echo esc_html( $description ); ?></p>
			</div>
			<?php

			endforeach;

		?>
		</div>
		<?php

		endif;

	?>
	</div>
</div>
<?php

get_footer( 'empty' );
