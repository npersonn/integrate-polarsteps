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
		return $this->get_all_steps()[ $position ] ?: [];
	}

}
