<?php
namespace MyTravelElementor\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use MyTravelElementor\Modules\QueryControl\Controls\Group_Control_Query;
use MyTravelElementor\Modules\Woocommerce\Classes\Products_Renderer;
use MyTravelElementor\Modules\Woocommerce\Classes\Current_Query_Renderer;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Class Products
 */
class Products extends Products_Base {
	/**
	 * Does it have an editor template?
	 *
	 * @var bool
	 */
	protected $_has_template_content = false;
	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-woocommerce-products';
	}
	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Products', 'mytravel-elementor' );
	}
	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-products';
	}
	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'product', 'archive' ];
	}
	/**
	 * Register query controls for this widget.
	 */
	protected function register_query_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Query::get_type(),
			[
				'name'           => Products_Renderer::QUERY_CONTROL_NAME,
				'post_type'      => 'product',
				'presets'        => [ 'include', 'exclude', 'order' ],
				'fields_options' => [
					'post_type' => [
						'default' => 'product',
						'options' => [
							'current_query' => esc_html__( 'Current Query', 'mytravel-elementor' ),
							'product'       => esc_html__( 'Latest Products', 'mytravel-elementor' ),
							'sale'          => esc_html__( 'Sale', 'mytravel-elementor' ),
							'featured'      => esc_html__( 'Featured', 'mytravel-elementor' ),
							'by_id'         => esc_html_x( 'Manual Selection', 'Posts Query Control', 'mytravel-elementor' ),
						],
					],
					'orderby'   => [
						'default' => 'date',
						'options' => [
							'date'       => esc_html__( 'Date', 'mytravel-elementor' ),
							'title'      => esc_html__( 'Title', 'mytravel-elementor' ),
							'price'      => esc_html__( 'Price', 'mytravel-elementor' ),
							'popularity' => esc_html__( 'Popularity', 'mytravel-elementor' ),
							'rating'     => esc_html__( 'Rating', 'mytravel-elementor' ),
							'rand'       => esc_html__( 'Random', 'mytravel-elementor' ),
							'menu_order' => esc_html__( 'Menu Order', 'mytravel-elementor' ),
						],
					],
					'exclude'   => [
						'options' => [
							'current_post'     => esc_html__( 'Current Post', 'mytravel-elementor' ),
							'manual_selection' => esc_html__( 'Manual Selection', 'mytravel-elementor' ),
							'terms'            => esc_html__( 'Term', 'mytravel-elementor' ),
						],
					],
					'include'   => [
						'options' => [
							'terms' => esc_html__( 'Term', 'mytravel-elementor' ),
						],
					],
				],
				'exclude'        => [
					'posts_per_page',
					'exclude_authors',
					'authors',
					'offset',
					'related_fallback',
					'related_ids',
					'query_id',
					'avoid_duplicates',
					'ignore_sticky_posts',
				],
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register  controls for this widget.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'mytravel-elementor' ),
				'type'         => Controls_Manager::NUMBER,
				'prefix_class' => 'mytravel-elementorducts-columns%s-',
				'min'          => 1,
				'max'          => 12,
				'default'      => Products_Renderer::DEFAULT_COLUMNS_AND_ROWS,
				'required'     => true,
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'rows',
			[
				'label'       => esc_html__( 'Rows', 'mytravel-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => Products_Renderer::DEFAULT_COLUMNS_AND_ROWS,
				'render_type' => 'template',
				'range'       => [
					'px' => [
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'paginate',
			[
				'label'     => esc_html__( 'Pagination', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'allow_order',
			[
				'label'     => esc_html__( 'Allow Order', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->add_control(
			'wc_notice_frontpage',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Ordering is not available if this widget is placed in your front page. Visible on frontend only.', 'mytravel-elementor' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition'       => [
					'paginate'    => 'yes',
					'allow_order' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_result_count',
			[
				'label'     => esc_html__( 'Show Result Count', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_sidebar_toggle',
			[
				'label'     => esc_html__( 'Show Sidebar Toggle', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'paginate' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->register_query_controls();

		parent::register_controls();
	}
	/**
	 * Get shortcode object.
	 *
	 * @param string $settings Product settings.
	 */
	protected function get_shortcode_object( $settings ) {
		if ( 'current_query' === $settings[ Products_Renderer::QUERY_CONTROL_NAME . '_post_type' ] ) {
			$type = 'current_query';
			return new Current_Query_Renderer( $settings, $type );
		}
		$type = 'products';
		return new Products_Renderer( $settings, $type );
	}
	/**
	 * Output.
	 */
	protected function render() {
		if ( WC()->session ) {
			wc_print_notices();
		}
		// For Products_Renderer.
		if ( ! isset( $GLOBALS['post'] ) ) {
			$GLOBALS['post'] = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}

		$settings = $this->get_settings();

		$shortcode = $this->get_shortcode_object( $settings );

		$content = $shortcode->get_content();

		if ( $content ) {
			echo $content; // phpcs:ignore.
		} elseif ( $this->get_settings( 'nothing_found_message' ) ) {
			echo '<div class="elementor-nothing-found mytravel-elementorducts-nothing-found">' . esc_html( $this->get_settings( 'nothing_found_message' ) ) . '</div>';
		}
	}
	/**
	 * Render plain content.
	 */
	public function render_plain_content() {}
}
