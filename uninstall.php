<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @since      0.2.1
 *
 * @package    Polarsteps_Integration
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

polarsteps_delete_option('polarsteps_user_id');
polarsteps_delete_option('polarsteps_trip_id');
polarsteps_delete_option('polarsteps_trip_legacy_id');
polarsteps_delete_option('polarsteps_trip_slug');
polarsteps_delete_option('polarsteps_username');
polarsteps_delete_option('polarsteps_db_version');


function polarsteps_delete_option( $option_name ) {
	delete_option($option_name);
	delete_site_option($option_name);
}

global $wpdb;
$wpdb->query(sprintf('DROP TABLE IF EXISTS %spolarsteps', $wpdb->prefix));