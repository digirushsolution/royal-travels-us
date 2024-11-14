<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use EasyBooking\Date_Selection;

if ( ! class_exists( 'MAS_Travels' ) ) {

	/**
	 * Main MAS Travels class
	 *
	 * @class MAS_Travels
	 * @version 1.0.0
	 */
	final class MAS_Travels {
		/**
		 * MAS Travels version
		 *
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * Single Instance of the class
		 *
		 * @var MAS_Travels
		 */
		protected static $_instance = null; // phpcs:ignore

		/**
		 * Main MAS_Travels instance
		 *
		 * Ensures only one instance of MAS_Travels is loaded or can be loaded
		 *
		 * @static
		 * @return MAS_Travels - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'mas-travels' ), '2.1' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'mas-travels' ), '2.1' );
		}

		/**
		 * MAS_Travels constructor
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'mas_travels_loaded' );
		}

		/**
		 * Define constants
		 */
		private function define_constants() {
			$this->define( 'MAS_TRAVELS_ABSPATH', dirname( MAS_TRAVELS_PLUGIN_FILE ) . '/' );
			$this->define( 'MAS_TRAVELS_PLUGIN_BASENAME', plugin_basename( MAS_TRAVELS_PLUGIN_FILE ) );
		}

		/**
		 * Init MAS_Travels when WordPress Initializes
		 */
		public function includes() {
			include_once MAS_TRAVELS_ABSPATH . 'includes/product-formats.php';
			include_once MAS_TRAVELS_ABSPATH . 'includes/mas-travels-room.php';
			include_once MAS_TRAVELS_ABSPATH . 'includes/class-mas-travels-share.php';
			include_once MAS_TRAVELS_ABSPATH . 'includes/hotel-review.php';
		}

		/**
		 * Init Hooks
		 */
		public function init_hooks() {
			add_action( 'woocommerce_register_taxonomy', array( $this, 'register_product_format_taxonomy' ), 0 );
			add_action( 'init', array( __CLASS__, 'check_version' ), 6 );
			add_action( 'post_submitbox_misc_actions', array( $this, 'product_data_format' ), 20 );
			add_action( 'save_post_product', array( $this, 'save_product_format' ), 10, 3 );
			add_action( 'woocommerce_product_options_related', array( $this, 'add_hotels_for_rooms' ), 10 );
			add_filter( 'woocommerce_catalog_orderby', array( $this, 'orderby_options' ) );
			add_filter( 'woocommerce_cart_item_name', array( $this, 'custom_product_title_name' ), 10, 3 );
			add_filter( 'woocommerce_products_admin_list_table_filters', array( $this, 'products_format_filter' ) );
			add_filter( 'views_edit-product', array( $this, 'products_format_links' ), 20 );
			add_filter( 'woocommerce_add_cart_item_data', array( $this, 'mas_travels_add_cart_item_booking_data' ), 10, 4 );
			add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'added_grouped_order_item_meta' ), 10, 4 );

			add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'mas_travels_add_order_item_booking_data' ), 20, 4 );
			add_filter( 'woocommerce_display_item_meta', array( $this, 'mas_travels_display_booking_dates_in_checkout' ), 10, 3 );

			add_filter( 'woocommerce_order_item_name', array( $this, 'custom_order_item_name' ), 10, 3 );
			add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'mas_travels_filter_dropdown_option_html' ), 12, 2 );
			add_action( 'woocommerce_after_add_attribute_fields', array( $this, 'mas_travels_custom_product_attribute_field' ) );
			add_action( 'woocommerce_after_edit_attribute_fields', array( $this, 'mas_travels_custom_product_attribute_field' ) );
			add_action( 'woocommerce_attribute_added', array( $this, 'save_mas_travels_custom_product_attribute' ) );
			add_action( 'woocommerce_attribute_updated', array( $this, 'save_mas_travels_custom_product_attribute' ) );
			add_action( 'woocommerce_process_product_meta_grouped', array( $this, 'mas_travels_action_process_children_product_meta' ) );
			add_filter( 'woocommerce_format_price_range', array( $this, 'format_price_range' ), 10, 3 );
			add_filter( 'woocommerce_get_item_data', array( $this, 'mas_travels_display_booking_dates_in_cart' ), 10, 2 );
			add_filter( 'woocommerce_sale_flash', array( $this, 'mytravel_add_percentage_to_sale_badge' ), 20, 3 );
			add_action( 'init', array( $this, 'mytravel_remove_yith_wcwl_post_class' ) );

			add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'mas_travels_custom_single_add_to_cart_text' ) );

			add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'mas_travels_add_to_cart_validation' ), 15, 5 );
			add_filter( 'woocommerce_order_item_get_formatted_meta_data', array( $this, 'mas_travels_order_item_get_formatted_meta_data' ), 10, 1 );
		}

		/**
		 * Check WooCommerce version and run the updater is required.
		 *
		 * This check is done on all requests and runs if the versions do not match.
		 */
		public static function check_version(){
			$mas_travels_version = get_option( 'mas_travels_version' );
			$mas_travels_code_version = MAS_Travels()->version;
			$requires_update = version_compare( $mas_travels_version, $mas_travels_code_version, '<' );
			if ( $requires_update ) {

				self::install();
				do_action( 'woocommerce_updated' );
				// If there is no woocommerce_version option, consider it as a new install.
				if ( ! $mas_travels_version ) {
					do_action( 'woocommerce_newly_installed' );
				}
			}
		}

		 /**
		  *
		  * Check that dates are set and valid before adding to cart.
		  *
		  * @param bool -             $passed True or False.
		  * @param int -              $product_id Product ID.
		  * @param int -              $quantity Quantity.
		  * @param (optional) int -   $variation_id Variation ID.
		  * @param (optional) array - $variations Array().
		  * @return bool - $passed
		  **/
		public function mas_travels_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = '', $variations = array() ) {
			$_product_id = empty( $variation_id ) ? $product_id : $variation_id;
			$product     = wc_get_product( $product_id );
			$_product    = wc_get_product( $_product_id );

			if ( ! $passed || ! $_product ) {
				return false;
			}

			if ( mytravel_is_wceb_activated() && wceb_is_bookable( $_product ) ) {

				// Use $_REQUEST to allow $_POST and $_GET.
				$start = isset( $_REQUEST['start_date_submit'] ) ? $_REQUEST['start_date_submit'] : false;// phpcs:ignore.
				$end   = isset( $_REQUEST['end_date_submit'] ) ? $_REQUEST['end_date_submit'] : false;// phpcs:ignore.

				$valid_dates = Date_Selection::check_selected_dates( $start, $end, $_product );

				if ( is_wp_error( $valid_dates ) ) {
					$passed = true;
				}

				$valid_booking_duration = Date_Selection::get_selected_booking_duration( $start, $end, $_product );

				if ( is_wp_error( $valid_booking_duration ) ) {
					$passed = true;
				}
			}

			return $passed;

		}

		/**
		 * Product Format Taxonomies
		 */
		public function register_product_format_taxonomy() {
			register_taxonomy(
				'product_format',
				apply_filters( 'woocommerce_taxonomy_objects_product_format', array( 'product' ) ),
				apply_filters(
					'woocommerce_taxonomy_args_product_format',
					array(
						'public'      => true,
						'hierarchial' => false,
						'labels'      => array(
							'name'          => esc_html__( 'Formats', 'mas-travels' ),
							'singular_name' => esc_html__( 'Format', 'mas-travels' ),
						),
						'query_var'   => true,
						'rewrite'     => false,
						'show_ui'     => false,
					)
				)
			);
		}

		/**
		 * Terms Insert Install Process
		 */
		public static function install() {

			if ( ! is_blog_installed() ) {
				return;
			}

			// Check if we are not already running this routine.
			if ( 'yes' === get_transient( 'mas_travels_installing' ) ) {
				return;
			}

			set_transient( 'mas_travels_installing', 'yes', MINUTE_IN_SECONDS * 10 );
			
			self::create_terms();
			self::update_mas_travels_version();

			delete_transient( 'mas_travels_installing' );

		}

		public static function create_terms() {
			$taxonomies = array(
				'product_format' => array(
					'product-format-tour',
					'product-format-hotel',
					'product-format-activity',
					'product-format-rental',
					'product-format-car_rental',
					'product-format-yacht',
				)
			);
		
			foreach ( $taxonomies as $taxonomy => $terms ) {
				foreach ( $terms as $term ) {
					if ( ! get_term_by( 'name', $term, $taxonomy ) ) { // @codingStandardsIgnoreLine.
						wp_insert_term( $term, $taxonomy );
					}
				}
			}
		}

		/**
		 * Update MAS Travels version to current.
		 */
		private static function update_mas_travels_version() {
			update_option( 'mas_travels_version', MAS_Travels()->version );
		}

		/**
		 * Output product visibility options.
		 */
		public function product_data_format() {
			global $post, $thepostid, $product_object;

			if ( 'product' !== $post->post_type ) {
				return;
			}
			$product_formats        = get_product_format_strings();
			$current_product_format = get_product_format( $post );
			?>
			<div class="misc-pub-section" id="product-format">
				<label for="_post-format"><?php esc_html_e( 'Product Format:', 'mas-travels' ); ?></label>
				<select name="product_format" id="_product-format">
					<?php foreach ( $product_formats as $slug => $product_format ) : ?>
						<option value="<?php echo esc_attr( $slug ); ?>"
							<?php
							if ( $slug === $current_product_format ) :
								?>
							selected<?php endif; ?>><?php echo esc_html( $product_format ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php
		}
		/**
		 * Output product format.
		 *
		 * @param string $post_ID Post id.
		 * @param string $post Post.
		 * @param string $update Post update.
		 */
		public function save_product_format( $post_ID, $post, $update ) {
			if ( isset( $_POST['product_format'] ) ) { // phpcs:ignore.
				$format = set_product_format( $post_ID, sanitize_key( $_POST['product_format'] ) );// phpcs:ignore.
			}
		}
		/**
		 * Output hotel rooms.
		 */
		public function add_hotels_for_rooms() {
			global $post;
			$data_store = WC_Data_Store::load( 'product' );
			$ids        = $data_store->get_products(
				array(
					'tax_query' => array(// phpcs:ignore WordPress.DB.DirectDatabaseQuery.: slow query ok.
						array(
							'taxonomy' => 'product_format',
							'field'    => 'name',
							'terms'    => array( 'product-format-hotel' ),
						),
					),
				)
			);

			?>
			<div class="options_group show_if_product_format_room">
				<p class="form-field">
					<label for="product_room_hotel"><?php esc_html_e( 'Hotel', 'mas-travels' ); ?></label>
					<select class="wc-product-search" style="width: 50%;" id="product_room_hotel" name="product_room_hotel" data-sortable="true" data-placeholder="<?php esc_attr_e( 'Search for a hotel&hellip;', 'mas-travels' ); ?>" data-action="woocommerce_json_search_products" data-exclude="<?php echo intval( $post->ID ); ?>">
						<?php
						$product_ids = array();

						foreach ( $product_ids as $product_id ) {
							$product = wc_get_product( $product_id );
							if ( is_object( $product ) ) {
								echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
							}
						}
						?>
					</select> <?php echo wc_help_tip( __( 'This lets you choose which hotel does this room belongs to.', 'mas-travels' ) ); // phpcs:ignore Standard.Category.SniffName.ErrorCode. ?>
				</p>
			</div>
			<?php
		}

		/**
		 * Override product sorting options
		 *
		 * @param array $options Sorting options.
		 */
		public function orderby_options( $options ) {
			$options = array(
				'menu_order' => esc_html__( 'Default', 'mas-travels' ),
				'popularity' => esc_html__( 'Popularity', 'mas-travels' ),
				'rating'     => esc_html__( 'Guest rating', 'mas-travels' ),
				'date'       => esc_html__( 'Latest', 'mas-travels' ),
				'price'      => esc_html__( 'Price: low to high', 'mas-travels' ),
				'price-desc' => esc_html__( 'Price: high to low', 'mas-travels' ),
			);
			return $options;
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string      $name Name.
		 * @param  string|bool $value Value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}
		/**
		 * Change single product add to cart text
		 *
		 * @param  string $text The text.
		 */
		public function mas_travels_custom_single_add_to_cart_text( $text ) {
			global $product, $text;

			if ( ! class_exists( 'MyTravel' ) ) {
				return;
			}

			$product_type        = $product->get_type();
			$easy_booking        = mytravel_is_wceb_activated();
			$product_is_bookable = $easy_booking ? wceb_is_bookable( $product ) : '';
			$product_format      = get_product_format() ? get_product_format() : 'standard';

			if ( $product_is_bookable ) {
				$text = esc_html__( 'Book Now', 'mas-travels' );
			} elseif ( 'rental' === $product_format && ! $product_is_bookable ) {
				$text = esc_html__( 'Buy Now', 'mas-travels' );
			} elseif ( 'external' === $product_type ) {
				$text = esc_html__( 'Buy Now', 'mas-travels' );
			} else {
				$text = esc_html__( 'Add to cart', 'mas-travels' );
			}

			return $text;
		}
		/**
		 * Add the parent grouped product name to cart items names
		 *
		 * @param string $cart_item_name Cart item name.
		 * @param string $cart_item Cart item.
		 * @param int    $cart_item_key Cart item key.
		 */
		public function custom_product_title_name( $cart_item_name, $cart_item, $cart_item_key ) {
			// Only in cart and checkout pages.
			if ( is_cart() || is_checkout() ) {
				// The product object from cart item.
				$product = $cart_item['data'];

				$product_permalink = $product->is_visible() ? $product->get_permalink( $cart_item ) : '';

				// The parent product name and data.
				if ( ! empty( $cart_item['_hotel_id'] ) ) {
					$group_prod_id = $cart_item['_hotel_id'];

					$group_prod = wc_get_product( $group_prod_id );

					if ( ! $group_prod->is_type( 'grouped' ) ) {
						return $cart_item_name;
					}
					$parent_product_name  = $group_prod->get_name();
					$group_prod_permalink = $group_prod->is_visible() ? $group_prod->get_permalink() : '';

					if ( ! $product_permalink ) {
						return sprintf( '<span class="d-block text-dark font-weight-bold">%s</span> <span class="text-grey-1 font-size-14 font-weight-normal">%s</span>', $parent_product_name, $product->get_name() );
					} else {
						return sprintf( '<a class="d-block text-dark font-weight-bold" href="%s">%s</a> <span class="text-grey-1 font-size-14 font-weight-normal">%s</span>', esc_url( $group_prod_permalink ), $parent_product_name, $product->get_name() );
					}
				} else {
					return $cart_item_name;
				}
			} else {
				return $cart_item_name;
			}
		}

		/**
		 * Add the parent grouped product name to cart items names
		 *
		 * @param string $item Order item.
		 * @param string $cart_item_key Cart item key.
		 * @param int    $values Cart item values.
		 */
		public function added_grouped_order_item_meta( $item, $cart_item_key, $values ) {
			if ( ! empty( $values['_hotel_id'] ) ) {
				$hotel_id = sanitize_text_field( $values['_hotel_id'] );
				$item->add_meta_data( '_hotel_id', $hotel_id );
			}
		}

		/**
		 * Add the parent grouped product name to order item
		 *
		 * @param string $item_name Order item name.
		 * @param string $item Order item.
		 * @param bool   $is_visible Check is visible.
		 */
		public function custom_order_item_name( $item_name, $item, $is_visible ) {
			$product           = $item->get_product();
			$product_id        = $item->get_product_id();
			$product_permalink = $is_visible ? $product->get_permalink( $item ) : '';

			$grouped_data = $item->get_meta( '_hotel_id' );

			$group_prod = wc_get_product( $grouped_data );

			if ( empty( $grouped_data ) ) {
				$item_name = $product_permalink ? sprintf(
					'<a class="text-dark font-weight-bold" href="%s">%s</a>',
					esc_url( $product_permalink ),
					$item->get_name()
				) : $item->get_name();
			} else {
				$item_name = $product_permalink ? sprintf(
					'<a class="d-block text-dark font-weight-bold" href="%s">%s</a><span class="text-grey-1 font-size-14 font-weight-normal">%s</span>',
					esc_url( $group_prod->get_permalink() ),
					$group_prod->get_name(),
					$item->get_name()
				) : $group_prod->get_name() . ' > ' . $item->get_name();
			}

			return $item_name;
		}

		/**
		 * Filters whether to remove the 'Formats' drop-down from the post list table.
		 *
		 * @param string $args Argument.
		 */
		public function products_format_filter( $args ) {
			$args['product_format'] = 'render_products_format_filter';
			return $args;
		}

		/**
		 * Product format links
		 *
		 * @param string $views Argument.
		 */
		public function products_format_links( $views ) {
			$views['product_format_links'] = render_products_format_view();
			return $views;
		}

		/**
		 * Display booking data
		 *
		 * @param string $cart_item_meta Argument.
		 * @param int    $product_id Product id.
		 * @param int    $variation_id Variation product id.
		 * @param int    $quantity Product quantity.
		 */
		public function mas_travels_add_cart_item_booking_data( $cart_item_meta, $product_id, $variation_id, $quantity ) {
			// Use $_REQUEST to allow $_POST and $_GET.
			if ( isset( $_REQUEST ) && ! empty( $product_id ) ) {
				$post_data = $_REQUEST;
			} else {
				return $cart_item_meta;
			}

			$_product_id = empty( $variation_id ) ? $product_id : $variation_id;
			$product     = wc_get_product( $product_id );
			$_product    = wc_get_product( $_product_id );

			// Return if start date is not set.
			if ( ! isset( $post_data['start_date_submit'] ) ) {
				return $cart_item_meta;
			}

			$start = $post_data['start_date_submit'];
			$end   = isset( $post_data['end_date_submit'] ) ? $post_data['end_date_submit'] : false;

			$cart_item_meta['start_date_submit'] = sanitize_text_field( $post_data['start_date_submit'] );
			$cart_item_meta['end_date_submit']   = sanitize_text_field( $post_data['end_date_submit'] );

			return apply_filters( 'mas_travels_booking_add_cart_item_booking_data', $cart_item_meta );

		}

		/**
		 * Display booking dates in Cart
		 *
		 * @param string $other_data Other data.
		 * @param int    $cart_item Cart item.
		 */
		public function mas_travels_display_booking_dates_in_cart( $other_data, $cart_item ) {
			$id = $cart_item['product_id'];

			if ( 'hotel' === get_product_format( $id ) || ( isset( $cart_item['_hotel_id'] ) && ! empty( $cart_item['_hotel_id'] ) ) ) {
				$booking_start = esc_html__( 'Check In', 'mas-travels' );
				$booking_end   = esc_html__( 'Check Out', 'mas-travels' );
			} else {
				$booking_start = esc_html__( 'Start', 'mas-travels' );
				$booking_end   = esc_html__( 'End', 'mas-travels' );
			}

			// For bundles, only display dates on parent product.
			if ( isset( $cart_item['bundled_by'] ) ) {
				return $other_data;
			}

			if ( isset( $cart_item['start_date_submit'] ) && ! empty( $cart_item['start_date_submit'] ) ) {

				$other_data[] = array(
					'name'  => apply_filters( 'mas_travels_booking_start_date_text', $booking_start ),
					'date'  => esc_html__( 'start', 'mas-travels' ),
					'value' => date_i18n( get_option( 'date_format' ), strtotime( $cart_item['start_date_submit'] ) ),
				);

			}

			if ( isset( $cart_item['end_date_submit'] ) && ! empty( $cart_item['end_date_submit'] ) ) {

				$other_data[] = array(
					'name'  => apply_filters( 'mas_travels_booking_end_date_text', $booking_end ),
					'date'  => esc_html__( 'end', 'mas-travels' ),
					'value' => date_i18n( get_option( 'date_format' ), strtotime( $cart_item['end_date_submit'] ) ),
				);

			}

			return $other_data;

		}

		/**
		 * Add order item booking data
		 *
		 * @param string $item Order item.
		 * @param int    $cart_item_key Cart item key.
		 * @param string $values Order item values.
		 */
		public function mas_travels_add_order_item_booking_data( $item, $cart_item_key, $values ) {

			if ( ! empty( $values['start_date_submit'] ) ) {

				// Start date format yyyy-mm-dd.
				$start = sanitize_text_field( $values['start_date_submit'] );

				// Store start date.
				$item->add_meta_data( 'start_date_submit', $start );

				// End date format yyyy-mm-dd.
				$end = ! empty( $values['end_date_submit'] ) ? sanitize_text_field( $values['end_date_submit'] ) : false;

				// Maybe store end date.
				if ( $end ) {
					$item->add_meta_data( 'end_date_submit', $end );
				}
			}
		}

		/**
		 * Display booking dates in chekout
		 *
		 * @param string $html HTML.
		 * @param string $item Order item.
		 * @param string $args Arguments.
		 */
		public function mas_travels_display_booking_dates_in_checkout( $html, $item, $args ) {

			$product   = $item->get_product();
			$strings   = array();
			$meta_data = array();
			// Add class for styling.
			$args = wp_parse_args(
				array( 'before' => '<ul class="wc-item-meta mas-travels-item-meta mt-2"><li>' ),
				$args
			);

			$start = $item->get_meta( 'start_date_submit' );

			if ( isset( $start ) && ! empty( $start ) ) {

				$meta_data[] = array(
					'display_key'   => esc_html__( 'Start', 'mas-travels' ),
					'display_value' => date_i18n( get_option( 'date_format' ), strtotime( $start ) ),
				);

			}

			$end = $item->get_meta( 'end_date_submit' );

			if ( isset( $end ) && ! empty( $end ) ) {

				$meta_data[] = array(
					'display_key'   => esc_html__( 'End', 'mas-travels' ),
					'display_value' => date_i18n( get_option( 'date_format' ), strtotime( $end ) ),
				);

			}

			foreach ( apply_filters( 'mas_travels_display_item_meta', $meta_data, $item ) as $index => $meta ) {
				$value     = $args['autop'] ? wp_kses_post( $meta['display_value'] ) : wp_kses_post( make_clickable( trim( $meta['display_value'] ) ) );
				$strings[] = $args['label_before'] . wp_kses_post( $meta['display_key'] ) . $args['label_after'] . $value;
			}

			if ( $strings ) {
				$html .= $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
			}

			return $html;

		}

		/**
		 * Variable product dropdown option
		 *
		 * @param string $html HTML.
		 * @param string $args Argument.
		 */
		public function mas_travels_filter_dropdown_option_html( $html, $args ) {
			global $product;
			$product_format = get_product_format() ? get_product_format() : 'standard';
			$product_type   = $product->get_type();

			if ( 'tour' === $product_format || 'activity' === $product_format ) :
				$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : esc_html__( 'Choose an option', 'mas-travels' );
				$show_option_none_html = '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

				$html = str_replace( $show_option_none_html, '', $html );

			endif;
			return $html;
		}
		/**
		 * Add product attribute custom field
		 */
		public function mas_travels_custom_product_attribute_field() {
			$id    = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
			$value = $id ? get_option( "woocommerce_custom_attribute_field-$id" ) : '';
			?>
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="custom_attribute_field"><?php echo esc_html__( 'Attribute Title', 'mas-travels' ); ?></label>
					</th>
					<td>
						<input name="custom_attribute_field" id="custom_attribute_field" value="<?php echo esc_attr( $value ); ?>" />
						<p class="description"><?php esc_html_e( 'Title for the attribute (shown on the front-end), display only for the product format Tour and Activity. ', 'mas-travels' ); ?></p>

					</td>
				</tr>
			<?php
		}

		/**
		 * Save product attribute custom field
		 *
		 * @param int $id Attribute id.
		 */
		public function save_mas_travels_custom_product_attribute( $id ) {
			if ( is_admin() && isset( $_POST['custom_attribute_field'] ) ) {// phpcs:ignore.
				$option = "woocommerce_custom_attribute_field-$id";
				update_option( $option, sanitize_text_field( $_POST['custom_attribute_field'] ) ); //phpcs:ignore.

			}
		}
		/**
		 * Get the grouped children products ids
		 *
		 * @param int $post_id Post id.
		 */
		public function mas_travels_action_process_children_product_meta( $post_id ) {
			// Get the children products ids.
			$children_ids = (array) get_post_meta( $post_id, '_children', true );

			// Loop through children product Ids.
			foreach ( $children_ids as $child_id ) {
				// add a specific custom field to each child with the parent grouped product id.
				update_post_meta( $child_id, '_child_of', $post_id );
			}
		}

		/**
		 * Override price range HTML
		 *
		 * @param string $price  Price HTML.
		 * @param string $from   Start price.
		 * @param string $to     End price.
		 */
		public function format_price_range( $price, $from, $to ) {
			$layout = get_product_format() ? get_product_format() : 'standard';

			if ( is_numeric( $from ) ) {
				$from = wc_price( $from );
			}

			if ( is_archive() ) {
				$class = 'text-white';
			} else {
				$class = 'text-gray-1';
			}

			if ( 'yacht' === $layout ) {
				$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'd-none' : 'font-size-14 text-white';
			} elseif ( 'tour' === $layout ) {
				$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'mr-1 font-size-14 text-gray-1' : 'mr-1 text-white';
			} elseif ( 'activity' === $layout ) {
				$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'mr-1 font-size-14' : 'mr-1 font-size-14 text-gray-1';
			} elseif ( 'rental' === $layout || 'car_rental' === $layout ) {
				$price_class = ( 'list' === wc_get_loop_prop( 'tab-view' ) ) ? 'd-none' : 'mr-1 font-size-14 mb-2 d-inline-block text-white';
			} else {
				$price_class = 'mr-1 font-size-14 text-gray-1';
			}

			if ( is_product() && empty( wc_get_loop_prop( 'name' ) ) ) {
				$price_class = 'font-size-14';
			}
			/* translators: %s: price range text */
			$price = sprintf( _x( '%2$s %1$s', 'Price range: from-to', 'mas-travels' ), $from, '<span class="' . esc_attr( $price_class ) . '">' . esc_html__( 'From', 'mas-travels' ) . '</span>' );

			return $price;
		}


		/**
		 * Display product categories
		 *
		 * @param string $html Sale badge HTML.
		 * @param string $post  Sale post.
		 * @param string $product  Sale product.
		 */
		public function mytravel_add_percentage_to_sale_badge( $html, $post, $product ) {

			if ( apply_filters( 'mytravel_enable_percentage_to_sale_badge', true ) ) {

				if ( $product->is_type( 'variable' ) ) {
					$percentages = array();
					// Get all variation prices.
					$prices = $product->get_variation_prices();

					// Loop through variation prices.
					foreach ( $prices['price'] as $key => $price ) {
						// Only on sale variations.
						if ( $prices['regular_price'][ $key ] !== $price ) {
							// Calculate and set in the array the percentage for each variation on sale.
							$percentages[] = round( 100 - ( floatval( $prices['sale_price'][ $key ] ) / floatval( $prices['regular_price'][ $key ] ) * 100 ) );
						}
					}
					// We keep the highest value.
					$percentage = '%' . max( $percentages );

				} elseif ( $product->is_type( 'grouped' ) ) {
					$percentages = array();

					// Get all variation prices.
					$children_ids = $product->get_children();

					// Loop through variation prices.
					foreach ( $children_ids as $child_id ) {
						$child_product = wc_get_product( $child_id );

						$regular_price = (float) $child_product->get_regular_price();
						$sale_price    = (float) $child_product->get_sale_price();

						if ( 0 !== $sale_price || ! empty( $sale_price ) ) {
							// Calculate and set in the array the percentage for each child on sale.
							$percentages[] = round( 100 - ( $sale_price / $regular_price * 100 ) );
						}
					}
					// We keep the highest value.
					$percentage = '%' . max( $percentages );

				} else {
					$regular_price = (float) $product->get_regular_price();
					$sale_price    = (float) $product->get_sale_price();

					if ( 0 !== $sale_price || ! empty( $sale_price ) ) {
						$percentage = '%' . round( 100 - ( $sale_price / $regular_price * 100 ) );
					} else {
						return $html;
					}
				}
				return $percentage;
			}
		}

		/**
		 * Yith integration
		 */
		public function mytravel_remove_yith_wcwl_post_class() {
			if ( class_exists( 'MyTravel' ) && mytravel_is_yith_wcwl_activated() ) {
				remove_filter( 'woocommerce_post_class', array( YITH_WCWL_Frontend(), 'add_products_class_on_loop' ) );
			}
		}

		/**
		 * Remove order meta item
		 *
		 * @param string $formatted_meta Array.
		 */
		public function mas_travels_order_item_get_formatted_meta_data( $formatted_meta ) {
			$temp_metas = [];
			foreach ( $formatted_meta as $key => $meta ) {
				if ( isset( $meta->key ) && ! in_array(
					$meta->key,
					[
						'start_date_submit',
						'end_date_submit',
					]
				) ) {
					$temp_metas[ $key ] = $meta;
				}
			}
			return $temp_metas;
		}
	}
}


