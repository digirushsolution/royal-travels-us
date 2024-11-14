<?php
/**
 * Room Gallery
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( $has_gallery ) :

	?><div class="js-slick-carousel u-slick rounded-right height-760 overflow-hidden width-960 ml-auto"
	data-slides-show="1"
	data-slides-scroll="1"
	data-pagi-classes="text-right justify-content-end position-absolute right-0 bottom-0 left-0 u-slick__pagination u-slick__pagination--white mb-5 mr-5"
	data-arrows-classes="u-slick__arrow-classic u-slick__arrow-centered--y"
	data-arrow-left-classes="fas fa-arrow-left font-size-23 bg-transparent text-white u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
	data-arrow-right-classes="fas fa-arrow-right font-size-23 bg-transparent text-white u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4">
	<?php

	foreach ( $attachment_ids as $attachment_id ) :

		$caption = _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
		$title   = _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$image   = wp_get_attachment_image(
			$attachment_id,
			'woocommerce_single',
			false,
			array(
				'title'        => $title,
				'data-caption' => $caption,
				'class'        => esc_attr( 'img-fluid w-100 position-relative' ),
			)
		);

		?>
		<div class="js-slide gradient-overlay-half-bg-gradient-v7">
		<?php

			echo wp_kses( $image, 'image' );

		if ( ! empty( $caption ) ) :

			?>
			<h6 class="z-index-2 font-weight-bold text-white font-size-18 ml-4 mb-4 position-absolute bottom-0"><?php echo esc_html( $caption ); ?></h6>
			<?php

			endif;

		?>
		</div>
		<?php

	endforeach;

	?>
	</div>
	<?php

endif;
