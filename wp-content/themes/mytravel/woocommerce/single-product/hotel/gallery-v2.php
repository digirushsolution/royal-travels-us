<?php
/**
 * Gallery v3 for Hotel
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$fancybox_id    = 'fancebox-' . $product->get_id();
$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();

if ( $attachment_ids ) {
	$wrap_class = 'col-lg-8 col-xl-9';
} else {
	$wrap_class = 'col-lg-12';
}


// if ( $attachment_ids || $main_image_id ) :.

?><div class="pb-4 mb-2">
	<div class="row mx-n1">
		<div class="mb-1 mb-lg-0 px-0 px-lg-1 <?php echo esc_attr( $wrap_class ); ?>">
													   <?php
														$image_att = wp_get_attachment_image_src( $main_image_id, 'full', false );
														$caption   = _wp_specialchars( get_post_field( 'post_excerpt', $main_image_id ), ENT_QUOTES, 'UTF-8', true );
														if ( $image_att ) {
															$image_src = $image_att[0];
														} else {
															$image_src = esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) );

														}

														?>
			<a class="js-fancybox u-media-viewer" href="javascript:;"
				data-src="<?php echo esc_attr( $image_src ); ?>"
				data-fancybox="<?php echo esc_attr( $fancybox_id ); ?>"
				data-caption="<?php echo esc_attr( $caption ); ?>"
				data-speed="700">
				<img class="img-fluid border-radius-3 min-height-458 w-100" src="<?php echo esc_attr( $image_src ); ?>" alt="<?php echo esc_attr( $caption ); ?>">

				<span class="u-media-viewer__container">
					<span class="u-media-viewer__icon">
						<span class="fas fa-plus u-media-viewer__icon-inner"></span>
					</span>
				</span>
			</a>
		</div>

		<?php if ( $attachment_ids ) : ?>
		<div class="col-lg-4 col-xl-3 px-0">
			<?php

			$count = 1;

			foreach ( $attachment_ids as $attachment_id ) :

				$image_att = wp_get_attachment_image_src( $attachment_id, 'full', false );
				$caption   = _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true );
				$image_src = $image_att[0];

				if ( 3 === $count ) {
					$media_viewer_class = 'u-media-viewer__dark';
				} else {
					$media_viewer_class = 'pb-1';
				}

				if ( $count <= 3 ) :

					?>
			<a class="js-fancybox u-media-viewer <?php echo esc_attr( $media_viewer_class ); ?>" href="javascript:;"
				data-src="<?php echo esc_url( $image_src ); ?>"
				data-fancybox="<?php echo esc_attr( $fancybox_id ); ?>"
				data-caption="<?php echo esc_attr( $caption ); ?>"
				data-speed="700">
				<img class="img-fluid border-radius-3 min-height-150" src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $caption ); ?>">
																					  <?php

																						if ( 3 !== $count ) :

																							?>
				<span class="u-media-viewer__container">
					<span class="u-media-viewer__icon">
						<span class="fas fa-plus u-media-viewer__icon-inner"></span>
					</span>
				</span>
																							<?php

					else :

						?>
				<span class="u-media-viewer__container z-index-2 w-100">
					<span class="u-media-viewer__icon u-media-viewer__icon--active w-100 bg-transparent">
						<span class="u-media-viewer__icon-inner font-size-14"><?php esc_html_e( 'SEE ALL PHOTOS', 'mytravel' ); ?></span>
					</span>
				</span>
						<?php

					endif;

					?>
			</a>
					<?php

				else :

					?>
			<img class="js-fancybox d-none" alt="<?php echo esc_attr( $caption ); ?>"
			data-fancybox="<?php echo esc_attr( $fancybox_id ); ?>"
			data-src="<?php echo esc_url( $image_src ); ?>"
			src="<?php echo esc_url( $image_src ); ?>"
			data-caption="<?php echo esc_attr( $caption ); ?>"
			data-speed="700">
					<?php

				endif;

				$count++;

		endforeach;
			?>
		</div>
	<?php endif; ?>
	</div><!-- /.row -->
</div>
<?php

// endif;.
