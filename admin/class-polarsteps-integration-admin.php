<?php

/**
 * The admin-specific functionality of the plugin.
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/admin
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Admin {

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
	 * @param      string $polarsteps_integration The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $polarsteps_integration, $version ) {

		$this->polarsteps_integration = $polarsteps_integration;
		$this->version                = $version;

	}

	/**
	 * Registers the required Settings for Polarsteps Integration
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function register_settings() {

		//add_settings_section( 'polarsteps_settings', 'Settings for Polarsteps Integration' );
		register_setting( 'polarsteps_settings', 'polarsteps_user_id', array(
			'show_in_rest' => true,
			'type'         => 'integer',
			'description'  => __( 'User Id from Polarsteps API.' ),
		) );

		register_setting( 'polarsteps_settings', 'polarsteps_trip_id', array(
			'show_in_rest' => true,
			'type'         => 'integer',
			'description'  => __( 'Trip Id from Polarsteps API.' ),
		) );
	}

	/**
	 * Creates the submenu item and calls render-method to render the page
	 *
     * @since 0.1.0
	 * @return void
	 */
	public function add_options_page() {

		add_options_page(
			'Polarstep Integration Settings',
			'Polarstep Settings',
			'manage_options',
			'polarsteps-settings',
			array( $this, 'render' )
		);
	}

	/**
     * Render the contents of the settings page
     *
	 * @since 0.1.0
	 * @return void
	 */
	public function render() {
		?>
        <div class="wrap">

            <h1>
                <?php
                    _e('Polarsteps Integration Settings', 'polarsteps-integration');
                ?>
            </h1>

            <form method="post" action="options.php">

                <?php
                    settings_fields( 'polarsteps_settings' );
                ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="polarsteps_user_id"><?php _e( 'User Id for Polarsteps API', 'polarsteps-integration' ); ?></label></th>
                        <td>
                            <input name="polarsteps_user_id" type="number" step="1" min="0" id="polarsteps_user_id" value="<?php form_option( 'polarsteps_user_id' ); ?>" class="small-text" />

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                             _e('Inspect on your browser all the calls made, when open your trip on the polarsteps website. You find a XHR-call in this
                            scheme: `https://www.polarsteps.com/api/users/123456`. `123456` is your User Id.', 'polarsteps-integration');
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                    for="polarsteps_trip_id"><?php _e( 'Trip Id for Polarsteps API', 'polarsteps-integration'); ?></label></th>
                        <td>
                            <input name="polarsteps_trip_id" type="number" step="1" min="0" id="polarsteps_trip_id"
                                   value="<?php form_option( 'polarsteps_trip_id' ); ?>" class="small-text"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            _e('Default Trip Id is "0".', 'polarsteps-integration');
                            ?>

                        </td>
                    </tr>

	                <?php do_settings_fields( 'polarsteps_settings', 'default' ); ?>
                </table>

	            <?php
                do_settings_sections( 'polarsteps_settings' );

				submit_button();
				?>
            </form>
        </div>

		<?php

	}
}
