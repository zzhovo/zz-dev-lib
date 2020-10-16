<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_Entity_Page_Resource {
	// region Menu

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