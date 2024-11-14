<?php
namespace MyTravelElementor\Modules\Search\Widgets;

use MyTravelElementor\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Search module class
 */
class Search extends Base_Widget {

	/**
	 * Return the name of the module.
	 *
	 * @return string.
	 */
	public function get_name() {
		return 'myt-search';
	}

	/**
	 * Get the title of the widget.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Search', 'mytravel-elementor' );
	}

	/**
	 * Get the icon for the widget.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-search';
	}

	/**
	 * Register controls for this widget.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'search_content',
			[
				'label' => esc_html__( 'Search Form', 'mytravel-elementor' ),
			]
		);

		$search_options = [
			'hotel'      => esc_html__( 'Hotel', 'mytravel-elementor' ),
			'tour'       => esc_html__( 'Tour', 'mytravel-elementor' ),
			'activity'   => esc_html__( 'Activity', 'mytravel-elementor' ),
			'rental'     => esc_html__( 'Rental', 'mytravel-elementor' ),
			'car_rental' => esc_html__( 'Car Rental', 'mytravel-elementor' ),
			'yacht'      => esc_html__( 'Yacht', 'mytravel-elementor' ),
		];

		$this->add_control(
			'skin',
			[
				'label'              => esc_html__( 'Search', 'mytravel-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'hotel',
				'options'            => $search_options,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'enable_destination',
			[
				'label'   => esc_html__( 'Enable Destination', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);

		$this->add_control(
			'destination_label',
			[
				'label'     => esc_html__( 'Destination Label', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Destination or Hotel Name', 'mytravel-elementor' ),
				'condition' => [
					'enable_destination' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_date_picker',
			[
				'label'     => esc_html__( 'Enable Date Picker', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'skin' => 'hotel',
				],
			]
		);

		$this->add_control(
			'date_picker_label',
			[
				'label'     => esc_html__( 'Date Picker Label', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Check In - Out', 'mytravel-elementor' ),
				'condition' => [
					'skin'               => 'hotel',
					'enable_date_picker' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_vacancy_info',
			[
				'label'     => esc_html__( 'Enable Rooms Vacancy', 'mytravel-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'skin' => 'hotel',
				],

			]
		);

		$this->add_control(
			'room_vacancy_label',
			[
				'label'     => esc_html__( 'Room Vacancy Label', 'mytravel-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Rooms and Guests', 'mytravel-elementor' ),
				'condition' => [
					'skin'                => 'hotel',
					'enable_vacancy_info' => 'yes',
				],
			]
		);

		$this->add_control(
			'btn_txt',
			[
				'label'   => esc_html__( 'Button Text', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Search', 'mytravel-elementor' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'   => esc_html__( 'Color', 'mytravel-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => [
					'primary' => esc_html__( 'Primary', 'mytravel-elementor' ),
					'success' => esc_html__( 'Success', 'mytravel-elementor' ),
					'danger'  => esc_html__( 'Danger', 'mytravel-elementor' ),
					'warning' => esc_html__( 'Warning', 'mytravel-elementor' ),
					'info'    => esc_html__( 'Info', 'mytravel-elementor' ),
					'dark'    => esc_html__( 'Dark', 'mytravel-elementor' ),
					'link'    => esc_html__( 'Link', 'mytravel-elementor' ),
					'white'   => esc_html__( 'White', 'mytravel-elementor' ),
					'purple'  => esc_html__( 'Purple', 'mytravel-elementor' ),
				],
			]
		);

		$this->add_control(
			'button_css',
			[
				'label'   => esc_html__( 'Button CSS', 'mytravel-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'w-100 border-radius-3 mb-xl-0 mb-lg-1',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register hotel filter.
	 */
	protected function render_filter() {
		global $product;
		$settings       = $this->get_settings();
		$action         = home_url( '/' );
		$skin           = $settings['skin'];
		$product_format = mytravel_get_product_format();

		$destination_label  = $settings['destination_label'];
		$date_picker_label  = $settings['date_picker_label'];
		$room_vacancy_label = $settings['room_vacancy_label'];
		$button_color       = $settings['button_color'];
		$btn_txt            = $settings['btn_txt'];
		$btn_classes        = 'btn transition-3d-hover';
		$button_css         = $settings['button_css'];
		if ( ! empty( $button_css ) ) {
			$btn_classes .= ' ' . $button_css;
		}
		$taxonomy = mytravel_get_location_taxonomy();
		$taxonomy_name = apply_filters( 'mytravel_search_taxonomy_name', 'filter_locations' );

		if ( 'hotel' === $skin ) {
			if ( 'yes' !== $settings['enable_date_picker'] && 'yes' !== $settings['enable_vacancy_info'] ) {
				$wrap_class = 'col-sm-12 col-lg mb-4 mb-xl-0';
			} else {
				$wrap_class = 'col-sm-12 col-lg-3dot6 col-xl-3gdot5 mb-4 mb-xl-0';
			}
		} else {
			$wrap_class = 'col-sm-12 col-lg mb-4 mb-xl-0';
		}

		?>

		<div class="search_vacancy row d-block nav-select d-lg-flex mb-lg-3 px-2 px-lg-3 align-items-end">
			<?php if ( $settings['enable_destination'] ) { ?>
				<div class="<?php echo esc_attr( $wrap_class ); ?>">
					<span class="d-block text-gray-1 font-weight-normal text-left mb-0">
						<?php echo esc_html( $destination_label ); ?>
					</span>
					<?php
					if ( function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated() ) {
						wp_dropdown_categories(
							array(
								'class'       => 'js-select selectpicker dropdown-select tab-dropdown col-12 pl-0 flaticon-pin-1 d-flex align-items-center text-primary font-weight-semi-bold',
								'taxonomy'    => $taxonomy,
								'id'          => 'location-dropdown-' . esc_attr( $skin ) . '',
								'name'        => $taxonomy_name,
								'value_field' => 'slug',
							)
						);
					}
					?>
				</div>
			<?php } ?>

			<?php
			if ( 'hotel' === $skin ) {
				if ( $settings['enable_date_picker'] ) {
					?>
				<div class="col-sm-12 col-lg-3dot7 col-xl-3gdot5 mb-4 mb-xl-0 mytravel-elementor-date-picker">
					<span class="d-block text-gray-1 font-weight-normal text-left mb-0">
						<?php echo esc_html( $date_picker_label ); ?>
					</span>
					<div class="border-bottom border-width-2 border-color-1">
						<?php mytravel_input_datepicker(); ?>
					</div>
				</div>
				<?php } ?>

				<?php if ( $settings['enable_vacancy_info'] ) { ?>
				<div class="col-sm-12 col-lg-4 col-xl-3 mb-4 mb-xl-0 dropdown-custom">
					<span class="d-block text-gray-1 font-weight-normal text-left mb-0">
						<?php echo esc_html( $room_vacancy_label ); ?>
					</span>
					<?php mytravel_guests_picker(); ?>
				</div>
					<?php
				}
			}
			?>

			<div class="col-sm-12 col-xl-2 pr-0 align-self-lg-end text-md-right">
				<button type="submit" class="btn-<?php echo esc_attr( $button_color ); ?> <?php echo esc_attr( $btn_classes ); ?>">
					<i class="flaticon-magnifying-glass font-size-20 mr-1"></i>
						<?php echo esc_html( $btn_txt ); ?>
				</button>
			</div>
		</div>
		<?php
	}

	/**
	 * Register hotel filter.
	 *
	 * @param string $destination_label Destination Label.
	 * @param string $date_picker_label Date picker Label.
	 * @param string $room_vacancy_label Room vacancy Label.
	 * @param string $button_color Button color.
	 * @param string $btn_classes Button classes.
	 * @param string $button_css Button CSS.
	 */
	protected function render_hotel_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css ) {
		$settings = $this->get_settings();
		$action   = home_url( '/' );
		$skin     = $settings['skin']
		?>
		<div class="card border-0 tab-shadow">
			<div class="card-body">
				<form class="product_filters" method="get" action="<?php echo esc_url( $action ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="product_format" value="product-format-hotel" />
					<?php $this->render_filter(); ?>
				</form>
			</div>
		</div>	
		<?php
	}

	/**
	 * Register tour filter.
	 *
	 * @param string $destination_label Destination Label.
	 * @param string $date_picker_label Date picker Label.
	 * @param string $room_vacancy_label Room vacancy Label.
	 * @param string $button_color Button color.
	 * @param string $btn_classes Button classes.
	 * @param string $button_css Button CSS.
	 */
	protected function render_tour_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css ) {
		$settings = $this->get_settings();
		$action   = home_url( '/' );
		$skin     = $settings['skin'];
		?>
		<div class="card border-0 tab-shadow">
			<div class="card-body">
				<form class="product_filters" method="get" action="<?php echo esc_url( home_url() ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="product_format" value="product-format-tour" />
					<?php $this->render_filter(); ?>
				</form>
			</div>
		</div>
		<?php

	}

	/**
	 * Register activity filter.
	 *
	 * @param string $destination_label Destination Label.
	 * @param string $date_picker_label Date picker Label.
	 * @param string $room_vacancy_label Room vacancy Label.
	 * @param string $button_color Button color.
	 * @param string $btn_classes Button classes.
	 * @param string $button_css Button CSS.
	 */
	protected function render_activity_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css ) {
		$settings = $this->get_settings();
		$action   = home_url( '/' );
		$skin     = $settings['skin'];

		?>
		<div class="card border-0 tab-shadow">
			<div class="card-body">
				<form class="product_filters" method="get" action="<?php echo esc_url( $action ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="product_format" value="product-format-activity" />
					<?php $this->render_filter(); ?>
				</form>
			</div>
		</div>
		<?php

	}

	/**
	 * Register rental filter.
	 *
	 * @param string $destination_label Destination Label.
	 * @param string $date_picker_label Date picker Label.
	 * @param string $room_vacancy_label Room vacancy Label.
	 * @param string $button_color Button color.
	 * @param string $btn_classes Button classes.
	 * @param string $button_css Button CSS.
	 */
	protected function render_rental_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css ) {
		$settings = $this->get_settings();
		$action   = home_url( '/' );
		$skin     = $settings['skin'];

		?>
		<div class="card border-0 tab-shadow">
			<div class="card-body">
				<form class="product_filters" method="get" action="<?php echo esc_url( $action ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="product_format" value="product-format-rental" />
					<?php $this->render_filter(); ?>
				</form>
			</div>
		</div>
		<?php

	}

	/**
	 * Register car rental filter.
	 *
	 * @param string $destination_label Destination Label.
	 * @param string $date_picker_label Date picker Label.
	 * @param string $room_vacancy_label Room vacancy Label.
	 * @param string $button_color Button color.
	 * @param string $btn_classes Button classes.
	 * @param string $button_css Button CSS.
	 */
	protected function render_car_rental_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css ) {
		$settings = $this->get_settings();
		$action   = home_url( '/' );
		$skin     = $settings['skin'];

		?>
		<div class="card border-0 tab-shadow">
			<div class="card-body">
				<form class="product_filters" method="get" action="<?php echo esc_url( $action ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="product_format" value="product-format-car_rental" />
					<?php $this->render_filter(); ?>
				</form>
			</div>
		</div>
		<?php

	}

	/**
	 * Register yacht filter.
	 *
	 * @param string $destination_label Destination Label.
	 * @param string $date_picker_label Date picker Label.
	 * @param string $room_vacancy_label Room vacancy Label.
	 * @param string $button_color Button color.
	 * @param string $btn_classes Button classes.
	 * @param string $button_css Button CSS.
	 */
	protected function render_yacht_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css ) {
		$settings = $this->get_settings();
		$action   = home_url( '/' );
		$skin     = $settings['skin'];

		?>
		<div class="card border-0 tab-shadow">
			<div class="card-body">
				<form class="product_filters" method="get" action="<?php echo esc_url( $action ); ?>">
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="product_format" value="product-format-yacht" />
					<?php $this->render_filter(); ?>
				</form>
			</div>
		</div>
		<?php

	}

	/**
	 * Render Search Widget.
	 */
	protected function render() {
		$settings           = $this->get_settings();
		$skin               = $settings['skin'];
		$destination_label  = $settings['destination_label'];
		$date_picker_label  = $settings['date_picker_label'];
		$room_vacancy_label = $settings['room_vacancy_label'];
		$button_color       = $settings['button_color'];
		$btn_txt            = $settings['btn_txt'];
		$btn_classes        = 'btn transition-3d-hover';
		$button_css         = $settings['button_css'];

		if ( ! empty( $button_css ) ) {
			$btn_classes .= ' ' . $button_css;
		}

		if ( function_exists( 'mytravel_is_woocommerce_activated' ) && mytravel_is_woocommerce_activated() ) {
			$taxonomy = mytravel_get_location_taxonomy();

			if ( ! taxonomy_exists( $taxonomy ) ) {
				return;
			}
			if ( 'yacht' === $skin ) {
				$this->render_yacht_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css );
			} elseif ( 'car_rental' === $skin ) {
				$this->render_car_rental_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css );
			} elseif ( 'rental' === $skin ) {
				$this->render_rental_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css );
			} elseif ( 'activity' === $skin ) {
				$this->render_activity_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css );
			} elseif ( 'tour' === $skin ) {
				$this->render_tour_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css );
			} elseif ( 'hotel' === $skin ) {
				$this->render_hotel_filter( $destination_label, $date_picker_label, $room_vacancy_label, $button_color, $btn_classes, $button_css );
			}
		} else {
			?>
			<div class="card border-0 tab-shadow">
				<div class="card-body">
					<form role="search" method="get" class="search-form input-group input-group-borderless" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<!-- Input -->
						<div class="js-focus-state w-100">
							<div class="input-group border border-color-8 border-width-2 rounded d-flex align-items-center">
								<input type="text" class="form-control font-size-14 placeholder-1 ml-1" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'mytravel-elementor' ); ?>" value="<?php echo get_search_query(); ?>" name="s"
								title="<?php echo esc_attr_x( 'Search for:', 'label', 'mytravel-elementor' ); ?>">
								<input type="hidden" class="form-control" name="post_type" value="post">

								<div class="input-group-append">
									<span class="input-group-text">
										<i class="flaticon-magnifying-glass-1 font-size-20 text-gray-8 mr-1"></i>
									</span>
								</div>
							</div>
						</div>
						<!-- End Input -->
					</form>
				</div>
			</div>
			<?php
		}
	}
}
