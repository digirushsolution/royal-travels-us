<?php
namespace MyTravelElementor\Modules\Posts\Widgets;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Base\Base_Widget;
use MyTravelElementor\Modules\QueryControl\Module as Module_Query;
use MyTravelElementor\Modules\QueryControl\Controls\Group_Control_Related;
use Elementor\Controls_Manager;
use MyTravelElementor\Modules\Posts\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Products
 */
class Products extends Posts_Base {

	/**
	 * The custom query.
	 *
	 * @var \WP_Query
	 */
	private $_query = null;
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
		return 'mt-products';
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
		return 'eicon-parallax';
	}
	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'portfolio', 'custom post type' ];
	}
	/**
	 * On Widgets import
	 *
	 * @param Elementor\Controls_Stack $element The element that is being imported.
	 * @return Elementor\Controls_Stack
	 */
	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}
	/**
	 * Register skins for the widget.
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\skin_products_style_1( $this ) );
		$this->add_skin( new Skins\skin_products_style_2( $this ) );
		$this->add_skin( new Skins\skin_products_style_3( $this ) );
		$this->add_skin( new Skins\skin_products_style_4( $this ) );
		$this->add_skin( new Skins\skin_products_style_5( $this ) );
		$this->add_skin( new Skins\skin_products_style_6( $this ) );
	}
	/**
	 * 1) build query args
	 * 2) invoke callback to fine-tune query-args
	 * 3) generate WP_Query object
	 * 4) if no results & fallback is set, generate a new WP_Query with fallback args
	 * 5) return WP_Query
	 *
	 * @return \WP_Query
	 */
	public function get_query() {
		return $this->_query;
	}
	/**
	 * Register controls for this widget.
	 */
	protected function register_controls() {
		$this->register_query_section_controls();
	}
	/**
	 * Register query controls for this widget.
	 */
	private function register_query_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'mytravel-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'              => esc_html__( 'Columns', 'mytravel-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '3',
				'tablet_default'     => '2',
				'mobile_default'     => '1',
				'options'            => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class'       => 'elementor-grid%s-',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'enable_shop_control_bar',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Shop Control Bar ?', 'mytravel-elementor' ),
				'default'   => 'yes',
				'label_off' => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'  => esc_html__( 'Show', 'mytravel-elementor' ),
				'condition' => [
					'_skin!' => 'myt-nav-tabs-skin',
				],
			]
		);

		$this->add_control(
			'enable_sorting',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Sorting ?', 'mytravel-elementor' ),
				'default'   => 'yes',
				'label_off' => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'  => esc_html__( 'Show', 'mytravel-elementor' ),
				'condition' => [
					'enable_shop_control_bar' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Related::get_type(),
			[
				'name'      => 'posts',
				'presets'   => [ 'full' ],
				'post_type' => 'product',
				'exclude'   => [
					'posts_per_page', // use the one from Layout section.
				],
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Query posts based on Query Selector
	 */
	public function query_posts() {

		$query_args = [
			'posts_per_page' => $this->get_settings( 'posts_per_page' ),
			'paged'          => $this->get_current_page(),

		];

		// /** @var Module_Query $elementor_query */
		$elementor_query = Module_Query::instance();
		$this->_query    = $elementor_query->get_query( $this, 'posts', $query_args, [] );
	}
}
