<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_DB_Table implements ZDL_I_DB_Table {
	// region Table Prefix
	/**
	 * @var string
	 */
	protected $table_prefix;
	/**
	 * @param string    $table_prefix
	 */
	protected function set_table_prefix( $table_prefix ) {
		$this->table_prefix = trim( $table_prefix );
	}
	/**
	 * @return string
	 */
	public function get_table_prefix() {
		return $this->table_prefix;
	}
	// endregion

	// region Table Name
	/**
	 * @var string
	 */
	protected $table_name;
	/**
	 * @param string    $table_name
	 */
	protected function set_table_name( $table_name ) {
		$this->table_name = trim( $table_name );
	}
	/**
	 * @return string
	 */
	public function get_table_name() {
		return $this->get_table_prefix() . $this->table_name;
	}
	// endregion

	// region Id Columns
	/**
	 * @var string|string[]
	 */
	protected $id_column_names;
	/**
	 * @param string|string[]   $id_column_names
	 */
	protected function set_id_column_names( $id_column_names ) {
		if( is_array( $id_column_names ) && 1 === count( $id_column_names ) ) {
			$id_column_names = $id_column_names[0];
		}

		$this->id_column_names = $id_column_names;
	}
	/**
	 * @return string|string[]
	 */
	public function get_id_column_names() {
		return $this->id_column_names;
	}
	// endregion

	// region Column Types
	/**
	 * @var array<string, string>
	 */
	protected $column_types;
	/**
	 * @param array<string, string> $column_types   {column name} => {ZDL_E_Column_Type constant}
	 */
	protected function set_column_types( $column_types ) {
		$column_formats = array();
		foreach( $column_types as $column_name => $column_type ) {
			$column_formats[ $column_name ] = ZDL_E_Column_Type::get_format( $column_type );
		}
		$this->column_types = $column_types;
		$this->column_formats = $column_formats;
	}
	/**
	 * @return array<string, string>
	 */
	public function get_column_types() {
		return $this->column_types;
	}
	/**
	 * @param string        $column_name
	 *
	 * @return string
	 */
	public function get_column_type( $column_name ) {
		if( ! array_key_exists( $column_name, $this->column_types ) ) {
			throw new ZDL_Dao_Invalid_Column_Exception( $this->get_table_name(), $column_name );
		}

		return $this->column_types[ $column_name ];
	}
	/**
	 * @param string[]      $column_names
	 *
	 * @return string[]
	 */
	public function get_column_types_by_column_names( array $column_names ) {
		return array_map( array( $this, 'get_column_type' ), $column_names );
	}
	// endregion

	// region Column Formats
	/**
	 * @var array<string, string>
	 */
	protected $column_formats;
	/**
	 * @return array<string, string>
	 */
	public function get_column_formats() {
		return $this->column_formats;
	}
	/**
	 * @param string    $column_name
	 *
	 * @return string
	 */
	public function get_column_format( $column_name ) {
		if( ! array_key_exists( $column_name, $this->column_formats ) ) {
			throw new ZDL_Dao_Invalid_Column_Exception( $this->get_table_name(), $column_name );
		}

		return $this->column_formats[ $column_name ];
	}
	/**
	 * @param string[]      $column_names
	 *
	 * @return string[]
	 */
	public function get_column_formats_by_column_names( array $column_names ) {
		return array_map( array( $this, 'get_column_format' ), $column_names );
	}
	// endregion

	// region Helpers
	/**
	 * @param array<string, mixed>|mixed      $id_values
	 *
	 * @return array<string, mixed>
	 */
	public function prepare_id_values( $id_values ) {
		$id_column_names = $this->get_id_column_names();
		if( is_array( $id_column_names ) ) {
			if( ! is_array( $id_values ) || count( $id_values ) !== count( $id_column_names ) ) {
				throw new ZDL_Dao_Exception(
					$this->get_table_name(),
					'given $id_values does not match with the id column  names'
				);
			}

			$prepared_id_values = array();
			foreach( $id_column_names as $column_name ) {
				if( ! array_key_exists( $column_name, $id_values ) ) {
					throw new ZDL_Dao_Exception(
						$this->get_table_name(),
						'given $id_values should contain value for ' . $column_name
					);
				}
				$prepared_id_values[ $column_name ] = $id_values[ $column_name ];
			}

			return $prepared_id_values;
		}else{
			if( is_array( $id_values ) ) {
				if( 1 < count( $id_values ) ) {
					throw new ZDL_Dao_Exception(
						$this->get_table_name(),
						'given $id_values does not match with the id column(s)'
					);
				}
				$id_values = array_pop($id_values );
			}

			return array( $id_column_names => $id_values );
		}
	}

	/**
	 * @param array<string, mixed>[]|array<string, string, mixed>[] $values '{column_name}', {value}
	 *                                                                      '{operation}', '{column_name}', {value}|<{value}>
	 *
	 * @return string
	 */
	protected function prepare_where( array $values ) {
		$query_where = '';
		foreach( $values as $column_value ) {
			if( ! is_array( $column_value ) ) {
				throw new InvalidArgumentException('Each item in $values should be array');
			}

			if( 2 === count( $column_value ) ) {
				$operator = ZDL_E_DB_Value_Comparison_Operator::O_AND;
				$column_name = $column_value[0];
				$column_value = $column_value[1];
			} else {
				ZDL_E_DB_Value_Comparison_Operator::validate_item( $column_value[0] );
				$operator = $column_value[0];
				$column_name = $column_value[1];
				$column_value = $column_value[2];
			}

			$query_where .= ZDL_E_DB_Value_Comparison_Operator::prepare(
				$operator,
				$this->prepare_column_name( $column_name ),
				$this->get_column_format( $column_name ),
				$column_value
			);
		}

		return $query_where;
	}

	/**
	 * @param array<string, mixed> $values '{column_name}' => {value}
	 *
	 * @return string
	 */
	protected function prepare_update_set( array $values ) {
		global $wpdb;

		$query_update_values = array();
		foreach( $values as $column_name => $column_value ) {
			$prepared_column_name = $this->prepare_column_name( $column_name );
			if ( null === $column_value ) {
				$query_update_values[] = $prepared_column_name . ' = NULL ';
			}else{
				$format = $this->get_column_format( $column_name );
				$query_update_values[] = $prepared_column_name . $wpdb->prepare(' = ' . $format, $column_value ) . ' ';
			}
		}

		return implode( ',', $query_update_values );
	}

	/**
	 * @param string[]  $column_names
	 *
	 * @return string
	 */
	protected function prepare_columns( array $column_names ) {
		if( 0 === count( $column_names ) ) {
			return '*';
		}

		$query_select_columns = array();
		foreach( $column_names as $column_name ) {
			if( trim( $column_name ) === '*' ) {
				$query_select_columns[] = ' * ';
			}else{
				$query_select_columns[] = $this->prepare_column_name( $column_name );
			}
		}
		$query_select = implode( ',', $query_select_columns );

		return $query_select;
	}

	/**
	 * @param string        $column_name
	 *
	 * @return string
	 */
	protected function prepare_column_name( $column_name ) {
		global $wpdb;

		if( ! array_key_exists( $column_name, $this->column_types ) ) {
			throw new ZDL_Dao_Invalid_Column_Exception( $this->get_table_name(), $column_name );
		}

		$prepared_column_name = $wpdb->prepare( '%s', $column_name );
		$prepared_column_name = ZDL_String::trim_matching_quotes( $prepared_column_name );
		$prepared_column_name = '`' . $prepared_column_name . '`';

		return $prepared_column_name;
	}

	protected function prepare_limit_offset( $limit = 0, $offset = 0 ) {
		global $wpdb;

		$query_limit = '';
		if( 0 < $limit ) {
			if( 0 < $offset ) {
				$query_limit = $wpdb->prepare('
						LIMIT %d, %d
					', $offset, $limit );
			} else {
				$query_limit = $wpdb->prepare('
						LIMIT %d
					', $limit );
			}
		}

		return $query_limit;
	}

	/**
	 * @param array< array<string, mixed> > $items
	 */
	protected function reformat_db_values( array & $items ) {
		foreach( $items as & $item ) {
			foreach( $item as $column_name => $column_value ) {
				if( null === $column_value ) {
					$item[ $column_name ] = null;
				} else {
					$item[ $column_name ] = ZDL_E_Column_Type::format_value(
						$this->get_column_type( $column_name ),
						$column_value
					);
				}
			}
		}
	}
	protected function reformat_db_values_by_formats( array & $items, array $column_types ) {
		foreach( $items as & $item ) {
			foreach( $item as $column_name => $column_value ) {
				if( ! array_key_exists( $column_name, $column_types ) ) {
					throw new InvalidArgumentException('could not find format for column: ' . $column_name );
				}
				$item[ $column_name ] = ZDL_E_Column_Type::format_value(
					$column_types[ $column_name ],
					$column_value
				);
			}
		}
	}
	// endregion
}