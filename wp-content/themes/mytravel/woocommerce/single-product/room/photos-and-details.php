<?php
/**
 * The template for displaying photos and details of the room
 *
 * @package MyTravel\Templates
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$id             = $product->get_id(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$modal_id       = 'room-details-' . $id;
$attachment_ids = $product->get_gallery_image_ids();
$amenities = '';
if ( mytravel_is_acf_activated() ) {
	$amenities = mytravel_get_field( 'room_amenities' );
}

$has_gallery = $attachment_ids && $product->get_image_id();

if ( ! $has_gallery || ( mytravel_is_acf_activated() && ! $amenities ) ) {
	return;
}

?><!-- On Target Modal -->
<a class="font-size-14 text-underline d-block" href="#<?php echo esc_attr( $modal_id ); ?>"
	data-modal-target="#<?php echo esc_attr( $modal_id ); ?>"
	data-modal-effect="fadein">
	<?php
		esc_html_e( 'Room Photos and Details', 'mytravel' );
	?>
	</a>
<div id="<?php echo esc_attr( $modal_id ); ?>" class="js-modal-window u-modal-window u-modal-window-custom container"
			data-modal-type="ontarget"
			data-open-effect="fadeIn"
			data-close-effect="fadeOut"
			data-speed="500">
	<div class="card rounded border-0 mx-3 mx-md-4 mx-xl-0 mb-4 mb-md-0">
		<div class="row no-gutters position-relative">
			
			<button type="button" class="border-0 width-50 height-50 bg-primary z-index-2 flex-content-center position-absolute rounded-circle mt-n4 mr-n4 top-0 right-0" aria-label="Close" onclick="Custombox.modal.close();">
				<i aria-hidden="true" class="flaticon-close text-white font-size-14"></i>
			</button>
			
			<div class="col-xl-3 mb-4 mb-xl-0 order-1 order-xl-0">
			<?php

				wc_get_template( 'single-product/room/title-and-price.php' );

				wc_get_template( 'single-product/room/amenities.php', array( 'amenities' => $amenities ) );

			?>
			</div>

			<div class="col-xl-9">
			<?php
				wc_get_template(
					'single-product/room/gallery.php',
					array(
						'attachment_ids' => $attachment_ids,
						'has_gallery'    => $has_gallery,
					)
				);
				?>
			</div>
		</div><!-- /.row -->
	</div><!-- /.card -->
</div><!-- /.js-modal-window -->
