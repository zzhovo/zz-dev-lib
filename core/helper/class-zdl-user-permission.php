<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_User_Permission {
	/**
	 * @param string[] $permissions
	 *
	 * @return bool
	 */
	static public function current_user_can_optimistic( array $permissions ) {
		foreach( $permissions as $permission ) {
			if( current_user_can( $permission ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param string[] $permissions
	 *
	 * @return bool
	 */
	static public function current_user_can_pessimistic( array $permissions ) {
		foreach( $permissions as $permission ) {
			if( ! current_user_can( $permission ) ) {
				return false;
			}
		}

		return true;
	}
}