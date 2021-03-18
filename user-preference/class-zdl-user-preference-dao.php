<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_User_Preference_Dao extends ZDL_Dao implements ZDL_I_User_Preference_Dao {
	// region singleton
	/**
	 * @var ZDL_User_Preference_Dao
	 */
	static private $instance = null;

	/**
	 * @return ZDL_User_Preference_Dao
	 */
	static public function get_instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->set_table_prefix( ZDL_Plugin_Config::get_instance()->get_db_table_prefix() );
		$this->set_table_name( 'user_preferences' );
		$this->set_id_column_names( array( 'user_id', 'name' ) );
		$this->set_column_types( array(
			'user_id'   => ZDL_E_Column_Type::INT,
			'name'      => ZDL_E_Column_Type::STRING,
			'value'     => ZDL_E_Column_Type::STRING
		) );
	}
	private function __clone() {}
	private function __wakeup() {}
	// endregion

	/**
	 * @var array<int, array<string, string>>
	 */
	protected $user_preferences = array();

	/**
	 * @param $user_id
	 */
	protected function cache_user_preferences( $user_id ) {
		$preferences = $this->get_many_properties_by_values( array( array( 'user_id', $user_id ) ), array( 'name', 'value' ) );

		$this->user_preferences[ $user_id ] = array();

		foreach( $preferences as $preference ) {
			$this->user_preferences[ $user_id ][ $preference['name'] ] = $preference['value'];
		}
	}
	/**
	 * @param int   $user_id
	 */
	protected function flush_user_preference_cache( $user_id ) {
		unset( $this->user_preferences[ $user_id ] );
	}

	/**
	 * @param string    $preference_name
	 * @param int       $user_id
	 *
	 * @return string|null    in the case the preference is not set null will be returned
	 */
	public function get_preference( $preference_name, $user_id ) {
		if( ! array_key_exists( $user_id, $this->user_preferences ) ) {
			$this->cache_user_preferences( $user_id );
		}

		if( array_key_exists( $preference_name, $this->user_preferences[ $user_id ] ) ) {
			return $this->user_preferences[ $user_id ][ $preference_name ];
		}

		return null;
	}
	/**
	 * @param string    $preference_name
	 * @param string    $preference_value
	 * @param int       $user_id
	 * @param bool      $flush_cache
	 *
	 * @return bool
	 */
	public function set_preference( $preference_name, $preference_value, $user_id, $flush_cache = true ) {
		$preference = array(
			'user_id' => $user_id,
			'name'    => $preference_name,
			'value'   => $preference_value
		);

		$created = $this->create_single( $preference, true );

		if( true === $flush_cache ) {
			$this->flush_user_preference_cache( $user_id );
		}

		return $created;
	}
	/**
	 * @param string    $preference_name
	 * @param int       $user_id
	 * @param bool      $flush_cache
	 *
	 * @return bool
	 */
	public function unset_preference( $preference_name, $user_id, $flush_cache = true ) {
		$where_values = array(
			'user_id' => $user_id,
			'name'    => $preference_name
		);

		$deleted = $this->delete_many_by_values( $where_values );

		if( false === $deleted ) {
			return false;
		}

		if( true === $flush_cache ) {
			$this->flush_user_preference_cache( $user_id );
		}

		return true;
	}
}