<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_String {
	/**
	 * @param string    $needle
	 * @param string    $haystack
	 *
	 * @return bool
	 */
	static public function starts_with( $needle, $haystack ) {
		$length = strlen( $needle );
		return substr( $haystack, 0, $length ) === $needle;
	}

	/**
	 * @param string    $needle
	 * @param string    $haystack
	 *
	 * @return bool
	 */
	static public function ends_with( $needle, $haystack ) {
		$length = strlen( $needle );
		if( ! $length ) {
			return true;
		}
		return substr( $haystack, -$length ) === $needle;
	}

	/**
	 * @param string        $value
	 *
	 * @return string
	 *
	 * @example "asd" => asd
	 *          'asd' => asd
	 *          'asd" => 'asd"
	 *          "asd' => "asd'
	 *          ' => '
	 *          " => "
	 */
	static public function trim_matching_quotes( $value ) {
		if( 2 > strlen( $value ) ) {
			return $value;
		}

		if(
			(self::starts_with( "'", $value ) && self::ends_with( "'", $value ) )
			|| ( self::starts_with( '"', $value ) && self::ends_with( '"', $value ) )
		) {
			return substr( $value, 1, -1 );
		}

		return $value;
	}
}