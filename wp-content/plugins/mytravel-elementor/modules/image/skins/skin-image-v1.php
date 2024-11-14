<?php
namespace MyTravelElementor\Modules\Image\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Skin_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Plugin;
use Elementor\Control_Media;
use Elementor\Repeater;
use Elementor\Utils;
use MyTravelElementor\Core\Utils as MYTUtils;

/**
 * Skin Image Mytravel
 */
class Skin_Image_V1 extends Skin_Base {

	/**
	 * Constructor.
	 *
	 * @param Elementor\Widget_Base $parent The widget settings.
	 * @return void
	 */
	public function __construct( Elementor\Widget_Base $parent ) {
		parent::__construct( $parent );
		add_filter( 'elementor/widget/print_template', array( $this, 'skin_print_template' ), 10, 2 );
		add_action( 'elementor/element/image/section_image/before_section_end', [ $this, 'remove_style_controls' ], 10 );
	}

	/**
	 * Remove Image controls.
	 *
	 * @param Elementor\Widget_Base $widget The widget settings.
	 * @return void
	 */
	public function remove_style_controls( Elementor\Widget_Base $widget ) {

		$this->parent = $widget;

		$update_control_ids = [ 'align' ];

		foreach ( $update_control_ids as $update_control_id ) {
			$this->parent->update_control(
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
	 * Get the id of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'myt-image';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Style 1', 'mytravel-elementor' );
	}

	/**
	 * Check if the current widget has caption
	 *
	 * @param array $settings the widget settings.
	 *
	 * @return boolean
	 */
	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	/**
	 * Get the caption for current widget.
	 *
	 * @param array $settings the widget settings.
	 *
	 * @return string
	 */
	private function get_caption( $settings ) {
		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}
		return $caption;
	}
	/**
	 * Retrieve image widget link URL.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings Widget settings.
	 *
	 * @return array|string|false An array/string containing the link URL, or false if no link.
	 */
	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}

			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];
	}


	/**
	 * Render.
	 *
	 * @return void
	 */
	public function render() {

		$widget = $this->parent;

		$settings    = $widget->get_settings_for_display();
		$has_caption = $this->has_caption( $settings );
		$widget->add_render_attribute( 'wrapper', 'class', 'mb-5' );
		?>

		<div <?php $widget->print_render_attribute_string( 'wrapper' ); ?>>   
			<?php
			$settings['image_class'] = 'img-fluid position-50-horizontal';
			$img_css                 = $settings['image_class'];
			$link_class              = 'd-block position-50-hover text-center overflow-hidden';

			$link = $this->get_link_url( $settings );

			$widget->add_render_attribute(
				'link',
				[
					'class' => $link_class,
					'href'  => $link,
				]
			);

			$widget->add_render_attribute( 'caption-class', 'class', 'mb-0 font-size-17 font-weight-bold' );
			?>
			<?php if ( $link ) : ?>
				<a <?php echo $widget->get_render_attribute_string( 'link' ); //phpcs:ignore ?>>
			<?php else : ?>  
				<span class="<?php echo esc_attr( $link_class ); ?>">  
			<?php endif; ?>  
			<div class="bg-img-hero rounded-xs bg-gray-23 min-height-200">
				<?php if ( $has_caption ) : ?>
					<div class="pt-4 mb-5 widget-image-caption wp-caption-text">
						<h6 <?php echo $widget->get_render_attribute_string( 'caption-class' ); //phpcs:ignore ?>>
							<?php echo wp_kses_post( $this->get_caption( $settings ) ); ?>
						</h6>
					</div>
				<?php endif; ?>
				<?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
			</div>
			<?php if ( $link ) : ?>
				</a>
			<?php else : ?>
			</span>
			<?php endif; ?> 
		</div>
		<?php
	}


	/**
	 * Render the Image class and size..
	 *
	 * @param string $image_html image_html arguments.
	 * @param array  $img_classes attributes.
	 * @return string
	 */
	public function add_class_to_image_html( $image_html, $img_classes ) {
		if ( is_array( $img_classes ) ) {
			$str_class = implode( ' ', $img_classes );
		} else {
			$str_class = $img_classes;
		}

		if ( false === strpos( $image_html, 'class="' ) ) {
			$image_html = str_replace( '<img', '<img class="' . esc_attr( $str_class ) . '"', $image_html );
		} else {
			$image_html = str_replace( 'class="', 'class="' . esc_attr( $str_class ) . ' ', $image_html );
		}

		return $image_html;
	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $widget widget name.
	 * @return string
	 */
	public function skin_print_template( $content, $widget ) {
		if ( 'image' === $widget->get_name() ) {
			return '';
		}
		return $content;
	}
}
