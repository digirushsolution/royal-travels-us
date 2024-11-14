<?php
namespace MyTravelElementor\Modules\Posts\Widgets;

use Elementor\Controls_Manager;
use MyTravelElementor\Modules\QueryControl\Module as Module_Query;
use MyTravelElementor\Modules\QueryControl\Controls\Group_Control_Related;
use MyTravelElementor\Modules\Posts\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Posts
 */
class Posts extends Posts_Base {
	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mt-posts';
	}
	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Posts', 'mytravel-elementor' );
	}
	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
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
	 * Register the skins for the widget.
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Post_Grid( $this ) );
		$this->add_skin( new Skins\Skin_Post_List( $this ) );
	}

	/**
	 * Register controls for this widget.
	 */
	protected function register_controls() {
		parent::register_controls();
		$this->register_query_section_controls();
		$this->register_pagination_section_controls();
	}
	/**
	 * Query posts based on Query Selector
	 */
	public function query_posts() {

		$query_args = [
			'posts_per_page' => $this->get_current_skin()->get_instance_value( 'posts_per_page' ),
			'paged'          => $this->get_current_page(),
		];

		// /** @var Module_Query $elementor_query */
		$elementor_query = Module_Query::instance();
		$this->query     = $elementor_query->get_query( $this, 'posts', $query_args, [] );
	}
	/**
	 * Register query controls for this widget.
	 */
	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'              => __( 'Columns', 'mytravel-elementor' ),
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
				'condition'          => [
					'_skin' => 'grid',
				],
			]
		);

		$this->add_control(
			'additional_class',
			[
				'label'       => esc_html__( 'Post Additional Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Wrap CSS classes separated by space that you\'d like to apply to the post list class <div> tag.', 'mytravel-elementor' ),
				'default'     => 'mb-6',

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
				'name'    => 'posts',
				'presets' => [ 'full' ],
			]
		);

		$this->end_controls_section();
	}
}
