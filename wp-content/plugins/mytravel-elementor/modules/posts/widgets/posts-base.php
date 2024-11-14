<?php
namespace MyTravelElementor\Modules\Posts\Widgets;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Base\Base_Widget;
use Elementor\Controls_Manager;
use MyTravelElementor\Modules\Posts\Traits\Button_Widget_Trait;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Posts
 */
abstract class Posts_Base extends Base_Widget {
	use Button_Widget_Trait;

	const LOAD_MORE_ON_CLICK        = 'load_more_on_click';
	const LOAD_MORE_INFINITE_SCROLL = 'load_more_infinite_scroll';


	/**
	 * The custom query.
	 *
	 * @var \WP_Query
	 */
	protected $query = null;
	/**
	 * Does it have an editor template?
	 *
	 * @var bool
	 */
	protected $_has_template_content = false;
	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}
	/**
	 * Get the script dependencies for this widget.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'imagesloaded', 'load-more' ];
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
		return $this->query;
	}
	/**
	 * Render the widget.
	 */
	public function render() {}

	/**
	 * Register load more button style controls
	 */
	public function register_load_more_button_style_controls() {
		$this->add_control(
			'heading_load_more_style_button',
			[
				'label'     => esc_html__( 'Button', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);

		$this->register_button_style_controls(
			[
				'section_condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);
	}

	/**
	 * Register load more message style controls
	 */
	public function register_load_more_message_style_controls() {
		$this->add_control(
			'heading_load_more_on_click_no_posts_message',
			[
				'label'     => esc_html__( 'No More Posts Message', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);

		$this->add_control(
			'heading_load_more_on_click_infinity_scroll_no_posts_message',
			[
				'label'     => esc_html__( 'No More Posts Message', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'pagination_type' => 'load_more_infinite_scroll',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'load_more_no_posts_message',
				'selector' => '{{WRAPPER}} .e-load-more-message',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'load_more_no_posts_message_color',
			[
				'label'     => esc_html__( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--load-more-message-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_spinner_color',
			[
				'label'     => esc_html__( 'Spinner Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => '--load-more-spinner-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'load_more_spinner[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'load_more_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--load-more—spacing: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
	}

	/**
	 * Register pagination section controls for this widget.
	 */
	public function register_pagination_section_controls() {
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => __( 'Pagination', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label'   => __( 'Pagination', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''                              => __( 'None', 'mytravel-elementor' ),
					'numbers'                       => __( 'Numbers', 'mytravel-elementor' ),
					'prev_next'                     => __( 'Previous/Next', 'mytravel-elementor' ),
					'numbers_and_prev_next'         => __( 'Numbers', 'mytravel-elementor' ) . ' + ' . __( 'Previous/Next', 'mytravel-elementor' ),
					self::LOAD_MORE_ON_CLICK        => esc_html__( 'Load on Click', 'mytravel-elementor' ),
					self::LOAD_MORE_INFINITE_SCROLL => esc_html__( 'Infinite Scroll', 'mytravel-elementor' ),
				],
			]
		);

		$this->add_control(
			'pagination_page_limit',
			[
				'label'     => __( 'Page Limit', 'mytravel-elementor' ),
				'default'   => '5',
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_numbers_shorten',
			[
				'label'     => __( 'Shorten', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'pagination_type' => [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_prev_label',
			[
				'label'     => __( 'Previous Label', 'mytravel-elementor' ),
				'default'   => __( '&laquo; Previous', 'mytravel-elementor' ),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_next_label',
			[
				'label'     => __( 'Next Label', 'mytravel-elementor' ),
				'default'   => __( 'Next &raquo;', 'mytravel-elementor' ),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'load_more_spinner',
			[
				'label'                  => esc_html__( 'Spinner', 'mytravel-elementor' ),
				'type'                   => Controls_Manager::ICONS,
				'fa4compatibility'       => 'icon',
				'default'                => [
					'value'   => 'fas fa-spinner',
					'library' => 'fa-solid',
				],
				'exclude_inline_options' => [ 'svg' ],
				'recommended'            => [
					'fa-solid' => [
						'spinner',
						'cog',
						'sync',
						'sync-alt',
						'asterisk',
						'circle-notch',
					],
				],
				'skin'                   => 'inline',
				'label_block'            => false,
				'condition'              => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
				'frontend_available'     => true,
			]
		);

		$this->add_control(
			'heading_load_more_button',
			[
				'label'     => esc_html__( 'Button', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);

		$this->register_button_content_controls(
			[
				'button_text'            => esc_html__( 'Load More', 'mytravel-elementor' ),
				'control_label_name'     => esc_html__( 'Button Text', 'mytravel-elementor' ),
				'prefix_class'           => 'load-more-align-',
				'alignment_default'      => 'center',
				'section_condition'      => [
					'pagination_type' => 'load_more_on_click',
				],
				'exclude_inline_options' => [ 'svg' ],
			]
		);

		$this->remove_control( 'button_type' );
		$this->remove_control( 'link' );
		$this->remove_control( 'size' );

		$this->add_control(
			'heading_load_more_no_posts_message',
			[
				'label'     => esc_html__( 'No More Posts Message', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->add_responsive_control(
			'load_more_no_posts_message_align',
			[
				'label'     => esc_html__( 'Alignment', 'mytravel-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--load-more-message-alignment: {{VALUE}};',
				],
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->add_control(
			'load_more_no_posts_message_switcher',
			[
				'label'     => esc_html__( 'Custom Messages', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->add_control(
			'load_more_no_posts_custom_message',
			[
				'label'       => esc_html__( 'No more posts message', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'No more posts to show', 'mytravel-elementor' ),
				'condition'   => [
					'pagination_type'                     => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
					'load_more_no_posts_message_switcher' => 'yes',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => __( 'Pagination', 'mytravel-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_typography',
				'selector' => '{{WRAPPER}} .elementor-pagination',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'pagination_color_heading',
			[
				'label'     => __( 'Colors', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'pagination_colors' );

		$this->start_controls_tab(
			'pagination_color_normal',
			[
				'label' => __( 'Normal', 'mytravel-elementor' ),

			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => __( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
				],
				'default'   => '#5a5b75',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_hover',
			[
				'label' => __( 'Hover', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'pagination_hover_background_color',
			[
				'label'     => __( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'background-color: {{VALUE}};',
				],
				'default'   => '#e7e7ec',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_active',
			[
				'label' => __( 'Active', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'     => __( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
				],
				'default'   => '#fff',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'     => __( 'Space Between', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
				'default'   => [
					'size' => '19',
					'unit' => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_spacing_top',
			[
				'label'     => __( 'Spacing', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'pagination_active_border',
			[
				'label'     => __( 'Border', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'selectors' => [
					'{{WRAPPER}}  .elementor-pagination .page-numbers' => 'border: 1px solid;',
				],
			]
		);

		$this->add_control(
			'pagination_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .elementor-pagination .page-numbers' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'pagination_active_border' => 'yes',
				],
				'default'   => '#d9e2ef',
			]
		);

		$this->add_control(
			'pagination_active_border_color',
			[
				'label'     => esc_html__( 'Active Border Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .elementor-pagination .page-numbers.current' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'pagination_active_border' => 'yes',
				],
				'default'   => '#4a8f9f',
			]
		);

		$this->add_control(
			'pagination_active_bg_color',
			[
				'label'     => esc_html__( 'Active Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .elementor-pagination .page-numbers.current' => 'background-color: {{VALUE}} !important;',
				],
				'condition' => [
					'pagination_active_border' => 'yes',
				],
				'default'   => '#4a8f9f',
			]
		);

		$this->add_control(
			'pagination_active_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .elementor-pagination .page-numbers' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pagination_active_border' => 'yes',
				],
				'default'   => [
					'size' => '50',
					'unit' => '%',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label'     => esc_html__( 'Pagination', 'mytravel-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->register_load_more_button_style_controls();

		$this->register_load_more_message_style_controls();

		$this->end_controls_section();
	}
	/**
	 * Register layout section controls for this widget.
	 */
	public function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'mytravel-elementor' ),
			]
		);
		$this->end_controls_section();
	}
	/**
	 * Query posts based on Query Selector
	 */
	abstract public function query_posts();
	/**
	 * Get current page
	 */
	public function get_current_page() {
		if ( '' === $this->get_settings( 'pagination_type' ) ) {
			return 1;
		}

		return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
	}
	/**
	 * Get WP Link page
	 *
	 * @param  int $i Page Number.
	 * @return string
	 */
	public function get_wp_link_page( $i ) {
		if ( ! is_singular() || is_front_page() ) {
			return get_pagenum_link( $i );
		}

		// Based on wp-includes/post-template.php:957 `_wp_link_page`.
		global $wp_rewrite;
		$post       = get_post();
		$query_args = [];
		$url        = get_permalink();

		if ( $i > 1 ) {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
				$url = add_query_arg( 'page', $i, $url );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
			} else {
				$url = trailingslashit( $url ) . user_trailingslashit( $i, 'single_paged' );
			}
		}

		if ( is_preview() ) {
			if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
				$query_args['preview_id']    = mytravel_elementor_clean( wp_unslash( $_GET['preview_id'] ) );//phpcs:ignore
				$query_args['preview_nonce'] = mytravel_elementor_clean( wp_unslash( $_GET['preview_nonce'] ) );//phpcs:ignore
			}

			$url = get_preview_post_link( $post, $query_args, $url );
		}

		return $url;
	}
	/**
	 * Get posts nav link.
	 *
	 * @param int|null $page_limit The max number of pages.
	 * @return array
	 */
	public function get_posts_nav_link( $page_limit = null ) {
		if ( ! $page_limit ) {
			$page_limit = $this->query->max_num_pages;
		}

		$return = [];

		$paged = $this->get_current_page();

		$link_template     = '<a class="page-numbers %s" href="%s">%s</a>';
		$disabled_template = '<span class="page-numbers %s">%s</span>';

		if ( $paged > 1 ) {
			$next_page = intval( $paged ) - 1;
			if ( $next_page < 1 ) {
				$next_page = 1;
			}

			$return['prev'] = sprintf( $link_template, 'prev', $this->get_wp_link_page( $next_page ), $this->get_settings( 'pagination_prev_label' ) );
		} else {
			$return['prev'] = sprintf( $disabled_template, 'prev', $this->get_settings( 'pagination_prev_label' ) );
		}

		$next_page = intval( $paged ) + 1;

		if ( $next_page <= $page_limit ) {
			$return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), $this->get_settings( 'pagination_next_label' ) );
		} else {
			$return['next'] = sprintf( $disabled_template, 'next', $this->get_settings( 'pagination_next_label' ) );
		}

		return $return;
	}
}
