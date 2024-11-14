<?php

namespace MyTravelElementor\Modules\Button\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Button Skin Mytravel class
 */
class Skin_Button_Mytravel extends Skin_Base {

	/**
	 * Get the ID of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'button-mytravel';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mytravel', 'mytravel-elementor' );
	}

	/**
	 * Register controls for the skin.
	 */
	protected function _register_controls_actions() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		add_action( 'elementor/element/button/section_button/before_section_end', [ $this, 'register_section_button_controls' ], 10 );
		add_action( 'elementor/element/button/section_style/after_section_end', [ $this, 'register_section_style_controls' ], 10 );
		add_action( 'elementor/element/button/section_style/after_section_start', [ $this, 'update_button_style_controls' ], 10 );

		add_filter( 'mytravel-elementor/widget/button/print_template', [ $this, 'print_template' ], 10 );
	}

	/**
	 * Register button controls
	 *
	 * @param Elementor\Widget_Base $widget The widget object.
	 */
	public function register_section_button_controls( Elementor\Widget_Base $widget ) {
		$this->parent = $widget;

		$this->parent->update_control( 'button_type', [ 'condition' => [ '_skin!' => 'button-mytravel' ] ] );

		$this->parent->update_control( 'size', [ 'condition' => [ '_skin!' => 'button-mytravel' ] ] );

		$this->add_control(
			'button_type',
			[
				'label'   => esc_html__( 'Type', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => [
					'primary'   => esc_html__( 'Primary', 'mytravel-elementor' ),
					'secondary' => esc_html__( 'Secondary', 'mytravel-elementor' ),
					'success'   => esc_html__( 'Success', 'mytravel-elementor' ),
					'danger'    => esc_html__( 'Danger', 'mytravel-elementor' ),
					'warning'   => esc_html__( 'Warning', 'mytravel-elementor' ),
					'info'      => esc_html__( 'Info', 'mytravel-elementor' ),
					'indigo'    => esc_html__( 'Indigo', 'mytravel-elementor' ),
					'navy'      => esc_html__( 'Navy', 'mytravel-elementor' ),
					'light'     => esc_html__( 'Light', 'mytravel-elementor' ),
					'dark'      => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'      => esc_html__( 'Link', 'mytravel-elementor' ),
					'white'     => esc_html__( 'White', 'mytravel-elementor' ),
				],
			],
			[
				'position' => [
					'of' => '_skin',
				],
			]
		);

		$this->add_control(
			'button_variant',
			[
				'label'   => esc_html__( 'Variant', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''            => esc_html__( 'Default', 'mytravel-elementor' ),
					'outline'     => esc_html__( 'Outline', 'mytravel-elementor' ),
					'translucent' => esc_html__( 'Translucent', 'mytravel-elementor' ),
					'soft'        => esc_html__( 'Soft', 'mytravel-elementor' ),
				],
			],
			[
				'position' => [
					'of' => 'button_type',
				],
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'   => esc_html__( 'Style', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__( 'Default', 'mytravel-elementor' ),
					'pill'   => esc_html__( 'Pill', 'mytravel-elementor' ),
					'square' => esc_html__( 'Square', 'mytravel-elementor' ),
				],
			],
			[
				'position' => [
					'at' => 'before',
					'of' => 'text',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => esc_html__( 'Size', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''      => esc_html__( 'Default', 'mytravel-elementor' ),
					'xs'    => esc_html__( 'Extra Small', 'mytravel-elementor' ),
					'sm'    => esc_html__( 'Small', 'mytravel-elementor' ),
					'lg'    => esc_html__( 'Large', 'mytravel-elementor' ),
					'wide'  => esc_html__( 'Wide', 'mytravel-elementor' ),
					'block' => esc_html__( 'Block', 'mytravel-elementor' ),
				],
			],
			[
				'position' => [
					'at' => 'before',
					'of' => 'text',
				],
			]
		);

		$this->add_control(
			'icon_css',
			[
				'label'       => esc_html__( 'CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <i> tag', 'mytravel-elementor' ),
			],
			[
				'position' => [
					'at' => 'after',
					'of' => 'icon_indent',
				],
			]
		);

		$this->parent->update_control(
			'icon_indent',
			[
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .btn .btn__icon--right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .btn .btn__icon--left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
	}

	/**
	 * Update mytravel button content controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function update_button_style_controls( $widget ) {

		$widget->update_control(
			'section_style',
			[
				'condition' => [
					'_skin' => '',
				],
			]
		);
	}

	/**
	 * Register button style tab controls
	 *
	 * @param Elementor\Widget_Base $widget The widget object.
	 */
	public function register_section_style_controls( Elementor\Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .mytravel-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .mytravel-button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_txt_css',
			[
				'label'       => esc_html__( 'Text CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to .elementor-button-text tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'icon_wrapper_css',
			[
				'label'       => esc_html__( 'Icon Wrapper Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to .elementor-button-icon', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mytravel-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mytravel-button' => 'background-color: {{VALUE}};',
				],
				'global'    => [
					'default' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mytravel-button-text:hover, {{WRAPPER}} .mytravel-button-text:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mytravel-button-text:hover svg path, {{WRAPPER}} .mytravel-button-text:focus svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'mytravel-elementor' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'btn_css',
			[
				'label'       => esc_html__( 'CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to .btn tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'btn_content_wrapper_css',
			[
				'label'       => esc_html__( 'CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to .elementor-button-content-wrapper tag', 'mytravel-elementor' ),
			]
		);
		$this->end_controls_section();

	}

	/**
	 * Print the template in the editor
	 *
	 * @param string $content Widget content to override.
	 * @return string
	 */
	public function print_template( $content ) {
		ob_start();
		$this->content_template( $content );
		return ob_get_clean();
	}

	/**
	 * Render the skin in the frontend.
	 */
	public function render() {
		$widget = $this->parent;

		$settings = $widget->get_settings_for_display();

		$widget->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		$button_type    = $settings[ $this->get_control_id( 'button_type' ) ];
		$button_variant = $settings[ $this->get_control_id( 'button_variant' ) ];
		$button_style   = $settings[ $this->get_control_id( 'button_style' ) ];
		$button_size    = $settings[ $this->get_control_id( 'button_size' ) ];
		$btn_css        = $settings[ $this->get_control_id( 'btn_css' ) ];
		$animation      = $settings[ $this->get_control_id( 'hover_animation' ) ];

		$widget->add_link_attributes( 'button', $settings['link'] );
		$widget->add_render_attribute( 'button', 'class', 'mytravel-button elementor-button-link' );

		$widget->add_render_attribute( 'button', 'class', 'btn' );
		$widget->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$widget->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( 'outline' === $button_variant ) {
			$btn_class = 'btn-outline-' . $button_type;
		} elseif ( 'translucent' === $button_variant ) {
			$btn_class = 'btn-text-' . $button_type;
		} elseif ( 'soft' === $button_variant ) {
			$btn_class = 'btn-soft-' . $button_type;
		} else {
			$btn_class = 'btn-' . $button_type;
		}
		$widget->add_render_attribute( 'button', 'class', $btn_class );

		if ( ! empty( $button_style ) ) {
			$widget->add_render_attribute( 'button', 'class', 'btn-' . $button_style );
		}

		if ( ! empty( $button_size ) ) {
			$widget->add_render_attribute( 'button', 'class', 'btn-' . $button_size );
		}

		if ( ! empty( $animation ) ) {
			$widget->add_render_attribute( 'button', 'class', 'elementor-animation-' . $animation );
		}

		if ( ! empty( $btn_css ) ) {
			$widget->add_render_attribute( 'button', 'class', $btn_css );
		}

		if ( ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) && empty( $settings['text'] ) ) {
			$widget->add_render_attribute( 'button', 'class', 'btn-icon' );
		}

		?>
		<div <?php $widget->print_render_attribute_string( 'wrapper' ); ?>>
			<a <?php $widget->print_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render the button text
	 */
	/**
	 * Render the button text
	 */
	public function render_text() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();

		$widget->add_render_attribute(
			[
				'content-wrapper' => [
					'class' => 'elementor-button-content-wrapper',
				],
				'icon-align'      => [
					'class' => [
						'mytravel-elementor-button-icon',
						'btn__icon',
						'btn__icon--' . $settings['icon_align'],
					],
				],
				'text'            => [
					'class' => 'mytravel-button-text',
				],
			]
		);

		if ( ! empty( $settings[ $this->get_control_id( 'btn_content_wrapper_css' ) ] ) ) {
			$widget->add_render_attribute( 'content-wrapper', 'class', $settings[ $this->get_control_id( 'btn_content_wrapper_css' ) ] );
		}

		if ( 'right' === $settings['icon_align'] ) {
			$widget->add_render_attribute( 'icon-align', 'class', 'order-2' );
			$widget->add_render_attribute( 'text', 'class', 'order-1' );
		}

		if ( ! empty( $settings[ $this->get_control_id( 'btn_txt_css' ) ] ) ) {
			$widget->add_render_attribute( 'text', 'class', $settings[ $this->get_control_id( 'btn_txt_css' ) ] );
		}

		if ( ! empty( $settings[ $this->get_control_id( 'icon_wrapper_css' ) ] ) ) {
			$widget->add_render_attribute( 'icon-align', 'class', $settings[ $this->get_control_id( 'icon_wrapper_css' ) ] );
		}
		?>
		<span <?php $widget->print_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
			<span <?php $widget->print_render_attribute_string( 'icon-align' ); ?>>
				<?php
					$icon_atts = [ 'aria-hidden' => 'true' ];
				if ( ! empty( $settings[ $this->get_control_id( 'icon_css' ) ] ) ) {
					$icon_atts['class'] = $settings[ $this->get_control_id( 'icon_css' ) ];
				}
					Icons_Manager::render_icon( $settings['selected_icon'], $icon_atts );
				?>
			</span>
			<?php endif; ?>
			<?php if ( ! empty( $settings['text'] ) ) : ?>
			<span <?php $widget->print_render_attribute_string( 'text' ); ?>><?php echo wp_kses_post( $settings['text'] ); ?></span>
			<?php endif; ?>
		</span>
		<?php
	}

	/**
	 * Render the button in the editor.
	 *
	 * @param string $content Button content in the editor.
	 */
	public function content_template( $content ) {
		?>
		<# if ( 'button-mytravel' === settings._skin ) { #>
			<#
			view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );
			view.addInlineEditingAttributes( 'text', 'none' );
			var iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );

			var button_type     = settings.button_mytravel_button_type;
			var button_variant  = settings.button_mytravel_button_variant;
			var button_style    = settings.button_mytravel_button_style;
			var button_size     = settings.button_mytravel_button_size;
			<!-- var enable_lift     = settings.button_mytravel_enable_lift; -->
			<!-- var enable_shadow   = settings.button_mytravel_enable_shadow; -->
			var enable_fancybox = settings.button_mytravel_enable_fancybox;
			var btn_css         = settings.button_mytravel_btn_css;
			var btn_class       = '';
			var animation       = settings.button_mytravel_hover_animation;

			view.addRenderAttribute( 'button', 'class', 'btn' );

			view.addRenderAttribute( 'button', 'class', [
				'elementor-animation-' + animation,
			] );

			view.addRenderAttribute( 'button', 'id', settings.button_css_id );
			view.addRenderAttribute( 'button', 'role', 'button' );
			view.addRenderAttribute( 'button', 'href', settings.link.url );

			if ( 'outline' === button_variant ) {
				btn_class = 'btn-outline-' + button_type;
			} else if ( 'translucent' === button_variant ) {
				btn_class = 'btn-text-' + button_type;
			} else if ( 'soft' === button_variant ) {
				btn_class = 'btn-soft-' + button_type;
			} else {
				btn_class = 'btn-' + button_type;
			}

			view.addRenderAttribute( 'button', 'class', btn_class );

			if ( '' !== button_style ) {
				view.addRenderAttribute( 'button', 'class', 'btn-' + button_style );
			}

			if ( '' !== button_size ) {
				view.addRenderAttribute( 'button', 'class', 'btn-' + button_size );
			}

			if ( 'yes' == enable_fancybox ) {
				view.addRenderAttribute( 'button', 'data-fancybox', 'true' );
			}

			view.addRenderAttribute( 'icon', 'class', [
				'elementor-button-icon', 'btn__icon', 'btn__icon--' + settings.icon_align
			] );

			if ( 'right' === settings.icon_align ) {
				view.addRenderAttribute( 'icon', 'class', 'order-2' );
				view.addRenderAttribute( 'text', 'class', 'order-1' );
			}

			if ( '' !== btn_css ) {
				view.addRenderAttribute( 'button', 'class', btn_css );
			}

			if ( '' == settings.text && ( settings.icon || settings.selected_icon ) ) {
				view.addRenderAttribute( 'button', 'class', 'btn-icon' );
			}

			#>
			<div class="elementor-button-wrapper">
				<a {{{ view.getRenderAttributeString( 'button' ) }}}>
					<span class="elementor-button-content-wrapper">
						<# if ( settings.icon || settings.selected_icon ) { #>
						<span {{{ view.getRenderAttributeString( 'icon' ) }}}>
							<# if ( ( migrated || ! settings.icon ) && iconHTML.rendered ) { #>
								{{{ iconHTML.value }}}
							<# } else { #>
								<i class="{{ settings.icon }}" aria-hidden="true"></i>
							<# } #>
						</span>
						<# } #>
						<# if ( '' != settings.text ) { #>
						<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
						<# } #>
					</span>
				</a>
			</div>
		<# } else { #>
			<?php echo $content; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<# } #>
		<?php
	}
}
