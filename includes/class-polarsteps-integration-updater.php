<?php

/**
 * Updates Data into Polarsteps Table
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 */

/**
 * Updates the Polarsteps Data from API.
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Updater {

	/**
	 * @var wpdb
	 */
	private $wpdb;

	/**
	 * Tablename of Trips in Wpdb
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private $table_name;

	/**
	 * @var Polarsteps_Integration_Connector
	 */
	private $connector;

	/**
	 * @var Polarsteps_Integration_Data_Loader
	 */
	private $data_loader;

	/**
	 * Polarsteps_Integration_Updater constructor.
	 *
	 * @param Polarsteps_Integration_Connector $connector
	 * @param Polarsteps_Integration_Data_Loader $data_loader
	 *
	 * @since 0.1.0
	 */
	public function __construct( Polarsteps_Integration_Connector $connector, Polarsteps_Integration_Data_Loader $data_loader ) {

		global $wpdb;
		global $polarsteps_table_name;

		$this->wpdb        = $wpdb;
		$this->table_name  = $polarsteps_table_name;
		$this->connector   = $connector;
		$this->data_loader = $data_loader;
	}

	/**
	 * Update the steps from Polarsteps API
	 * If not already existing create new, if incomplete update incomplete
	 *
	 * @since    0.1.0
	 */
	public function update() {

		$steps          = $this->connector->polarsteps_get_step_data();
		$existing_steps = $this->data_loader->get_all_steps();

		if ( ! is_array( $steps ) ) {
			return;
		}

		$is_existing   = false;
		$is_incomplete = false;
		foreach ( $steps as $step ) {

			foreach ( $existing_steps as $existing_step ) {
				if ( isset( $existing_step['uuid'] ) && $step['uuid'] == $existing_step['uuid'] ) {
					$is_existing = true;

					if ( empty ( $existing_step['location_name'] ) ) {
						$is_incomplete = true;
					}
				}
			}

			if ( ! $is_existing ) {

				$this->wpdb->insert(
					$this->table_name,
					$step
				);
			} else {

				if ( $is_incomplete ) {

					$this->wpdb->update(
						$this->table_name,
						$step,
						[ 'uuid' => $step['uuid'] ]
					);
				}

				$is_incomplete = false;
				$is_existing   = false;
			}

		}
	}
}
