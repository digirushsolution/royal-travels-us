<?php

/**
 * Widget "MAS Travels - Layered Nav Widget"
 *
 * Displays your attribute.
 *
 * @uses WP_Widget
 */
class MAS_Travels_Widget_Layered_Nav extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'mytravel widget_layered_nav mytravel-widget-layered-nav';
		$this->widget_description = esc_html__( 'Display a list of attributes to filter products in your store.', 'mas-travels' );
		$this->widget_id          = 'mytravel_layered_nav';
		$this->widget_name        = esc_html__( 'MyTravel Filter Products by Attribute', 'mas-travels' );
		parent::__construct();
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @see WP_Widget->update
	 *
	 * @param array $new_instance New Instance.
	 * @param array $old_instance Old Instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();
		return parent::update( $new_instance, $old_instance );
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @see WP_Widget->form
	 *
	 * @param array $instance Instance.
	 */
	public function form( $instance ) {
		$this->init_settings();
		parent::form( $instance );
	}

	/**
	 * Init settings after post types are registered.
	 */
	public function init_settings() {
		$attribute_array      = array();
		$std_attribute        = '';
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
			$std_attribute = current( $attribute_array );
		}

		$this->settings = array(
			'title'        => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Filter by', 'mas-travels' ),
				'label' => esc_html__( 'Title', 'mas-travels' ),
			),
			'attribute'    => array(
				'type'    => 'select',
				'std'     => $std_attribute,
				'label'   => esc_html__( 'Attribute', 'mas-travels' ),
				'options' => $attribute_array,
			),
			'display_type' => array(
				'type'    => 'select',
				'std'     => 'list',
				'label'   => esc_html__( 'Display type', 'mas-travels' ),
				'options' => array(
					'list'     => esc_html__( 'List', 'mas-travels' ),
					'dropdown' => esc_html__( 'Dropdown', 'mas-travels' ),
				),
			),
			'query_type'   => array(
				'type'    => 'select',
				'std'     => 'and',
				'label'   => esc_html__( 'Query type', 'mas-travels' ),
				'options' => array(
					'and' => esc_html__( 'AND', 'mas-travels' ),
					'or'  => esc_html__( 'OR', 'mas-travels' ),
				),
			),
		);
	}

	/**
	 * Get this widgets taxonomy.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_taxonomy( $instance ) {
		if ( isset( $instance['attribute'] ) ) {
			return wc_attribute_taxonomy_name( $instance['attribute'] );
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					return wc_attribute_taxonomy_name( $tax->attribute_name );
				}
			}
		}

		return '';
	}

	/**
	 * Get this widgets query type.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_query_type( $instance ) {
		return isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
	}

	/**
	 * Get this widgets display type.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_display_type( $instance ) {
		return isset( $instance['display_type'] ) ? $instance['display_type'] : 'list';
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args Arguments.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$taxonomy           = $this->get_instance_taxonomy( $instance );
		$query_type         = $this->get_instance_query_type( $instance );
		$display_type       = $this->get_instance_display_type( $instance );

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}

		$terms = get_terms( $taxonomy, array( 'hide_empty' => '1' ) );

		if ( 0 === count( $terms ) ) {
			return;
		}

		ob_start();

		$this->widget_start( $args, $instance );

		if ( 'dropdown' === $display_type ) {
			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_style( 'select2' );
			$found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type );
		} else {
			$found = $this->layered_nav_list( $terms, $taxonomy, $query_type );
		}

		$this->widget_end( $args );

		// Force found when option is selected - do not force found on taxonomy attributes.
		if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
			$found = true;
		}

		if ( ! $found ) {
			ob_end_clean();
		} else {
			echo ob_get_clean(); // @codingStandardsIgnoreLine
		}
	}

	/**
	 * Return the currently viewed taxonomy name.
	 *
	 * @return string
	 */
	protected function get_current_taxonomy() {
		return is_tax() ? get_queried_object()->taxonomy : '';
	}

	/**
	 * Return the currently viewed term ID.
	 *
	 * @return int
	 */
	protected function get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}

	/**
	 * Return the currently viewed term slug.
	 *
	 * @return int
	 */
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

	/**
	 * Show dropdown layered nav.
	 *
	 * @param  array  $terms Terms.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return bool Will nav display?
	 */
	protected function layered_nav_dropdown( $terms, $taxonomy, $query_type ) {
		global $wp;
		$found = false;

		if ( $taxonomy !== $this->get_current_taxonomy() ) {
			$term_counts          = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
			$_chosen_attributes   = WC_Query::get_layered_nav_chosen_attributes();
			$taxonomy_filter_name = wc_attribute_taxonomy_slug( $taxonomy );
			$taxonomy_label       = wc_attribute_label( $taxonomy );

			/* translators: %s: taxonomy name */
			$any_label      = apply_filters( 'mytravel_layered_nav_any_label', sprintf( __( 'Any %s', 'mas-travels' ), $taxonomy_label ), $taxonomy_label, $taxonomy );
			$multiple       = 'or' === $query_type;
			$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();

			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
			}

			echo '<form method="get" action="' . esc_url( $form_action ) . '" class="woocommerce-widget-layered-nav-dropdown">';
			echo '<select class="woocommerce-widget-layered-nav-dropdown dropdown_layered_nav_' . esc_attr( $taxonomy_filter_name ) . '"' . ( $multiple ? 'multiple="multiple"' : '' ) . '>';
			echo '<option value="">' . esc_html( $any_label ) . '</option>';

			foreach ( $terms as $term ) {

				// If on a term page, skip that term in widget list.
				if ( $term->term_id === $this->get_current_term_id() ) {
					continue;
				}

				// Get count based on current view.
				$option_is_set = in_array( $term->slug, $current_values, true );
				$count         = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

				// Only show options with count > 0.
				if ( 0 < $count ) {
					$found = true;
				} elseif ( 0 === $count && ! $option_is_set ) {
					continue;
				}

				echo '<option value="' . esc_attr( urldecode( $term->slug ) ) . '" ' . selected( $option_is_set, true, false ) . '>' . esc_html( $term->name ) . '</option>';
			}

			echo '</select>';

			if ( $multiple ) {
				echo '<button class="woocommerce-widget-layered-nav-dropdown__submit" type="submit" value="' . esc_attr__( 'Apply', 'mas-travels' ) . '">' . esc_html__( 'Apply', 'mas-travels' ) . '</button>';
			}

			if ( 'or' === $query_type ) {
				echo '<input type="hidden" name="query_type_' . esc_attr( $taxonomy_filter_name ) . '" value="or" />';
			}

			echo '<input type="hidden" name="filter_' . esc_attr( $taxonomy_filter_name ) . '" value="' . esc_attr( implode( ',', $current_values ) ) . '" />';
			echo wc_query_string_form_fields( null, array( 'filter_' . $taxonomy_filter_name, 'query_type_' . $taxonomy_filter_name ), '', true ); // @codingStandardsIgnoreLine
			echo '</form>';

			wc_enqueue_js(
				"
				// Update value on change.
				jQuery( '.dropdown_layered_nav_" . esc_js( $taxonomy_filter_name ) . "' ).on( 'change', function() {
					var slug = jQuery( this ).val();
					jQuery( ':input[name=\"filter_" . esc_js( $taxonomy_filter_name ) . "\"]' ).val( slug );

					// Submit form on change if standard dropdown.
					if ( ! jQuery( this ).attr( 'multiple' ) ) {
						jQuery( this ).closest( 'form' ).trigger( 'submit' );
					}
				});

				// Use Select2 enhancement if possible
				if ( jQuery().selectWoo ) {
					var wc_layered_nav_select = function() {
						jQuery( '.dropdown_layered_nav_" . esc_js( $taxonomy_filter_name ) . "' ).selectWoo( {
							placeholder: decodeURIComponent('" . rawurlencode( (string) wp_specialchars_decode( $any_label ) ) . "'),
							minimumResultsForSearch: 5,
							width: '100%',
							allowClear: " . ( $multiple ? 'false' : 'true' ) . ",
							language: {
								noResults: function() {
									return '" . esc_js( _x( 'No matches found', 'enhanced select', 'mas-travels' ) ) . "';
								}
							}
						} );
					};
					wc_layered_nav_select();
				}
			"
			);
		}

		return $found;
	}

	/**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * This query allows counts to be generated based on the viewed products, not all products.
	 *
	 * @param  array  $term_ids Term IDs.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query.
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];

		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'"
			. $tax_query_sql['where'] . $meta_query_sql['where'] .
			'AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')';

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query['group_by'] = 'GROUP BY terms.term_id';
		$query             = apply_filters( 'front_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );

		// We have a query - let's see if cached results of this query already exist.
		$query_hash = md5( $query );

		// Maybe store a transient of the count values.
		$cache = apply_filters( 'mytravel_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}

		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$results                      = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine
			$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
			$cached_counts[ $query_hash ] = $counts;
			if ( true === $cache ) {
				set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
			}
		}

		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}


	/**
	 * Wrapper for WC_Query::get_main_tax_query() to ease unit testing.
	 *
	 * @since 4.4.0
	 * @return array
	 */
	protected function get_main_tax_query() {
		return WC_Query::get_main_tax_query();
	}

	/**
	 * Wrapper for WC_Query::get_main_search_query_sql() to ease unit testing.
	 *
	 * @since 4.4.0
	 * @return string
	 */
	protected function get_main_search_query_sql() {
		return WC_Query::get_main_search_query_sql();
	}

	/**
	 * Wrapper for WC_Query::get_main_search_queryget_main_meta_query to ease unit testing.
	 *
	 * @since 4.4.0
	 * @return array
	 */
	protected function get_main_meta_query() {
		return WC_Query::get_main_meta_query();
	}


	/**
	 * Show list based layered nav.
	 *
	 * @param  array  $terms Terms.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return bool   Will nav display?
	 */
	protected function layered_nav_list( $terms, $taxonomy, $query_type ) {
		$tax_uniqid = $taxonomy . '-' . uniqid();
		$i          = 0;
		// List display.
		echo '<div class="woocommerce-widget-layered-nav-list mytravel-widget-layered-nav-list">';

		$term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$found              = false;
		$base_link          = $this->get_current_page_url();

		foreach ( $terms as $term ) {
			$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
			$option_is_set  = in_array( $term->slug, $current_values, true );
			$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

			// Skip the term for the current archive.
			if ( $this->get_current_term_id() === $term->term_id ) {
				continue;
			}

			// Only show options with count > 0.
			if ( 0 < $count ) {
				$found = true;
			} elseif ( 0 === $count && ! $option_is_set ) {
				continue;
			}

			$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); //phpcs:ignore
			$current_filter = array_map( 'sanitize_title', $current_filter );

			if ( ! in_array( $term->slug, $current_filter, true ) ) {
				$current_filter[] = $term->slug;
			}

			$link = remove_query_arg( $filter_name, $base_link );

			// Add current filters to URL.
			foreach ( $current_filter as $key => $value ) {
				// Exclude query arg for current term archive term.
				if ( $value === $this->get_current_term_slug() ) {
					unset( $current_filter[ $key ] );
				}

				// Exclude self so filter can be unset on click.
				if ( $option_is_set && $value === $term->slug ) {
					unset( $current_filter[ $key ] );
				}
			}

			if ( ! empty( $current_filter ) ) {
				asort( $current_filter );
				$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

				// Add Query type Arg to URL.
				if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
					$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
				}
				$link = str_replace( '%2C', ',', $link );
			}

			if ( $count > 0 || $option_is_set ) {
				$link      = apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy );
				$term_html = '<a rel="nofollow" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a>';
			} else {
				$link      = false;
				$term_html = '<span>' . esc_html( $term->name ) . '</span>';
			}

			$show_hide_limit = apply_filters( "mytravel_product_layered_nav_show_hide_limit_{$taxonomy}", 4 );

			$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

			if ( $show_hide_limit === $i ) :
				echo '<div class="collapse" id="' . esc_attr( $tax_uniqid ) . '">';
			endif;

			echo '<div class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ' . ( $option_is_set ? 'woocommerce-widget-layered-nav-list__item--chosen chosen' : '' ) . '">';
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.EscapeOutput.OutputNotEscaped
			echo apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count );
			echo '</div>';

			if ( $show_hide_limit <= $i && ( count( $terms ) - 1 ) === $i ) :
				echo '</div><a class="link link-collapse small font-size-1 collapsed" data-toggle="collapse" href="#' . esc_attr( $tax_uniqid ) . '" role="button" aria-expanded="false" aria-controls="' . esc_attr( $tax_uniqid ) . '"><span class="link-collapse__default">' . esc_html__( 'Show all', 'mas-travels' ) . ' ' . count( $terms ) . '</span><span class="link-collapse__active">' . esc_html__( 'Show less', 'mas-travels' ) . '</span></a>';
			endif;
			$i++;
		}
		echo '</div>';

		return $found;
	}
}
