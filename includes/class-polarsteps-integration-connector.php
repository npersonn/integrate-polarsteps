<?php

/**
 * Connects to Polarsteps API
 *
 *
 * @since      0.1.0
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 */

/**
 * Updates the Polarsteps Data from API.
 *
 * @package    Polarsteps_Integration
 * @subpackage Polarsteps_Integration/includes
 * @author     NPersonn <nick@personn.com>
 */
class Polarsteps_Integration_Connector {

	/**
	 * Uri to Polarsteps API
	 * @since 0.1.0
	 * @var string
	 */
	const POLARSTEPS_URI = 'https://api.polarsteps.com/';

	/**
	 * Gets the Step Data from Polarsteps API
	 *
	 * @since 0.1.0
	 * @return array|bool
	 */
	public function polarsteps_get_step_data() {

		$user_id  = get_option( 'polarsteps_user_id' );
		$username = get_option( 'polarsteps_username' );

		if ( empty( $user_id ) ) {

			// ToDo: The API now offers direct access to user-data by username. This step is redundant
			$user_id = $this->polarsteps_obtain_user_id( $username );

			if ( ! $user_id ) {
				return false;
			}

			update_option( 'polarsteps_user_id', $user_id );
		}

		$result = $this->doRemoteCall( self::POLARSTEPS_URI . $this->buildQuery( $username ) );

		if ( $result ) {

			$trip_id = get_option( 'polarsteps_trip_id' );

			$user_data = json_decode( $result );

			$this->polarsteps_set_user_data( $user_data->username );

			$all_trips = is_array( $user_data->alltrips ) ? $user_data->alltrips : [];

			if ( ! isset( $all_trips [ $trip_id ] ) ) {
				error_log(
					sprintf( 'The User with Id %s exists, but does not have any public trips',
						$user_id )
				);

				return false;
			}

			$trip = is_object( $all_trips[ $trip_id ] ) ? $all_trips[ $trip_id ] : [];

			$this->polarsteps_set_trip_data( $trip );

			$steps = is_array( $trip->all_steps ) ? $trip->all_steps : [];

			$result = [];
			foreach ( $steps as $step ) {

				$result_step = [];

				$result_step['legacy_id']    = $step->id;
				$result_step['uuid']         = $step->uuid;
				$result_step['start_time']   = date( 'Y-m-d H:i:s', $step->start_time );
				$result_step['location_lat'] = $step->location->lat;
				$result_step['location_lon'] = $step->location->lon;
				$result_step['slug']         = $step->slug;
				$result_step['trip_id']      = $step->trip_id;

				if ( ! empty( $step->location->name ) ) {
					$result_step['location_name'] = $step->location->name;
				}
				if ( ! empty( $step->location->country_code ) ) {
					$result_step['location_country_code'] = $step->location->country_code;
				}
				if ( ! empty( $step->location->detail ) ) {
					$result_step['detail'] = $step->location->detail;
				}

				$result[] = $result_step;
			}

			return $result;
		}

		error_log(
			sprintf( 'Unable to receive user-dataset from Polarsteps API. Username: %s UserId: %s',
				$username,
				$user_id
			)
		);

		return [];
	}

	/**
	 * Checks, if a User exists
	 *
	 * @param string $username
	 *
	 * @return bool|WP_Error
	 */
	public function polarsteps_get_user_exists( string $username ) {

		$result = $this->polarsteps_obtain_user_id( $username );

		if ( false === $result ) {
			return false;
		}

		return true;
	}

	/**
	 * Sets the Username from Polarsteps API
	 *
	 * @since 0.2.0
	 *
	 * @param string $username
	 *
	 * @return void
	 */
	protected function polarsteps_set_user_data( string $username ): void {
		if ( ! get_option( 'polarsteps_username' ) && ! empty ( $username ) ) {
			update_option( 'polarsteps_username', $username );
		}
	}

	/**
	 * Sets Trip Data from Polarsteps API
	 *
	 * @since 0.2.0
	 *
	 * @param stdClass $trip
	 *
	 * @return void
	 */
	protected function polarsteps_set_trip_data( stdClass $trip ): void {
		if ( ! empty ( $trip->slug ) ) {
			update_option( 'polarsteps_trip_slug', $trip->slug );
		}
		if ( ! empty ( $trip->id ) ) {
			update_option( 'polarsteps_trip_legacy_id', $trip->id );
		}

	}

	/**
	 * Returning the UserId from a given Username
	 *
	 * Due to performance the query call is only done to get the username. Updating/Caching the Steps is done directly
	 * addressing the UserId
	 *
	 * @since 0.3.0
	 *
	 * @param string $username
	 *
	 * @return int
	 */
	protected function polarsteps_obtain_user_id( string $username = null ): int {
		if ( ! empty( $username ) ) {

			$result = $this->doRemoteCall( self::POLARSTEPS_URI . $this->buildQuery( $username ) );

			if ( $result ) {
				$result = json_decode( $result );

				if ( ! empty( $result->id ) ) {

					return $result->id;
				}
			}
		}

		error_log(
			sprintf( 'Polarsteps-Username %s does not exist.', $username )
		);

		return false;
	}

	/**
	 * Building a Query for search for Users
	 *
	 * @since 0.3.0
	 *
	 * @param string $username
	 *
	 * @return string
	 */
	protected function buildQuery( string $username ): string {
		return 'users/byusername/' . urlencode( $username );
	}

	/**
	 * Building a Query for search for Users
	 *
	 * @since 0.4.0
	 *
	 * @param string $url
	 *
	 * @return mixed
	 */
	protected function doRemoteCall( string $url ) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_URL, $url);
		curl_setopt( $ch, CURLOPT_SSLVERSION, 3 );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}

}
