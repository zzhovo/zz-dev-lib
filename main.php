<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

(function() {
	$zdl_plugin_config = ZDL_Plugin_Config::get_instance();

	require_once( $zdl_plugin_config->get_path() . '/core/bootstrap.php' );
	require_once( $zdl_plugin_config->get_path() . '/user-preference/bootstrap.php' );
	require_once( $zdl_plugin_config->get_path() . '/list-items-per-page/bootstrap.php' );
	require_once( $zdl_plugin_config->get_path() . '/entity-page-resource/bootstrap.php' );
})();

function zdl_enqueue_common_scripts() {
	$zdl_plugin_config =  ZDL_Plugin_Config::get_instance();

	wp_enqueue_script(
		'zdl-common-script',
		$zdl_plugin_config->get_assets_url() . '/js/zdl-common.js',
		array( 'jquery' ),
		$zdl_plugin_config->get_assets_version()
	);

	wp_enqueue_style(
		'zdl-common-style',
		$zdl_plugin_config->get_assets_url() . '/css/zdl-common.css',
		array(),
		$zdl_plugin_config->get_assets_version()
	);
}

add_action( 'admin_enqueue_scripts', 'zdl_enqueue_common_scripts' );