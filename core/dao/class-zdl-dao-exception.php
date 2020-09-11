<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ZDL_Dao_Exception extends Exception {
	public function __construct( $table_name, $message, $code = 0, Exception $previous = null ) {
		if( $table_name ){
			$message = sprintf( 'Table: `%s`.', $table_name ) . $message;
		}
		parent::__construct( $message, $code, $previous );
	}
}