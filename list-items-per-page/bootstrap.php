<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( __DIR__ . '/class-zdl-e-list-items-per-page.php' );
require_once( __DIR__ . '/class-zdl-list-items-per-page-resource.php' );
require_once( __DIR__ . '/class-zdl-list-items-per-page-dropdown-manager.php' );

ZDL_List_Items_Per_Page_Dropdown_Manager::get_instance();