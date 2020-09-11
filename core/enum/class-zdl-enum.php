<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_Enum {
	/**
	 * @noinspection PhpDocMissingThrowsInspection
	 *
	 * @return string[]
	 */
	static public function get_all(){
		$enum = new ReflectionClass( static::class );
		$constants = $enum->getConstants();

		return array_values( $constants );
	}

	/**
	 * @noinspection PhpDocMissingThrowsInspection
	 *
	 * @param $item
	 *
	 * @return bool
	 */
	static public function is_item_valid( $item ){
		$enum = new ReflectionClass( static::class );
		$constants = $enum->getConstants();

		return in_array( $item, $constants );
	}

	/**
	 * @param $item
	 *
	 * @throws InvalidArgumentException
	 */
	static public function validate_item( $item ){
		if( ! static::is_item_valid( $item ) ){
			throw new InvalidArgumentException( 'invalid enum constant value: ' . $item );
		}
	}
}