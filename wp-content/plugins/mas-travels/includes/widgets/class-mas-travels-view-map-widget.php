<?php
/**
 * Widget "MAS Travels - View Map"
 *
 * Displays your map.
 *
 * @uses WP_Widget
 */
class MAS_Travels_View_Map extends WP_Widget {

	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'mytravel_view_map';
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Displays map', 'mas-travels' ) );
		parent::__construct( $this->widget_id, esc_html__( 'MyTravel - View Map', 'mas-travels' ), $opts );

	}

	/**
	 * Display the widget contents.
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}.
	 * @param array $instance Widget settings.
	 */
	public function widget( $args, $instance ) {
		if ( ! function_exists( 'mytravel_view_map' ) ) {
			return;
		}

		?>
		<div class="widget widget_view_map pb-4 mb-2">
			<?php mytravel_view_map(); ?>
		</div>
		<?php
	}

}
