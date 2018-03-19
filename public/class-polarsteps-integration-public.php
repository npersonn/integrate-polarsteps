<?php

/**
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/public
 */

/**
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/public
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string $polarsteps_integration The ID of this plugin.
	 */
	private $polarsteps_integration;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 *
	 * @param      string $polarsteps_integration The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $polarsteps_integration, $version ) {

		$this->polarsteps_integration = $polarsteps_integration;
		$this->version                = $version;

	}

	/**
	 * Register the location widget
	 * @since 0.1.0
	 * @return void
	 */
	public function register_location_widget() {
		register_widget( get_class( new Polarsteps_Integration_Location_Widget() ) );
	}

	/**
	 * Get all persisted steps from Wordpress Db
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function get_all_steps() {
		$data_loader = new Polarsteps_Integration_Data_Loader();

		return $data_loader->get_all_steps();
	}

	/**
	 * Getting one specific step from Wordpress Db
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function get_step( $position ) {
		$data_loader = new Polarsteps_Integration_Data_Loader();

		return $data_loader->get_step( $position );
	}

	/**
	 * Updating Steps in Wordpress Db from Polarsteps API
	 * @since 0.1.0
	 * @return void
	 */
	public function update_steps() {
		$step_updater = new Polarsteps_Integration_Updater(
			new Polarsteps_Integration_Connector(),
			new Polarsteps_Integration_Data_Loader()
		);

		$step_updater->update();
	}

	/**
	 * Validating if a Username exists on Polarsteps API
	 *
	 * @since 0.3.4
	 *
	 * @param string $username
	 *
	 * @return bool
	 */
	public function validate_username( $username ) {
		$connector = new Polarsteps_Integration_Connector();

		return $connector->polarsteps_get_user_exists( $username );
	}


}
