<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_Entity_Menu_Manager {
	// region Resource

	/**
	 * @return ZDL_I_Entity_Page_Resource
	 */
	public function get_entity_page_resource();

	// endregion

	// region Page Instance

	/**
	 * @return ZDL_I_Page_List
	 */
	public function get_entity_list_page_instance();

	/**
	 * @return ZDL_I_Page_Single
	 */
	public function get_entity_single_page_instance();

	// endregion
}