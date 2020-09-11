<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_User_Preference_Dao extends ZDL_I_Dao {
	/**
	 * @param string    $preference_name
	 * @param int       $user_id
	 *
	 * @return string|null    in the case the preference is not set null will be returned
	 */
	public function get_preference( $preference_name, $user_id );

	/**
	 * @param string    $preference_name
	 * @param string    $preference_value
	 * @param int       $user_id
	 * @param bool      $flush_cache
	 *
	 * @return bool
	 */
	public function set_preference( $preference_name, $preference_value, $user_id, $flush_cache = true );
}
