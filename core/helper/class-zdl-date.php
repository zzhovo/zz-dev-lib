<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_Date {
	/**
	 * @return string
	 */
	static public function get_current_date_mysql() {
		return current_time('mysql');
	}
}