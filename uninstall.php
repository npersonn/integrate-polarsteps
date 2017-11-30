<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// ToDo: Need to remove polarsteps table from Db