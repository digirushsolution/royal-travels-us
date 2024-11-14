<?php

namespace MyTravelElementor\Modules\Section;

use MyTravelElementor\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Section module class
 */
class Module extends Module_Base {
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		$this->add_actions();
	}

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'override-section';
	}
	/**
	 * Add Actions
	 *
	 * @return void
	 */
	public function add_actions() {
		add_action( 'elementor/frontend/section/after_render', [ $this, 'after_render' ], 20 );
		add_action( 'elementor/frontend/section/before_render', [ $this, 'before_render' ], 5 );
		add_action( 'elementor/element/section/section_advanced/before_section_end', [ $this, 'add_section_controls' ], 10, 2 );
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'add_parallax_controls' ], 10, 2 );
		add_filter( 'elementor/section/print_template', [ $this, 'print_template' ], 10, 2 );
	}
	/**
	 * Add section controls.
	 *
	 * @param array $element The content.
	 * @param array $args    Argument.
	 * @return void
	 */
	public function add_section_controls( $element, $args ) {
		$element->add_control(
			'container_class',
			[
				'label'       => esc_html__( 'Container CSS Classes', 'mytravel-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Applied to elementor-container element. You can use additional bootstrap utility classes here.', 'mytravel-elementor' ),
			]
		);
	}

	/**
	 * Add parallax controls.
	 *
	 * @param array $element The content.
	 * @param array $args    Argument.
	 * @return void
	 */
	public function add_parallax_controls( $element, $args ) {
		$element->start_controls_section(
			'_section_parallax',
			[
				'label' => esc_html__( 'Parallax', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'enable_parallax',
			[
				'label'        => esc_html__( 'Enable Parallax', 'mytravel-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable Parallax.', 'mytravel-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'mytravel-elementor' ),
				'label_off'    => esc_html__( 'No', 'mytravel-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$element->add_control(
			'bg_image',
			[
				'label'     => esc_html__( 'Background', 'mytravel-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'enable_parallax' => 'yes',
				],
			]
		);

		$element->end_controls_section();

		$element->start_controls_section(
			'section_parallax_style',
			[
				'label' => esc_html__( 'Parallax', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$element->add_control(
			'parallax_css',
			[
				'label'       => esc_html__( 'Parallax CSS', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Additional CSS classes separated by space that you\'d like to apply to the highlighted text', 'mytravel-elementor' ),
				'default'     => '',
			]
		);

		$element->add_control(
			'parallax_height',
			[
				'label'      => esc_html__( 'Parallax Background Image Height', 'mytravel-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 130,
					'unit' => '%',
				],
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1040,
					],
				],
				'selectors'  => [
					'.dzsparallaxer .dzsparallaxer--target' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$element->end_controls_section();

	}

	/**
	 * Wrap Start.
	 *
	 * @param array $section The widget.
	 *
	 * @return void
	 */
	public function wrap_start( $section ) {
		$settings     = $section->get_settings_for_display();
		$has_parallax = 'yes' === $settings['enable_parallax'] ? true : false;
		$height       = $settings['parallax_height'];

		$section->add_render_attribute(
			'parallax',
			'class',
			[
				'dzsparallaxer',
				'auto-init',
				'height-is-based-on-content',
				'use-loading',
				'mode-scroll',
				$settings['parallax_css'],
			]
		);

		if ( $has_parallax ) :
			?>
			<div <?php $section->print_render_attribute_string( 'parallax' ); ?> data-options='{direction: "normal"}'>
				<?php
				if ( isset( $settings['bg_image']['url'] ) && ! empty( $settings['bg_image']['url'] ) ) {
					?>
					<div class="divimage dzsparallaxer--target" style="height:130%; background-image: url(<?php echo esc_attr( $settings['bg_image']['url'] ); ?>);"></div>
					<?php
				}
		endif;
	}

	/**
	 * Wrap End.
	 *
	 * @param array $section The widget.
	 *
	 * @return void
	 */
	public function after_render( $section ) {
		$settings     = $section->get_settings_for_display();
		$has_parallax = 'yes' === $settings['enable_parallax'] ? true : false;

		if ( $has_parallax ) :
			?>
			</div><!-- /.custom-wrap -->
			<?php
		endif;
	}


	/**
	 * Render Before Content.
	 *
	 * @param array $element The content.
	 */
	public function before_render( $element ) {

		$settings        = $element->get_settings();
		$container_class = $settings['gap'];

		if ( 'no' === $settings['gap'] ) {
			$container_class = $settings['gap'] . ' no-gutters';
		}

		if ( isset( $settings['container_class'] ) && ! empty( $settings['container_class'] ) ) {
			$container_class .= ' ' . $settings['container_class'];
		}

		if ( ! empty( $container_class ) ) {
			$element->set_settings( 'gap', $container_class );
		}

		$this->wrap_start( $element );

	}

	/**
	 * Print Template.
	 *
	 * @param string $template template.
	 * @param array $widget The section element object.
	 * @return string
	 */
	public function print_template( $template, $widget ) {
        if( 'section' === $widget->get_name() ){
            ob_start();
            $this->content_template();
            $template = ob_get_clean();
        }
        return $template;
    }

	/**
	 * Content Template.
	 *
	 * @return void
	 */
	public function content_template() {
		?>
		<#
		if ( settings.background_video_link ) {
			let videoAttributes = 'autoplay muted playsinline';

			if ( ! settings.background_play_once ) {
				videoAttributes += ' loop';
			}

			view.addRenderAttribute( 'background-video-container', 'class', 'elementor-background-video-container' );

			if ( ! settings.background_play_on_mobile ) {
				view.addRenderAttribute( 'background-video-container', 'class', 'elementor-hidden-phone' );
			}
		#>
			<div {{{ view.getRenderAttributeString( 'background-video-container' ) }}}>
				<div class="elementor-background-video-embed"></div>
				<video class="elementor-background-video-hosted elementor-html5-video" {{ videoAttributes }}></video>
			</div>
		<# }
		if ( 'no' == settings.gap ) {
			settings.gap = `${ settings.gap } no-gutters`;
		}

		if ( '' != settings.container_class ) {
			settings.gap = `${ settings.gap } ${ settings.container_class }`;
		}

		if ( 'yes' == settings.enable_parallax ) {
			
			view.addRenderAttribute( 'parallax', 'class', 'dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll' );  
			
			view.addRenderAttribute(
			'bg_image',
			{
				'class': [ 'divimage dzsparallaxer--target' ],
			}
			);
			#>
			<div {{{ view.getRenderAttributeString( 'parallax' ) }}} data-options='{direction: "normal"}'>
				<div {{{ view.getRenderAttributeString( 'bg_image' ) }}} style="height:130%; background-image: url( {{ settings.bg_image.url }} );" >this is background image</div>
			</div>
			<#

		}

		#>
		<div class="elementor-background-overlay"></div>
		<div class="elementor-shape elementor-shape-top"></div>
		<div class="elementor-shape elementor-shape-bottom"></div>
		<div class="elementor-container elementor-column-gap-{{ settings.gap }}">
		</div>
		<?php
	}

}

