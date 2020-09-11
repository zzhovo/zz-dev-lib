<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_Enum_Display extends ZDL_Enum {
	/**
	 * @param mixed     $item
	 *
	 * @return string
	 */
	abstract static public function get_display_name( $item );
}