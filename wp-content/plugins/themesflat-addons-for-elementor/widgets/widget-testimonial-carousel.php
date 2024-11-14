<?php
class TFTestimonialCarousel_Widget_Fr extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-testimonial-carousel';
    }
    
    public function get_title() {
        return esc_html__( 'TF Testimonial Carousel', 'tf-addon-for-elementer' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }	

	public function get_style_depends() {
		return ['owl-carousel', 'regular', 'owl-carousel', 'tf-testimonial-style'];
	}

	public function get_script_depends() {
		return ['owl-carousel', 'tf-testimonial-main'];
	}

	protected function register_controls() {
    	// Start Carousel Setting        
			$this->start_controls_section( 
				'section_carousel',
	            [
	                'label' => esc_html__('Testimonial Carousel', 'tf-addon-for-elementer'),
	            ]
	        );

	        $this->add_control(
				'testimonial_style',
				[
					'label' => esc_html__( 'Style', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1'  => esc_html__( 'Style 1', 'tf-addon-for-elementer' ),
						'style-2' => esc_html__( 'Style 2', 'tf-addon-for-elementer' ),
					],
				]
			);	    

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'avatar',
				[
					'label' => esc_html__( 'Choose Avatar', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/default-team.jpg",
					],
				]
			);

			$repeater->add_control(
				'name',
				[
					'label' => esc_html__( 'Title', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Default title', 'tf-addon-for-elementer' ),
					'placeholder' => esc_html__( 'Type your title here', 'tf-addon-for-elementer' ),
				]
			);

			$repeater->add_control(
				'position',
				[
					'label' => esc_html__( 'Title', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Default title', 'tf-addon-for-elementer' ),
					'placeholder' => esc_html__( 'Type your title here', 'tf-addon-for-elementer' ),
				]
			);

			$repeater->add_control(
				'description',
				[
					'label' => esc_html__( 'Description', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'rows' => 10,
					'default' => esc_html__( 'Default description', 'tf-addon-for-elementer' ),
					'placeholder' => esc_html__( 'Type your description here', 'tf-addon-for-elementer' ),
				]
			);

			$repeater->add_control(
				'image_quote',
				[
					'label' => esc_html__( 'Choose Image Quote', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_FREE."assets/img/quote-new.png",
					],
				]
			);

			$this->add_control( 
				'carousel_list',
					[					
						'type' => \Elementor\Controls_Manager::REPEATER,
						'fields' => $repeater->get_controls(),
						'default' => [
							[ 
								'name' => 'Mr. Jems Bond -',
								'position' => '24webpro Studio',
								'description'=> '“Etiam et congue dui, eget suscipit neque. Pellentesque ut sollicitudin neque. Vestibulum non eleifend ex, auctor congue enim. Sed pulvinar placerat.',
							],
							[ 
								'name' => 'Mr. Jems Bond -',
								'position' => '24webpro Studio',
								'description'=> '“Etiam et congue dui, eget suscipit neque. Pellentesque ut sollicitudin neque. Vestibulum non eleifend ex, auctor congue enim. Sed pulvinar placerat.',
							],
							[ 
								'name' => 'Mr. Jems Bond -',
								'position' => '24webpro Studio',
								'description'=> '“Etiam et congue dui, eget suscipit neque. Pellentesque ut sollicitudin neque. Vestibulum non eleifend ex, auctor congue enim. Sed pulvinar placerat.',
							],
						],					
					]
				);
			
			$this->end_controls_section();
    	// /.End Carousel	

    	// Start Style        
			$this->start_controls_section( 
				'section_style',
	            [
	                'label' => esc_html__('Style', 'tf-addon-for-elementer'),
	            ]
	        );	

	        $this->add_control(
				'h_general',
				[
					'label' => esc_html__( 'General', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			$this->add_responsive_control(
				'general_padding',
				[
					'label' => esc_html__( 'Padding', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => 50,
						'right' => 0,
						'bottom' => 0,
						'left' => 0,
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

	        $this->add_control(
				'h_name',
				[
					'label' => esc_html__( 'Name', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'name_typography',
					'label' => esc_html__( 'Typography', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-testimonial-carousel .item .name',
				]
			);
			$this->add_control(
				'name_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .item .name' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'h_position',
				[
					'label' => esc_html__( 'Position', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'position_typography',
					'label' => esc_html__( 'Typography', 'tf-addon-for-elementer' ),
					'selector' => '{{WRAPPER}} .tf-testimonial-carousel .item .position',
				]
			);
			$this->add_control(
				'position_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .item .position' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'h_description',
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
					'selector' => '{{WRAPPER}} .tf-testimonial-carousel .item .description',
				]
			);
			$this->add_control(
				'description_color',
				[
					'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .item .description' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'description_margin',
				[
					'label' => esc_html__( 'Margin', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'default' => [
						'top' => 0,
						'right' => 0,
						'bottom' => 40,
						'left' => 0,
						'unit' => 'px',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .item .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'h_line',
				[
					'label' => esc_html__( 'Line', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'line_1_color',
				[
					'label' => esc_html__( 'Line 1 Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#EB6D2F',
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel.style-2 .item .line-bottom:before' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'line_2_color',
				[
					'label' => esc_html__( 'Line 2 Color', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#FDDB05',
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel.style-2 .item .line-bottom:after' => 'background-color: {{VALUE}}',
					],
				]
			);

	        $this->end_controls_section();
        // /.End Style

        // Start Setting        
			$this->start_controls_section( 
				'section_setting',
	            [
	                'label' => esc_html__('Setting', 'tf-addon-for-elementer'),
	            ]
	        );	

			$this->add_control( 
				'carousel_loop',
				[
					'label' => esc_html__( 'Loop', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'tf-addon-for-elementer' ),
					'label_off' => esc_html__( 'Off', 'tf-addon-for-elementer' ),
					'return_value' => 'yes',
					'default' => 'yes',				
				]
			);

			$this->add_control( 
				'carousel_auto',
				[
					'label' => esc_html__( 'Auto Play', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'tf-addon-for-elementer' ),
					'label_off' => esc_html__( 'Off', 'tf-addon-for-elementer' ),
					'return_value' => 'yes',
					'default' => 'yes',				
				]
			);	

			$this->add_control(
				'carousel_spacer',
				[
					'label' => esc_html__( 'Spacer', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'default' => 30,				
				]
			);

			$this->add_control( 
	        	'carousel_column_desk',
				[
					'label' => esc_html__( 'Columns Desktop', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( '1', 'tf-addon-for-elementer' ),
						'2' => esc_html__( '2', 'tf-addon-for-elementer' ),
						'3' => esc_html__( '3', 'tf-addon-for-elementer' ),
						'4' => esc_html__( '4', 'tf-addon-for-elementer' ),
						'5' => esc_html__( '5', 'tf-addon-for-elementer' ),
						'6' => esc_html__( '6', 'tf-addon-for-elementer' ),
					],				
				]
			);

			$this->add_control( 
	        	'carousel_column_tablet',
				[
					'label' => esc_html__( 'Columns Tablet', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( '1', 'tf-addon-for-elementer' ),
						'2' => esc_html__( '2', 'tf-addon-for-elementer' ),
						'3' => esc_html__( '3', 'tf-addon-for-elementer' ),
						'4' => esc_html__( '4', 'tf-addon-for-elementer' ),
						'5' => esc_html__( '5', 'tf-addon-for-elementer' ),
						'6' => esc_html__( '6', 'tf-addon-for-elementer' ),
					],				
				]
			);

			$this->add_control( 
	        	'carousel_column_mobile',
				[
					'label' => esc_html__( 'Columns Mobile', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( '1', 'tf-addon-for-elementer' ),
						'2' => esc_html__( '2', 'tf-addon-for-elementer' ),
						'3' => esc_html__( '3', 'tf-addon-for-elementer' ),
						'4' => esc_html__( '4', 'tf-addon-for-elementer' ),
						'5' => esc_html__( '5', 'tf-addon-for-elementer' ),
						'6' => esc_html__( '6', 'tf-addon-for-elementer' ),
					],				
				]
			);		
	        $this->end_controls_section();
        // /.End Setting

        // Start Arrow        
			$this->start_controls_section( 
				'section_arrow',
	            [
	                'label' => esc_html__('Arrow', 'tf-addon-for-elementer'),
	            ]
	        );

	        $this->add_control( 
				'carousel_arrow',
				[
					'label' => esc_html__( 'Arrow', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'tf-addon-for-elementer' ),
					'label_off' => esc_html__( 'Hide', 'tf-addon-for-elementer' ),
					'return_value' => 'yes',
					'default' => 'yes',				
					'description'	=> 'Just show when you have two slide',
					'separator' => 'before',
				]
			);

	        $this->add_control( 
				'carousel_prev_icon', [
	                'label' => esc_html__( 'Prev Icon', 'tf-addon-for-elementer' ),
	                'type' => \Elementor\Controls_Manager::ICON,
	                'default' => 'fa fa-chevron-left',
	                'include' => [
						'fa fa-angle-double-left',
						'fa fa-angle-left',
						'fa fa-chevron-left',
						'fa fa-arrow-left',
					],  
	                'condition' => [                	
	                    'carousel_arrow' => 'yes',
	                ]
	            ]
	        );

	    	$this->add_control( 
	    		'carousel_next_icon', [
	                'label' => esc_html__( 'Next Icon', 'tf-addon-for-elementer' ),
	                'type' => \Elementor\Controls_Manager::ICON,
	                'default' => 'fa fa-chevron-right',
	                'include' => [
						'fa fa-angle-double-right',
						'fa fa-angle-right',
						'fa fa-chevron-right',
						'fa fa-arrow-right',
					], 
	                'condition' => [                	
	                    'carousel_arrow' => 'yes',
	                ]
	            ]
	        );

	        $this->add_responsive_control( 
	        	'carousel_arrow_fontsize',
				[
					'label' => esc_html__( 'Font Size', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'default' => [
						'unit' => 'px',
						'size' => 12,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_arrow' => 'yes',
	                ]
				]
			);

			$this->add_responsive_control( 
				'w_size_carousel_arrow',
				[
					'label' => esc_html__( 'Width', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'default' => [
						'unit' => 'px',
						'size' => 46,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_arrow' => 'yes',
	                ]
				]
			);

			$this->add_responsive_control( 
				'h_size_carousel_arrow',
				[
					'label' => esc_html__( 'Height', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'default' => [
						'unit' => 'px',
						'size' => 46,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_arrow' => 'yes',
	                ]
				]
			);	

			$this->add_responsive_control( 
				'carousel_arrow_horizontal_position_prev',
				[
					'label' => esc_html__( 'Horizontal Position Previous', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -2000,
							'max' => 2000,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev' => 'left: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_arrow' => 'yes',
	                ]
				]
			);

			$this->add_responsive_control( 
				'carousel_arrow_horizontal_position_next',
				[
					'label' => esc_html__( 'Horizontal Position Next', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -2000,
							'max' => 2000,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'right: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_arrow' => 'yes',
	                ]
				]
			);

			$this->add_responsive_control( 
				'carousel_arrow_vertical_position',
				[
					'label' => esc_html__( 'Vertical Position', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'top: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_arrow' => 'yes',
	                ]
				]
			);

			$this->start_controls_tabs( 
				'carousel_arrow_tabs',
				[
					'condition' => [
		                'carousel_arrow' => 'yes',	                
		            ]
				] );

				$this->start_controls_tab( 
					'carousel_arrow_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'tf-addon-for-elementer' ),						
					]
				);

				$this->add_control( 
					'carousel_arrow_color',
		            [
		                'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::COLOR,
		                'default' => '#ffffff',
		                'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'color: {{VALUE}}',
						],
						'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );

		        $this->add_control( 
		        	'carousel_arrow_bg_color',
		            [
		                'label' => esc_html__( 'Background Color', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::COLOR,
		                'default' => '#000000',
		                'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'background-color: {{VALUE}};',
						],
						'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );	

		        $this->add_group_control( 
		        	\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'carousel_arrow_border',
						'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
						'selector' => '{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next',
						'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
					]
				);

				$this->add_responsive_control( 
					'carousel_arrow_border_radius',
		            [
		                'label' => esc_html__( 'Border Radius Previous', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::DIMENSIONS,
		                'size_units' => [ 'px', '%', 'em' ],
		                'selectors' => [
		                    '{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		                ],
		                'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );

		        $this->add_responsive_control( 
					'carousel_arrow_border_radius_next',
		            [
		                'label' => esc_html__( 'Border Radius Next', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::DIMENSIONS,
		                'size_units' => [ 'px', '%', 'em' ],
		                'selectors' => [
		                    '{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		                ],
		                'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );

		        $this->end_controls_tab();

		        $this->start_controls_tab( 
			    	'carousel_arrow_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'tf-addon-for-elementer' ),
					]
				);

		    	$this->add_control( 
		    		'carousel_arrow_color_hover',
		            [
		                'label' => esc_html__( 'Color', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::COLOR,
		                'default' => '',
		                'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next:hover' => 'color: {{VALUE}}',
						],
						'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );

		        $this->add_control( 
		        	'carousel_arrow_hover_bg_color',
		            [
		                'label' => esc_html__( 'Background Color', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::COLOR,
		                'default' => '',
		                'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next:hover' => 'background-color: {{VALUE}};',
						],
						'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );

		        $this->add_group_control( 
		        	\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'carousel_arrow_border_hover',
						'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
						'selector' => '{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next:hover',
						'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
					]
				);

				$this->add_responsive_control( 
					'carousel_arrow_border_radius_hover',
		            [
		                'label' => esc_html__( 'Border Radius Previous', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::DIMENSIONS,
		                'size_units' => [ 'px', '%', 'em' ],
		                'selectors' => [
		                    '{{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-prev:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-nav .owl-next:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		                ],
		                'condition' => [
		                    'carousel_arrow' => 'yes',
		                ]
		            ]
		        );

	       		$this->end_controls_tab();

	        $this->end_controls_tabs();

	        $this->end_controls_section();
        // /.End Arrow

        // Start Bullets        
			$this->start_controls_section( 
				'section_bullets',
	            [
	                'label' => esc_html__('Bullets', 'tf-addon-for-elementer'),
	            ]
	        );

			$this->add_control( 
				'carousel_bullets',
	            [
	                'label'         => esc_html__( 'Bullets', 'tf-addon-for-elementer' ),
	                'type'          => \Elementor\Controls_Manager::SWITCHER,
	                'label_on'      => esc_html__( 'Show', 'tf-addon-for-elementer' ),
	                'label_off'     => esc_html__( 'Hide', 'tf-addon-for-elementer' ),
	                'return_value'  => 'yes',
	                'default'       => 'yes',
	                'separator' => 'before',
	            ]
	        );        

			$this->add_responsive_control( 
				'carousel_bullets_horizontal_position',
				[
					'label' => esc_html__( 'Horizonta Offset', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 2000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 50,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-dots' => 'left: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_bullets' => 'yes',
	                ]
				]
			);

			$this->add_responsive_control( 
				'carousel_bullets_vertical_position',
				[
					'label' => esc_html__( 'Vertical Offset', 'tf-addon-for-elementer' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => -40,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-dots' => 'bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [					
	                    'carousel_bullets' => 'yes',
	                ]
				]
			);

			$this->add_responsive_control( 
				'carousel_bullets_margin',
				[
					'label' => esc_html__( 'Spacing', 'tf-addon-for-elementer' ),
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
						'size' => 5,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
					],
					'condition' => [
	                    'carousel_bullets' => 'yes',
	                ]
				]
			);

			$this->start_controls_tabs( 
				'carousel_bullets_tabs',
					[
						'condition' => [						
		                    'carousel_bullets' => 'yes',
		                ]
					] );
				$this->start_controls_tab( 
					'carousel_bullets_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'tf-addon-for-elementer' ),						
					]
				);

				$this->add_responsive_control( 
		        	'w_size_carousel_bullets',
						[
							'label' => esc_html__( 'Width', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								]
							],
							'default' => [
								'unit' => 'px',
								'size' => 12,
							],
							'selectors' => [
								'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot' => 'width: {{SIZE}}{{UNIT}};',
							],
							'condition' => [						
			                    'carousel_bullets' => 'yes',
			                ]
						]
				);			

				$this->add_responsive_control( 
					'h_size_carousel_bullets',
					[
						'label' => esc_html__( 'Height', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
								'step' => 1,
							]
						],
						'default' => [
							'unit' => 'px',
							'size' => 12,
						],
						'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
						],
						'condition' => [					
		                    'carousel_bullets' => 'yes',
		                ]
					]
				);

				$this->add_control( 
					'carousel_bullets_bg_color',
		            [
		                'label' => esc_html__( 'Background Color', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::COLOR,
		                'default' => 'rgba(0,0,0,0.5)',
		                'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot' => 'background-color: {{VALUE}}',
						],
						'condition' => [
		                    'carousel_bullets' => 'yes',
		                ]
		            ]
		        );

		        $this->add_group_control( 
		        	\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'carousel_bullets_border',
						'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
						'selector' => '{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot',
						'condition' => [
		                    'carousel_bullets' => 'yes',
		                ]
					]
				);

				$this->add_responsive_control( 
					'carousel_bullets_border_radius',
		            [
		                'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::DIMENSIONS,
		                'size_units' => [ 'px', '%', 'em' ],
		                'selectors' => [
		                    '{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		                ],
		                'condition' => [
		                    'carousel_bullets' => 'yes',
		                ]
		            ]
		        );

			    $this->end_controls_tab();

		        $this->start_controls_tab( 
		        	'carousel_bullets_hover_tab',
					[
						'label' => esc_html__( 'Active', 'tf-addon-for-elementer' ),
					]
				);

				$this->add_responsive_control( 
		        	'w_size_carousel_bullets_active',
						[
							'label' => esc_html__( 'Width', 'tf-addon-for-elementer' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								]
							],
							'default' => [
								'unit' => 'px',
								'size' => 12,
							],
							'selectors' => [
								'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot.active' => 'width: {{SIZE}}{{UNIT}};',
							],
							'condition' => [						
			                    'carousel_bullets' => 'yes',
			                ]
						]
				);

				$this->add_responsive_control( 
					'h_size_carousel_bullets_active',
					[
						'label' => esc_html__( 'Height', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
								'step' => 1,
							]
						],
						'default' => [
							'unit' => 'px',
							'size' => 12,
						],
						'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot.active' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
						],
						'condition' => [					
		                    'carousel_bullets' => 'yes',
		                ]
					]
				);

				$this->add_control( 
					'size_carousel_bullets_active_scale_hover',
					[
						'label' => esc_html__( 'Scale', 'tf-addon-for-elementer' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 2,
								'step' => 0.1,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 1,
						],
						'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot.active, {{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot:hover' => 'transform: scale({{SIZE}});',
						],
					]
				);	

	        	$this->add_control( 
	        		'carousel_bullets_hover_bg_color',
		            [
		                'label' => esc_html__( 'Background Color', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::COLOR,
		                'default' => '#000000',
		                'selectors' => [
							'{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot.active' => 'background-color: {{VALUE}}',
						],
						'condition' => [
		                    'carousel_bullets' => 'yes',
		                ]
		            ]
		        );

	        	$this->add_group_control( 
	        		\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'carousel_bullets_border_hover',
						'label' => esc_html__( 'Border', 'tf-addon-for-elementer' ),
						'selector' => '{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot.active',
						'condition' => [
		                    'carousel_bullets' => 'yes',
		                ]
					]
				);

				$this->add_responsive_control( 
					'carousel_bullets_border_radius_hover',
		            [
		                'label' => esc_html__( 'Border Radius', 'tf-addon-for-elementer' ),
		                'type' => \Elementor\Controls_Manager::DIMENSIONS,
		                'size_units' => [ 'px', '%', 'em' ],
		                'selectors' => [
		                    '{{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot:hover, {{WRAPPER}} .tf-testimonial-carousel .owl-dots .owl-dot.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		                ],
		                'condition' => [
		                    'carousel_bullets' => 'yes',
		                ]
		            ]
		        );

				$this->end_controls_tab();

		    $this->end_controls_tabs();	

	        $this->end_controls_section();
        // /.End Bullets    
	    
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();
		
		$carousel_arrow = 'no-arrow';
		if ( $settings['carousel_arrow'] == 'yes' ) {
			$carousel_arrow = 'has-arrow';
		}

		$carousel_bullets = 'no-bullets';
		if ( $settings['carousel_bullets'] == 'yes' ) {
			$carousel_bullets = 'has-bullets';
		}

		?>
		<div class="tf-testimonial-carousel <?php echo esc_attr($settings['testimonial_style']) ?> <?php echo esc_attr($carousel_arrow); ?> <?php echo esc_attr($carousel_bullets); ?>" data-loop="<?php echo esc_attr($settings['carousel_loop']); ?>" data-auto="<?php echo esc_attr($settings['carousel_auto']); ?>" data-column="<?php echo esc_attr($settings['carousel_column_desk']); ?>" data-column2="<?php echo esc_attr($settings['carousel_column_tablet']); ?>" data-column3="<?php echo esc_attr($settings['carousel_column_mobile']); ?>" data-spacer="<?php echo esc_attr($settings['carousel_spacer']); ?>" data-prev_icon="<?php echo esc_attr($settings['carousel_prev_icon']) ?>" data-next_icon="<?php echo esc_attr($settings['carousel_next_icon']) ?>">
			<div class="owl-carousel owl-theme">
			<?php foreach ($settings['carousel_list'] as $carousel): ?>				
				<div class="item">	
					<?php if ($settings['testimonial_style'] == 'style-2'): ?>						
						<div class="wrap-content">
							<span class="bg-quote"></span>	
							<div class="image-quote"><img src="<?php echo esc_attr($carousel['image_quote']['url']); ?>" alt="image"></div>
							<div class="description"><?php echo esc_attr($carousel['description']); ?></div>
							<div class="wrap-author">				
								<span class="avatar"><img src="<?php echo esc_attr($carousel['avatar']['url']); ?>" alt="image"></span>
								<span class="name"><?php echo esc_attr($carousel['name']); ?></span>
								<span class="position"><?php echo esc_attr($carousel['position']); ?></span>
							</div>	
						</div>
						<div class="line-bottom"></div>
					<?php else: ?>
						<div class="image-quote"><img src="<?php echo esc_attr($carousel['image_quote']['url']); ?>" alt="image"></div>
						<div class="description"><?php echo esc_attr($carousel['description']); ?></div>
						<div class="wrap-author">				
							<span class="avatar"><img src="<?php echo esc_attr($carousel['avatar']['url']); ?>" alt="image"></span>
							<span class="name"><?php echo esc_attr($carousel['name']); ?></span>
							<span class="position"><?php echo esc_attr($carousel['position']); ?></span>
						</div>
					<?php endif; ?>			
				</div>				
			<?php endforeach;?>
			</div>
		</div>
		<?php	
	}
}