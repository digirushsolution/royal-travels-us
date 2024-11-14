<?php
namespace MyTravelElementor\Modules\Posts\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Grid v1 Skin class.
 */
class Skin_Post_Grid extends Skin_Base {

	/**
	 * Get the ID of the skin.
	 *
	 * @return string
	 */
	public function get_id() {
		return 'grid';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Grid', 'mytravel-elementor' );
	}

	/**
	 * Render loop header.
	 */
	protected function render_loop_header() {
		$this->parent->add_render_attribute( 'container', array( 'class' => 'row' ) );
		parent::render_loop_header();
	}

	/**
	 * Render loop post.
	 */
	public function render_post() {
		$widget     = $this->parent;
		$settings   = $widget->get_settings_for_display();
		$columns    = ! empty( $settings['columns'] ) ? 12 / intval( $settings['columns'] ) : 3;
		$wrap_class = $settings['additional_class'];

		?>
		<div class="mt-article col-md-6 col-lg-<?php echo esc_attr( $columns ); ?> <?php echo esc_attr( $wrap_class ); ?>">
			<?php
				get_template_part( 'templates/contents/content', 'grid' );
			?>
		</div>
		<?php
	}
}
