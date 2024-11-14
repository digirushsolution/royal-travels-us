<?php
/**
 * Room Amenities
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( $amenities ) :

	?><div class="pl-4 pt-4 h-100">
	<div class="font-weight-medium mb-3"><?php esc_html_e( 'Amenities', 'mytravel' ); ?></div>
	<div class="js-scrollbar height-570">
		<ul class="d-block list-unstyled">
		<?php

		foreach ( $amenities as $amenity ) :
			if ( ! is_wp_error( $amenity ) && $amenity ) {
				$term_id  = $amenity->term_id;
				$taxonomy = $amenity->taxonomy; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$icon     = mytravel_get_field( 'icon_class', $taxonomy . '_' . $term_id );

				?>
				<li class="mb-3">
					<i class="<?php echo esc_attr( $icon ); ?> mr-3 text-primary font-size-24"></i>
										 <?php
											echo esc_html( $amenity->name );
											?>
				</li>
				<?php
			}

		endforeach;

		?>
		</ul>
	</div>
</div>
	<?php

endif;
