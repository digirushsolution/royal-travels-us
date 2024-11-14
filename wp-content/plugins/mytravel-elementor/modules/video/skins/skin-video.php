<?php
namespace MyTravelElementor\Modules\Video\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use MyTravelElementor\Core\Controls_Manager as MYT_Controls_Manager;

/**
 * Video Skin Mytravel class
 */
class Skin_Video extends Skin_Base {

	/**
	 * Constructor.
	 *
	 * @param Widget_Base $parent The widget settings.
	 * @return void
	 */
	public function __construct( Widget_Base $parent ) { // phpcs:disable
		parent::__construct( $parent );
	}

	/**
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'video_skin';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Video Fancybox', 'mytravel-elementor' );
	}

	/**
	 * Register control actions.
	 *
	 * @return void
	 */
	protected function _register_controls_actions() {
		add_action( 'elementor/element/video/section_video/before_section_end', [ $this, 'register_video_fancybox_controls' ], 10 );
		add_action( 'elementor/element/video/section_image_overlay/before_section_end', [ $this, 'remove_video_imagebox_controls' ] );
		add_action( 'elementor/element/video/section_video_style/after_section_end', [ $this, 'style_video_controls' ], 10 );
		add_filter( 'mytravel-elementor/widget/video/print_template', [ $this, 'skin_print_template' ], 10, 2 );
	}

	/**
	 * Register mytravel video content controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function register_video_fancybox_controls( $widget ) {
		$this->parent = $widget;

		$update_control_ids =
		[
			'video_type',
			'youtube_url',
			'vimeo_url',
			'dailymotion_url',
			'start',
			'end',
			'autoplay',
			'play_on_mobile',
			'mute',
			'loop',
			'controls',
			'showinfo',
			'modestbranding',
			'logo',
			'yt_privacy',
			'lazy_load',
			'rel',
		];

		foreach ( $update_control_ids as $update_control_id ) {
			$widget->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin' => '',
					],
				]
			);
		}

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'mytravel-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'flaticon-multimedia',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Video Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [ 'url' => '//vimeo.com/167434033' ],
			]
		);

		$this->add_control(
			'data_speed',
			[
				'label'              => esc_html__( 'Data Speed', 'mytravel-elementor' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 700,
				'frontend_available' => true,
			]
		);
	}

	/**
	 * Remove mytravel video image overlay section controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function remove_video_imagebox_controls( $widget ) {
		$this->parent = $widget;

		$update_control_ids = [ 'section_image_overlay' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$widget->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin' => '',
					],
				]
			);
		}
	}

	/**
	 * Register mytravel video style controls.
	 *
	 * @param array $widget The widget settings.
	 * @return void
	 */
	public function style_video_controls( $widget ) {

		$update_control_ids = [ 'section_video_style' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$widget->update_control(
				$update_control_id,
				[
					'condition' => [
						'_skin' => '',
					],
				]
			);
		}

		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Icon', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'play_icon_color',
			[
				'label'     => esc_html__( 'Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-video-icon-play' => 'color: {{VALUE}} !important',
				],
			]
		);

		$this->add_control(
			'anchor_css',
			[
				'label'       => esc_html__( 'Anchor CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <a> tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'icon_wrap_css',
			[
				'label'       => esc_html__( 'Wrap CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to <span> tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'icon_css',
			[
				'label'       => esc_html__( 'Icon CSS Classes', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Added to icon class <span> tag', 'mytravel-elementor' ),
			]
		);
		$this->end_controls_section();
	}


	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {

		$widget     = $this->parent;
		$settings   = $widget->get_settings();
		$icon_value = $this->get_instance_value( 'icon' );

		$widget->add_render_attribute(
			'data_options',
			[
				'class'            => [ 'js-fancybox', 'd-inline-block', 'u-media-player', $this->get_instance_value( 'anchor_css' ) ],
				'href'             => 'javascript:;',
				'data-src'         => $this->get_instance_value( 'link' ),
				'data-speed'       => $this->get_instance_value( 'data_speed' ),
				'data-animate-in'  => 'zoomIn',
				'data-animate-out' => 'zoomOut',
				'data-caption'     => esc_attr( 'MyTravel - Responsive Website Template' ),
			]
		);

		$widget->add_render_attribute(
			'icon_wrap',
			'class',
			[
				'elementor-video-icon-play',
				'u-media-player__icon',
				'u-media-player__icon--lg',
				'bg-transparent',
				'text-primary',
				$this->get_instance_value( 'icon_wrap_css' ),
			]
		);

		$widget->add_render_attribute(
			'video_icon',
			'class',
			[
				$icon_value['value'],
				'font-size-60',
				'u-media-player__icon-inner',
				$this->get_instance_value( 'icon_css' ),

			]
		);

		?>
		<a <?php $widget->print_render_attribute_string( 'data_options' ); ?>>
			<span <?php $widget->print_render_attribute_string( 'icon_wrap' ); ?>>
				<span <?php $widget->print_render_attribute_string( 'video_icon' ); ?>></span>
			</span>
		</a>
		<?php
	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $widget widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $widget ) {
		if ( 'video' === $widget->get_name() ) {
			return '';
		}
		return $content;
	}
}
