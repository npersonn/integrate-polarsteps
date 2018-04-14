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
 * The admin-specific functionality of the polarsteps integration plugin.
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

		register_setting( 'polarsteps_settings', 'polarsteps_username', array(
			'show_in_rest' => true,
			'type'         => 'string',
			'description'  => __( 'Username from Polarsteps API.' ),
		) );

		register_setting( 'polarsteps_settings', 'polarsteps_trip_id', array(
			'show_in_rest' => true,
			'type'         => 'integer',
			'description'  => __( 'Trip Id from Polarsteps API.' ),
			'default'      => 0,
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
			'Polarsteps Integration Settings',
			'Polarsteps Settings',
			'manage_options',
			'polarsteps-settings',
			array( $this, 'render' )
		);
	}

	/**
	 * Render the contents of the settings page, if User has sufficient rights
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function render() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient rights to access this page.' ) );
		}

		?>
        <div class="wrap">

            <h1>
				<?php
				_e( 'Polarsteps Integration Settings', 'polarsteps-integration' );
				?>
            </h1>

			<?php
			_e( $this->generate_recent_step_notice() );
			?>

            <form method="post" action="options.php">

                <?php
                    settings_fields( 'polarsteps_settings' );
                ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><label
                                    for="polarsteps_username"><?php _e( 'Username for Polarsteps API', 'polarsteps-integration' ); ?></label>
                        </th>
                        <td>
                            <input name="polarsteps_username" type="text" id="polarsteps_username" class="regular-text"
                                   value="<?php form_option( 'polarsteps_username' ); ?>"/>

                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php
							_e( 'Your Polarsteps Username.', 'polarsteps-integration' );
							?>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label
                                    for="polarsteps_trip_id"><?php _e( 'Trip Id for Polarsteps API', 'polarsteps-integration' ); ?></label>
                        </th>
                        <td>
                            <input name="polarsteps_trip_id" type="number" step="1" min="0" id="polarsteps_trip_id"
                                   value="<?php form_option( 'polarsteps_trip_id' ); ?>" class="regular-text"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php
							_e( 'Default Trip Id is "0".', 'polarsteps-integration' );
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

	/**
	 * Updates the Steps. It is been triggered from Admin-Context e.g. on update_option_polarsteps_username
	 *
	 * @since 0.3.3
	 * @return void
	 */
	public function polarsteps_update_steps_from_admin() {

		// Remove the polarsteps_user_id from wp_options
		update_option( 'polarsteps_user_id', null );

		// Update Steps with new Options
		do_action( 'polarsteps_update_steps' );
	}

	/**
	 * Validates the Settings for Username
	 *
	 * @since 0.3.4
	 *
	 * @param string $new_value The newly set Username
	 *
	 * @return string|false
	 */
	public function polarsteps_validate_username( $new_value ) {

		if ( empty ( $new_value ) ) {
			add_settings_error(
				'polarsteps_username',
				'-1',
				'The Username cannot be empty'
			);

			return false;
		}

		$is_username_exists = apply_filters( 'polarsteps_validate_username', $new_value );
		if ( $is_username_exists == false ) {
			add_settings_error(
				'polarsteps_username',
				'-1',
				sprintf( 'The Username "%s" does not exist on Polarsteps.com.', $new_value )
			);

			return false;
		}

		return $new_value;
	}

	/**
	 * Getting the last cached step, to show it in the options.
	 *
	 * @since 0.3.3
	 * @return string|void
	 */
	private function generate_recent_step_notice() {
		$last_step = apply_filters( 'polarsteps_get_step', 0 );

		if ( ! empty ( $last_step ) && ! empty ( $last_step['location_name'] ) ) {
			$last_step_message = sprintf( '%s, %s',
				$last_step['location_name'],
				$last_step['detail']
			);

			return sprintf( '
            <div class="card">
                <h2>
                    Recent Location
                </h2>
                    
                <p>
                    Your last saved step is "%s".
                </p>
            </div>', $last_step_message );

		}
	}
}
