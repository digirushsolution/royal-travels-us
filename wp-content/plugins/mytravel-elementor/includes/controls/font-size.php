<?php
namespace MyTravelElementor\Includes\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Base_Data_Control;
/**
 * Control Font Size class
 */
class Control_Font_Size extends Base_Data_Control {
	/**
	 * Get type
	 */
	public function get_type() {
		return 'font_size';
	}
	/**
	 * Get sizes
	 *
	 * @return array
	 */
	public static function get_sizes() {
		$font_sizes = [
			'default'             => esc_html__( 'Default', 'mytravel-elementor' ),
			'display-1'           => esc_html__( 'Display 1', 'mytravel-elementor' ),
			'display-2'           => esc_html__( 'Display 2', 'mytravel-elementor' ),
			'display-3'           => esc_html__( 'Display 3', 'mytravel-elementor' ),
			'display-4'           => esc_html__( 'Display 4', 'mytravel-elementor' ),
			'font-size-1'         => esc_html__( 'fs-1', 'mytravel-elementor' ),
			'font-size-2'         => esc_html__( 'fs-2', 'mytravel-elementor' ),
			'font-size-3'         => esc_html__( 'fs-3', 'mytravel-elementor' ),
			'font-size-4'         => esc_html__( 'fs-4', 'mytravel-elementor' ),
			'font-size-5'         => esc_html__( 'fs-5', 'mytravel-elementor' ),
			'font-size-md-down-3' => esc_html__( 'fs-md-3', 'mytravel-elementor' ),
			'font-size-md-down-5' => esc_html__( 'fs-md-5', 'mytravel-elementor' ),
			'h1'                  => esc_html__( 'h1', 'mytravel-elementor' ),
			'h2'                  => esc_html__( 'h2', 'mytravel-elementor' ),
			'h3'                  => esc_html__( 'h3', 'mytravel-elementor' ),
			'h4'                  => esc_html__( 'h4', 'mytravel-elementor' ),
			'h5'                  => esc_html__( 'h5', 'mytravel-elementor' ),
			'h6'                  => esc_html__( 'h6', 'mytravel-elementor' ),
		];

		$additional_sizes = apply_filters( 'mytravel-elementor/controls/lk-font-size/font_size_options', [] );

		return array_merge( $font_sizes, $additional_sizes );
	}
	/**
	 * Return content template
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<select id="<?php echo esc_attr( $control_uid ); ?>" data-setting="{{ data.name }}">
					<?php foreach ( static::get_sizes() as $key => $size ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $size ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
