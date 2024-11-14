<?php
namespace MyTravelElementor\Modules\Carousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use MyTravelElementor\Modules\Carousel\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Testimonial Carousel
 */
class Testimonial_Carousel extends Base {
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
		return 'myt-testimonial-carousel';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'cards', 'carousel', 'image', 'testimonial' ];
	}

	/**
	 * Register the Skins with the widget.
	 *
	 * @return void
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Testimonial_Carousel_V1( $this ) );
		$this->add_skin( new Skins\Skin_Testimonial_Carousel_V2( $this ) );

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
	 * Register repeater controls for this widget.
	 *
	 * @param Repeater $repeater repeater control arguments.
	 * @return void
	 */
	protected function add_repeater_controls( Repeater $repeater ) {

		$repeater->add_control(
			'blockquote',
			[
				'label'   => esc_html__( 'Blockquote', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html( 'This is the 3rd time I’ve used Travelo website and telling you the truth their services are always realiable and it only takes few minutes to plan and finalize' ),

			]
		);

		$repeater->add_control(
			'avatar',
			[
				'label'   => esc_html__( 'Avatar', 'mytravel-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'name',
			[
				'label'   => esc_html__( 'Name', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html( 'Ali Tufan ' ),

			]
		);

		$repeater->add_control(
			'role',
			[
				'label'   => esc_html__( 'Role', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html( 'client' ),

			]
		);
	}

	/**
	 * Register controls for this widget.
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
			'blockquote_text_css',
			[
				'label'     => esc_html__( 'Blockquote Text CSS Class', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'title'     => esc_html__( 'Add your custom class for text without the dot. e.g: my-class', 'mytravel-elementor' ),
				'condition' => [ 'enable_blockquote_icon' => 'yes' ],
				'separator' => 'after',
			]
		);
	}

	/**
	 * Register controls for this widget.
	 *
	 * @return void
	 */
	protected function register_style_controls() {
		parent::register_controls();

		$this->start_injection(
			[
				'at' => 'before',
				'of' => 'section_slides_style',
			]
		);

		$this->add_control(
			'blockquote',
			[
				'label' => esc_html__( 'Blockquote', 'mytravel-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'blockquote_text',
				'label'    => __( 'Blockquote Text', 'mytravel-elementor' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .js-slide blockquote',
			]
		);

		$this->add_control(
			'blockquote_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .js-slide blockquote' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'blockquote_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-blockquote' => 'background-color: {{VALUE}} !important;',
				],
				'condition' => [
					'enable_blockquote_icon' => 'yes',
				],
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
				'blockquote' => esc_html__( 'This is the 3rd time I’ve used Travelo website and telling you the truth their services are always realiable and it only takes few minutes to plan and finalize', 'mytravel-elementor' ),
				'avatar'     => [
					'url' => $placeholder_image_src,
				],
				'name'       => esc_html__( 'Ali Tufan ', 'mytravel-elementor' ),
				'role'       => esc_html__( 'client', 'mytravel-elementor' ),
			],
			[
				'blockquote' => esc_html__( 'This is the 3rd time I’ve used Travelo website and telling you the truth their services are always realiable and it only takes few minutes to plan and finalize', 'mytravel-elementor' ),
				'avatar'     => [
					'url' => $placeholder_image_src,
				],
				'name'       => esc_html__( 'Augusta Silva', 'mytravel-elementor' ),
				'role'       => esc_html__( 'client', 'mytravel-elementor' ),
			],
			[
				'blockquote' => esc_html__( 'This is the 3rd time I’ve used Travelo website and telling you the truth their services are always realiable and it only takes few minutes to plan and finalize', 'mytravel-elementor' ),
				'avatar'     => [
					'url' => $placeholder_image_src,
				],
				'name'       => esc_html__( 'Jessica Brown', 'mytravel-elementor' ),
				'role'       => esc_html__( 'client', 'mytravel-elementor' ),
			],
		];
	}

	/**
	 * Print the Blockquote.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_blockquote( array $slide, array $settings, $element_key ) {

		$text_css = [ 'mb-0', 'text-gray-1', 'font-italic', 'text-lh-inherit', ' js-slide blockquote' ];
		if ( $settings['blockquote_text_css'] ) {
			$text_css[] = $settings['blockquote_text_css'];
		}
		$this->add_render_attribute(
			'blockquote-text-' . $element_key,
			[
				'class' => $text_css,
			]
		);

		?>
		<p <?php $this->print_render_attribute_string( 'blockquote-text-' . $element_key ); ?>><?php echo esc_html( $slide['blockquote'] ); ?></p>
		<?php
	}

	/**
	 * Print the Blockquote Image.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_blockquote_image( array $slide, array $settings, $element_key ) {
		?>
			<figure class="testimonial-v1">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="56px" height="48px" fill="#EBF0F7" x="0px" y="0px" viewBox="0 0 56 48" style="enable-background:new 0 0 56 48;" xml:space="preserve" class="injected-svg myt-blockquote-icon js-svg-injector myt-blockquote " data-parent="#quotedd29fa6"> <g> <path class="st1" d="M11.9,39.7c-2.4-3.9-4-8.1-4.9-12.4C6.1,23.1,6,18.8,6.8,14.7c0.7-4.2,2.2-8.1,4.4-12c2.2-3.8,5.2-7.3,9-10.3 l5.8,3.5c1,0.7,1.4,1.5,1.4,2.4c-0.1,1-0.4,1.7-1,2.2c-1,1.3-2.1,2.9-3,5c-1,2.1-1.6,4.3-2,6.9c-0.4,2.5-0.3,5.3,0.1,8.2 c0.5,2.9,1.6,5.8,3.4,8.7c0.9,1.5,1.1,2.7,0.8,3.8c-0.4,1.1-1.2,1.8-2.5,2.3L11.9,39.7z M36.8,39.7c-2.4-3.9-4-8.1-4.9-12.4 c-0.9-4.3-0.9-8.5-0.2-12.7c0.7-4.2,2.2-8.1,4.4-12s5.2-7.3,9-10.3l5.8,3.5c1,0.7,1.4,1.5,1.3,2.4c-0.1,1-0.4,1.7-1,2.2 c-1.1,1.3-2.1,2.9-3,5c-1,2.1-1.6,4.3-2,6.9c-0.4,2.5-0.3,5.3,0.1,8.2c0.4,2.9,1.6,5.8,3.4,8.7c0.9,1.5,1.1,2.7,0.8,3.8 c-0.4,1.1-1.2,1.8-2.5,2.3L36.8,39.7z"></path> </g> </svg>
			</figure>
			<?php
	}

	/**
	 * Print the author.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_author_image( array $slide, array $settings, $element_key ) {

		$this->add_render_attribute(
			'avatar-' . $element_key,
			[
				'class'  => 'img-fluid rounded-circle',
				'src'    => $slide['avatar']['url'],
				'alt'    => $slide['name'],
				'width'  => '101',
				'height' => '101',
			]
		);
		?>
		<div class="card-img z-index-2 mb-3">
			<div class="ml-3">
				<img <?php $this->print_render_attribute_string( 'avatar-' . $element_key ); ?>>
			</div>
		</div>
		<?php
	}

	/**
	 * Print the author.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_author( array $slide, array $settings, $element_key ) {

		$this->add_render_attribute( 'name-' . $element_key, 'class', ' font-size-17 font-weight-bold text-gray-6 mb-0 ' );
		$this->add_render_attribute( 'role-' . $element_key, 'class', ' text-blue-lighter-1 font-size-normal ' );
		?>
		<h6 <?php $this->print_render_attribute_string( 'name-' . $element_key ); ?>><?php echo esc_html( $slide['name'] ); ?></h6>
		<span <?php $this->print_render_attribute_string( 'role-' . $element_key ); ?>><?php echo esc_html( $slide['role'] ); ?></span>
		<?php
	}


	/**
	 * Print the slide.
	 *
	 * @param array $slide the slides settings.
	 * @param array $settings the widget settings.
	 * @param array $element_key the element_key slider id.
	 * @return void
	 */
	public function print_slide( array $slide, array $settings, $element_key ) {

		?>
		<div class="card rounded-xs border-color-7 w-100">
			<div class="card-body p-5">
				<div class="d-flex justify-content-between align-items-baseline">
					<div class="mb-5">
						<?php $this->print_author( $slide, $settings, $element_key ); ?>
					</div>
					<?php $this->print_blockquote_image( $slide, $settings, $element_key ); ?>
				</div>
				<?php $this->print_blockquote( $slide, $settings, $element_key ); ?>
			</div>
			<?php $this->print_author_image( $slide, $settings, $element_key ); ?>
		</div>
		<?php
	}
}
