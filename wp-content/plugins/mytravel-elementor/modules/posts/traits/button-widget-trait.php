<?php
namespace MyTravelElementor\Modules\Posts\Traits;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * The button widget Trait.
 */
trait Button_Widget_Trait {
	/**
	 * Get button sizes.
	 *
	 * Retrieve an array of button sizes for the button widget.
	 *
	 * @return array An array containing button sizes.
	 */
	public static function get_button_sizes() {
		return [
			'xs' => esc_html__( 'Extra Small', 'mytravel-elementor' ),
			'sm' => esc_html__( 'Small', 'mytravel-elementor' ),
			'md' => esc_html__( 'Medium', 'mytravel-elementor' ),
			'lg' => esc_html__( 'Large', 'mytravel-elementor' ),
			'xl' => esc_html__( 'Extra Large', 'mytravel-elementor' ),
		];
	}

	/**
	 * Register button content controls.
	 *
	 * @param array $args Arguments.
	 */
	protected function register_button_content_controls( $args = [] ) {
		$default_args = [
			'section_condition'      => [],
			'button_text'            => esc_html__( 'Click here', 'mytravel-elementor' ),
			'control_label_name'     => esc_html__( 'Text', 'mytravel-elementor' ),
			'prefix_class'           => 'elementor%s-align-',
			'alignment_default'      => '',
			'exclude_inline_options' => [],
			'button_css'             => 'btn-outline-primary',
		];

		$args = wp_parse_args( $args, $default_args );

		$this->add_control(
			'button_type',
			[
				'label'        => esc_html__( 'Type', 'mytravel-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => '',
				'options'      => [
					'primary' => esc_html__( 'Default', 'mytravel-elementor' ),
					'info'    => esc_html__( 'Info', 'mytravel-elementor' ),
					'success' => esc_html__( 'Success', 'mytravel-elementor' ),
					'warning' => esc_html__( 'Warning', 'mytravel-elementor' ),
					'danger'  => esc_html__( 'Danger', 'mytravel-elementor' ),
				],
				'prefix_class' => 'btn-',
				'condition'    => $args['section_condition'],
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => $args['control_label_name'],
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => $args['button_text'],
				'placeholder' => $args['button_text'],
				'condition'   => $args['section_condition'],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [
					'url' => '#',
				],
				'condition'   => $args['section_condition'],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'        => esc_html__( 'Alignment', 'mytravel-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'start'   => [
						'title' => esc_html__( 'Left', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'end'     => [
						'title' => esc_html__( 'Right', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'mytravel-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => $args['prefix_class'],
				'default'      => $args['alignment_default'],
				'condition'    => $args['section_condition'],
			]
		);

		$this->add_control(
			'size',
			[
				'label'          => esc_html__( 'Size', 'mytravel-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'sm',
				'options'        => self::get_button_sizes(),
				'style_transfer' => true,
				'condition'      => $args['section_condition'],
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'                  => esc_html__( 'Icon', 'mytravel-elementor' ),
				'type'                   => Controls_Manager::ICONS,
				'fa4compatibility'       => 'icon',
				'skin'                   => 'inline',
				'label_block'            => false,
				'condition'              => $args['section_condition'],
				'exclude_inline_options' => $args['exclude_inline_options'],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'     => esc_html__( 'Icon Position', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => esc_html__( 'Before', 'mytravel-elementor' ),
					'right' => esc_html__( 'After', 'mytravel-elementor' ),
				],
				'condition' => array_merge( $args['section_condition'], [ 'selected_icon[value]!' => '' ] ),
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn__load-more .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .btn__load-more .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => $args['section_condition'],
			]
		);

		$this->add_control(
			'view',
			[
				'label'     => esc_html__( 'View', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => 'traditional',
				'condition' => $args['section_condition'],
			]
		);

		$this->add_control(
			'button_wrapper_css',
			[
				'label'       => esc_html__( 'Button Wrapper CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'Additional CSS to be applied to .btn-wrapper element.', 'mytravel-elementor' ),
				'condition'   => $args['section_condition'],
			]
		);

		$this->add_control(
			'button_css',
			[
				'label'       => esc_html__( 'Button CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'btn-outline-primary',
				'description' => esc_html__( 'Additional CSS to be applied to .btn element.', 'mytravel-elementor' ),
				'condition'   => $args['section_condition'],
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label'       => esc_html__( 'Button ID', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => '',
				'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'mytravel-elementor' ),
				'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows `A-z 0-9` & underscore chars without spaces.', 'mytravel-elementor' ),
				'separator'   => 'before',
				'condition'   => $args['section_condition'],
			]
		);
	}

	/**
	 * Register Button Style controls.
	 *
	 * @param array $args Additional arguments to the control.
	 */
	protected function register_button_style_controls( $args = [] ) {
		$default_args = [
			'section_condition' => [],
		];

		$args = wp_parse_args( $args, $default_args );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'typography',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .btn__load-more',
				'condition' => $args['section_condition'],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'      => 'text_shadow',
				'selector'  => '{{WRAPPER}} .btn__load-more',
				'condition' => $args['section_condition'],
			]
		);

		$this->start_controls_tabs(
			'tabs_button_style',
			[
				'condition' => $args['section_condition'],
			]
		);

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => esc_html__( 'Normal', 'mytravel-elementor' ),
				'condition' => $args['section_condition'],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .btn__load-more' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
				'condition' => $args['section_condition'],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'background',
				'label'          => esc_html__( 'Background', 'mytravel-elementor' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .btn__load-more',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color'      => [
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
					],
				],
				'condition'      => $args['section_condition'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => esc_html__( 'Hover', 'mytravel-elementor' ),
				'condition' => $args['section_condition'],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn__load-more:hover, {{WRAPPER}} .btn__load-more:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .btn__load-more:hover svg, {{WRAPPER}} .btn__load-more:focus svg' => 'fill: {{VALUE}};',
				],
				'condition' => $args['section_condition'],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'button_background_hover',
				'label'          => esc_html__( 'Background', 'mytravel-elementor' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .btn__load-more:hover, {{WRAPPER}} .btn__load-more:focus',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition'      => $args['section_condition'],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .btn__load-more:hover, {{WRAPPER}} .btn__load-more:focus' => 'border-color: {{VALUE}};',
				],
				'condition' => $args['section_condition'],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label'     => esc_html__( 'Hover Animation', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => $args['section_condition'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'border',
				'selector'  => '{{WRAPPER}} .btn__load-more',
				'separator' => 'before',
				'condition' => $args['section_condition'],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'mytravel-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .btn__load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => $args['section_condition'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .btn__load-more',
				'condition' => $args['section_condition'],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'mytravel-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .btn__load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => $args['section_condition'],
			]
		);
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @param \Elementor\Widget_Base|null $instance The widget instance.
	 */
	protected function render_button( Widget_Base $instance = null ) {
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$settings = $instance->get_settings();
		$instance->add_render_attribute( 'wrapper', 'class', [ 'btn-wrapper', 'elementor-button-wrapper' ] );

		if ( ! empty( $settings['button_wrapper_css'] ) ) {
			$instance->add_render_attribute( 'wrapper', 'class', $settings['button_wrapper_css'] );
		}

		if ( ! empty( $settings['link']['url'] ) ) {
			$instance->add_link_attributes( 'button', $settings['link'] );
			$instance->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

		$instance->add_render_attribute( 'button', 'class', [ 'btn', 'btn__load-more' ] );
		$instance->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css'] ) ) {
			$instance->add_render_attribute( 'button', 'class', $settings['button_css'] );
		}

		if ( ! empty( $settings['button_css_id'] ) ) {
			$instance->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$instance->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$instance->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
		?>
		<div <?php $instance->print_render_attribute_string( 'wrapper' ); ?>>
			<a <?php $instance->print_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text( $instance ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @param \Elementor\Widget_Base $instance The widget instance.
	 */
	protected function render_text( Widget_Base $instance ) {
		$settings = $instance->get_settings();

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		if ( ! $is_new && empty( $settings['icon_align'] ) ) {
			// @todo: remove when deprecated
			// added as bc in 2.6
			// old default
			$settings['icon_align'] = $instance->get_settings( 'icon_align' );
		}

		$instance->add_render_attribute(
			[
				'content-wrapper' => [
					'class' => 'elementor-button-content-wrapper',
				],
				'icon-align'      => [
					'class' => [
						'elementor-button-icon',
						'elementor-align-icon-' . $settings['icon_align'],
					],
				],
				'text'            => [
					'class' => 'elementor-button-text',
				],
			]
		);

		// TODO: replace the protected with public
		// $instance->add_inline_editing_attributes( 'text', 'none' ); .
		?>
		<span <?php $instance->print_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
				<span <?php $instance->print_render_attribute_string( 'icon-align' ); ?>>
				<?php
				if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				else :
					?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</span>
			<?php endif; ?>
			<span <?php $instance->print_render_attribute_string( 'text' ); ?>><?php Utils::print_unescaped_internal_string( $settings['text'] ); // Todo: Make $instance->print_unescaped_setting public. ?></span>
		</span>
		<?php
	}

	/**
	 * On import widget.
	 *
	 * @param array $element The element being imported.
	 */
	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
	}
}
