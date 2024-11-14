<?php
namespace MyTravelElementor\Modules\Destination\Widgets;

use MyTravelElementor\Base\Base_Widget;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use MyTravelElementor\Plugin;
use MyTravelElementor\Core\Controls_Manager as SN_Controls_Manager;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Destination widget.
 */
class Destination extends Base_Widget {

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'destination';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Destination', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-navigator';
	}

	/**
	 * Get the categories for the widget.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'mytravel' ];
	}

	/**
	 * Register controls for this widget.
	 *
	 * @return void
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'mytravel-elementor' ),
				'default'     => 'United Kingdom ',
				'description' => esc_html__( 'Use <br> to break into two lines', 'mytravel-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'product_name',
			[
				'label'       => esc_html__( 'Product Name', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Product title is  apply to the style-v3', 'mytravel-elementor' ),
				'condition'   => [
					'style' => 'style-v3',
				],
			]
		);

		$this->add_control(
			'title_link',
			[
				'label'       => esc_html__( 'Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'additional_link',
			[
				'label'       => esc_html__( 'Product Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [
					'url' => '',
				],
				'condition'   => [
					'style' => 'style-v3',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'    => 'H1',
					'h2'    => 'H2',
					'h3'    => 'H3',
					'h4'    => 'H4',
					'h5'    => 'H5',
					'h6'    => 'H6',
					'div'   => 'div',
					'span'  => 'span',
					'small' => 'small',
					'p'     => 'p',
				],
				'default'   => 'h2',
				'condition' => [
					'style' => 'style-v2',
				],
			]
		);

		$this->add_control(
			'dropdown_list_item',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Dropdown ?', 'mytravel-elementor' ),
				'default'   => 'no',
				'label_off' => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'  => esc_html__( 'Show', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-v1',
				'options' => [
					'style-v1' => 'Style v1',
					'style-v2' => 'Style v2',
					'style-v3' => 'Style v3',
				],
			],
			[
				'position' => [
					'at' => 'before',
					'of' => 'title',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Backround Image', 'mytravel-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_item',
			[
				'label'       => esc_html__( 'Dropdown Item', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Dropdown Item', 'mytravel-elementor' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Item Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'lists',
			[
				'label'       => esc_html__( 'Dropdown List', 'mytravel-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'list_item' => esc_html__( '30 Hotel', 'mytravel-elementor' ),
					],
					[
						'list_item' => esc_html__( '48 Tours', 'mytravel-elementor' ),
					],
					[
						'list_item' => esc_html__( '46 Activity', 'mytravel-elementor' ),
					],
					[
						'list_item' => esc_html__( '32 Yacht', 'mytravel-elementor' ),
					],
				],
				'title_field' => '{{{ list_item }}}',
				'condition'   => [
					'dropdown_list_item' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .mytravel-elementor-destination__title' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .mytravel-elementor-destination__title::after' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .mytravel-elementor-destination__title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_style',
			[
				'label'     => esc_html__( 'Lists', 'mytravel-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => 'style-v1',
				],
			]
		);

		$this->add_control(
			'list_color',
			[
				'label'     => esc_html__( 'List Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .mytravel-elementor-destination__list' => 'color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'style-v1',
				],
			]
		);

		$this->add_control(
			'dropdown_hover_color',
			[
				'label'     => esc_html__( 'Dropdown Hover Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dropdown-item:hover' => 'color: {{VALUE}};',
				],
				'default'   => '#D2CDCD',
				'condition' => [
					'style' => 'style-v1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_typography',
				'selector' => '{{WRAPPER}} .mytravel-elementor-destination__list',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label'     => esc_html__( 'Pill Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .mytravel-elementor-destination__style-v3' => 'background-color: {{VALUE}} !important;',
				],
				'condition' => [
					'style' => 'style-v3',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Pill Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .mytravel-elementor-destination__style-v3' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'style' => 'style-v3',
				],
			]
		);

		$this->add_control(
			'wrap_css',
			[
				'label'       => esc_html__( 'Wrap CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Wrap CSS classes separated by space that you\'d like to apply to the destination class wrap', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'content_wrap_css',
			[
				'label'       => esc_html__( 'Content Wrap CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Content Wrap CSS classes separated by space that you\'d like to apply to the destination-content class wrap', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'title_wrap_css',
			[
				'label'       => esc_html__( 'Title Wrap CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( '<div> Tag CSS classes separated by space that you\'d like to apply to the title wrap', 'mytravel-elementor' ),
				'condition'   => [
					'style' => 'style-v3',
				],
			]
		);

		$this->add_control(
			'title_css',
			[
				'label'       => esc_html__( 'Title CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Additional CSS classes separated by space that you\'d like to apply to the title', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'style_css',
			[
				'label'       => esc_html__( 'Additional CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( '<div> Tag CSS classes separated by space that you\'d like to apply to the Product name top wrap', 'mytravel-elementor' ),
				'condition'   => [
					'style' => 'style-v3',
				],
			]
		);

		$this->add_control(
			'anchor_css',
			[
				'label'       => esc_html__( 'Anchor CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Anchor CSS classes separated by space that you\'d like to apply to the destination-style-v3 class', 'mytravel-elementor' ),
				'condition'   => [
					'style' => 'style-v3',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render.
	 *
	 * @return void
	 */
	protected function render() {
		$settings  = $this->get_settings_for_display();
		$title     = $settings['title'];
		$title_tag = $settings['title_tag'];
		if ( 'style-v1' === $settings['style'] || 'style-v3' === $settings['style'] ) {
			$title_tag = 'a';
		} else {
			$title_tag = $settings['title_tag'];
		}

		if ( ! empty( $settings['title_link']['url'] && 'style-v1' === $settings['style'] || 'style-v3' === $settings['style'] ) ) {
			$this->add_link_attributes( 'link', $settings['title_link'] );
		}

		if ( ! empty( $settings['title_link']['url'] ) ) {
			$this->add_link_attributes( 'wrap', $settings['title_link'] );
			$this->add_render_attribute( 'wrap', 'class', 'd-block' );
		}

		if ( 'style-v2' === $settings['style'] ) : ?>
		<a <?php $this->print_render_attribute_string( 'wrap' ); ?>>
			<?php
		endif;

		$this->add_render_attribute(
			'wrap_class',
			'class',
			[
				'bg-img-hero',
				'rounded-border',
				'transition-3d-hover',
				'shadow-hover-2',
				$settings['wrap_css'],
			]
		);

		$this->add_render_attribute(
			'content',
			'class',
			[
				'destination-content',
				'd-flex',
				'justify-content-between',
				$settings['content_wrap_css'],
			]
		);

		$this->add_render_attribute(
			'title',
			'class',
			[
				'mytravel-elementor-destination__title',
				'text-white',
				'font-weight-bold',
				$settings['title_css'],
			]
		);

		if ( 'style-v1' === $settings['style'] || 'style-v2' === $settings['style'] ) :
			?>
			<div <?php $this->print_render_attribute_string( 'wrap_class' ); ?> 
			<?php
			if ( ! empty( $settings['image']['url'] ) ) :
				?>
				style="background-image: url(<?php echo esc_url( $settings['image']['url'] ); ?> );"<?php endif; ?>>
				<div <?php $this->print_render_attribute_string( 'content' ); ?>>
					<div class="position-relative">
						<<?php echo esc_attr( $title_tag ); ?> <?php $this->print_render_attribute_string( 'link' ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo esc_html( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
							<?php
							if ( 'yes' === $settings['dropdown_list_item'] ) {
								?>
							<!-- Dropdown List -->
							<div class="destination-dropdown v1">
								<?php
								foreach ( $settings['lists'] as $index => $list ) :
										$this->add_render_attribute(
											'dropdown',
											[
												'class' => 'mytravel-elementor-destination__list dropdown-item',
												'href'  => $list['link'],
											]
										);
									?>
									<a <?php $this->print_render_attribute_string( 'dropdown' ); ?>><?php echo esc_html( $list['list_item'] ); ?></a>
								<?php endforeach; ?>
							</div>
							<!-- End Dropdown List -->
								<?php
							}
							?>
					</div>
				</div>
			</div>
			<?php
			if ( 'style-v2' === $settings['style'] ) {
				?>
			</a>
				<?php

			}
		endif;
		$product_name = $settings['product_name'];

		$this->add_render_attribute(
			'product_class',
			'class',
			[
				'style-v3',
				'mytravel-elementor-destination__style-v3',
				$settings['style_css'],
			]
		);

		if ( ! empty( $settings['additional_link']['url'] ) ) {
			$this->add_link_attributes( 'product_link', $settings['additional_link'] );
		}

		$this->add_render_attribute(
			'product_link_class',
			'class',
			[
				'mytravel-elementor-destination__style-v3',
				'destination-style-v3',
				$settings['anchor_css'],
			]
		);

		$this->add_render_attribute(
			'wrap_title',
			'class',
			[
				'pb-3',
				'text-lh-1',
				$settings['title_wrap_css'],
			]
		);

		if ( 'style-v3' === $settings['style'] ) :
			?>
			<div <?php $this->print_render_attribute_string( 'wrap_class' ); ?> 
			<?php
			if ( ! empty( $settings['image']['url'] ) ) :
				?>
				style="background-image: url(<?php echo esc_url( $settings['image']['url'] ); ?> );"<?php endif; ?>>
				<header <?php $this->print_render_attribute_string( 'content' ); ?>>
					<div>
						<div <?php $this->print_render_attribute_string( 'wrap_title' ); ?>>
							<<?php echo esc_attr( $title_tag ); ?> <?php $this->print_render_attribute_string( 'link' ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo esc_html( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
						</div>
						<div <?php $this->print_render_attribute_string( 'product_class' ); ?>>
							<a <?php $this->print_render_attribute_string( 'product_link' ); ?> <?php $this->print_render_attribute_string( 'product_link_class' ); ?>><?php echo esc_html( $product_name ); ?></a>
						</div>
					</div>
				</header>
			</div>
			<?php
		endif;
	}

}
