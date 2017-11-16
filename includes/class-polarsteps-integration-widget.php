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
	 * Polarsteps_Integration_Location_Widget constructor.
	 * @since 0.1.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'polarsteps_integration_location_widget',
			'description' => 'Showing the recent Location from Polarsteps Account',
		);
		parent::__construct( 'polarsteps_integration_location_widget', 'Recent Location', $widget_ops );
	}

	/**
	 * @param $args
	 * @param $instance
	 * @since 0.1.0
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$last_step = apply_filters('polarsteps_get_step', 0 );

		echo '<h2>Recent Location</h2>';

		echo '<div class="polarsteps_widget">';

		echo '<div class="polarsteps_location_name">';
		echo 'Location: ' . esc_html__( $last_step['location_name'], 'text_domain' );
		echo '</div>';

		if ( ! empty( $last_step['detail'] ) ) {
			echo '<div class="polarsteps_detail">';
			echo 'Country: ' . esc_html__( $last_step['detail'] );
			echo '</div>';
		}

		echo '<div class="polarsteps_start_time">';
		echo esc_html__( $last_step['start_time'] );
		echo '</div>';

		echo '</div>';
		echo $args['after_widget'];
	}
}