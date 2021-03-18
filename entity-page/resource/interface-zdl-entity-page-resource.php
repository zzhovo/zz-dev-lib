<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_Entity_Page_Resource {
	// region Menu List

	/**
	 * @return string
	 */
	public function get_menu_list_slug();

	/**
	 * @return string
	 */
	public function get_menu_list_name();

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_list_url( array $properties = array() );

	/**
	 * @return string
	 */
	public function get_menu_list_permission();

	// endregion

	// region Menu New

	/**
	 * @return string
	 */
	public function get_menu_new_slug();

	/**
	 * @return string
	 */
	public function get_menu_new_name();

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_new_url( array $properties = array() );

	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_new_link( $class = '', array $properties = array() );

	/**
	 * @return string
	 */
	public function get_menu_new_permission();

	// endregion

	// region Menu Edit

	/**
	 * @return string
	 */
	public function get_menu_edit_slug();

	/**
	 * @return string
	 */
	public function get_menu_edit_name();

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_edit_url( array $properties = array() );

	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_edit_link( $class = '', array $properties = array() );

	/**
	 * @return string
	 */
	public function get_menu_edit_permission();

	// endregion

	// region Menu View

	/**
	 * @return string
	 */
	public function get_menu_view_slug();

	/**
	 * @return string
	 */
	public function get_menu_view_name();

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_view_url( array $properties = array() );

	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_view_link( $class = '', array $properties = array() );

	// endregion


	// region Scripts Base

	/**
	 * @return string
	 */
	public function get_asset_base_url();

	/**
	 * @return string
	 */
	public function get_asset_base_path();

	// endregion

	// region Menu List Scripts

	/**
	 * @return string
	 */
	public function get_menu_list_script_slug();
	/**
	 * @return string
	 */
	public function get_menu_list_script_path();
	/**
	 * @return string
	 */
	public function get_menu_list_script_url();
	/**
	 * @return string
	 */
	public function get_menu_list_style_slug();
	/**
	 * @return string
	 */
	public function get_menu_list_style_path();
	/**
	 * @return string
	 */
	public function get_menu_list_style_url();

	// endregion

	// region Menu New Scripts

	/**
	 * @return string
	 */
	public function get_menu_new_script_slug();
	/**
	 * @return string
	 */
	public function get_menu_new_script_path();
	/**
	 * @return string
	 */
	public function get_menu_new_script_url();
	/**
	 * @return string
	 */
	public function get_menu_new_style_slug();
	/**
	 * @return string
	 */
	public function get_menu_new_style_path();
	/**
	 * @return string
	 */
	public function get_menu_new_style_url();

	// endregion

	// region Menu Edit Scripts

	/**
	 * @return string
	 */
	public function get_menu_edit_script_slug();
	/**
	 * @return string
	 */
	public function get_menu_edit_script_path();
	/**
	 * @return string
	 */
	public function get_menu_edit_script_url();
	/**
	 * @return string
	 */
	public function get_menu_edit_style_slug();
	/**
	 * @return string
	 */
	public function get_menu_edit_style_path();
	/**
	 * @return string
	 */
	public function get_menu_edit_style_url();

	// endregion

	// region Menu View Scripts

	/**
	 * @return string
	 */
	public function get_menu_view_script_slug();
	/**
	 * @return string
	 */
	public function get_menu_view_script_path();
	/**
	 * @return string
	 */
	public function get_menu_view_script_url();
	/**
	 * @return string
	 */
	public function get_menu_view_style_slug();
	/**
	 * @return string
	 */
	public function get_menu_view_style_path();
	/**
	 * @return string
	 */
	public function get_menu_view_style_url();

	// endregion


	// region Menu Delete

	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 * @param string                $message
	 *
	 * @return string
	 */
	public function get_menu_delete_link( $class = '', array $properties = array(), $message = '' );

	/**
	 * @return string
	 */
	public function get_menu_delete_permission();

	// endregion

	// region Ajax Actions

	/**
	 * @return string
	 */
	public function get_ajax_action_delete();

	// endregion

	// region Nonce

	/**
	 * @var string
	 */
	public function get_delete_nonce_action();

	/**
	 * @return string
	 */
	public function get_delete_nonce_name();


	/**
	 * @return string
	 */
	public function get_save_nonce_action();

	/**
	 * @return string
	 */
	public function get_save_nonce_name();


	/**
	 * @return string
	 */
	public function get_update_nonce_action();

	/**
	 * @return string
	 */
	public function get_update_nonce_name();

	// endregion
}