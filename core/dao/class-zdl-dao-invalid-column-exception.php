<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ZDL_Dao_Invalid_Column_Exception extends ZDL_Dao_Exception {
	public function __construct( $table_name, $column_name, $message = '', $code = 0, Exception $previous = null ) {
		if( $column_name ){
			$message = sprintf( 'Invalid column name: `%s`.', $column_name ) . $message;
		}
		parent::__construct( $table_name, $message, $code, $previous );
	}
}