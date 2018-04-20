<?php

/**
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 */

/**
 * The core plugin class for Polarsteps Integration into Wordpress
 *
 * @since      0.1.0
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration {

	/**
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      Polarsteps_Integration_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $polarsteps_integration    The string used to uniquely identify this plugin.
	 */
	protected $polarsteps_integration;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The string used for the trips table.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string $polarsteps_trip_table The string used for the trips table.
	 */
	protected $polarsteps_trip_table;

	/**
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->polarsteps_integration = 'polarsteps-integration';
		$this->version = '0.1.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->set_globals();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Polarsteps_Integration_Loader. Orchestrates the hooks of the plugin.
	 * - Polarsteps_Integration_i18n. Defines internationalization functionality.
	 * - Polarsteps_Integration_Admin. Defines all hooks for the admin area.
	 * - Polarsteps_Integration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-polarsteps-integration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-polarsteps-integration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-polarsteps-integration-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-polarsteps-integration-public.php';

		/**
		 * The class responsible for defining widget related
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-polarsteps-integration-widget.php';

		/**
		 * The class responsible for defining Database Updating related
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-polarsteps-integration-updater.php';

		/**
		 * The class responsible for defining Database Loading related
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-polarsteps-integration-data-loader.php';

		/**
		 * The class responsible for connecting and receiving data from Polarsteps API
		 *
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-polarsteps-integration-connector.php';

		$this->loader = new Polarsteps_Integration_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Polarsteps_Integration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Polarsteps_Integration_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Polarsteps_Integration_Admin( $this->get_polarsteps_integration(), $this->get_version() );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
		// Filter hooks into update_options, when a new Username is saved in the admin panel
		$this->loader->add_filter('pre_update_option_polarsteps_username', $plugin_admin, 'polarsteps_validate_username');
		$this->loader->add_filter('pre_add_option_polarsteps_username', $plugin_admin, 'polarsteps_validate_username');
		$this->loader->add_filter('update_option_polarsteps_username', $plugin_admin, 'polarsteps_update_steps_from_admin');
		$this->loader->add_filter('add_option_polarlarsteps_username', $plugin_admin, 'polarsteps_update_steps_from_admin');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Polarsteps_Integration_Public( $this->get_polarsteps_integration(), $this->get_version() );

		$this->loader->add_action( 'widgets_init', $plugin_public, 'register_location_widget' );
		$this->loader->add_action( 'polarsteps_get_all_steps', $plugin_public, 'get_all_steps' );
		$this->loader->add_filter( 'polarsteps_get_step', $plugin_public, 'get_step');
		$this->loader->add_action( 'polarsteps_update_steps', $plugin_public, 'update_steps' );
		$this->loader->add_filter( 'polarsteps_validate_username', $plugin_public, 'validate_username' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_polarsteps_integration() {
		return $this->polarsteps_integration;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    Polarsteps_Integration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the trips table name.
	 *
	 * @since     0.1.0
	 * @return    string    The trips table name.
	 */
	public function get_table_name() {
		return $this->polarsteps_trip_table;
	}

	/**
	 * Setting the main configs for the plugin
	 *
	 * @since   0.1.0
	 * @return void
	 */
	private function set_globals() {
		global $wpdb;
		global $polarsteps_db_version;
		global $polarsteps_table_name;

		$polarsteps_db_version = '1.1';
		$polarsteps_table_name = $wpdb->prefix . 'polarsteps';
	}

}
