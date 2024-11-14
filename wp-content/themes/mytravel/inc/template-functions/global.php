<?php
/**
 * Template functions used globally by the theme.
 *
 * @package mytravel
 */

if ( ! function_exists( 'mytravel_breadcrumb' ) ) {

	/**
	 * Output the Mytravel Breadcrumb.
	 *
	 * @param array $args Arguments.
	 */
	function mytravel_breadcrumb( $args = array() ) {
		$args = wp_parse_args(
			$args,
			apply_filters(
				'mytravel_breadcrumb_defaults',
				array(
					'delimiter'   => '',
					'wrap_before' => '<nav aria-label="breadcrumb"><ol class="breadcrumb breadcrumb-no-gutter justify-content-center mb-0">',
					'wrap_after'  => '</ol></nav>',
					'before'      => '<li class="breadcrumb-item font-size-14">',
					'after'       => '</li>',
					'home'        => _x( 'Home', 'breadcrumb', 'mytravel' ),
				)
			)
		);

		if ( mytravel_is_woocommerce_activated() ) {
			woocommerce_breadcrumb( $args );
		} else {
			require_once get_template_directory() . '/inc/class-mytravel-breadcrumb.php';

			$breadcrumbs = new Mytravel_Breadcrumb();

			if ( ! empty( $args['home'] ) ) {
				$breadcrumbs->add_crumb( $args['home'], apply_filters( 'mytravel_breadcrumb_home_url', home_url() ) );
			}

			$args['breadcrumb'] = $breadcrumbs->generate();

			do_action( 'mytravel_breadcrumb', $breadcrumbs, $args );

			if ( ! empty( $args['breadcrumb'] ) ) {

				$output = wp_kses_post( $args['wrap_before'] );

				foreach ( $args['breadcrumb'] as $key => $crumb ) {

					if ( ! empty( $crumb[1] ) && count( $args['breadcrumb'] ) !== $key + 1 ) {
						$output .= wp_kses_post(
							sprintf(
								'%s<a href="%s" class="text-white">%s</a>%s',
								$args['before'],
								esc_url( $crumb[1] ),
								$crumb[0],
								$args['after']
							)
						);
					} else {
						$output .= '<li class="breadcrumb-item font-size-14 text-white active">' . esc_html( $crumb[0] ) . '</li>';
					}
				}

				$output .= wp_kses_post( $args['wrap_after'] );

				echo wp_kses_post( apply_filters( 'mytravel_breadcrumb_html', $output ) );
			}
		}
	}
}
