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
	const POLARSTEPS_URI = 'https://www.polarsteps.com/api/';

	/**
	 * Gets
	 *
	 * @since 0.1.0
	 * @return array|bool
	 */
	public function polarsteps_get_step_data() {

		$user_id = get_option( 'polarsteps_user_id' );
		$trip_id = get_option( 'polarsteps_trip_id' );
		$result  = file_get_contents( self::POLARSTEPS_URI . 'users/' . $user_id );

		if ( $result ) {

			$user_data = json_decode( $result );

			$all_trips = is_array( $user_data->alltrips ) ? $user_data->alltrips : [];
			$trip      = is_object( $all_trips[ $trip_id ] ) ? $all_trips[ $trip_id ] : [];

			$steps = is_array( $trip->all_steps ) ? $trip->all_steps : [];

			$result = [];
			foreach ( $steps as $step ) {

				$result_step = [];

				$result_step['uuid']         = $step->uuid;
				$result_step['start_time']   = date( 'Y-m-d H:i:s', $step->start_time );
				$result_step['location_lat'] = $step->location->lat;
				$result_step['location_lon'] = $step->location->lon;

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

		return [];
	}

}
