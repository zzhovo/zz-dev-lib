<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_E_DB_Value_Comparison_Operator extends ZDL_Enum {
	CONST O_AND = 'and';
	CONST O_OR = 'or';
	CONST O_AND_NOT = 'and_not';
	CONST O_OR_NOT = 'or_not';
	CONST O_AND_IN = 'and_in';
	CONST O_AND_NOT_IN = 'and_not_in';
	CONST O_OR_IN = 'or_in';
	CONST O_OR_NOT_IN = 'or_not_in';

	static public function prepare( $operator, $column_name, $format, $value ) {
		global $wpdb;

		self::validate_item( $operator );

		if( is_array( $value ) ) {
			if( 0 === count( $value ) ) {
				return ' ';
			}

			$values = array();
			foreach( $value as $_value ) {
				$values[] = $wpdb->prepare( $format, $_value );
			}
			$value = implode( ',', $values );

			switch( $operator ) {
				case self::O_AND:
					$operator = self::O_AND_IN;
					break;
				case self::O_OR:
					$operator = self::O_OR_IN;
					break;
				case self::O_AND_NOT:
					$operator = self::O_AND_NOT_IN;
					break;
				case self::O_OR_NOT:
					$operator = self::O_OR_NOT_IN;
					break;
			}
		} else {
			switch( $operator ) {
				case self::O_AND_IN:
					$operator = self::O_AND;
					break;
				case self::O_OR_IN:
					$operator = self::O_OR;
					break;
				case self::O_AND_NOT_IN:
					$operator = self::O_AND_NOT;
					break;
				case self::O_OR_NOT_IN:
					$operator = self::O_OR_NOT;
					break;
			}
		}

		switch( $operator ) {
			case self::O_AND:
				$result = ' AND ' . $column_name . ' = ' . $wpdb->prepare( $format, $value );
				break;
			case self::O_OR:
				$result = ' OR ' . $column_name . ' = ' . $wpdb->prepare( $format, $value );
				break;
			case self::O_AND_NOT:
				$result = ' AND ' . $column_name . ' != ' . $wpdb->prepare( $format, $value );
				break;
			case self::O_OR_NOT:
				$result = ' OR ' . $column_name . ' != ' . $wpdb->prepare( $format, $value );
				break;
			case self::O_AND_IN:
				$result = ' AND ' . $column_name . ' IN ( ' . $value . ' )';
				break;
			case self::O_AND_NOT_IN:
				$result = ' AND ' . $column_name . ' NOT IN ( ' . $value . ' )';
				break;
			case self::O_OR_IN:
				$result = ' OR ' . $column_name . ' IN ( ' . $value . ' )';
				break;
			case self::O_OR_NOT_IN:
				$result = ' OR ' . $column_name . ' NOT IN ( ' . $value . ' )';
				break;
		}
		$result .= ' ';

		return $result;
	}
}