<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_E_Column_Type extends ZDL_Enum {
	CONST FLOAT = 'f';
	CONST INT = 'i';
	CONST BOOL = 'b';
	CONST STRING = 's';

	public static function get_format( $column_type ){
		switch( $column_type ){
			case self::FLOAT:
				return '%f';
				break;
			case self::INT:
			case self::BOOL:
				return '%d';
				break;
			case self::STRING:
				return '%s';
				break;
			default:
				throw new InvalidArgumentException('Invalid $column_type: ' . $column_type );
				break;
		}
	}

	public static function format_value( $column_type, $value ){
		switch( $column_type ){
			case self::FLOAT:
				return (float) $value;
				break;
			case self::INT:
				return (int) $value;
				break;
			case self::BOOL:
				return (bool) $value;
				break;
			case self::STRING:
				return (string) $value;
				break;
			default:
				throw new InvalidArgumentException('Invalid $column_type: ' . $column_type );
				break;
		}
	}
}