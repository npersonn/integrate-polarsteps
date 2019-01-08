<?php

/**
 * @since             0.1.0
 * @package           Polarsteps_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Polarsteps Integration
 * Plugin URI:        http://github.com/npersonn/integrate-polarsteps
 * Description:       Integrating Trip Data from Polarsteps.com into Wordpress. Showing the last location in a widget. To get started: After activation, set your polarsteps Username in the Polarsteps Settings to be able to get data.
 * Version:           0.4.0
 * Author:            npersonn
 * Author URI:        http://github.com/npersonn
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       polarsteps-integration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-polarsteps-integration-activator.php
 */
function activate_polarsteps_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-polarsteps-integration-activator.php';
	Polarsteps_Integration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-polarsteps-integration-deactivator.php
 */
function deactivate_polarsteps_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-polarsteps-integration-deactivator.php';
	Polarsteps_Integration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_polarsteps_integration' );
register_deactivation_hook( __FILE__, 'deactivate_polarsteps_integration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-polarsteps-integration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_polarsteps_integration() {

	$plugin = new Polarsteps_Integration();
	$plugin->run();

}

run_polarsteps_integration();
