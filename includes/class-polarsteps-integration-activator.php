<?php

/**
 * Fired during plugin activation
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Activator {

	/**
	 * Activates Polarsteps Integration Plugin.
	 *
	 * Installing Tables for Polarsteps Integration Plugin.
	 *
	 * @since    0.1.0
	 */
	public static function activate() {

		global $wpdb;
		global $polarsteps_db_version;
		global $polarsteps_table_name;

		$charset_collate = $wpdb->get_charset_collate();

		$installed_version = get_option( 'polarsteps_db_version' );

		if ( $installed_version != $polarsteps_db_version ) {

			$sql = "CREATE TABLE $polarsteps_table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				uuid text NOT NULL,
				start_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				location_name VARCHAR(155),
				detail VARCHAR(155),
				location_lat FLOAT NOT NULL, 
				location_lon FLOAT NOT NULL,
				location_country_code VARCHAR(5),
				legacy_id mediumint(9),
				slug VARCHAR (55),
				trip_id mediumint(9),
				thumbnail_path_small VARCHAR(155),		 
				thumbnail_path_large VARCHAR(155),		 
				PRIMARY KEY  (id)
		) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( 'polarsteps_db_version', $polarsteps_db_version );
		}

		add_option('polarsteps_username');
		do_action( 'polarsteps_update_steps' );

		if ( ! wp_next_scheduled( 'polarsteps_update_steps' ) ) {

			wp_schedule_event( time(), 'hourly', 'polarsteps_update_steps' );
		}
	}


}
