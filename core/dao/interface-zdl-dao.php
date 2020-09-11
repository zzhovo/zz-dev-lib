<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_Dao extends ZDL_I_DB_Table {
	/**
	 * @param array<string, mixed>  $entity             '{column_name}' => {value}
	 * @param bool                  $replace_existing
	 *
	 * @return int
	 * @throws ZDL_Dao_Exception
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function create_single( array $entity, $replace_existing = false );
	/**
	 * @param array< array<string, mixed > >    $entities           array of {column_name} => {column_value}
	 * @param bool                              $replace_existing
	 *
	 * @return false|int
	 * @throws ZDL_Dao_Exception
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function create_many( array $entities, $replace_existing = false );

	/**
	 * @param array<string, mixed>|mixed    $id_values
	 *
	 * @return false|array<string, mixed>
	 * @throws ZDL_Dao_Exception
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function get_single_by_id( $id_values );
	/**
	 * @param array<string, mixed>|mixed    $id_values
	 * @param string[]                      $columns    all the columns will be selected, in the case it's an empty array
	 *
	 * @return false|array<string, mixed>
	 * @throws ZDL_Dao_Exception
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function get_single_properties_by_id( $id_values, array $columns = array() );
	/**
	 * @param array<string, mixed>  $where_values   '{column_name}' => {value}
	 * @param string[]              $columns        all the columns will be selected, in the case it's an empty array
	 * @param int                   $limit          no limit will be applied in the case it's 0
	 * @param int                   $offset
	 * @param bool                  $get_count
	 *
	 * @return array|int                            an int will be returned in the case the $get_count is true
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function get_many_properties_by_values(
		array $where_values,
		array $columns = array(),
		$limit = 0,
		$offset = 0,
		$get_count = false
	);

	/**
	 * @param array<string, mixed>|mixed    $id_values
	 * @param array<string, mixed>          $update_values  '{column_name}' => {value}
	 *
	 * @return bool
	 * @throws ZDL_Dao_Exception
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function update_single_by_id( $id_values, array $update_values );
	/**
	 * @param array<string, mixed>  $where_values   '{column_name}' => {value}
	 * @param array<string, mixed>  $update_values  '{column_name}' => {value}
	 *
	 * @return false|int
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function update_many_by_values( array $where_values, array $update_values );

	/**
	 * @param array<string, mixed>|mixed  $id_values
	 *
	 * @return bool
	 * @throws ZDL_Dao_Exception
	 */
	public function delete_single_by_id( $id_values );
	/**
	 * @param array<string, mixed>  $where_values '{column_name}' => {value}
	 *
	 * @return false|int
	 */
	public function delete_many_by_values( array $where_values );

	/**
	 * @param array<string, mixed>              $where_values   '{column_name}' => {value}
	 * @param array< array<string, mixed> >     $entities       '{column_name}' => {value}
	 *
	 * @return bool
	 * @throws ZDL_Dao_Exception
	 * @throws ZDL_Dao_Invalid_Column_Exception
	 */
	public function delete_insert( array $where_values = array(), array $entities = array() );
}