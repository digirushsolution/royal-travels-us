<?php
/**
 * MyTravel functions.
 *
 * @package mytravel
 */

use Elementor\Plugin;


if ( ! function_exists( 'mytravel_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function mytravel_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

/**
 * Filter for changing Blog Header Styles.
 */
function mytravel_get_default_header_style() {
	return apply_filters( 'mytravel_default_header_style', 'v1' );
}

if ( ! function_exists( 'mytravel_is_ocdi_activated' ) ) {
	/**
	 * Check if One Click Demo Import is activated
	 */
	function mytravel_is_ocdi_activated() {
		return class_exists( 'OCDI_Plugin' ) ? true : false;
	}
}

if ( ! function_exists( 'mytravel_is_woocommerce_booking_activated' ) ) {
	/**
	 * Check if Woocommerce Booking is activated
	 */
	function mytravel_is_woocommerce_booking_activated() {
		return class_exists( 'WC_Bookings' ) ? true : false;
	}
}

if ( ! function_exists( 'mytravel_is_wceb_activated' ) ) {
	/**
	 * Check if Woocommerce Easy Booking is activated
	 */
	function mytravel_is_wceb_activated() {
		return class_exists( 'Easy_Booking' ) ? true : false;
	}
}

/**
 * Header Activation
 *
 * @return string
 */
function mytravel_get_header_style() {

	$default          = mytravel_get_default_header_style();
	$myt_page_options = array();
	$woocommerce      = function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated();

	if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
		$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
		$_myt_page_options = maybe_unserialize( $clean_meta_data );

		if ( is_array( $_myt_page_options ) ) {
			$myt_page_options = $_myt_page_options;
		}
	}
	if ( isset( $myt_page_options['header'] ) && isset( $myt_page_options['header']['mytravel_enable_custom_header'] ) && 'yes' === $myt_page_options['header']['mytravel_enable_custom_header'] ) {
		$header_style = isset( $myt_page_options['header']['header_variant'] ) ? $myt_page_options['header']['header_variant'] : $default;
	} elseif ( filter_var( get_theme_mod( 'shop_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
		$header_style = get_theme_mod( 'mytravel_shop_header_version', $default );
	} elseif ( filter_var( get_theme_mod( '404_enable_separate_header', 'yes' ), FILTER_VALIDATE_BOOLEAN ) && is_404() ) {
		$header_style = get_theme_mod( 'mytravel_404_header_version', $default );
	} else {
		$header_style = get_theme_mod( 'mytravel_header_version', $default );
	}

	return (string) apply_filters( 'mytravel_header_style', $header_style );
}

/**
 * Footer Activation
 *
 * @return string
 */
function mytravel_get_footer_style() {

	$myt_page_options = array();

	if ( function_exists( 'mytravel_option_enabled_post_types' ) && is_singular( mytravel_option_enabled_post_types() ) ) {
		$clean_meta_data   = get_post_meta( get_the_ID(), '_myt_page_options', true );
		$_myt_page_options = maybe_unserialize( $clean_meta_data );

		if ( is_array( $_myt_page_options ) ) {
			$myt_page_options = $_myt_page_options;
		}
	}
	if ( isset( $myt_page_options['footer'] ) && isset( $myt_page_options['footer']['mytravel_enable_custom_footer'] ) && 'yes' === $myt_page_options['footer']['mytravel_enable_custom_footer'] ) {
		$footer_style = isset( $myt_page_options['footer']['mytravel_footer_variant'] ) ? $myt_page_options['footer']['mytravel_footer_variant'] : 'v1';
	} else {
		$footer_style = get_theme_mod( 'mytravel_footer_version', 'v1' );
	}
	return (string) apply_filters( 'mytravel_footer_style', $footer_style );
}

if ( ! function_exists( 'mytravel_option_enabled_post_types' ) ) {
	/**
	 * Option enabled post types.
	 *
	 * @return array
	 */
	function mytravel_option_enabled_post_types() {
		$post_types = [ 'post', 'page', 'docs', 'jetpack-portfolio' ];
		return apply_filters( 'mytravel_option_enabled_post_types', $post_types );
	}
}

if ( ! function_exists( 'mytravel_is_mas_static_content_activated' ) ) {
	/**
	 * Query MAS Static Content activation
	 */
	function mytravel_is_mas_static_content_activated() {
		return class_exists( 'Mas_Static_Content' ) ? true : false;
	}
}

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `mytravel_attr_{context}_output`.
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 * @param array  $args       Optional. Custom data to pass to filter.
 * @return void
 */
function mytravel_render_attr( $context, $attributes = array(), $args = array() ) {
	$output = '';

	// Cycle through attributes, build tag attribute string.
	foreach ( $attributes as $key => $value ) {

		if ( ! $value ) {
			continue;
		}

		if ( true === $value ) {
			$output .= esc_html( $key ) . ' ';
		} else {
			if ( 'href' === $key || 'src' === $key ) {
				$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_url( $value ) );
			} else {
				$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
			}
		}
	}

	$output = apply_filters( "mytravel_attr_{$context}_output", $output, $attributes, $context, $args );

	echo trim( $output ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.0.0
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function mytravel_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

/**
 * Get the content background color
 * Accounts for the MyTravel Designer and MyTravel Powerpack content background option.
 *
 * @since  1.0.0
 * @return string the background color
 */
function mytravel_get_content_background_color() {
	if ( class_exists( 'MyTravel_Designer' ) ) {
		$content_bg_color = get_theme_mod( 'sd_content_background_color' );
		$content_frame    = get_theme_mod( 'sd_fixed_width' );
	}

	if ( class_exists( 'MyTravel_Powerpack' ) ) {
		$content_bg_color = get_theme_mod( 'sp_content_frame_background' );
		$content_frame    = get_theme_mod( 'sp_content_frame' );
	}

	$bg_color = str_replace( '#', '', get_theme_mod( 'background_color' ) );

	if ( class_exists( 'MyTravel_Powerpack' ) || class_exists( 'MyTravel_Designer' ) ) {
		if ( $content_bg_color && ( 'true' === $content_frame || 'frame' === $content_frame ) ) {
			$bg_color = str_replace( '#', '', $content_bg_color );
		}
	}

	return '#' . $bg_color;
}

/**
 * Apply inline style to the MyTravel header.
 *
 * @uses  get_header_image()
 * @since  1.0.0
 */
function mytravel_header_styles() {
	$is_header_image = apply_filters( 'mytravel_page_header_bg_image', get_header_image() );

	$header_bg_image = '';

	if ( $is_header_image ) {
		$header_bg_image = 'url(' . esc_url( $is_header_image ) . ')';
	}

	$styles = array();

	if ( '' !== $header_bg_image ) {
		$styles['background-image'] = $header_bg_image;
	}

	$styles = apply_filters( 'mytravel_header_styles', $styles );

	foreach ( $styles as $style => $value ) {
		echo esc_attr( $style . ': ' . $value . '; ' );
	}
}

/**
 * Apply inline style to the MyTravel homepage content.
 *
 * @uses  get_the_post_thumbnail_url()
 * @since  1.0.0
 */
function mytravel_homepage_content_styles() {
	$featured_image   = get_the_post_thumbnail_url( get_the_ID() );
	$background_image = '';

	if ( $featured_image ) {
		$background_image = 'url(' . esc_url( $featured_image ) . ')';
	}

	$styles = array();

	if ( '' !== $background_image ) {
		$styles['background-image'] = $background_image;
	}

	$styles = apply_filters( 'mytravel_homepage_content_styles', $styles );

	foreach ( $styles as $style => $value ) {
		echo esc_attr( $style . ': ' . $value . '; ' );
	}
}

/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param  strong  $hex   hex color e.g. #111111.
 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @return string        brightened/darkened hex color
 * @since  1.0.0
 */
function mytravel_adjust_color_brightness( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter.
	$steps = max( -255, min( 255, $steps ) );

	// Format the hex color string.
	$hex = str_replace( '#', '', $hex );

	if ( 3 === strlen( $hex ) ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values.
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	// Adjust number of steps and keep it inside 0 to 255.
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 * @since  1.0.0
 */
function mytravel_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 * @since  1.0.0
 */
function mytravel_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * MyTravel Sanitize Hex Color
 *
 * @param string $color The color as a hex.
 * @todo remove in 2.1.
 */
function mytravel_sanitize_hex_color( $color ) {
	_deprecated_function( 'mytravel_sanitize_hex_color', '2.0', 'sanitize_hex_color' );

	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

/**
 * Is Background Dark
 */
function mytravel_is_dark_bg() {
	$footer_bg = mytravel_get_footer_bg();
	return ( 'bg-dark-1' === $footer_bg );
}

/**
 * Gets Footer Background
 */
function mytravel_get_footer_bg() {
	return apply_filters( 'mytravel_footer_bg', 'bg-dark-1' );
}

if ( ! function_exists( 'mytravel_input_datepicker' ) ) {
	/**
	 * Gets datepicker
	 *
	 * @param string $start_date Start date.
	 * @param string $end_date End date.
	 * @param string $format Date format.
	 */
	function mytravel_input_datepicker( $start_date = null, $end_date = null, $format = 'M d / Y' ) {
		$product_format = mytravel_get_product_format();

		$wrapper_id = uniqid( 'datepickerWrapperPick-' );

		$start = ! is_null( $start_date ) ? $start_date : '+ 10 days';
		$end   = ! is_null( $end_date ) ? $end_date : '+ 11 days';

		$start_date = gmdate( $format, strtotime( $start ) );
		$end_date   = gmdate( $format, strtotime( $end ) );

		if ( 'tour' === $product_format || 'activity' === $product_format ) {
			$default_date = '["' . $start_date . '"]';
			$type         = 'single';
		} else {
			$default_date = '["' . $start_date . '", "' . $end_date . '"]';
			$type         = 'range';
		}

		?><div id="<?php echo esc_attr( $wrapper_id ); ?>" class="u-datepicker input-group">
			<div class="input-group-prepend">
				<span class="d-flex align-items-center mr-2 font-size-21"><i class="flaticon-calendar text-primary font-weight-semi-bold"></i></span>
			</div>
			<input type="hidden" name="start_date_submit" value="<?php echo esc_attr( $start_date ); ?>">
			<input class="js-range-datepicker font-size-lg-16 shadow-none font-weight-bold form-control hero-form bg-transparent border-0 flatpickr-input pl-2"
				type="text"
				placeholder="<?php echo esc_attr( $start_date ); ?>"
				data-rp-type="<?php echo esc_attr( $type ); ?>"
				aria-label="<?php echo esc_attr( $start_date ); ?>"
				data-rp-wrapper="#<?php echo esc_attr( $wrapper_id ); ?>"
				data-rp-date-format="<?php echo esc_attr( $format ); ?>"
				data-rp-default-date='<?php echo esc_attr( $default_date ); ?>'>
			<input type="hidden" name="end_date_submit" value="<?php echo esc_attr( $end_date ); ?>">
		</div>
		<!-- End Datepicker -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_guests_picker' ) ) {
	/**
	 * Get guest picker
	 *
	 * @param int $rooms Room count.
	 * @param int $adults No of adults.
	 * @param int $children No of children.
	 */
	function mytravel_guests_picker( $rooms = 1, $adults = 2, $children = 2 ) {
		$guests    = $adults + $children;
		$unique_id = uniqid();
		?>
		<div class="guests-picker">
			<a id="basicDropdownClickInvoker-<?php echo esc_attr( $unique_id ); ?>" class="dropdown-nav-link flex-horizontal-center pt-3 dropdown-toggle pb-2" href="javascript:;" role="button"
				aria-haspopup="true"
				aria-expanded="false"
				data-unfold-event="click"
				data-unfold-target="#basicDropdownClick-<?php echo esc_attr( $unique_id ); ?>"
				data-unfold-type="css-animation"
				data-unfold-duration="300"
				data-unfold-delay="300"
				data-unfold-hide-on-scroll="true"
				data-unfold-animation-in="slideInUp"
				data-unfold-animation-out="fadeOut">
				<i class="flaticon-add-group d-flex align-items-center mr-3 font-size-20 text-primary font-weight-semi-bold"></i>
				<span class="text-black font-size-16 font-weight-semi-bold mr-auto">
					<span class="rooms-count" data-text-singular="<?php esc_attr_e( 'Room', 'mytravel' ); ?>" data-text-plural="<?php esc_attr_e( 'Rooms', 'mytravel' ); ?>">
																				<?php
																					/* translators: %s: room count. */
																					echo wp_kses_post( sprintf( _n( '%s Room', '%s Rooms', $rooms, 'mytravel' ), $rooms ) );
																				?>
					</span>
					-
					<span class="guests-count" data-text-singular="<?php esc_attr_e( 'Guest', 'mytravel' ); ?>" data-text-plural="<?php esc_attr_e( 'Guests', 'mytravel' ); ?>">
																				<?php
																					/* translators: %s: guest count. */
																					echo wp_kses_post( sprintf( _n( '%s Guest', '%s Guests', $guests, 'mytravel' ), $guests ) );
																				?>
					</span>
				</span>
			</a>

			<div id="basicDropdownClick-<?php echo esc_attr( $unique_id ); ?>" class="dropdown-menu dropdown-unfold col m-0" aria-labelledby="basicDropdownClickInvoker-<?php echo esc_attr( $unique_id ); ?>">
				<div class="w-100 py-2 px-3 mb-3">
					<div class="js-quantity mx-3 row align-items-center justify-content-between">
						<span class="d-block font-size-16 text-secondary font-weight-medium"><?php esc_html_e( 'Rooms', 'mytravel' ); ?></span>
						<div class="d-flex">
							<a class="js-minus btn btn-icon btn-medium btn-outline-secondary rounded-circle" href="javascript:;">
								<small class="fas fa-minus btn-icon__inner"></small>
							</a>
							<input class="rooms-required js-result form-control h-auto border-0 rounded p-0 max-width-6 text-center" type="text" value="<?php echo esc_attr( $rooms ); ?>">
							<a class="js-plus btn btn-icon btn-medium btn-outline-secondary rounded-circle" href="javascript:;">
								<small class="fas fa-plus btn-icon__inner"></small>
							</a>
						</div>
					</div>
				</div>
				<div class="w-100 py-2 px-3 mb-3">
					<div class="js-quantity mx-3 row align-items-center justify-content-between">
						<span class="d-block font-size-16 text-secondary font-weight-medium"><?php esc_html_e( 'Adults', 'mytravel' ); ?></span>
						<div class="d-flex">
							<a class="js-minus btn btn-icon btn-medium btn-outline-secondary rounded-circle" href="javascript:;">
								<small class="fas fa-minus btn-icon__inner"></small>
							</a>
							<input class="guests-adults js-result form-control h-auto border-0 rounded p-0 max-width-6 text-center" type="text" value="<?php echo esc_attr( $adults ); ?>">
							<a class="js-plus btn btn-icon btn-medium btn-outline-secondary rounded-circle" href="javascript:;">
								<small class="fas fa-plus btn-icon__inner"></small>
							</a>
						</div>
					</div>
				</div>
				<div class="w-100 py-2 px-3">
					<div class="js-quantity mx-3 row align-items-center justify-content-between">
						<span class="d-block font-size-16 text-secondary font-weight-medium"><?php esc_html_e( 'Children', 'mytravel' ); ?></span>
						<div class="d-flex">
							<a class="js-minus btn btn-icon btn-medium btn-outline-secondary rounded-circle" href="javascript:;">
								<small class="fas fa-minus btn-icon__inner"></small>
							</a>
							<input class="guests-children js-result form-control h-auto border-0 rounded p-0 max-width-6 text-center" type="text" value="<?php echo esc_attr( $children ); ?>">
							<a class="js-plus btn btn-icon btn-medium btn-outline-secondary rounded-circle" href="javascript:;">
								<small class="fas fa-plus btn-icon__inner"></small>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_guests_picker_v2' ) ) {
	/**
	 * Get guest picker
	 *
	 * @param int $adults No of adults.
	 * @param int $children No of children.
	 * @param int $infant No of infant.
	 */
	function mytravel_guests_picker_v2( $adults = 1, $children = 2, $infant = 2 ) {
		$guests = $adults + $children + $infant;

		?>
		<div class="guests-picker">
			<span class="d-block text-gray-1 font-weight-normal mb-2 text-left"><?php esc_html_e( 'Adults', 'mytravel' ); ?></span>
			<div class="mb-4">
				<div class="border-bottom border-width-2 border-color-1 pb-1">
					<div class="js-quantity flex-center-between mb-1 text-dark font-weight-bold">
						<span class="d-block"><?php esc_html_e( 'Age 18+', 'mytravel' ); ?></span>
						<div class="flex-horizontal-center">
							<a class="js-minus font-size-10 text-dark" href="javascript:;">
								<i class="fas fa-chevron-up"></i>
							</a>
							<input class="guests-adults js-result form-control h-auto width-30 font-weight-bold font-size-16 shadow-none bg-tranparent border-0 rounded p-0 mx-1 text-center" type="text" value="<?php echo esc_attr( $adults ); ?>" min="01" max="100">
							<a class="js-plus font-size-10 text-dark" href="javascript:;">
								<i class="fas fa-chevron-down"></i>
							</a>
						</div>

					</div>
				</div>
			</div>
			<span class="d-block text-gray-1 font-weight-normal mb-2 text-left"><?php esc_html_e( 'Children', 'mytravel' ); ?></span> 

			<div class="mb-4">
				<div class="border-bottom border-width-2 border-color-1 pb-1">
					<div class="js-quantity flex-center-between mb-1 text-dark font-weight-bold">
						<span class="d-block"><?php echo esc_html__( 'Age 6-17', 'mytravel' ); ?></span>
						<div class="flex-horizontal-center">
							<a class="js-minus font-size-10 text-dark" href="javascript:;">
								<i class="fas fa-chevron-up"></i>
							</a>
							<input class="guests-children js-result form-control h-auto width-30 font-weight-bold font-size-16 shadow-none bg-tranparent border-0 rounded p-0 mx-1 text-center" type="text" value="<?php echo esc_attr( $children ); ?>" min="01" max="100">
							<a class="js-plus font-size-10 text-dark" href="javascript:;">
								<i class="fas fa-chevron-down"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
			<span class="d-block text-gray-1 font-weight-normal mb-2 text-left"><?php esc_html_e( 'Infant', 'mytravel' ); ?></span> 

			<div class="mb-4">
				<div class="border-bottom border-width-2 border-color-1 pb-1">
					<div class="js-quantity flex-center-between mb-1 text-dark font-weight-bold">
						<span class="d-block"><?php echo esc_html__( 'Age 0-5', 'mytravel' ); ?></span>
						<div class="flex-horizontal-center">
							<a class="js-minus font-size-10 text-dark" href="javascript:;">
								<i class="fas fa-chevron-up"></i>
							</a>
							<input class="guests-children js-result form-control h-auto width-30 font-weight-bold font-size-16 shadow-none bg-tranparent border-0 rounded p-0 mx-1 text-center" type="text" value="<?php echo esc_attr( $infant ); ?>" min="01" max="100">
							<a class="js-plus font-size-10 text-dark" href="javascript:;">
								<i class="fas fa-chevron-down"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_get_product_format' ) ) {
	/**
	 *  Get product format
	 */
	function mytravel_get_product_format() {
		if ( class_exists( 'MAS_Travels' ) ) {
			$product_format = get_product_format() ? get_product_format() : 'standard';
		} else {
			$product_format = 'standard';
		}
		return $product_format;
	}
}

if ( ! function_exists( 'mytravel_get_google_api_key' ) ) {
	/**
	 *  Get google api key
	 */
	function mytravel_get_google_api_key() {
		$default = '';
		return apply_filters( 'mytravel_google_api_key', get_theme_mod( 'mytravel_api_key', $default ) );
	}
}

if ( ! function_exists( 'mytravel_render_html_attributes' ) ) {
	/**
	 * Render attribute HML
	 *
	 * @param array $attributes Optional. Extra attributes to merge with defaults.
	 */
	function mytravel_render_html_attributes( array $attributes ) {
		$rendered_attributes = [];

		foreach ( $attributes as $attribute_key => $attribute_values ) {
			if ( is_array( $attribute_values ) ) {
				$attribute_values = implode( ' ', $attribute_values );
			}

			$rendered_attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( $attribute_values ) );
		}

		return implode( ' ', $rendered_attributes );
	}
}

if ( ! function_exists( 'mytravel_bootstrap_pagination' ) ) {
	/**
	 * Display pagination in Bootstrap format.
	 *
	 * @param string        $pages Pages.
	 * @param WP_Query|null $wp_query WordPress query.
	 * @param bool          $echo     should echo or return.
	 * @param string        $ul_class class for the <ul> wrapper.
	 * @param string        $a_class  class for the anchor.
	 *
	 * @return string
	 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
	 * or nothing to use the current global $wp_query (eg: taxonomy term page)
	 * - Tested on WP 4.9.5
	 * - Tested with Bootstrap 4.1
	 * - Tested on Sage 9
	 *
	 * USAGE:
	 *     <?php echo koach_bootstrap_pagination(); ?> //uses global $wp_query
	 * or with custom WP_Query():
	 *     <?php
	 *      $query = new \WP_Query($args);
	 *       ... while(have_posts()), $query->posts stuff ...
	 *       echo koach_bootstrap_pagination($query);
	 *     ?>
	 */
	function mytravel_bootstrap_pagination( $pages = null, \WP_Query $wp_query = null, $echo = true, $ul_class = '', $a_class = '' ) {

		if ( null === $wp_query ) {
			global $wp_query;
		}

		if ( null === $pages ) {
			$pages = paginate_links(
				[
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'format'       => '?paged=%#%',
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'total'        => $wp_query->max_num_pages,
					'type'         => 'array',
					'show_all'     => false,
					'end_size'     => 3,
					'mid_size'     => 1,
					'prev_next'    => true,
					'prev_text'    => esc_html__( '&laquo; Prev', 'mytravel' ),
					'next_text'    => esc_html__( 'Next &raquo;', 'mytravel' ),
					'add_args'     => false,
					'add_fragment' => '',
				]
			);
		}

		if ( is_array( $pages ) ) {

			if ( ! empty( $ul_class ) ) {
				$ul_class = ' ' . $ul_class;
			}

			$pagination = '<nav aria-label="' . esc_attr__( 'Page navigation', 'mytravel' ) . '"><ul class="' . esc_attr( $ul_class ) . '">';

			foreach ( $pages as $page ) {
				$t          = ( strpos( $page, 'current' ) === false ) ? $a_class : '';
				$t         .= ' page-link';
				$icon_right = '<i class="flaticon-right-thin-chevron font-size-10 font-weight-bold"></i>';
				$icon_left  = '<i class="flaticon-left-direction-arrow font-size-10 font-weight-bold"></i>';
				$prev_icon  = str_replace( '&laquo; Prev', $icon_left, $page );
				$next_icon  = str_replace( 'Next &raquo;', $icon_right, $prev_icon );

				$pagination .= '<li class="page-item' . ( strpos( $page, 'current' ) !== false ? ' active' : '' ) . '">' . str_replace( 'page-numbers', $t, $next_icon ) . '</li>';
			}

			$pagination .= '</ul></nav>';

			if ( $echo ) {
				echo wp_kses( $pagination, 'pagination' );
			} else {
				return $pagination;
			}
		}

		return null;
	}
}

if ( ! function_exists( 'mytravel_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox.
	 *
	 * @param bool $input state of the checkbox.
	 */
	function mytravel_sanitize_checkbox( $input ) {
		// returns true if checkbox is checked.
		return ( ( isset( $input ) && true === $input ) ? true : false );
	}
}

if ( ! function_exists( 'mytravel_render_content' ) ) {
	/**
	 * Mytravel render content.
	 *
	 * @param array $post_id  post ID.
	 * @param bool  $echo  echo.
	 */
	function mytravel_render_content( $post_id, $echo = false ) {
		if ( did_action( 'elementor/loaded' ) ) {
			$content = Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
		} else {
			$content = get_the_content( null, false, $post_id );
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
		}

		if ( $echo ) {
			echo wp_kses_post( $content );
		} else {
			return $content;
		}
	}
}

if ( ! function_exists( 'mytravel_kses_allowed_html' ) ) {
	/**
	 * Custom allowed HTML for kses function.
	 *
	 * @param array  $tags Array of tags that are allowed.
	 * @param string $context Context of the kses.
	 */
	function mytravel_kses_allowed_html( $tags, $context ) {
		switch ( $context ) {
			case 'post-title':
				$tags = array(
					'em'     => array(),
					'b'      => array(),
					'sup'    => array(),
					'span'   => array( 'class' => array() ),
					'strong' => array( 'class' => array() ),
					'a'      => array(
						'href'  => array(),
						'class' => array(),
					),
				);
				break;
			case 'pagination':
				$tags = array(
					'nav'  => array( 'aria-label' => array() ),
					'ul'   => array( 'class' => array() ),
					'i'    => array( 'class' => array() ),
					'li'   => array( 'class' => array() ),
					'span' => array( 'class' => array() ),
					'a'    => array(
						'href'  => array(),
						'class' => array(),
					),
				);
				break;
			case 'image':
				$tags = array(
					'img' => array(
						'src'          => array(),
						'height'       => array(),
						'width'        => array(),
						'alt'          => array(),
						'title'        => array(),
						'class'        => array(),
						'loading'      => array(),
						'data-caption' => array(),
					),
				);
				break;
			case 'room-price':
				$tags = array(
					'span' => array(
						'class' => array(),
					),
				);
				break;
			case 'copyright':
				$tags = array(
					'p' => array(
						'class' => array(),
					),
				);
				break;
			case 'logo-html':
				$tags = array(
					'a'    => array(
						'href'  => array(),
						'class' => array(),
						'rel'   => array(),
					),
					'span' => array( 'class' => array() ),
					'img'  => array(
						'src'     => array(),
						'height'  => array(),
						'width'   => array(),
						'alt'     => array(),
						'title'   => array(),
						'class'   => array(),
						'loading' => array(),
					),
				);
				break;
			case 'page-title':
				$tags = array(
					'h1' => array(
						'class' => array(),
					),
				);
				break;
			case 'wishlist-button':
				$tags = array(
					'div'  => array(
						'class'                 => array(),
						'data-fragment-ref'     => array(),
						'data-fragment-options' => array(),
					),
					'i'    => array( 'class' => array() ),
					'span' => array( 'class' => array() ),
					'a'    => array(
						'href'                     => array(),
						'class'                    => array(),
						'data-product-id'          => array(),
						'data-product-type'        => array(),
						'data-original-product-id' => array(),
						'data-title'               => array(),
						'rel'                      => array(),
					),
				);
				break;
			case 'category-list':
			case 'tags-list':
				$tags = array(
					'a' => array(
						'href'  => array(),
						'class' => array(),
						'rel'   => array(),
					),
				);
				break;
			case 'badge-class':
				$tags = array(
					'li'   => array(
						'class' => array(),
					),
					'span' => array(
						'class' => array(),
					),
				);
				break;
			case 'badge-html':
				$tags = array(
					'span' => array(
						'class' => array(),
					),
					'div'  => array(
						'class' => array(),
					),
				);
				break;
			case 'category-html':
				$tags = array(
					'span' => array( 'class' => array() ),
					'a'    => array(
						'href'  => array(),
						'class' => array(),
						'rel'   => array(),
					),
				);
				break;
			case 'icon-html':
				$tags = array(
					'i' => array(
						'class' => array(),

					),
				);
				break;
			case 'price-html':
				$tags = array(
					'span' => array(
						'class' => array(),

					),
					'del'  => array(
						'aria-hidden' => array(),
						'span'        => array(
							'class' => array(),

						),
					),
					'ins'  => array(
						'span' => array(
							'class' => array(),

						),
					),
					'span' => array(
						'class' => array(),

					),
					'bdi'  => array(
						'class' => array(),

					),
				);
				break;
			case 'image-html':
				$tags = array(
					'img' => array(
						'src'     => array(),
						'height'  => array(),
						'width'   => array(),
						'alt'     => array(),
						'title'   => array(),
						'class'   => array(),
						'loading' => array(),
					),
					'div' => array(
						'class'            => array(),
						'style'            => array(),
						'data-slick-index' => array(),
						'aria-hidden'      => array(),
						'tabindex'         => array(),
					),
				);
				break;
			case 'reset-link':
				$tags = array(
					'a' => array(
						'class' => array(),
						'href'  => array(),
						'style' => array(),
					),
				);
				break;

		}
		return $tags;
	}
}
