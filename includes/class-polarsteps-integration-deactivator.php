<?php

/**
 * Fired during plugin deactivation
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.1.0
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Deactivator {

	/**
	 * Deactivate Update-Cron
	 * Removing cached Data from table
	 *
	 * @since    0.2.1
	 */
	public static function deactivate() {

		$timestamp = wp_next_scheduled( 'polarsteps_update_steps' );
		wp_unschedule_event( $timestamp, 'polarsteps_update_steps' );

		global $wpdb;
		global $polarsteps_table_name;
		$wpdb->query("TRUNCATE TABLE {$polarsteps_table_name}");
	}

}
