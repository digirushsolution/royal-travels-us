<?php
namespace MyTravelElementor\Modules\NavTabs\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use MyTravelElementor\Base\Base_Widget;
use Elementor\Repeater;
use MyTravelElementor\Core\Controls_Manager as MYT_Controls_Manager;
use Elementor\Icons_Manager;
use MyTravelElementor\Modules\NavTabs\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Nav Tabs Mytravel Elementor Widget.
 */
class Nav_Tabs extends Base_Widget {

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-nav-tabs';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Nav Tabs', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'navtabs', 'tabs', 'nav' ];
	}

	/**
	 * Register the Skins with the widget.
	 *
	 * @return void
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Nav_Tabs( $this ) );

	}

	/**
	 * Register controls for this widget.
	 */
	protected function register_controls() {
		parent::register_controls();

		$this->start_controls_section(
			'section_list',
			[
				'label' => esc_html__( 'Nav Tabs List', 'mytravel-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list',
			[
				'label'       => esc_html__( 'List Item', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'List Item', 'mytravel-elementor' ),
				'default'     => esc_html__( 'List Item', 'mytravel-elementor' ),
			]
		);

		$repeater->add_control(
			'content_id',
			[
				'label'       => esc_html__( 'Tab Content ID', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Tab Content Id', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'list_item_icon',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => esc_html__( 'Enable Icons ?', 'mytravel-elementor' ),
				'default'   => 'yes',
				'label_off' => esc_html__( 'Hide', 'mytravel-elementor' ),
				'label_on'  => esc_html__( 'Show', 'mytravel-elementor' ),
				'condition' => [
					'_skin!' => 'myt-nav-tabs-skin',
				],
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'mytravel-elementor' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'nav_tabs',
			[
				'label'       => esc_html__( 'Nav List', 'mytravel-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title' => esc_html__( 'Hotel', 'mytravel-elementor' ),
					],
					[
						'title' => esc_html__( 'Tours', 'mytravel-elementor' ),
					],
					[
						'title' => esc_html__( 'Activity', 'mytravel-elementor' ),
					],
					[
						'title' => esc_html__( 'Rental', 'mytravel-elementor' ),
					],
				],
				'title_field' => '{{{ list }}}',
			]
		);

		$this->add_control(
			'nav_tabs_style',
			[
				'label'     => esc_html__( 'Tabs Style', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => esc_html__( 'Default', 'mytravel-elementor' ),
					'pill'    => esc_html__( 'Pill', 'mytravel-elementor' ),
					'rounded' => esc_html__( 'Rounded Icon', 'mytravel-elementor' ),
					'boxed'   => esc_html__( 'Boxed', 'mytravel-elementor' ),
					'square'  => esc_html__( 'Square', 'mytravel-elementor' ),
					'shadow'  => esc_html__( 'Shadow', 'mytravel-elementor' ),
					'line'    => esc_html__( 'Line', 'mytravel-elementor' ),
				],
				'condition' => [
					'_skin!' => 'myt-nav-tabs-skin',
				],
			],
			[
				'position' => [
					'at' => 'before',
					'of' => 'list_item_icon',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_style',
			[
				'label' => esc_html__( 'List', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_title_typography',
				'selector' => '{{WRAPPER}} .nav-item .nav-link',
			]
		);

		$this->add_control(
			'tab_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-elementor__tab' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'list_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .nav-item .nav-link' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .nav-item .nav-link span, {{WRAPPER}} .nav-item .nav-link i' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'text_color_hover',
			[
				'label'     => esc_html__( 'Text Active Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .tab-nav-line .nav-link.active span' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-list .nav-link.active i, {{WRAPPER}} .tab-nav-list .nav-link.active span' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-list .nav-link.active' => 'border-left-color: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-line .nav-link.active .tabtext::after' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-rounded .nav-link.active .icon::before' => 'background-color: {{VALUE}} !important; border: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-shadow .nav-link.active::before' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-list .nav-link.active ' => 'color: {{VALUE}} !important;',

				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .myt-elementor__icon' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tab-nav-list .nav-link i' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'_skin!' => 'myt-nav-tabs-skin',
				],
			]
		);

		$this->add_control(
			'nav_css',
			[
				'label'       => esc_html__( 'Nav CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <ul> tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'link_css',
			[
				'label'       => esc_html__( 'Anchor CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <a> tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'text_wrap_css',
			[
				'label'       => esc_html__( 'Text Wrap CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <div> tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'text_css',
			[
				'label'       => esc_html__( 'Text CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <span> tag', 'mytravel-elementor' ),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Renders the Nav Tabs widget.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$list_id  = uniqid( 'tabs-' );
		$classes  = $settings['nav_css'];

		$this->add_render_attribute(
			'list',
			[
				'class' => array( 'nav', 'flex-nowrap', 'tab-nav', 'text-nowrap', 'tab-nav-' . $settings['nav_tabs_style'], $classes ),
				'role'  => 'tablist',
			]
		);

		?>
		<ul <?php $this->print_render_attribute_string( 'list' ); ?>>
			<?php
			foreach ( $settings['nav_tabs'] as $index => $item ) :
				$count    = $index + 1;
				$active   = '';
				$selected = 'false';

				$this->add_render_attribute(
					'list_item' . $count,
					[
						'class' => [
							'nav-item',
							'myt-elementor__tab',
						],
					]
				);

				if ( 1 === $count ) {
					$active   = 'active';
					$selected = 'true';
					$this->add_render_attribute( 'list_item' . $count, 'class' );
				}

				$this->add_render_attribute(
					'list_link' . $count,
					[
						'class'         => array( 'nav-link font-weight-medium', $active ),
						'id'            => 'nav-' . $item['content_id'],
						'data-toggle'   => 'pill',
						'data-target'   => '#' . $item['content_id'],
						'href'          => '#',
						'role'          => 'tab',
						'aria-controls' => 'nav-' . $item['content_id'],
						'aria-selected' => $selected,
					]
				);

				if ( ! empty( $settings['link_css'] && 1 === $count ) ) {
					$this->add_render_attribute( 'list_link' . $count, 'class', $settings['link_css'] );
				}

				$icon = [ 'icon font-size-3', 'myt-elementor__icon' ];

				if ( $item['icon']['value'] ) {
					$icon[] = $item['icon']['value'];
				}

				$this->add_render_attribute(
					'list_icon' . $count,
					[
						'class' => $icon,
					]
				);

				$this->add_render_attribute(
					'wrap_css' . $count,
					[
						'class' => array( 'd-flex', 'flex-column', 'flex-md-row', 'position-relative', 'align-items-center', $settings['text_wrap_css'] ),
					]
				);

				$this->add_render_attribute(
					'text_css' . $count,
					[
						'class' => array( 'tabtext', 'font-weight-semi-bold', $settings['text_css'] ),
					]
				);
				?>
				<li <?php $this->print_render_attribute_string( 'list_item' . $count ); ?>>
					<a <?php $this->print_render_attribute_string( 'list_link' . $count ); ?>>
						<div <?php $this->print_render_attribute_string( 'wrap_css' . $count ); ?>>
							<?php
							if ( ! empty( $item['icon']['value'] ) && 'yes' === $settings['list_item_icon'] ) {
								?>
								<figure class="ie-height-40 d-md-block mr-md-3">
									<i <?php $this->print_render_attribute_string( 'list_icon' . $count ); ?>></i>
								</figure>
								<?php
							}
							?>
							<span <?php $this->print_render_attribute_string( 'text_css' . $count ); ?>><?php echo esc_html( $item['list'] ); ?></span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
