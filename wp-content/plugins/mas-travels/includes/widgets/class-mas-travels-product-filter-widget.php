<?php
/**
 * Creates a Products Filter Widget which can be placed in sidebar
 *
 * @class       MAS_Travels_Products_Filter_Widget
 * @version     1.0.0
 * @package     Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WP_Widget' ) ) :
	/**
	 * MAS Travels Products Filter widget class
	 *
	 * @since 1.0.0
	 */
	class MAS_Travels_Products_Filter_Widget extends WP_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products filter sidebar widgets to your sidebar.', 'mas-travels' ) );
			parent::__construct( 'mytravel_products_filter', esc_html__( 'MyTravel Product Filter', 'mas-travels' ), $widget_ops );
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 * @param array $args     Arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {

			if ( ! woocommerce_products_will_display() ) {
				return;
			}

			echo wp_kses_post( $args['before_widget'] );

			if ( ! is_active_sidebar( 'product-filters-widgets' ) ) {
				if ( function_exists( 'mytravel_default_product_filter_widgets' ) ) {
					mytravel_default_product_filter_widgets();
				}
			} else {
				?><div class="product-filters mx-n4 my-n4">
					<?php dynamic_sidebar( 'product-filters-widgets' ); ?>
				</div>
				<?php

			}

			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @see WP_Widget->form
		 *
		 * @param array $instance Instance.
		 */
		public function form( $instance ) {
			global $wp_registered_sidebars;

			// If no sidebars exists.
			if ( ! $wp_registered_sidebars ) {
				echo '<p>' . esc_html__( 'No sidebars are available.', 'mas-travels' ) . '</p>';
				return;
			}
		}
	}
endif;
