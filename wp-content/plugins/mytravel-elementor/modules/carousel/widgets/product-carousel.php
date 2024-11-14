<?php
namespace MyTravelElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Modules\QueryControl\Controls\Group_Control_Related;
use Elementor\Repeater;
use Elementor\Utils;
use MyTravelElementor\Modules\Carousel\Skins;
use Elementor\Group_Control_Image_Size;
use MyTravelElementor\Modules\QueryControl\Module as Module_Query;
use MyTravelElementor\Core\Utils as MYT_Utils;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Carousel Geeks Elementor widget class.
 */
class Product_Carousel extends Base {
	/**
	 * Query
	 *
	 * @var \WP_Query
	 */
	protected $query = null;

	/**
	 * Fetch the Scripts based on keyword.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'slick-carousel' ];
	}
	/**
	 * Skip widget.
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
		return 'myt-product-carousel';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Product Carousel', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'product-carousel', 'products', 'carousel', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
	}

	/**
	 * Register the Skins with the widget.
	 *
	 * @return void
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Product_Carousel_V1( $this ) );
		$this->add_skin( new Skins\Skin_Product_Carousel_V2( $this ) );
		$this->add_skin( new Skins\Skin_Product_Carousel_V3( $this ) );
		$this->add_skin( new Skins\Skin_Product_Carousel_V4( $this ) );
		$this->add_skin( new Skins\Skin_Product_Carousel_V5( $this ) );
		$this->add_skin( new Skins\Skin_Product_Carousel_V6( $this ) );
	}


	/**
	 * Return the query var
	 *
	 * @return \WP_Query
	 */
	public function get_query() {
		return $this->query;
	}

	/**
	 * Get post type object on import.
	 *
	 * @param array $element settings posttype.
	 * @return array
	 */
	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	/**
	 * Get the group for this widget.
	 *
	 * @return string
	 */
	public function get_group_name() {
		return 'carousel';
	}

	/**
	 * Add repeater controls
	 *
	 * @param Repeater $repeater Add controls to this repeater.
	 */
	protected function add_repeater_controls( Repeater $repeater ) {}

	/**
	 * Get the default values for the repeater controls
	 */
	protected function get_repeater_defaults() {}

	/**
	 * Print each item in the carousel
	 *
	 * @param array  $slide        Repeater setting for each slide.
	 * @param array  $settings     Widget settings.
	 * @param string $element_key  Key of the slide in the repeater.
	 */
	protected function print_slide( array $slide, array $settings, $element_key ) {}

	/**
	 * Register controls for this widget.
	 */
	protected function register_controls() {
		parent::register_controls();
		$this->remove_control( 'slides' );
		$this->register_query_section_controls();
	}

	/**
	 * Get posts.
	 *
	 * @param array $settings settings.
	 * @return void
	 */
	public function query_posts( $settings ) {
		$query_args = [
			'post_type'      => 'product',
			'posts_per_page' => $settings['posts_per_page'],
		];

		$elementor_query = Module_Query::instance();
		$this->query     = $elementor_query->get_query( $this, 'posts', $query_args, [] );
	}

	/**
	 * Register Query Section Controls for this widget.
	 *
	 * @return void
	 */
	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Product', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Products Per Page', 'mytravel-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_carousel_query',
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

}
