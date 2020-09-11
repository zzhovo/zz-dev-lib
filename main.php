<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

(function(){
	$zdl_plugin_config = ZDL_Plugin_Config::get_instance();

	require_once( $zdl_plugin_config->get_path() . '/core/bootstrap.php' );
	require_once( $zdl_plugin_config->get_path() . '/user-preference/bootstrap.php' );
	require_once( $zdl_plugin_config->get_path() . '/list-items-per-page/bootstrap.php' );
})();