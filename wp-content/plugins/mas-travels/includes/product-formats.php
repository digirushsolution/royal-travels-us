<?php
/**
 * Product format functions.
 *
 * @package MAS_Travels
 */

/**
 * Retrieve the format slug for a product
 *
 * @since 1.0.0
 *
 * @param int|object|null $post Product ID or post object. Optional, default is the current post from the loop.
 * @return string|false The format if successful. False otherwise.
 */
function get_product_format( $post = null ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return false;
	}

	$_format = get_the_terms( $post->ID, 'product_format' );

	if ( empty( $_format ) ) {
		return false;
	}

	$format = reset( $_format );

	return str_replace( 'product-format-', '', $format->slug );
}

/**
 * Check if a post has any of the given formats, or any format.
 *
 * @since 3.1.0
 *
 * @param string|array     $format Optional. The format or formats to check.
 * @param WP_Post|int|null $post   Optional. The post to check. If not supplied, defaults to the current post if used in the loop.
 * @return bool True if the post has any of the given formats (or any format, if no format specified), false otherwise.
 */
function has_product_format( $format = array(), $post = null ) {
	$prefixed = array();

	if ( $format ) {
		foreach ( (array) $format as $single ) {
			$prefixed[] = 'product-format-' . sanitize_key( $single );
		}
	}

	return has_term( $prefixed, 'product_format', $post );
}

/**
 * Assign a format to a post
 *
 * @since 3.1.0
 *
 * @param int|object $post   The post for which to assign a format.
 * @param string     $format A format to assign. Use an empty string or array to remove all formats from the post.
 * @return array|WP_Error|false WP_Error on error. Array of affected term IDs on success.
 */
function set_product_format( $post, $format ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return new WP_Error( 'invalid_post', esc_html__( 'Invalid post.', 'mas-travels' ) );
	}

	if ( ! empty( $format ) ) {
		$format = sanitize_key( $format );
		if ( 'standard' === $format || ! in_array( $format, get_product_format_slugs() ) ) { // phpcs:ignore.
			$format = '';
		} else {
			$format = 'product-format-' . $format;
		}
	}

	return wp_set_post_terms( $post->ID, $format, 'product_format' );
}

/**
 * Returns an array of post format slugs to their translated and pretty display versions
 *
 * @since 3.1.0
 *
 * @return string[] Array of post format labels keyed by format slug.
 */
function get_product_format_strings() {
	$strings = array(
		'standard'   => esc_html__( 'Standard', 'mas-travels' ), // Special case. Any value that evals to false will be considered standard.
		'hotel'      => esc_html__( 'Hotel', 'mas-travels' ),
		'room'       => esc_html__( 'Room', 'mas-travels' ),
		'tour'       => esc_html__( 'Tour', 'mas-travels' ),
		'activity'   => esc_html__( 'Activity', 'mas-travels' ),
		'rental'     => esc_html__( 'Rental', 'mas-travels' ),
		'car_rental' => esc_html__( 'Car Rental', 'mas-travels' ),
		'yacht'      => esc_html__( 'Yacht', 'mas-travels' ),

	);
	return $strings;
}

/**
 * Retrieves the array of post format slugs.
 *
 * @since 3.1.0
 *
 * @return string[] The array of post format slugs as both keys and values.
 */
function get_product_format_slugs() {
	$slugs = array_keys( get_product_format_strings() );
	return array_combine( $slugs, $slugs );
}

/**
 * Returns a pretty, translated version of a post format slug
 *
 * @since 3.1.0
 *
 * @param string $slug A post format slug.
 * @return string The translated post format name.
 */
function get_product_format_string( $slug ) {
	$strings = get_product_format_strings();
	if ( ! $slug ) {
		return $strings['standard'];
	} else {
		return ( isset( $strings[ $slug ] ) ) ? $strings[ $slug ] : '';
	}
}

/**
 * Returns a link to a post format index.
 *
 * @since 3.1.0
 *
 * @param string $format The post format slug.
 * @return string|WP_Error|false The post format term link.
 */
function get_product_format_link( $format ) {
	$term = get_term_by( 'slug', 'product-format-' . $format, 'product_format' );
	if ( ! $term || is_wp_error( $term ) ) {
		return false;
	}
	return get_term_link( $term );
}

/**
 * Filters the request to allow for the format prefix.
 *
 * @param array $qvs Filters the request to allow for the format prefix.
 * @return array
 */
function _product_format_request( $qvs ) {
	if ( ! isset( $qvs['product_format'] ) ) {
		return $qvs;
	}
	$slugs = get_product_format_slugs();
	if ( isset( $slugs[ $qvs['product_format'] ] ) ) {
		$qvs['product_format'] = 'product-format-' . $slugs[ $qvs['product_format'] ];
	}
	$tax = get_taxonomy( 'product_format' );
	if ( ! is_admin() ) {
		$qvs['post_type'] = $tax->object_type;
	}
	return $qvs;
}

/**
 * Filters the post format term link to remove the format prefix.
 *
 * @global WP_Rewrite $wp_rewrite WordPress rewrite component.
 *
 * @param string $link Filters the post format term link to remove the format prefix.
 * @param object $term Filters the post format term link to remove the format prefix.
 * @param string $taxonomy Filters the post format term link to remove the format prefix.
 * @return string
 */
function _product_format_link( $link, $term, $taxonomy ) {
	global $wp_rewrite;
	if ( 'product_format' !== $taxonomy ) {
		return $link;
	}
	if ( $wp_rewrite->get_extra_permastruct( $taxonomy ) ) {
		return str_replace( "/{$term->slug}", '/' . str_replace( 'product-format-', '', $term->slug ), $link );
	} else {
		$link = remove_query_arg( 'product_format', $link );
		return add_query_arg( 'product_format', str_replace( 'product-format-', '', $term->slug ), $link );
	}
}

/**
 * Remove the post format prefix from the name property of the term object created by get_term().
 *
 * @param object $term Remove the post format prefix from the name property of the term object created by terms.
 * @return object
 */
function _product_format_get_term( $term ) {
	if ( isset( $term->slug ) ) {
		$term->name = get_product_format_string( str_replace( 'product-format-', '', $term->slug ) );
	}
	return $term;
}

/**
 * Remove the post format prefix from the name property of the term objects created by get_terms().
 *
 * @param array        $terms Remove the post format prefix from the name property of the term objects created by terms.
 * @param string|array $taxonomies Remove the post format prefix from the name property of the term objects created by terms.
 * @param array        $args Remove the post format prefix from the name property of the term objects created by terms.
 * @return array
 */
function _product_format_get_terms( $terms, $taxonomies, $args ) {
	if ( in_array( 'product_format', (array) $taxonomies ) ) { // phpcs:ignore.
		if ( isset( $args['fields'] ) && 'names' === $args['fields'] ) {
			foreach ( $terms as $order => $name ) {
				$terms[ $order ] = get_product_format_string( str_replace( 'product-format-', '', $name ) );
			}
		} else {
			foreach ( (array) $terms as $order => $term ) {
				if ( isset( $term->taxonomy ) && 'product_format' === $term->taxonomy ) {
					$terms[ $order ]->name = get_product_format_string( str_replace( 'product-format-', '', $term->slug ) );
				}
			}
		}
	}
	return $terms;
}

/**
 * Remove the post format prefix from the name property of the term objects created by wp_get_object_terms().
 *
 * @param array $terms Remove the post format prefix from the name property of the term objects created by terms.
 * @return array
 */
function _product_format_wp_get_object_terms( $terms ) {
	foreach ( (array) $terms as $order => $term ) {
		if ( isset( $term->taxonomy ) && 'product_format' === $term->taxonomy ) {
			$terms[ $order ]->name = get_product_format_string( str_replace( 'product-format-', '', $term->slug ) );
		}
	}
	return $terms;
}

/**
 *  Render product format filter
 */
function render_products_format_filter() {
	ob_start();

	// Make sure the dropdown shows only formats with a post count greater than 0.
	$used_post_formats = get_terms(
		array(
			'taxonomy'   => 'product_format',
			'hide_empty' => true,
		)
	);

	// Return if there are no posts using formats.
	if ( ! $used_post_formats ) {
		return;
	}
	$displayed_post_format = isset( $_GET['product_format'] ) ? $_GET['product_format'] : ''; // phpcs:ignore.

	?>
	<select name="product_format" id="filter-by-format">
		<option value=""><?php esc_html_e( 'Filter by product format', 'mas-travels' ); ?></option>
		<?php
		foreach ( $used_post_formats as $used_post_format ) {
			// Post format slug.
			$slug = $used_post_format->slug;

			// Pretty, translated version of the post format slug.
			// $pretty_name = get_product_format_string( $slug );.
			$pretty_name = get_product_format_string( str_replace( 'product-format-', '', $used_post_format->slug ) );

			// Skip the standard post format.
			if ( 'standard' === $slug ) {
				continue;
			}
			?>
			<option 
			<?php
			if ( $slug === $displayed_post_format ) :
				?>
							selected<?php endif; ?> value="<?php echo esc_attr( $used_post_format->slug ); ?>"><?php echo esc_html( $pretty_name ); ?></option>
			<?php
		}
		?>
	</select>
	<?php
	$output = ob_get_clean();
	echo $output; // phpcs:ignore;
}

/**
 *  Render product format view
 */
function render_products_format_view() {
	global $wp_query;

	$terms = get_terms(
		[
			'taxonomy'   => 'product_format',
			'hide_empty' => false,
		]
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return;
	}

	$views = [];
	foreach ( $terms as $term ) {
		$count = $term->count;

		$term_name = $term->name;

		$pretty_name = str_replace( 'product-format-', '', $term_name );

		$class                 = ( isset( $wp_query->query['product_format'] ) && $term_name === $wp_query->query['product_format'] ) ? 'current' : '';
		$views[ $pretty_name ] = sprintf(
			'<a class="%s" href="%s" rel="tag">%s <span class="count">(%s)</span></a>',
			esc_attr( $class ),
			esc_url( admin_url( "edit.php?post_type=product&product_format=product-format-$pretty_name" ) ),
			esc_html( ucwords( str_replace( '_', ' ', $pretty_name ) ) ),
			$count
		);
	}
	return implode( '| ', $views );// Use of implode function.
}

