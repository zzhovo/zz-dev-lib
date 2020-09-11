<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_DB_Table {
	/**
	 * @return string
	 */
	public function get_table_prefix();

	/**
	 * @return string
	 */
	public function get_table_name();

	/**
	 * @return string|string[]
	 */
	public function get_id_column_names();

	/**
	 * @return array<string, string>
	 */
	public function get_column_types();
	/**
	 * @param string        $column_name
	 *
	 * @return string
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function get_column_type( $column_name );
	/**
	 * @param string[]      $column_names
	 *
	 * @return string[]
	 */
	public function get_column_types_by_column_names( array $column_names );

	/**
	 * @return array<string, string>
	 */
	public function get_column_formats();
	/**
	 * @param string    $column_name
	 *
	 * @return string
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function get_column_format( $column_name );
	/**
	 * @param string[]      $column_names
	 *
	 * @return string[]
	 */
	public function get_column_formats_by_column_names( array $column_names );

	/**
	 * @param array<string, mixed>|mixed      $id_values
	 *
	 * @return array<string, mixed>
	 * @throws ZDL_Dao_Exception
	 */
	public function prepare_id_values( $id_values );
}