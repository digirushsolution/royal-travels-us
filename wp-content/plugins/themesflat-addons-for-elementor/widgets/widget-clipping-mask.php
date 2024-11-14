<?php
class TFClipping_Mask_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'tfclippingmask';
    }
    
    public function get_title() {
        return esc_html__( 'TF Clipping Mask', 'tf-addon-for-elementer' );
    }

    public function get_icon() {
        return 'eicon-image-box';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

	protected function register_controls() {
        // Start Image        
			$this->start_controls_section( 
				'section_image',
	            [
	                'label' => esc_html__('Image', 'tf-addon-for-elementer'),
	            ]
	        );

		    $this->add_control(
			    'image_media',
			    [
				    'label' => esc_html__( 'Choose Image', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::MEDIA,
				    'dynamic' => ['active' => true],
				    'default' => [
					    'url' => \Elementor\Utils::get_placeholder_image_src(),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image' => 'background-image: url( {{url}} );',
	                ],
			    ]
		    );

		    $this->add_responsive_control(
			    'image_position',
			    [
				    'label' => esc_html__( 'Image Position', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'initial',
				    'options' => [
					    'initial'       => esc_html__( 'Default', 'tf-addon-for-elementer' ),
					    'center center' => esc_html__( 'Center Center', 'tf-addon-for-elementer' ),
					    'center left'   => esc_html__( 'Center Left', 'tf-addon-for-elementer' ),
					    'center right'  => esc_html__( 'Center Right', 'tf-addon-for-elementer' ),
					    'top center'    => esc_html__( 'Top Center', 'tf-addon-for-elementer' ),
					    'top left'      => esc_html__( 'Top Left', 'tf-addon-for-elementer' ),
					    'top right'     => esc_html__( 'Top Right', 'tf-addon-for-elementer' ),
					    'bottom center' => esc_html__( 'Bottom Center', 'tf-addon-for-elementer' ),
					    'bottom left'   => esc_html__( 'Bottom Left', 'tf-addon-for-elementer' ),
					    'bottom right'  => esc_html__( 'Bottom Right', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image' => 'background-position: {{value}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'image_attachment',
			    [
				    'label' => esc_html__( 'Image Attachment', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'initial',
				    'options' => [
	                    'initial'   => esc_html__( 'Default', 'tf-addon-for-elementer' ),
					    'scroll'    => esc_html__( 'Scroll', 'tf-addon-for-elementer' ),
					    'fixed'     => esc_html__( 'Fixed', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image' => 'background-attachment: {{value}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'image_repeat',
			    [
				    'label' => esc_html__( 'Image Repeat', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'initial',
				    'options' => [
					    'initial'    => esc_html__( 'Default', 'tf-addon-for-elementer' ),
					    'no-repeat'    => esc_html__( 'No-repeat', 'tf-addon-for-elementer' ),
					    'repeat'    => esc_html__( 'Repeat', 'tf-addon-for-elementer' ),
					    'repeat-x'    => esc_html__( 'Repeat-x', 'tf-addon-for-elementer' ),
					    'repeat-y'    => esc_html__( 'Repeat-y', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image' => 'background-repeat: {{value}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'image_size',
			    [
				    'label' => esc_html__( 'Image Size', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'initial',
				    'options' => [
					    'initial'    => esc_html__( 'Default', 'tf-addon-for-elementer' ),
					    'cover'    => esc_html__( 'Cover', 'tf-addon-for-elementer' ),
					    'contain'    => esc_html__( 'Contain', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image' => 'background-size: {{value}};',
				    ],
			    ]
		    );

		    $this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Default title', 'tf-addon-for-elementer' ),
					'separator' => 'before',
				]
			); 

			$this->add_control(
				'description',
				[
					'label' => esc_html__( 'Description', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
				]
			);

			$this->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'tf-addon-for-elementer' ),
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => true,
						'nofollow' => true,
					],
				]
			);
					
	        $this->end_controls_section();
        // /.End Image

	    // Start Clipping Mask        
			$this->start_controls_section( 
				'section_clipping_mask',
	            [
	                'label' => esc_html__('Clipping Mask', 'tf-addon-for-elementer'),
	            ]
	        );

		    $this->add_control(
			    'mask',
			    [
				    'label' => esc_html__( 'Mask', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'oval-5',
				    'options' => [
					    'mask1'         => esc_html__( 'Mask Style1', 'tf-addon-for-elementer' ),
					    'mask2'         => esc_html__( 'Mask Style2', 'tf-addon-for-elementer' ),
					    'mask3'         => esc_html__( 'Mask Style3', 'tf-addon-for-elementer' ),
					    'oval-1'         => esc_html__( 'Oval Style1', 'tf-addon-for-elementer' ),
					    'oval-2'         => esc_html__( 'Oval Style2', 'tf-addon-for-elementer' ),
					    'oval-3'         => esc_html__( 'Oval Style3', 'tf-addon-for-elementer' ),
					    'oval-4'         => esc_html__( 'Oval Style4', 'tf-addon-for-elementer' ),
					    'oval-5'         => esc_html__( 'Oval Style5', 'tf-addon-for-elementer' ),
					    'oval-6'         => esc_html__( 'Oval Style6', 'tf-addon-for-elementer' ),
					    'oval-7'         => esc_html__( 'Oval Style7', 'tf-addon-for-elementer' ),
					    'oval-8'         => esc_html__( 'Oval Style8', 'tf-addon-for-elementer' ),
					    'custom-year'         => esc_html__( 'Custom Year', 'tf-addon-for-elementer' ),
					    'custom'            => esc_html__( 'Custom', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'mask-image: url( '.URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE.'assets/img/{{value}}.svg ); -webkit-mask-image: url( '.URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE.'assets/img/{{value}}.svg );',
				    ]
			    ]
		    );

		    $this->add_control(
			    'mask_custom',
			    [
				    'label' => esc_html__( 'Choose Mask', 'tf-addon-for-elementer' ),
				    'description' => esc_html__( 'SVG Image Or PNG Image', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::MEDIA,
				    'dynamic' => ['active' => true],
				    'default' => [
					    'url' => \Elementor\Utils::get_placeholder_image_src(),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'mask-image: url( {{url}} ); -webkit-mask-image: url( {{url}} );',
				    ],
				    'condition' => [ 'mask' => 'custom' ],
			    ]
		    );

		    $this->add_responsive_control(
			    'mask_position',
			    [
				    'label' => esc_html__( 'Mask Position', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'unset',
				    'options' => [
					    'unset'         => esc_html__( 'Default', 'tf-addon-for-elementer' ),
					    'center center' => esc_html__( 'Center Center', 'tf-addon-for-elementer' ),
					    'center left'   => esc_html__( 'Center Left', 'tf-addon-for-elementer' ),
					    'center right'  => esc_html__( 'Center Right', 'tf-addon-for-elementer' ),
					    'top center'    => esc_html__( 'Top Center', 'tf-addon-for-elementer' ),
					    'top left'      => esc_html__( 'Top Left', 'tf-addon-for-elementer' ),
					    'top right'     => esc_html__( 'Top Right', 'tf-addon-for-elementer' ),
					    'bottom center' => esc_html__( 'Bottom Center', 'tf-addon-for-elementer' ),
					    'bottom left'   => esc_html__( 'Bottom Left', 'tf-addon-for-elementer' ),
					    'bottom right'  => esc_html__( 'Bottom Right', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'mask-position: {{value}}; -webkit-mask-position: {{value}};',
				    ]
			    ]
		    );

		    $this->add_responsive_control(
			    'mask_repeat',
			    [
				    'label' => esc_html__( 'Mask Repeat', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'no-repeat',
				    'options' => [
					    'no-repeat' => esc_html__( 'No-repeat', 'tf-addon-for-elementer' ),
					    'repeat'    => esc_html__( 'Repeat', 'tf-addon-for-elementer' ),
					    'repeat-x'  => esc_html__( 'Repeat-x', 'tf-addon-for-elementer' ),
					    'repeat-y'  => esc_html__( 'Repeat-y', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'mask-repeat: {{value}}; -webkit-mask-repeat: {{value}};',
				    ]
			    ]
		    );

		    $this->add_responsive_control(
			    'mask_size',
			    [
				    'label' => esc_html__( 'Mask Size', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::SELECT,
				    'default' => 'unset',
				    'options' => [
					    'unset'     => esc_html__( 'Default', 'tf-addon-for-elementer' ),
					    'cover'     => esc_html__( 'Cover', 'tf-addon-for-elementer' ),
					    'contain'   => esc_html__( 'Contain', 'tf-addon-for-elementer' ),
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'mask-size: {{value}}; -webkit-mask-size: {{value}};',
				    ]
			    ]
		    );

		    $this->add_control(
			    'mask_rotate',
			    [
				    'label' => esc_html__( 'Rotate', 'tf-addon-for-elementer' ),
				    'type'  => \Elementor\Controls_Manager::SLIDER,
				    'size_units' => [ 'deg' ],
				    'default' => [
					    'unit' => 'deg',
					    'size' => 0,
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'transform: rotate( {{SIZE}}{{UNIT}} );',
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask .image' => 'transform: rotate( calc( -1 * {{SIZE}}{{UNIT}} ) );',
				    ],
			    ]
		    );

	    	$this->end_controls_section();
        // /.End Clipping Mask
        
        // Start General Style        
			$this->start_controls_section( 
				'section_style_general',
	            [
	                'label' => esc_html__('General', 'tf-addon-for-elementer'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .tf-clipping-mask' => 'text-align: {{VALUE}};',
					],
				]
			);

	        $this->add_responsive_control(
			    'margin',
			    [
				    'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask' => 'margin: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'padding',
			    [
				    'label' => esc_html__( 'Padding', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'default' => [
						'top' => '20',
						'right' => '20',
						'bottom' => '20',
						'left' => '20',
						'unit' => 'px',
						'isLinked' => 'true',
					],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask' => 'padding: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
			    ]
		    );

		    $this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'label' => esc_html__( 'Box Shadow', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-clipping-mask',
				]
			);   

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-clipping-mask',
				]
			);

			$this->add_responsive_control(
			    'border_radius',
			    [
				    'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask' => 'border-radius: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
				    'toggle' => true,
				    'separator' => 'after'
			    ]
		    );	           

	        $this->end_controls_section();
        // /.End General Style

	    // Start Image Style
			$this->start_controls_section( 
				'section_style_image',
	            [
	                'label' => esc_html__('Image', 'tf-addon-for-elementer'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

		    $this->add_responsive_control(
			    'image_width',
			    [
				    'label' => esc_html__( 'Width', 'tf-addon-for-elementer' ),
				    'type'  => \Elementor\Controls_Manager::SLIDER,
				    'size_units' => [ 'px', '%', 'vw' ],
				    'default' => [
					    'unit' => '%',
					    'size' => 100,
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'width: {{SIZE}}{{UNIT}};',
				    ],
			    ]
		    );

		    $this->add_responsive_control(
			    'image_height',
			    [
				    'label' => esc_html__( 'Height', 'tf-addon-for-elementer' ),
				    'type'  => \Elementor\Controls_Manager::SLIDER,
				    'size_units' => [ 'px', '%', 'vh' ],
				    'range' => [
					    'px' => [
						    'min' => 0,
						    'max' => 1000,
						    'step' => 1,
					    ]
				    ],
				    'default' => [
					    'unit' => 'px',
					    'size' => 320,
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .image-clipping-mask' => 'height: {{SIZE}}{{UNIT}};',
				    ],
				    'separator' => 'after'
			    ]
		    );  

		    $this->add_control(
				'overlay_heading',
				[
					'label' => esc_html__( 'Overlay', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			); 

			$this->add_control(
				'overlay_background_color',
				[
					'label' => esc_html__( 'Background color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .tf-clipping-mask .overlay-image' => 'background-color: {{VALUE}}',
					],
				]
			);

	        $this->end_controls_section();
        // /.End Image Style

	    // Start Title & Description Style
	        $this->start_controls_section( 
				'section_style_title_description',
	            [
	                'label' => esc_html__('Title & Description', 'tf-addon-for-elementer'),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'title_heading',
				[
					'label' => esc_html__( 'Title', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

	        $this->add_control(
				'title_tag',
				[
					'label' => esc_html__( 'Title Tag', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'h3',
					'options' => [
						'h1'  => esc_html__( 'H1', 'tf-addon-for-elementer' ),
						'h2'  => esc_html__( 'H2', 'tf-addon-for-elementer' ),
						'h3'  => esc_html__( 'H3', 'tf-addon-for-elementer' ),
						'h4'  => esc_html__( 'H4', 'tf-addon-for-elementer' ),
						'h5'  => esc_html__( 'H5', 'tf-addon-for-elementer' ),
						'h6'  => esc_html__( 'H6', 'tf-addon-for-elementer' ),
					],
				]
			);  

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => esc_html__( 'Typography', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-clipping-mask .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tf-clipping-mask .title, {{WRAPPER}} .tf-clipping-mask .title a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#3858e9',
					'selectors' => [
						'{{WRAPPER}} .tf-clipping-mask .title a:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'link[url]!' => '', 
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'title_shadow',
					'label' => esc_html__( 'Text Shadow', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-clipping-mask .title',
				]
			);

			$this->add_responsive_control(
			    'title_margin',
			    [
				    'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .title' => 'margin: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
			    ]
		    );

		    $this->add_control(
				'description_heading',
				[
					'label' => esc_html__( 'Description', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			); 

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'label' => esc_html__( 'Typography', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-clipping-mask .description',
				]
			);

			$this->add_control(
				'description_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tf-clipping-mask .description' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'description_shadow',
					'label' => esc_html__( 'Text Shadow', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-clipping-mask .description',
				]
			);

			$this->add_responsive_control(
			    'description_margin',
			    [
				    'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
				    'type' => \Elementor\Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', '%', 'em' ],
				    'selectors' => [
					    '{{WRAPPER}} .tf-clipping-mask .description' => 'margin: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
				    ],
			    ]
		    );

	        $this->end_controls_section();
	    // /.End Title & Description Style
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$title = $html_description = '';
		
		$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';

		if ($settings['title'] != '') {
			$title = '<'.$settings['title_tag'].' class="title">'.$settings['title'].'</'.$settings['title_tag'].'>';
			if ( $settings['link']['url'] != '' ) {
				$title = '<'.$settings['title_tag'].' class="title"><a href="' . $settings['link']['url'] . '"' . $target . $nofollow . '>'.$settings['title'].'</a></'.$settings['title_tag'].'>';
			}
		}
		

		if ($settings['description'] != '') {
			$html_description = '<div class="description">'.$settings['description'].'</div>';
		}

		echo sprintf ( 
			'<div class="tf-clipping-mask"> 
                <div class="image-clipping-mask">                	
                	<div class="image"></div>
                	<div class="overlay-image"></div>
                </div>
                <div class="content">
	                %1$s
	                %2$s
				</div>
            </div>',
            $title,
            $html_description
        );
			
	}
}