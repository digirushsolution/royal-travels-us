<?php
class TFIconBox_Widget_Fr extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tficonbox';
    }
    
    public function get_title() {
        return esc_html__( 'TF Icon Box', 'tf-addon-for-elementer' );
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

	protected function register_controls() {
        // Start Icon Box Setting        
			$this->start_controls_section( 
				'section_tficonbox',
	            [
	                'label' => esc_html__('Icon Box', 'tf-addon-for-elementer'),
	            ]
	        );

	        $this->add_control(
				'icon_style',
				[
					'label' => esc_html__( 'Icon Style', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'none' => [
							'title' => esc_html__( 'None', 'tf-addon-for-elementer' ),
							'icon' => 'fa fa-ban',
						],
						'icon' => [
							'title' => esc_html__( 'Icon', 'tf-addon-for-elementer' ),
							'icon' => 'fa fa-paint-brush',
						],
						'image' => [
							'title' => esc_html__( 'Image', 'tf-addon-for-elementer' ),
							'icon' => 'fa fa-image',
						],
					],
					'default' => 'icon',
					'toggle' => false,
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_',
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'condition' => [
						'icon_style' => 'icon'
					]
				]
			);

			$this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'icon_style' => 'image'
					]
				]
			);			

			$this->add_control(
				'title_text',
				[
					'label' => esc_html__( 'Title', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'BUSINESS CONSULTING', 'tf-addon-for-elementer' ),
				]
			);

			$this->add_control(
				'description_text',
				[
					'label' => 'Description',
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error voluptatem accusantium doloremque lau dantium, totam aperiam.', 'tf-addon-for-elementer' ),
				]
			);		

			$this->add_control(
				'position',
				[
					'label' => esc_html__( 'Icon Position', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'default' => 'top',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-h-align-left',
						],
						'top' => [
							'title' => esc_html__( 'Top', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-v-align-top',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-h-align-right',
						],
					],
				]
			);
			
	        $this->end_controls_section();
        // /.End Icon Box Setting

        // Start Read More        
			$this->start_controls_section( 
				'section_button',
	            [
	                'label' => esc_html__('Read More', 'tf-addon-for-elementer'),
	            ]
	        );
	        $this->add_control(
				'show_button',
				[
					'label' => esc_html__( 'Show Button', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'tf-addon-for-elementer' ),
					'label_off' => esc_html__( 'Hide', 'tf-addon-for-elementer' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control( 
				'button_text',
				[
					'label' => esc_html__( 'Button Text', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Read More', 'tf-addon-for-elementer' ),
					'condition' => [
	                    'show_button'	=> 'yes',
	                ],
				]
			);
	        $this->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'tf-addon-for-elementer' ),
					'condition' => [
						'show_button' => 'yes'
					]
				]
			);
	        $this->end_controls_section();
        // /.End Read More	    

	    // Start Icon Style 
		    $this->start_controls_section( 
		    	'section_style_icon',
	            [
	                'label' => esc_html__( 'Icon', 'tf-addon-for-elementer' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        ); 

	        $this->add_control(
				'icon_showcase',
				[
					'label' => esc_html__( 'Type', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'tf-addon-for-elementer' ),
						'circle' => esc_html__( 'Circle', 'tf-addon-for-elementer' ),
						'square' => esc_html__( 'Square', 'tf-addon-for-elementer' ),
						'circle-outline' => esc_html__( 'Circle Outline', 'tf-addon-for-elementer' ),
						'square-outline' => esc_html__( 'Square Outline', 'tf-addon-for-elementer' ),
					],
					'default' => 'square',
					'condition' => [
						'icon[value]!' => '',
					],
				]
			);

	        $this->add_control( 
	        	'icon_size',
				[
					'label' => esc_html__( 'Size', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 50,
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tficonbox .wrap-icon-inner svg,{{WRAPPER}} .tficonbox .wrap-icon-inner img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control( 
	        	'wrap_icon_size',
				[
					'label' => esc_html__( 'Wrap Icon Size', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 100,
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tficonbox .wrap-icon.square .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square-outline .wrap-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'icon_showcase!' => 'default'
					],
				]
			);

			$this->add_control(
				'rotate',
				[
					'label' => esc_html__( 'Rotate', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);

			$this->add_control(
				'rotate_icon',
				[
					'label' => esc_html__( 'Rotate Icon', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner i, {{WRAPPER}} .tficonbox .wrap-icon-inner svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
						'{{WRAPPER}} .tficonbox .wrap-icon-inner img' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);

			$this->add_control(
				'icon_border_width',
				[
					'label' => esc_html__( 'Border Width', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 20,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 3,
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner' => 'border-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'width: calc(100% + 2 * {{SIZE}}{{UNIT}}); height: calc(100% + 2 * {{SIZE}}{{UNIT}}); border-width: {{SIZE}}{{UNIT}}; top: -{{SIZE}}{{UNIT}}; left: -{{SIZE}}{{UNIT}};',

					],
					'condition' => [
						'icon_showcase' => array('circle-outline','square-outline')
					],
				]
			);

			$this->add_control(
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'icon_showcase!' => 'default',
					],
				]
			);

			$this->add_control(
				'icon_margin',
				[
					'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'icon_tabs' );				

				$this->start_controls_tab( 
					'icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'tf-addon-for-elementer' ),						
					]
				);

				$this->add_control( 
					'icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .tficonbox .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-inner svg' => 'color: {{VALUE}}; fill: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'icon_background',
						'label' => esc_html__( 'Background', 'tf-addon-for-elementer' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tficonbox .wrap-icon.circle .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before',
						'condition' => [
							'icon_showcase' => ['circle','square']
						]
					]
				);

				$this->add_control( 
					'border_icon_color',
					[
						'label' => esc_html__( 'Border Color', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#3858e9',
						'selectors' => [
							'{{WRAPPER}} .tficonbox .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-color: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);

				$this->add_control(
					'border_style_icon',
					[
						'label' => esc_html__( 'Border Type', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'solid' => esc_html__( 'Solid', 'tf-addon-for-elementer' ),
							'double' => esc_html__( 'Double', 'tf-addon-for-elementer' ),
							'dotted' => esc_html__( 'Dotted', 'tf-addon-for-elementer' ),
							'dashed' => esc_html__( 'Dashed', 'tf-addon-for-elementer' ),
							'groove' => esc_html__( 'Groove', 'tf-addon-for-elementer' ),
						],
						'selectors' => [
							'{{WRAPPER}} .tficonbox .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-style: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);	

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'icon_box_shadow',
						'label' => esc_html__( 'Box Shadow', 'tf-addon-for-elementer' ),
						'selector' => '{{WRAPPER}} .tficonbox .wrap-icon .wrap-icon-inner',
					]
				);
		
				
				$this->end_controls_tab();

				$this->start_controls_tab( 
			    	'icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'tf-addon-for-elementer' ),
					]
				);

				$this->add_control( 
					'icon_color_hover',
					[
						'label' => esc_html__( 'Icon Color', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .tficonbox:hover .wrap-icon-inner' => 'color: {{VALUE}}; fill: {{VALUE}}',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'icon_background_hover',
						'label' => esc_html__( 'Background', 'tf-addon-for-elementer' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tficonbox:hover .wrap-icon.circle .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon.square .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon-spin-around:before',
						'condition' => [
							'icon_showcase' => ['circle','square']
						]
					]
				);				

				$this->add_control( 
					'border_icon_color_hover',
					[
						'label' => esc_html__( 'Border Color', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .tficonbox:hover .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon-spin-around:before' => 'border-color: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);	

				$this->add_control(
					'border_style_icon_hover',
					[
						'label' => esc_html__( 'Border Type', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'solid' => esc_html__( 'Solid', 'tf-addon-for-elementer' ),
							'double' => esc_html__( 'Double', 'tf-addon-for-elementer' ),
							'dotted' => esc_html__( 'Dotted', 'tf-addon-for-elementer' ),
							'dashed' => esc_html__( 'Dashed', 'tf-addon-for-elementer' ),
							'groove' => esc_html__( 'Groove', 'tf-addon-for-elementer' ),
						],
						'selectors' => [
							'{{WRAPPER}} .tficonbox:hover .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-style: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'icon_hover_box_shadow',
						'label' => esc_html__( 'Box Shadow', 'tf-addon-for-elementer' ),
						'selector' => '{{WRAPPER}} .tficonbox:hover .wrap-icon .wrap-icon-inner',
					]
				);

				$this->add_control(
					'icon_animation',
					[
						'label' => esc_html__( 'Hover Animation', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => 'default',
						'options' => [
							'default' => esc_html__( 'Default', 'tf-addon-for-elementer' ),
							'right-to-left' => esc_html__( 'Right To Left', 'tf-addon-for-elementer' ),
							'left-to-right' => esc_html__( 'Left To Right', 'tf-addon-for-elementer' ),
							'top-to-bottom' => esc_html__( 'Top To Bottom', 'tf-addon-for-elementer' ),
							'bottom-to-top' => esc_html__( 'Bottom To Top', 'tf-addon-for-elementer' ),
							'spin-around' => esc_html__( 'Spin Around', 'tf-addon-for-elementer' ),
							'wrap-icon-spin-around' => esc_html__( 'Wrap Icon Spin Around', 'tf-addon-for-elementer' ),
							'wrap-icon-pop' => esc_html__( 'Wrap Icon Pop', 'tf-addon-for-elementer' ),
						]
					]
				);		
				
				$this->end_controls_tab();

	        $this->end_controls_tabs();

		    $this->end_controls_section();
	    // /.End Icon Style

	    // Start Content Style 
		    $this->start_controls_section( 
		    	'section_style_content',
	            [
	                'label' => esc_html__( 'Content', 'tf-addon-for-elementer' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );  

	        $this->add_responsive_control(
				'text_align',
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
						'justify' => [
							'title' => esc_html__( 'Justified', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'heading_title',
				[
					'label' => esc_html__( 'Title', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);		

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .tficonbox .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .title, {{WRAPPER}} .tficonbox .content .title a' => 'color: {{VALUE}};',
					],
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

			$this->add_control(
				'title_margin',
				[
					'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'default' => [
						'top' => '0',
						'right' => '0',
						'bottom' => '15',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => 'false',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .title a:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'link[url]!' => ''
					],
				]
			);	

			$this->add_control(
				'heading_description',
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
					'selector' => '{{WRAPPER}} .tficonbox .content .description',
				]
			);

			$this->add_control(
				'description_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .description' => 'color: {{VALUE}};',
					]
				]
			);		    

		    $this->end_controls_section();
    	// /.End Content Style

		// Start Button Style 
		    $this->start_controls_section( 
		    	'section_style_button',
	            [
	                'label' => esc_html__( 'Button', 'tf-addon-for-elementer' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'button_align',
				[
					'label' => esc_html__( 'Alignment', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
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
						'justify' => [
							'title' => esc_html__( 'Justified', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
				]
			);

	        $this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'label' => esc_html__( 'Typography', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tficonbox .tf-button',
				]
			);

			$this->add_responsive_control( 
				'button_padding',
				[
					'label' => esc_html__( 'Padding', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'default' => [
						'top' => '15',
						'right' => '30',
						'bottom' => '15',
						'left' => '30',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .tf-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);		

			$this->add_responsive_control( 
				'button_margin',
				[
					'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'default' => [
						'top' => '20',
						'right' => '0',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .tf-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 
				'button_style_tabs' 
				);

	        	$this->start_controls_tab( 'button_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'tf-addon-for-elementer' ),
					] );	
	        		$this->add_control( 
						'button_color',
						[
							'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button' => 'color: {{VALUE}}',
								'{{WRAPPER}} .tficonbox .tf-button i' => 'color: {{VALUE}}',
								'{{WRAPPER}} .tficonbox .tf-button svg' => 'fill: {{VALUE}}',
							],
						]
					);

					$this->add_control( 
						'button_bg_color',
						[
							'label' => esc_html__( 'Background Color', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#3858e9',
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control( 
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'button_border',
							'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
							'selector' => '{{WRAPPER}} .tficonbox .tf-button',
						]
					);

					$this->add_control( 
						'button_border_radius',
						[
							'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_control( 
						'heading_button_icon',
						[
							'label' => esc_html__( 'Icon', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					); 

					$this->add_control( 
						'icon_button',
						[
							'label' => esc_html__( 'Icon Button', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::ICONS,
							'fa4compatibility' => 'icon_bt',
							'default' => [
								'value' => 'fas fa-angle-double-right',
								'library' => 'fa-solid',
							],				
						]
					);

					$this->add_control( 
						'button_icon_size',
						[
							'label' => esc_html__( 'Icon Size', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 50,
									'step' => 1,
								],
							],
							'default' => [
								'unit' => 'px',
								'size' => 15,
							],
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button i' => 'font-size: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .tficonbox .tf-button svg' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					); 

					$this->add_control( 
						'button_icon_position',
						[
							'label' => esc_html__( 'Icon Position', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'default' => 'bt_icon_after',
							'options' => [
								'bt_icon_before'  => esc_html__( 'Before', 'tf-addon-for-elementer' ),
								'bt_icon_after' => esc_html__( 'After', 'tf-addon-for-elementer' ),
							],
						]
					);

					$this->add_control( 
						'button_icon_spacer',
						[
							'label' => esc_html__( 'Icon Spacer', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 50,
									'step' => 1,
								],
							],
							'default' => [
								'unit' => 'px',
								'size' => 10,
							],
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button.bt_icon_before i' => 'margin-right: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .tficonbox .tf-button.bt_icon_before svg' => 'margin-right: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .tficonbox .tf-button.bt_icon_after i' => 'margin-left: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .tficonbox .tf-button.bt_icon_after svg' => 'margin-left: {{SIZE}}{{UNIT}};',
							],
						]
					);
					
				$this->end_controls_tab();

				$this->start_controls_tab( 'button_style_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'tf-addon-for-elementer' ),
					] );

					$this->add_control( 
						'button_color_hover',
						[
							'label' => esc_html__( 'Color Hover', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button:hover' => 'color: {{VALUE}}',
								'{{WRAPPER}} .tficonbox .tf-button:hover i' => 'color: {{VALUE}}',
								'{{WRAPPER}} .tficonbox .tf-button:hover svg' => 'fill: {{VALUE}}',
							],
						]
					);

					$this->add_control( 
						'button_bg_color_hover',
						[
							'label' => esc_html__( 'Background Color Hover', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'default' => '#000000',
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button:hover, {{WRAPPER}} .tficonbox .btn-overlay:after' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control( 
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'button_border_hover',
							'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
							'selector' => '{{WRAPPER}} .tficonbox .tf-button:hover',
						]
					);

					$this->add_control( 
						'button_border_radius_hover',
						[
							'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%' ],
							'selectors' => [
								'{{WRAPPER}} .tficonbox .tf-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'button_animation_options',
						[
							'label' => esc_html__( 'Effect Type', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'default' => 'default',
							'options' => [
								'default' => esc_html__( 'Default', 'tf-addon-for-elementer' ),
								'button' => esc_html__( 'Elementor Button Effect', 'tf-addon-for-elementer' ),
								'button-overlay' => esc_html__( 'TF Effect', 'tf-addon-for-elementer' ),
							]
						]
					);

					$this->add_control(
						'button_animation_overlay',
						[
							'label' => esc_html__( 'Style', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'default' => 'from-top',
							'options' => [								
								'from-top' => esc_html__( 'From Top', 'tf-addon-for-elementer' ),
								'from-bottom' => esc_html__( 'From Bottom', 'tf-addon-for-elementer' ),
								'from-left' => esc_html__( 'From Left', 'tf-addon-for-elementer' ),
								'from-right' => esc_html__( 'From Right', 'tf-addon-for-elementer' ),
								'from-center' => esc_html__( 'From Center', 'tf-addon-for-elementer' ),
								'skew' => esc_html__( 'Skew', 'tf-addon-for-elementer' ),								
							],
							'condition'=> [
								'button_animation_options' => 'button-overlay',
							],
						]
					);	

					$this->add_control(
						'button_animation',
						[
							'label' => esc_html__( 'Hover Animation', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'default' => 'elementor-animation-push',
							'options' => [
								'elementor-animation-grow' => esc_html__( 'Grow', 'tf-addon-for-elementer' ),
								'elementor-animation-shrink' => esc_html__( 'Shrink', 'tf-addon-for-elementer' ),
								'elementor-animation-pulse' => esc_html__( 'Pulse', 'tf-addon-for-elementer' ),
								'elementor-animation-pulse-grow' => esc_html__( 'Pulse Grow', 'tf-addon-for-elementer' ),
								'elementor-animation-pulse-shrink' => esc_html__( 'Pulse Shrink', 'tf-addon-for-elementer' ),
								'elementor-animation-push' => esc_html__( 'Push', 'tf-addon-for-elementer' ),
								'elementor-animation-pop' => esc_html__( 'Pop', 'tf-addon-for-elementer' ),
								'elementor-animation-bob' => esc_html__( 'Bob', 'tf-addon-for-elementer' ),
								'elementor-animation-hang' => esc_html__( 'Hang', 'tf-addon-for-elementer' ),
								'elementor-animation-skew' => esc_html__( 'Skew', 'tf-addon-for-elementer' ),
								'elementor-animation-wobble-vertical' => esc_html__( 'Wobble Vertical', 'tf-addon-for-elementer' ),
								'elementor-animation-wobble-horizontal' => esc_html__( 'Wobble Horizontal', 'tf-addon-for-elementer' ),

							],
							'condition'=> [
								'button_animation_options' => 'button',
							],
						]
					);	
					
				$this->end_controls_tab();

			$this->end_controls_tabs();

		    $this->end_controls_section();
	    // /.End Button Style

		// Start Container Style 
		    $this->start_controls_section( 
		    	'section_style_container',
	            [
	                'label' => esc_html__( 'Icon Box Container', 'tf-addon-for-elementer' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );  

	        $this->add_responsive_control(
				'container_align',
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
						'justify' => [
							'title' => esc_html__( 'Justified', 'tf-addon-for-elementer' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'container_background_color',
					'label' => esc_html__( 'Background', 'tf-addon-for-elementer' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .tficonbox',
				]
			);

			$this->add_control(
				'container_padding',
				[
					'label' => esc_html__( 'Padding', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'container_margin',
				[
					'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'container_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tficonbox',
				]
			);	

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'container_border',
					'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tficonbox',
				]
			);

			$this->add_control(
				'container_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);				    

		    $this->end_controls_section();
    	// /.End Container Style

	    // Start Design When Hover Style 
		    $this->start_controls_section( 
		    	'section_style_background_overlay',
	            [
	                'label' => esc_html__( 'Design When Hover', 'tf-addon-for-elementer' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'heading_effect_overlay',
				[
					'label' => esc_html__( 'Effect Overlay', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

	        $this->add_control(
				'enable_overlay',
				[
					'label' => esc_html__( 'Enable Overlay', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'tf-addon-for-elementer' ),
					'label_off' => esc_html__( 'Hide', 'tf-addon-for-elementer' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'background',
					'label' => esc_html__( 'Background', 'tf-addon-for-elementer' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .tficonbox .overlay',
					'condition' => [
						'enable_overlay' => 'yes'
					]
				]
			);

			$this->add_control(
				'hover_style',
				[
					'label' => esc_html__( 'Hover Style', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'fadein',
					'options' => [
						'fadein'  => esc_html__( 'Fade In', 'tf-addon-for-elementer' ),
						'from-left'  => esc_html__( 'From Left', 'tf-addon-for-elementer' ),
						'from-top'  => esc_html__( 'From Top', 'tf-addon-for-elementer' ),
						'from-right'  => esc_html__( 'From Right', 'tf-addon-for-elementer' ),
						'from-bottom'  => esc_html__( 'From Bottom', 'tf-addon-for-elementer' ),
						'flip-box'  => esc_html__( 'Flip Box', 'tf-addon-for-elementer' ),
					],
					'condition' => [
						'enable_overlay' => 'yes'
					]
				]
			);

			$this->add_control( 
						'flip_box_height',
						[
							'label' => esc_html__( 'Flip Box Height', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 1000,
									'step' => 1,
								],
							],
							'default' => [
								'unit' => 'px',
								'size' => 316,
							],
							'selectors' => [
								'{{WRAPPER}} .container-widget' => 'height: {{SIZE}}{{UNIT}};',
							],
							'condition' => [
								'enable_overlay' => 'yes',
								'hover_style' => 'flip-box'
							]
						]
					);

			$this->add_control(
				'flip_box_style',
				[
					'label' => esc_html__( 'Flip Box Style', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'horizontal-rotation',
					'options' => [
						'horizontal-rotation'  => esc_html__( 'Horizontal Rotation', 'tf-addon-for-elementer' ),
						'reverse-horizontal-rotation'  => esc_html__( 'Reverse Horizontal Rotation', 'tf-addon-for-elementer' ),
						'vertical-rotation'  => esc_html__( 'Vertical Rotation', 'tf-addon-for-elementer' ),
						'reverse-vertical-rotation'  => esc_html__( 'Reverse Vertical Rotation', 'tf-addon-for-elementer' ),
					],
					'condition' => [
						'enable_overlay' => 'yes',
						'hover_style' => 'flip-box'
					]
				]
			);

			$this->add_control(
				'enable_effect_hover_box',
				[
					'label' => esc_html__( 'Effect Hover Box', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'tf-addon-for-elementer' ),
					'label_off' => esc_html__( 'No', 'tf-addon-for-elementer' ),
					'return_value' => 'yes',
					'default' => 'no',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'heading_effect_border',
				[
					'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,	
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]				
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'effect_border_box',
					'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tficonbox:hover',
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]
				]
			);

			$this->add_control(
				'effect_border_radius_box',
				[
					'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]
				]
			);

			$this->add_control(
				'heading_effect_translate',
				[
					'label' => esc_html__( 'Translate Box', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]
				]
			);

			$this->add_control(
				'effect_translate',
				[
					'label' => esc_html__( 'Translate', 'tf-addon-for-elementer' ),
					'description' => esc_html__( 'ex: to Top (-10) or to Bottom (10)', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => -50,
							'max' => 50,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox:hover' => '-webkit-transform: translateY( {{SIZE}}{{UNIT}} ); transform: translateY( {{SIZE}}{{UNIT}} );',
					],
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]
				]
			);

			$this->add_control(
				'heading_effect_shadow',
				[
					'label' => esc_html__( 'Shadow Box', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'effect_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tficonbox:hover',
					'condition' => [
						'enable_effect_hover_box' => 'yes'
					]
				]
			);

	    	$this->end_controls_section();
    	// /.End Design When Hover Style

	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$migrated = isset( $settings['__fa4_migrated']['icon_button'] );	
		$is_new = empty( $settings['icon_bt'] );

		$btn_animation = 'hover-default';
		if ($settings['button_animation_options'] == 'button') {
			$btn_animation = 'hover-default ' . $settings['button_animation'];
		}elseif ($settings['button_animation_options'] == 'button-overlay') {
			$btn_animation = 'btn-overlay ' . $settings['button_animation_overlay'];
		}

		?>
		<?php if( $settings['hover_style'] == 'flip-box' || $settings['hover_style'] == 'flip-box-3d' ) : ?>
			<div class="container-widget <?php echo esc_attr($settings['hover_style']); ?> <?php echo esc_attr($settings['flip_box_style']); ?>">
				<div class="tficonbox flip-box-front <?php echo esc_attr($settings['position']); ?>">					
					<?php if ($settings['enable_overlay'] == 'yes'): ?>
					<div class="overlay <?php echo esc_attr($settings['hover_style']); ?>"></div>
					<?php endif; ?>	
					<?php if ($settings['icon_style'] == 'icon'): ?>
						<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
							<div class="wrap-icon-inner <?php echo esc_attr($settings['icon_style']); ?> <?php echo esc_attr($settings['icon_animation']); ?>">
								<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						</div>
					<?php elseif ($settings['icon_style'] == 'image'): ?>
						<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
							<div class="wrap-icon-inner <?php echo esc_attr($settings['icon_style']); ?>">
								<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="icon">
							</div>
						</div>
					<?php endif; ?>	

					<div class="content">
						<<?php echo esc_attr($settings['title_tag']);?> class="title"><?php echo esc_attr($settings['title_text']); ?></<?php echo esc_attr($settings['title_tag']);?>>
						<?php echo sprintf('<div class="description">%s</div>', $settings['description_text']); ?>
						
						<?php if ( $settings['show_button'] == 'yes' ): 

							$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
							?>
							
							<div class="tf-button-container <?php echo esc_attr($settings['button_align']); ?>">
								<a href="<?php echo esc_url( $settings['link']['url'] ) ?>" class="tf-button <?php echo esc_attr($settings['button_icon_position']); ?> <?php echo esc_attr($btn_animation); ?>" <?php echo esc_attr($target) . esc_attr($nofollow) ?> >
									<?php
									if ($settings['button_icon_position'] == 'bt_icon_before' ) {
										if ( $is_new || $migrated ) {
											if ( isset($settings['icon_button']['value']['url']) ) {
												\Elementor\Icons_Manager::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] );
											}else {
												echo '<i class="' . esc_attr($settings['icon_button']['value']) . '" aria-hidden="true"></i>';
											}									
										} else {
											echo '<i class="' . esc_attr($settings['icon_bt']) . ' aria-hidden="true""></i>';
										}
									}

									if ( $settings['button_text'] != '' ) {
										echo esc_attr( $settings['button_text'] );
									}

									if ($settings['button_icon_position'] == 'bt_icon_after' ) {
										if ( $is_new || $migrated ) {
											if ( isset($settings['icon_button']['value']['url']) ) {
												\Elementor\Icons_Manager::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] );
											}else {
												echo '<i class="' . esc_attr($settings['icon_button']['value']) . '" aria-hidden="true"></i>';
											}									
										} else {
											echo '<i class="' . esc_attr($settings['icon_bt']) . ' aria-hidden="true""></i>';
										}
									}

									?> 
								</a>
							</div>
						<?php endif; ?>

					</div>
				</div>

				<div class="tficonbox flip-box-back <?php echo esc_attr($settings['position']); ?>">					
					<?php if ($settings['enable_overlay'] == 'yes'): ?>
					<div class="overlay <?php echo esc_attr($settings['hover_style']); ?>"></div>
					<?php endif; ?>	
					<?php if ($settings['icon_style'] == 'icon'): ?>
						<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
							<div class="wrap-icon-inner <?php echo esc_attr($settings['icon_style']); ?> <?php echo esc_attr($settings['icon_animation']); ?>">
								<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						</div>
					<?php elseif ($settings['icon_style'] == 'image'): ?>
						<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
							<div class="wrap-icon-inner <?php echo esc_attr($settings['icon_style']); ?>">
								<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="icon">
							</div>
						</div>
					<?php endif; ?>	

					<div class="content">
						<<?php echo esc_attr($settings['title_tag']);?> class="title"><?php echo esc_attr($settings['title_text']); ?></<?php echo esc_attr($settings['title_tag']);?>>
						<?php echo sprintf('<div class="description">%s</div>', $settings['description_text']); ?>
						
						<?php if ( $settings['show_button'] == 'yes' ): 
							$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
							$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
							?>
							<div class="tf-button-container <?php echo esc_attr($settings['button_align']); ?>">
								<a href="<?php echo esc_url( $settings['link']['url'] ) ?>" class="tf-button <?php echo esc_attr($settings['button_icon_position']); ?> <?php echo esc_attr($btn_animation); ?>" <?php echo esc_attr($target) . esc_attr($nofollow) ?>>
									<?php
									if ($settings['button_icon_position'] == 'bt_icon_before' ) {
										if ( $is_new || $migrated ) {
											if ( isset($settings['icon_button']['value']['url']) ) {
												\Elementor\Icons_Manager::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] );
											}else {
												echo '<i class="' . esc_attr($settings['icon_button']['value']) . '" aria-hidden="true"></i>';
											}									
										} else {
											echo '<i class="' . esc_attr($settings['icon_bt']) . ' aria-hidden="true""></i>';
										}
									}

									if ( $settings['button_text'] != '' ) {
										echo esc_attr( $settings['button_text'] );
									}

									if ($settings['button_icon_position'] == 'bt_icon_after' ) {
										if ( $is_new || $migrated ) {
											if ( isset($settings['icon_button']['value']['url']) ) {
												\Elementor\Icons_Manager::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] );
											}else {
												echo '<i class="' . esc_attr($settings['icon_button']['value']) . '" aria-hidden="true"></i>';
											}									
										} else {
											echo '<i class="' . esc_attr($settings['icon_bt']) . ' aria-hidden="true""></i>';
										}
									}

									?> 
								</a>
							</div>
						<?php endif; ?>

					</div>					
				</div>
			</div>
		<?php else: ?>
			<div class="tficonbox <?php echo esc_attr($settings['position']); ?>">
				<?php if ($settings['enable_overlay'] == 'yes'): ?>
				<div class="overlay <?php echo esc_attr($settings['hover_style']); ?>"></div>
				<?php endif; ?>	
				<?php if ($settings['icon_style'] == 'icon'): ?>
					<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
						<div class="wrap-icon-inner <?php echo esc_attr($settings['icon_style']); ?> <?php echo esc_attr($settings['icon_animation']); ?>">
							<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					</div>
				<?php elseif ($settings['icon_style'] == 'image'): ?>
					<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
						<div class="wrap-icon-inner <?php echo esc_attr($settings['icon_style']); ?>">
							<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="icon">
						</div>
					</div>
				<?php endif; ?>	

				<div class="content">
					<<?php echo esc_attr($settings['title_tag']);?> class="title"><?php echo esc_attr($settings['title_text']); ?></<?php echo esc_attr($settings['title_tag']);?>>
					<?php echo sprintf('<div class="description">%s</div>', $settings['description_text']); ?>
					
					<?php if ( $settings['show_button'] == 'yes' ): 
						$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
						?>
						<div class="tf-button-container <?php echo esc_attr($settings['button_align']); ?>">
							<a href="<?php echo esc_url( $settings['link']['url'] ) ?>" class="tf-button <?php echo esc_attr($settings['button_icon_position']); ?> <?php echo esc_attr($btn_animation); ?>" <?php echo esc_attr($target) . esc_attr($nofollow) ?> >
								<?php
								if ($settings['button_icon_position'] == 'bt_icon_before' ) {
									if ( $is_new || $migrated ) {
										if ( isset($settings['icon_button']['value']['url']) ) {
											\Elementor\Icons_Manager::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] );
										}else {
											echo '<i class="' . esc_attr($settings['icon_button']['value']) . '" aria-hidden="true"></i>';
										}									
									} else {
										echo '<i class="' . esc_attr($settings['icon_bt']) . ' aria-hidden="true""></i>';
									}
								}

								if ( $settings['button_text'] != '' ) {
									echo esc_attr( $settings['button_text'] );
								}

								if ($settings['button_icon_position'] == 'bt_icon_after' ) {
									if ( $is_new || $migrated ) {
										if ( isset($settings['icon_button']['value']['url']) ) {
											\Elementor\Icons_Manager::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] );
										}else {
											echo '<i class="' . esc_attr($settings['icon_button']['value']) . '" aria-hidden="true"></i>';
										}									
									} else {
										echo '<i class="' . esc_attr($settings['icon_bt']) . ' aria-hidden="true""></i>';
									}
								}

								?> 
							</a>
						</div>
					<?php endif; ?>

				</div>
			</div>
		<?php
			endif;
	}	

}