<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package mytravel
 */

$notfound_heading     = apply_filters( 'mytravel_404_heading', get_theme_mod( '404_heading', esc_html__( '404', 'mytravel' ) ) );
$notfound_title       = apply_filters( 'mytravel_404_title', get_theme_mod( '404_title', esc_html__( 'Looks like you\'re lost', 'mytravel' ) ) );
$notfound_desc        = apply_filters( 'mytravel_404_desc', get_theme_mod( '404_desc', esc_html__( 'We can’t seem to find the page you’re looking for', 'mytravel' ) ) );
$notfound_action_text = apply_filters( 'mytravel_404_button_text', get_theme_mod( '404_btn_text', esc_html__( 'Back to Home', 'mytravel' ) ) );
$notfound_btn_clr     = apply_filters( 'mytravel_404_button_color', get_theme_mod( '404_button_color', 'primary' ) );
$notfound_btn_url     = apply_filters( 'mytravel_404_button_url', get_theme_mod( '404_button_url', '#' ) );
$notfound_img_url     = get_template_directory_uri() . '/assets/img/error/404-error-img.svg';

get_header();?>

	<div class="border-bottom border-color-8 mb-8">
		<div class="container">
			<div class="row mb-5 mb-md-7 mb-lg-0">
				<div class="col-xl-5 col-wd-4 d-xl-flex mb-6 mb-xl-0 text-center text-xl-left">
					<div class="space-xl-3 my-auto">
						<div class="font-weight-bold display-5 text-gray-3 text-xl-left">
							<?php echo esc_html( $notfound_heading ); ?>
						</div>

						<h6 class="font-size-21 font-weight-bold text-gray-3 mb-3 text-xl-left">
							<?php echo esc_html( $notfound_title ); ?>
						</h6>

						<p class="text-gray-1 mb-3 mb-lg-5 pb-lg-1 text-xl-left">
							<?php echo esc_html( $notfound_desc ); ?>
						</p>

						<a href="<?php echo esc_url( $notfound_btn_url ); ?>" class="btn btn-<?php echo esc_attr( $notfound_btn_clr ); ?> rounded-xs transition-3d-hover font-weight-bold min-width-190 min-height-60 d-inline-flex flex-content-center">
							<?php echo esc_html( $notfound_action_text ); ?>
						</a>
					</div>
				</div>
				<div class="col-xl-7 col-wd-8">
					<div class="space-xl-3 my-auto">
					<?php
					$image = wp_get_attachment_image(
						get_theme_mod( '404_image_option' ),
						'480px',
						false,
						[
							'class' => 'w-100',
							'alt'   => esc_html_x( 'Error 404', 'front-end', 'mytravel' ),
						]
					);

					if ( '' !== $image ) {
						$image = apply_filters( 'mytravel_404_image_option', $image );
						echo wp_kses( $image, 'image' );
					} else {
						?>
					<img class="w-100" src="<?php echo esc_url( $notfound_img_url ); ?>">
						<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
get_footer();
