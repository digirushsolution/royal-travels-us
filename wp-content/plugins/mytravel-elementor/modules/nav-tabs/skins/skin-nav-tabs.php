<?php

namespace MyTravelElementor\Modules\NavTabs\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Skin_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use MyTravelElementor\Plugin;
use Elementor\Group_Control_Image_Size;

/**
 * Skin Nav Tabs.
 */
class Skin_Nav_Tabs extends Skin_Base {

	/**
	 * Get the id of the skin.
	 *
	 * @return string.
	 */
	public function get_id() {
		return 'myt-nav-tabs-skin';
	}

	/**
	 * Get the title of the skin.
	 *
	 * @return string.
	 */
	public function get_title() {
		return esc_html__( 'Nav Tabs v1', 'mytravel-elementor' );
	}

	/**
	 * Register Control Actions in the skin.
	 *
	 * @return void.
	 */
	protected function _register_controls_actions() {
		add_filter( 'mytravel-elementor/widget/myt-nav-tabs/print_template', [ $this, 'skin_print_template' ], 10, 2 );
	}

	/**
	 * Skin print template.
	 *
	 * @param array $content the content.
	 * @param array $widget widget name.
	 * @return string.
	 */
	public function skin_print_template( $content, $widget ) {
		if ( 'skin_nav-tabs' === $widget->get_name() ) {
			return '';
		}
		return $content;
	}

	/**
	 * Render.
	 *
	 * @return void.
	 */
	public function render() {
		$widget   = $this->parent;
		$settings = $widget->get_settings_for_display();
		$id_int   = substr( $widget->get_id_int(), 0, 3 );

		?>
		<div class="tab-wrapper shadow-none">
			<ul class="nav flex-column mb-0 tab-nav-list" id="pills-<?php echo esc_attr( $id_int ); ?>" role="tablist">
				<?php
				foreach ( $settings['nav_tabs'] as $index => $item ) :
					$count    = $index + 1;
					$active   = '';
					$selected = 'false';

					$widget->add_render_attribute(
						'list_item' . $count,
						[
							'class' => [ 'nav-item', 'mx-0', 'mb-2', 'pb-1', 'myt-elementor__tab' ],
						]
					);

					if ( 1 === $count ) {
						$active   = 'active';
						$selected = 'true';
						$widget->add_render_attribute( 'list_link' . $count, 'class' );
					}

					$widget->add_render_attribute(
						'list_link' . $count,
						[
							'class'         => array( 'nav-link', 'px-4', 'd-flex', 'align-items-center', $active ),
							'id'            => 'nav-' . $item['content_id'],
							'data-toggle'   => 'pill',
							'data-target'   => '#' . $item['content_id'],
							'href'          => '#',
							'role'          => 'tab',
							'aria-controls' => 'nav-' . $item['content_id'],
							'aria-selected' => $selected,
						]
					);

					?>
					<li <?php $widget->print_render_attribute_string( 'list_item' . $count ); ?>>
						<a <?php $widget->print_render_attribute_string( 'list_link' . $count ); ?>>
							<i class="myt-elementor__icon fas fa-chevron-right font-size-12 mr-1 text-gray-3"></i>
							<span class="font-weight-normal ml-1 text-gray-1"><?php echo esc_html( $item['list'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}
