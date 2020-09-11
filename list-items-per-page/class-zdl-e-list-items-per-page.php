<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_E_List_Items_Per_Page extends ZDL_Enum_Display {
	const ITEMS_10 = 10;
	const ITEMS_20 = 20;
	const ITEMS_50 = 50;
	const ITEMS_75 = 75;
	const ITEMS_100 = 100;

	/**
	 * @param int   $list_items_per_page    on of this class constants
	 *
	 * @return string
	 */
	public static function get_display_name( $list_items_per_page ){
		switch( $list_items_per_page ){
			case self::ITEMS_10:
				return __( '10', 'zdl' );
			case self::ITEMS_20:
				return __( '20', 'zdl' );
			case self::ITEMS_50:
				return __( '50', 'zdl' );
			case self::ITEMS_75:
				return __( '75', 'zdl' );
			case self::ITEMS_100:
				return __( '100', 'zdl' );
			default:
				throw new InvalidArgumentException('Invalid list items per page: ' . $list_items_per_page );
		}
	}
}