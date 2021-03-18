<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_Dao extends ZDL_DB_Table implements ZDL_I_Dao {
	/**
	 * @param array<string, mixed>  $entity             '{column_name}' => {value}
	 * @param bool                  $replace_existing
	 *
	 * @return int
	 */
	public function create_single( array $entity, $replace_existing = false ) {
		$created = $this->create_many( array( $entity ), $replace_existing );

		if( false === $created ) {
			return false;
		}

		return true;
	}
	/**
	 * @param array< array<string, mixed > >    $entities           array of {column_name} => {column_value}
	 * @param bool                              $replace_existing
	 *
	 * @return false|int
	 */
	public function create_many( array $entities, $replace_existing = false ) {
		global $wpdb;

		// validate
		if( 0 === count( $entities ) ) {
			return 0;
		}
		if( ! is_array( $entities[0] ) || 0 === count( $entities[0] ) ) {
			throw new ZDL_Dao_Exception(
				$this->get_table_name(),
				'each item in $entities should be array with column names and appropriate values'
			);
		}

		// prepare ordered column names and formats
		$column_names = array();
		$column_formats = array();
		foreach( $entities[0] as $column_name => $column_value ) {
			$column_names[] = $column_name;
			$column_formats[] = $this->get_column_format( $column_name );
		}

		// prepare insert values
		$query_insert_values = array();
		foreach( $entities as $entity ) {
			$query_insert_value = array();
			for( $i = 0; $i < count( $column_names ); ++ $i ) {
				if( ! array_key_exists( $column_names[ $i ], $entity ) ) {
					throw new ZDL_Dao_Exception(
						$this->get_table_name(),
						'each array in $entities should contain value for column: ' . $column_names[ $i ]
					);
				}
				$query_insert_value[] = $wpdb->prepare( $column_formats[ $i ], $entity[ $column_names[ $i ] ] );
			}
			$query_insert_values[] = '(' . implode( ',', $query_insert_value ) . ')';
		}

		$query_select = $this->prepare_columns( $column_names );

		// query
		if( true === $replace_existing ) {
			$query = '
				REPLACE INTO `' . $this->get_table_name() . '` (' . $query_select . ')
				VALUES ' . implode( ',', $query_insert_values ) . '
			';
		}else {
			$query = '
				INSERT INTO `' . $this->get_table_name() . '` (' . $query_select . ')
				VALUES ' . implode( ',', $query_insert_values ) . '
			';
		}

		$inserted = $wpdb->query( $query );

		return $inserted;
	}

	/**
	 * @param array<string, mixed>|mixed    $id_values  {column_name} => {value}
	 *
	 * @return false|array<string, mixed>
	 */
	public function get_single_by_id( $id_values ) {
		return $this->get_single_properties_by_id( $id_values );
	}
	/**
	 * @param array<string, mixed>|mixed    $id_values  {column_name} => {value}
	 * @param string[]                      $columns    all the columns will be selected, in the case it's an empty array
	 *
	 * @return false|array<string, mixed>
	 */
	public function get_single_properties_by_id( $id_values, array $columns = array() ) {
		$id_values = $this->prepare_id_values( $id_values );

		$where_values = array();
		foreach( $id_values as $column_name => $column_value ) {
			$where_values[] = array( $column_name, $column_value );
		}

		$items = $this->get_many_properties_by_values( $where_values, $columns );

		if( 0 === count( $items ) ) {
			return false;
		}else{
			return $items[0];
		}
	}
	/**
	 * @param array<string, mixed>[]|array<string, string, mixed>[] $where_values   '{column_name}', {value}
	 *                                                                              '{operation}', '{column_name}', {value}|<{value}>
	 * @param string                $column_name
	 * @param int                   $limit          no limit will be applied in the case it's 0
	 * @param int                   $offset
	 *
	 * @return mixed[]
	 */
	public function get_column_by_values(
		array $where_values,
		$column_name,
		$limit = 0,
		$offset = 0
	) {
		$results = $this->get_many_properties_by_values(
			$where_values,
			array( $column_name ),
			$limit,
			$offset
		);

		foreach( $results as & $result ) {
			$result = $result[ $column_name ];
		}

		return $results;
	}
	/**
	 * @param array<string, mixed>[]|array<string, string, mixed>[] $where_values   '{column_name}', {value}
	 *                                                                              '{operation}', '{column_name}', {value}|<{value}>
	 * @param string[]              $columns        all the columns will be selected, in the case it's an empty array
	 * @param int                   $limit          no limit will be applied in the case it's 0
	 * @param int                   $offset
	 * @param bool                  $get_count
	 *
	 * @return array|int                            an int will be returned in the case the $get_count is true
	 */
	public function get_many_properties_by_values(
		array $where_values,
		array $columns = array(),
		$limit = 0,
		$offset = 0,
		$get_count = false
	) {
		global $wpdb;

		if( true === $get_count ) {
			$query_select = 'COUNT(*)';
		}else{
			if( 0 === count( $columns ) ) {
				$columns = array( '*' );
			}

			$query_select = $this->prepare_columns( $columns );
		}

		$query_where = $this->prepare_where( $where_values );

		$query_limit = '';
		if( false === $get_count ) {
			$query_limit = $this->prepare_limit_offset( $limit, $offset );
		}

		$query =
			'SELECT ' . $query_select . '
			FROM `' . $this->get_table_name() . '`
			WHERE 1=1 ' . $query_where
			. $query_limit
		;

		if( true === $get_count ) {
			$count = $wpdb->get_var( $query );

			return (int) $count;
		}else{
			$items = $wpdb->get_results( $query, ARRAY_A );

			if( ! $items ) {
				$items = array();
			}

			$this->reformat_db_values( $items );
			return $items;
		}
	}

	/**
	 * @param array<string, mixed>|mixed    $id_values
	 * @param array<string, mixed>          $update_values  '{column_name}' => {value}
	 *
	 * @return bool
	 */
	public function update_single_by_id( $id_values, array $update_values ) {
		$id_values = $this->prepare_id_values( $id_values );

		$updated = $this->update_many_by_values( $id_values, $update_values );

		if( false === $updated ) {
			return false;
		}

		return true;
	}
	/**
	 * @param array<string, mixed>  $where_values   '{column_name}' => {value}
	 * @param array<string, mixed>  $update_values  '{column_name}' => {value}
	 *
	 * @return false|int
	 */
	public function update_many_by_values( array $where_values, array $update_values ) {
		global $wpdb;

		if( 0 === count( $update_values ) ) {
			return true;
		}

		if( 0 < count( $where_values ) ) {
			$where_formats = $this->get_column_formats_by_column_names( array_keys( $where_values ) );
			$update_formats = $this->get_column_formats_by_column_names( array_keys( $update_values ) );

			$updated = $wpdb->update(
				$this->get_table_name(),
				$update_values,
				$where_values,
				$update_formats,
				$where_formats
			);
		}else{
			$query_update_values = $this->prepare_update_set( $update_values );

			$query = '
				UPDATE `' . $this->get_table_name() . '`
				SET ' . $query_update_values . '
			';

			$updated = $wpdb->query( $query );
		}

		return $updated;
	}

	/**
	 * @param array<string, mixed>|mixed  $id_values
	 *
	 * @return bool
	 */
	public function delete_single_by_id( $id_values ) {
		$id_values = $this->prepare_id_values( $id_values );

		$deleted = $this->delete_many_by_values( $id_values );

		if( !! $deleted ) {
			return true;
		}

		return false;
	}
	/**
	 * @param array<string, mixed>  $where_values '{column_name}' => {value}
	 *
	 * @return false|int
	 */
	public function delete_many_by_values( array $where_values ) {
		global $wpdb;

		$where_formats = $this->get_column_formats_by_column_names( array_keys( $where_values ) );

		$deleted = $wpdb->delete(
			$this->get_table_name(),
			$where_values,
			$where_formats
		);

		return $deleted;
	}

	/**
	 * @param array<string, mixed>              $where_values   '{column_name}' => {value}
	 * @param array< array<string, mixed> >     $entities       '{column_name}' => {value}
	 *
	 * @return bool
	 */
	public function delete_insert( array $where_values = array(), array $entities = array() ) {
		$transaction_manager = ZDL_Transaction_Manager::get_instance();
		if( ! $transaction_manager->is_started() && 0 < count( $where_values ) && 0 < count( $entities ) ) {
			$use_transaction = true;
		}else{
			$use_transaction = false;
		}

		if( $use_transaction ) {
			$transaction_manager->start();
		}

		if( 0 < count( $where_values ) ) {
			$deleted = $this->delete_many_by_values( $where_values );

			if( false === $deleted ) {
				if( $use_transaction ) {
					$transaction_manager->rollback();
				}
				return false;
			}
		}

		if( 0 < count( $entities ) ) {
			$created = $this->create_many( $entities );

			if( false === $created ) {
				if( $use_transaction ) {
					$transaction_manager->rollback();
				}
				return false;
			}
		}

		if( $use_transaction ) {
			$transaction_manager->commit();
		}
		return true;
	}
}