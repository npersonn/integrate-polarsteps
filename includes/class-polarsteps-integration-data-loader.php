<?php

/**
 * Loads Polarsteps Data from Wordpress Db
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 */

/**
 * Loading Trip Data
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Data_Loader {

	/**
	 * @since 0.1.0
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
	 * Polarsteps_Integration_Data_Loader constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		global $wpdb;
		global $polarsteps_table_name;

		$this->wpdb       = $wpdb;
		$this->table_name = $polarsteps_table_name;
	}

	/*
	 * Getting all persisted steps from wordpress db
	 * @since 0.1.0
	 * @return array
	 */
	public function get_all_steps() {

		return $this->wpdb->get_results( sprintf( 'SELECT * FROM %s ORDER BY id DESC', $this->table_name ), ARRAY_A );
	}

	/*
	 * Getting last recent step from wordpress db
	 * @since 0.1.0
	 * @return array
	 */
	public function get_step( $position ) {
		$all_steps = $this->get_all_steps();

		if ( ! empty( $all_steps ) ) {
			$step = $all_steps[ $position ] ?: [];
			$step['deep_link'] = $this->create_deeplink( $step );

			return $step;
		}

		return [];
	}

	/**
	 * @since 0.2.0
	 *
	 * @param array $step
	 *
	 * @return string|false
	 */
	private function create_deeplink( array $step ) {
		$trip_id   = get_option( 'polarsteps_trip_legacy_id' );
		$trip_slug = get_option( 'polarsteps_trip_slug' );
		$username  = get_option( 'polarsteps_username' );

		if (
			! empty( $trip_id )
			&& ! empty( $trip_slug )
			&& ! empty( $username )
			&& ! empty( $step['legacy_id'] )
			&& ! empty( $step['slug'] )
			&& ! empty( $step['uuid'] )
		) {
			return sprintf( 'https://www.polarsteps.com/%s/%s-%s/%s-%s/?s=%s',
				$username,
				$trip_id,
				$trip_slug,
				$step['legacy_id'],
				$step['slug'],
				strtoupper( $step['uuid'] )
			);
		}
		return false;
	}

}
