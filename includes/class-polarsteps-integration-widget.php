<?php

/**
 * Showing a Widget with the most recent locations from polarsteps.
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration
 * @author     NPersonn <nick@personn.com>
 */

class Polarsteps_Integration_Location_Widget extends WP_Widget {

	/**
	 * Unique identifier for the polarsteps location widget.
	 *
	 * @since 0.1.2
	 *
	 * @var string
	 */
	protected $widget_slug = 'polarsteps-location';

	/**
	 * Polarsteps_Integration_Location_Widget constructor.
	 * @since 0.1.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'polarsteps_integration_location_widget',
			'description' => 'Showing the recent Location from Polarsteps Account',
		);

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );


		parent::__construct( 'polarsteps_integration_location_widget', 'Recent Location', $widget_ops );
	}

	/**
	 * @param $args
	 * @param $instance
	 *
	 * @since 0.1.0
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$last_step = apply_filters( 'polarsteps_get_step', 0 );

		echo '<h2>Recent Location</h2>';

		echo '<div class="polarsteps_widget">';

		echo '<div class="polarsteps_location_name">';
		echo '<b>' . esc_html__( $last_step['location_name'], 'text_domain' ) . '</b>';
		echo '</div>';

		if ( ! empty( $last_step['detail'] ) && ! empty( $last_step['location_country_code'] ) ) {
			echo '<div class="polarsteps_detail">';
			echo '<img class="polarsteps_country_flag" src="' . esc_html__( $this->get_flag_url( $last_step['location_country_code'] ) ) . '">';
			echo esc_html__( $last_step['detail'] );
			echo '</div>';
		}


		echo '<div class="polarsteps_start_time">';
		echo esc_html__( date( "F jS, Y", strtotime( $last_step['start_time'] ) ) );
		echo '</div>';

		echo '</div>';
		echo $args['after_widget'];
	}

	/**
	 * Return the widget slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    string Plugin slug variable.
	 */
	public function get_widget_slug() {

		return $this->widget_slug;
	}

	/**
	 * @since 0.1.2
	 *
	 * @param string $country_code representing a Country Code value
	 *
	 * @return string
	 */
	private function get_flag_url( $country_code = '00' ) {

		$country_code = strtolower( $country_code );

		return sprintf( 'https://s3-eu-west-1.amazonaws.com/polarsteps/assets/img/flags/%s.svg', $country_code );

	}

	/**
	 * @since 0.1.2
	 */
	public function register_widget_styles() {
		wp_enqueue_style( $this->get_widget_slug() . '-styles', plugin_dir_url( __FILE__ ) . 'styles/location-widget.css' );
	}

}