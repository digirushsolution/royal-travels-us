<?php
namespace MyTravelElementor\Modules\TeamMember\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use MyTravelElementor\Base\Base_Widget;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Control_Media;
use MyTravelElementor\Core\Controls_Manager as MYT_Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Team Member Mytravel Elementor Widget.
 */
class Team_Member extends Base_Widget {
	/**
	 * Get the name of the widget.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'myt-team-member';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Team Member', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	/**
	 * Get the keywords associated with the widget.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'team', 'member' ];
	}

	/**
	 * Register controls for this widget.
	 */
	protected function register_controls() {

		$this->team_member_general_controls_content_tab();
		$this->team_member_general_controls_style_tab();

	}

	/**
	 * Register controls for this widget content tab.
	 */
	public function team_member_general_controls_content_tab() {

		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'team_author_image',
			[
				'label'   => esc_html__( 'Choose Image', 'mytravel-elementor' ),
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
			'team_image_class',
			[
				'label'       => esc_html__( 'Image Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Your Class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Additional CSS class that you want to apply to the <img> tag', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Name', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Author Name', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'position',
			[
				'label'   => esc_html__( 'Position', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Position', 'mytravel-elementor' ),
			]
		);

		$default_icon = [
			'value' => 'fab fa-facebook-f',
		];

		$repeater = new Repeater();

		$repeater->add_control(
			'selected_item_icon',
			[
				'label'   => esc_html__( 'Social Icon', 'mytravel-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => $default_icon,
			]
		);

		$repeater->add_control(
			'selected_icon_class',
			[
				'label'       => esc_html__( 'Social Icon Link Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Your Class', 'mytravel-elementor' ),
				'description' => esc_html__( 'Additional CSS class that you want to apply to the <a> tag', 'mytravel-elementor' ),
			]
		);

		$repeater->add_control(
			'icon_link',
			[
				'label'       => esc_html__( 'Social Icon Link', 'mytravel-elementor' ),
				'placeholder' => esc_html__( 'https://your-link.com', 'mytravel-elementor' ),
				'type'        => Controls_Manager::URL,
			]
		);

		$this->add_control(
			'team_member_icons',
			[
				'label'     => esc_html__( 'Social Icons', 'mytravel-elementor' ),
				'type'      => \Elementor\Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'default'   => $this->get_repeater_defaults(),
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register controls for this widget style tab.
	 */
	public function team_member_general_controls_style_tab() {

		$this->start_controls_section(
			'section_general_style',
			[
				'label'      => esc_html__( 'Image Overlay', 'mytravel-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);
		$this->add_control(
			'team_card_hover_background_color',
			[
				'label'     => esc_html__( 'Avatar image Hover Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .u-avatar-image-overlay' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label'      => esc_html__( 'Icon', 'mytravel-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs( 'tabs_style' );

		$this->start_controls_tab(
			'icon_normal',
			[
				'label' => esc_html__( 'Normal', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'social_icon_color',
			[
				'label'     => esc_html__( 'Social Icon Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-team_member__icon_wrap' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_icon_color_hover',
			[
				'label'     => esc_html__( 'Social Icon Hover Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-team_member__icon_wrap:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_icon_bg_color_hover',
			[
				'label'     => esc_html__( 'Social Icon Hover Background Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-team_member__icon_wrap:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'icon_typography',
				'selector' =>
					'{{WRAPPER}} .myt-team_member__icon_wrap',

			]
		);

		$this->end_controls_tab();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label'      => esc_html__( 'Content', 'mytravel-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'title_class',
			[
				'label'       => esc_html__( 'Title Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Your Class', 'mytravel-elementor' ),
				'default'     => 'font-size-17 font-weight-bold text-gray-11 mb-0',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-elementor__title_name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' =>
					'{{WRAPPER}} .myt-elementor__title_name',
			]
		);

		$this->add_control(
			'position_class',
			[
				'label'       => esc_html__( 'Postion Class', 'mytravel-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Your Class', 'mytravel-elementor' ),
				'separator'   => 'before',
				'default'     => 'text-blue-lighter-1 font-size-normal',
			]
		);

		$this->add_control(
			'byline_color',
			[
				'label'     => esc_html__( 'Byline Color', 'mytravel-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .myt-elementor__position' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'byline_typography',
				'selector' =>
					'{{WRAPPER}} .myt-elementor__position',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Icons defaults.
	 *
	 * @return string
	 */
	protected function get_repeater_defaults() {

		return [
			[
				'selected_item_icon' => [
					'value' => 'fab fa-facebook-f',
				],
			],
			[
				'selected_item_icon' => [
					'value' => 'fab fa-twitter',
				],
			],
			[
				'selected_item_icon' => [
					'value' => 'fab fa-instagram',
				],
			],
		];
	}

	/**
	 * Renders Team member widget.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$image_url   = $settings['team_author_image']['url'];
		$image_class = [];
		if ( $settings['team_image_class'] ) {
			$image_class[] = $settings['team_image_class'];
		}

		$this->add_render_attribute(
			'wrap_class',
			[
				'class' => [ 'mytravel-team-member' ],
			]
		);

		$this->add_render_attribute(
			'image_attribute',
			[
				'class' => $image_class,
				'src'   => $image_url,
				'alt'   => Control_Media::get_image_alt( $settings['team_author_image'] ),
			]
		);

		$this->add_render_attribute(
			'icon_list',
			[
				'class' => [ 'position-relative', 'd-flex', 'zindex-2' ],
			]
		);

		$title_class    = $settings['title_class'];
		$position_class = $settings['position_class'];

		$this->add_render_attribute(
			'title_attribute',
			[
				'class' => [ $title_class, 'myt-elementor__title_name' ],
			]
		);

		$this->add_render_attribute(
			'byline_attribute',
			[
				'class' => [ $position_class, 'myt-elementor__position' ],
			]
		);

		?>
		<div <?php $this->print_render_attribute_string( 'wrap_class' ); ?>>
			<div class="pb-3">
				<figure class="d-inline-block u-avatar-image rounded-circle overflow-hidden">
					<div class="u-avatar-image-overlay">
							<ul class="u-avatar-image-social list-unstyled m-0 w-100 h-100">
								<?php
								foreach ( $settings['team_member_icons'] as $index => $item ) :
									$count = $index + 1;

									$icon_link_class = $item['icon_link'];
									$icon_class      = $item['selected_icon_class'];

									$this->add_render_attribute(
										'icon_list_item' . $count,
										[
											'class' => [ 'btn', 'btn-icon', 'btn-medium', 'btn-soft-white', 'btn-bg-transparent', 'transition-3d-hover', 'rounded-circle', $icon_class, 'myt-team_member__icon_wrap' ],
											'href'  => $icon_link_class,
										]
									);

									$icon = [ 'myt-team_member__icon', 'btn-icon__inner' ];

									if ( $item['selected_item_icon']['value'] ) {
										$icon[] = $item['selected_item_icon']['value'];
									}

									$this->add_render_attribute(
										'list_icon' . $count,
										[
											'class' => $icon,
										]
									);

									?>
									<li>
										<a <?php $this->print_render_attribute_string( 'icon_list_item' . $count ); ?>>
											<i <?php $this->print_render_attribute_string( 'list_icon' . $count ); ?>></i>
										</a>
									</li>
									<?php
									endforeach;
								?>
							</ul>
					</div>
					<img <?php $this->print_render_attribute_string( 'image_attribute' ); ?>>
				</figure>
			</div>
			<?php
			if ( ! empty( $settings['title'] ) ) {
				?>
				<h6 <?php $this->print_render_attribute_string( 'title_attribute' ); ?>><?php echo esc_html( $settings['title'] ); ?></h6>
				<?php
			}
			?>

			<?php if ( ! empty( $settings['position'] ) ) { ?>
				<span <?php $this->print_render_attribute_string( 'byline_attribute' ); ?>><?php echo esc_html( $settings['position'] ); ?></span>
				<?php
			}
			?>
	
		</div>

		<?php
	}

}
