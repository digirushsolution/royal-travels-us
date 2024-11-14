<?php
namespace MyTravelElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use MyTravelElementor\Modules\QueryControl\Module as Module_Query;
use MyTravelElementor\Modules\QueryControl\Controls\Group_Control_Related;
use MyTravelElementor\Core\Utils as MYT_Utils;
use MyTravelElementor\Modules\Carousel\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Deal Carousel
 */
class Deal_Carousel extends Base {
	/**
	 * Fetch the Scripts based on keyword.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'slick-carousel' ];
	}
	/**
	 * Skip widget.
	 *
	 * @var bool
	 */
	protected $_has_template_content = false;

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-deal-carousel';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Deal Carousel', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'image-carousel', 'image', 'carousel', 'deal', 'deal-carousel' ];
	}

	/**
	 * Register the Skins with the widget.
	 *
	 * @return void
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Deal_Carousel( $this ) );
	}

	/**
	 * Get the group for this widget.
	 *
	 * @return string
	 */
	public function get_group_name() {
		return 'carousel';
	}

	/**
	 * Print the slide.
	 *
	 * @param array $slide the slide settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_slide( array $slide, array $settings, $element_key ) {}

	/**
	 * Register Title Controls for this widget.
	 *
	 * @return void
	 */
	protected function register_controls() {
		parent::register_controls();

		$this->start_injection(
			[
				'of' => 'slides',
			]
		);
		$this->add_control(
			'link',
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
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h6',
			]
		);
		$this->end_injection();

		$this->start_controls_section(
			'image_heading',
			[
				'label' => esc_html__( 'Image', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_css',
			[
				'label' => esc_html__( 'Image CSS Class', 'mytravel-elementor' ),
				'type'  => Controls_Manager::TEXT,
				'title' => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'anchor_css',
			[
				'label'     => esc_html__( 'Anchor Tag CSS Class', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'title'     => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
				'separator' => 'after',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_heading',
			[
				'label' => esc_html__( 'Text', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label'     => esc_html__( 'Title Color', 'mytravel-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .custom-title-color' => 'color: {{VALUE}}',
					],
					'global'    => [
						'default' => Global_Colors::COLOR_TEXT,
					],
				]
			);

			$this->add_control(
				'title_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'mytravel-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .custom-title-color:hover, {{WRAPPER}} .custom-title-color:focus' => 'color: {{VALUE}} !important;',
						'{{WRAPPER}} .custom-title-color:hover svg path, {{WRAPPER}} .custom-title-color:focus svg path' => 'fill: {{VALUE}} !important;',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'selector' => '{{WRAPPER}} .mytravel-elementor-title__name',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				]
			);

			$this->add_control(
				'title_css',
				[
					'label'     => esc_html__( 'Title CSS Class', 'mytravel-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'title'     => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
					'separator' => 'after',
				]
			);

			$this->add_control(
				'excerpt_color',
				[
					'label'     => esc_html__( 'Excerpt Color', 'mytravel-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .custom-excerpt-color' => 'color: {{VALUE}}',
					],
					'global'    => [
						'default' => Global_Colors::COLOR_TEXT,
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'excerpt_typography',
					'selector' => '{{WRAPPER}} .mytravel-elementor-excerpt__name',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				]
			);

			$this->add_control(
				'excerpt_css',
				[
					'label'     => esc_html__( 'Excerpt CSS Class', 'mytravel-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'title'     => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
					'separator' => 'after',
				]
			);
			$this->end_controls_section();
	}

	/**
	 * Register repeater controls for this widget.
	 *
	 * @param Repeater $repeater repeater control arguments.
	 * @return void
	 */
	protected function add_repeater_controls( Repeater $repeater ) {

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'mytravel-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'mytravel-elementor' ),
				'description' => esc_html__( 'Use <br> to break into two lines', 'mytravel-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'excerpt',
			[
				'label'       => esc_html__( 'Description', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'mytravel-elementor' ),
				'description' => esc_html__( 'Use <br> to break into two lines', 'mytravel-elementor' ),
				'label_block' => true,
			]
		);
	}

	/**
	 * Slider defaults.
	 *
	 * @return string
	 */
	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();

		return [
			[
				'image'   => [
					'url' => $placeholder_image_src,
				],
				'title'   => esc_html__( 'Earning Asiana Club Miles Just Got Easier! ', 'mytravel-elementor' ),
				'excerpt' => esc_html__( 'Book Hotels and Earn Asiana Club Miles!', 'mytravel-elementor' ),
			],
			[
				'image'   => [
					'url' => $placeholder_image_src,
				],
				'title'   => esc_html__( 'Save big on hotels!', 'mytravel-elementor' ),
				'excerpt' => esc_html__( 'Book and save with Trip.com on your next stay', 'mytravel-elementor' ),
			],
			[
				'image'   => [
					'url' => $placeholder_image_src,
				],
				'title'   => esc_html__( 'Experience Europe Your Way', 'mytravel-elementor' ),
				'excerpt' => esc_html__( 'With up to 30% Off, experience Europe your way!', 'mytravel-elementor' ),
			],
		];
	}

	/**
	 * Render Image.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function render_image( array $slide, array $settings, $element_key ) {

		$image_url = $slide['image']['url'];
		$image_css = [ 'img-fluid', 'w-100' ];

		if ( $settings['image_css'] ) {
			$image_css[] = $settings['image_css'];
		}

		$this->add_render_attribute(
			'image' . $element_key,
			[
				'class' => array( 'd-block', 'rounded-xs', 'overflow-hidden', 'mb-3', $settings['anchor_css'] ),
				'href'  => $settings['link'],
			]
		);

		if ( ! empty( $image_url ) ) {
			?>
			<!-- Image -->
			<a <?php $this->print_render_attribute_string( 'image' . $element_key ); ?>>
				<?php
				$image_html = wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $slide, 'thumbnail', 'image' ) );
				echo wp_kses_post( MYT_Utils::add_class_to_image_html( $image_html, $image_css ) );
				?>
			</a>
			<?php
		}

	}

	/**
	 * Render Title.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function render_title( array $slide, array $settings, $element_key ) {

		$title = $slide['title'];

		$this->add_render_attribute( 'title_text_' . $element_key, 'class', [ 'mytravel-elementor-title__name', 'font-size-17', 'pt-xl-1', 'font-weight-bold', 'mb-1', 'text-gray-6' ] );

		if ( ! empty( $settings['title_css'] ) ) {
			$this->add_render_attribute( 'title_text_' . $element_key, 'class', $settings['title_css'] );
		}

		if ( ! empty( $title ) ) {
			$this->add_render_attribute( 'title_' . $element_key, 'class', 'custom-title-color' );
			$this->add_link_attributes( 'title_' . $element_key, $settings['link'] );
		}

		?>
		<<?php echo esc_html( $settings['title_tag'] ); ?> <?php $this->print_render_attribute_string( 'title_text_' . $element_key ); ?>>
			<a <?php $this->print_render_attribute_string( 'title_' . $element_key ); ?>>
				<?php echo esc_html( $title ); ?> 
			</a>
		</<?php echo esc_html( $settings['title_tag'] ); ?>>
			<?php

	}

	/**
	 * Render Excerpt.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function render_excerpt( array $slide, array $settings, $element_key ) {

		$excerpt = $slide['excerpt'];

		if ( ! empty( $excerpt ) ) {
			$this->add_render_attribute(
				'excerpt_text' . $element_key,
				[
					'class' => 'mytravel-elementor-excerpt__name text-gray-1',
					'href'  => $settings['link'],
				]
			);
		}

		if ( ! empty( $settings['excerpt_css'] ) ) {
			$this->add_render_attribute( 'excerpt_text' . $element_key, 'class', $settings['excerpt_css'] );
		}

		?>
		<a <?php $this->print_render_attribute_string( 'excerpt_text' . $element_key ); ?>>
			<span class="custom-excerpt-color"><?php echo esc_html( $excerpt ); ?></span>
		</a>
			<?php

	}

}
