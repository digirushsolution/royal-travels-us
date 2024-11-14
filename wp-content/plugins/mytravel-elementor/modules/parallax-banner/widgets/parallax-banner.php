<?php
namespace MyTravelElementor\Modules\ParallaxBanner\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use MyTravelElementor\Base\Base_Widget;
use MyTravelElementor\Core\Controls_Manager as MYT_Controls_Manager;
use MyTravelElementor\Plugin;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Parallax Banner Mytravel Elementor Widget.
 */
class Parallax_Banner extends Base_Widget {
	/**
	 * Fetch the Scripts based on keyword.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'dzsparallaxer' ];
	}

	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-parallax-banner';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Parallax Banner', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-parallax';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'parallax', 'banner', 'parallax-banner' ];
	}

	/**
	 * Register Controls.
	 *
	 * @return void
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Content', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'   => esc_html__( 'Background Image', 'mytravel-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],

			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => esc_html__( 'Title', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Airbnb plus places to stay', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h5',
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'A selection of places to stay verified for quality and design', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'description_tag',
			[
				'label'   => esc_html__( 'Description HTML Tag', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'P',
				],
				'default' => 'p',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'   => esc_html__( 'Show Button', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button',
			[
				'label'     => esc_html__( 'Button', 'mytravel-elementor' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Stays', 'mytravel-elementor' ),
				'placeholder' => esc_html__( 'Click here', 'mytravel-elementor' ),
			]
		);

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
					'navy'      => esc_html__( 'Navy', 'mytravel-elementor' ),
					'light'     => esc_html__( 'Light', 'mytravel-elementor' ),
					'dark'      => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'      => esc_html__( 'Link', 'mytravel-elementor' ),
					'white'     => esc_html__( 'White', 'mytravel-elementor' ),
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
			'button_size',
			[
				'label'   => esc_html__( 'Size', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'xs'    => esc_html__( 'Small', 'mytravel-elementor' ),
					'sm'    => esc_html__( 'Extra Small', 'mytravel-elementor' ),
					''      => esc_html__( 'Default', 'mytravel-elementor' ),
					'lg'    => esc_html__( 'Large', 'mytravel-elementor' ),
					'block' => esc_html__( 'Block', 'mytravel-elementor' ),
					'wide'  => esc_html__( 'Wide', 'mytravel-elementor' ),
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
			'link',
			[
				'label'       => esc_html__( 'Link', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label'       => esc_html__( 'Button ID', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page   this form is displayed. This field allows A-z 0-9 & underscore chars without spaces.', 'mytravel-elementor' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Content Style Tab Start.

		$this->start_controls_section(
			'section_header_style',
			[
				'label' => esc_html__( 'Content', 'mytravel-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wrap_style',
			[
				'label' => esc_html__( 'Wraps', 'mytravel-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'bg_image_css',
			[
				'label' => esc_html__( 'BG Image Class', 'mytravel-elementor' ),
				'type'  => Controls_Manager::TEXT,
				'title' => esc_html__( 'Add your custom class for parallax. e.g: bg-hero', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'text_wrap',
			[
				'label'   => esc_html__( 'Wrap', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'title'   => esc_html__( 'Add your custom class for parallax. e.g: container,text-center', 'mytravel-elementor' ),
				'default' => 'container text-center space-2 space-md-3',
			]
		);

		$this->add_control(
			'space_wrap',
			[
				'label'   => esc_html__( 'Spacing Wrap', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'title'   => esc_html__( 'Add your custom class for parallax. e.g: container,text-center', 'mytravel-elementor' ),
				'default' => 'pb-3 mb-1 space-top-lg-1 mt-2',
			]
		);

		$this->add_control(
			'heading_heading_style',
			[
				'label'     => esc_html__( 'Title', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Title Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-parallax__heading' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .myt-parallax__heading',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'heading_class',
			[
				'label'   => esc_html__( 'Title Class', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'text-white font-size-40 font-weight-bold mb-1',
			]
		);

		$this->add_control(
			'description_style',
			[
				'label'     => esc_html__( 'Description', 'mytravel-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-parallax__description' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .myt-parallax__description',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'description_class',
			[
				'label'   => esc_html__( 'Descripton Class', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'text-white font-weight-normal mb-3 mb-lg-6',
			]
		);

		$this->end_controls_section();

		// Button Style Tab Start.

		$this->start_controls_section(
			'section_button_style',
			[
				'label'     => esc_html__( 'Button', 'mytravel-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_css_class',
			[
				'label' => esc_html__( 'Button CSS', 'mytravel-elementor' ),
				'type'  => Controls_Manager::TEXT,
				'title' => esc_html__( 'Add your custom class for button. e.g: card-active', 'mytravel-elementor' ),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Renders the Parallax Banner widget.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$bg_class = [ 'divimage dzsparallaxer--target' ];
		if ( $settings['bg_image_css'] ) {
			$bg_class[] = $settings['bg_image_css'];
		}

		$wrap_class = [ 'text-center' ];
		if ( $settings['text_wrap'] ) {
			$wrap_class[] = $settings['text_wrap'];
		}

		$space_wrap_class = [ 'myt_spacing' ];
		if ( $settings['space_wrap'] ) {
			$space_wrap_class[] = $settings['space_wrap'];
		}

		$title_class = [ 'myt-parallax__heading' ];
		if ( $settings['heading_class'] ) {
			$title_class[] = $settings['heading_class'];
		}

		$description_class = [ 'myt-parallax__description' ];
		if ( $settings['description_class'] ) {
			$description_class[] = $settings['description_class'];
		}

		$heading_tag    = $settings['heading_tag'];
		$descripton_tag = $settings['description_tag'];
		$this->add_render_attribute( 'bg_image', 'class', $bg_class );
		$this->add_render_attribute( 'wrap', 'class', $wrap_class );
		$this->add_render_attribute( 'space', 'class', $space_wrap_class );
		$this->add_render_attribute( 'title', 'class', $title_class );
		$this->add_render_attribute( 'desc', 'class', $description_class );
		?>
		<div class="banner-block banner-v6">
			<div class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll" data-options='{direction: "normal"}'>
				<!-- Apply your Parallax background image here -->
				<div <?php $this->print_render_attribute_string( 'bg_image' ); ?> style="height: 130%; background-image: url(<?php echo esc_html( $settings['background_image']['url'] ); ?>);"></div>
				<div <?php $this->print_render_attribute_string( 'wrap' ); ?>>
					<div <?php $this->print_render_attribute_string( 'space' ); ?>>
						<?php if ( ! empty( $settings['heading'] ) ) : ?>
							<<?php echo esc_html( $heading_tag ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo esc_html( $settings['heading'] ); ?></<?php echo esc_html( $heading_tag ); ?>>	
						<?php endif; ?>
						<?php if ( ! empty( $settings['description'] ) ) : ?>
							<<?php echo esc_html( $descripton_tag ); ?> <?php $this->print_render_attribute_string( 'desc' ); ?>><?php echo esc_html( $settings['description'] ); ?></<?php echo esc_html( $descripton_tag ); ?>>	
						<?php endif; ?>
						<?php $this->render_button( $settings ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
		$this->render_script();
	}

	/**
	 * Render the button.
	 *
	 * @param array $settings setting control.
	 */
	public function render_button( $settings ) {

		$button_classes = [ 'btn', 'myt-parallax__button' ];

		if ( ! empty( $settings['button_type'] ) ) {
			if ( '' === $settings['button_variant'] ) {
				$button_classes[] = 'btn-' . $settings['button_type'];
			} elseif ( 'soft' === $settings['button_variant'] ) {
				$button_classes[] = 'btn-' . $settings['button_type'] . '-' . $settings['button_variant'];
			} elseif ( 'outline' === $settings['button_variant'] ) {
				$button_classes[] = 'btn-' . $settings['button_variant'] . '-' . $settings['button_type'];
			}
		}

		if ( ! empty( $settings['button_css_class'] ) ) {
			$button_classes[] = $settings['button_css_class'];
		}

		if ( ! empty( $settings['button_size'] ) ) {
			$button_classes[] = 'btn-' . $settings['button_size'];
		}

		$this->add_render_attribute( 'button_text', 'class', $button_classes );

		$this->add_inline_editing_attributes( 'button_text' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'button_text', $settings['link'] );
		}

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button_text', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['button_text'] ) ) :
			?>
			<a <?php $this->print_render_attribute_string( 'button_text' ); ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
		<?php endif; ?>
		<?php
	}

	/**
	 * Render script in the editor.
	 */
	public function render_script() {

		if ( Plugin::elementor()->editor->is_edit_mode() ) :
			?>
			<script type="text/javascript">
				<?php get_template_directory_uri() . '/assets/vendor/dzsparallaxer/dzsparallaxer.js'; ?>
			</script>
			<?php
		endif;
	}
}
