<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_Entity_Page_Resource implements ZDL_I_Entity_Page_Resource {
	// region Menu

	/**
	 * @var string
	 */
	protected $menu_list_slug;
	/**
	 * @return string
	 */
	public function get_menu_list_slug() {
		return $this->menu_list_slug;
	}
	/**
	 * @param string $menu_list_slug
	 */
	protected function set_menu_list_slug( $menu_list_slug ) {
		$this->menu_list_slug = $menu_list_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_list_name;
	/**
	 * @return string
	 */
	public function get_menu_list_name() {
		return $this->menu_list_name;
	}
	/**
	 * @param string $menu_list_name
	 */
	protected function set_menu_list_name( $menu_list_name ) {
		$this->menu_list_name = $menu_list_name;
	}

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_list_url( array $properties = array() ) {
		$properties['page'] = $this->get_menu_list_slug();
		return add_query_arg( $properties, admin_url( 'admin.php', false ) );
	}


	/**
	 * @var string
	 */
	protected $menu_new_slug;
	/**
	 * @return string
	 */
	public function get_menu_new_slug() {
		return $this->menu_new_slug;
	}
	/**
	 * @param string $menu_new_slug
	 */
	protected function set_menu_new_slug( $menu_new_slug ) {
		$this->menu_new_slug = $menu_new_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_new_name;
	/**
	 * @return string
	 */
	public function get_menu_new_name() {
		return $this->menu_new_name;
	}
	/**
	 * @param string $menu_new_name
	 */
	protected function set_menu_new_name( $menu_new_name ) {
		$this->menu_new_name = $menu_new_name;
	}

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_new_url( array $properties = array() ) {
		$properties['page'] = $this->get_menu_new_slug();
		return add_query_arg( $properties, admin_url( 'admin.php', false ) );
	}


	/**
	 * @var string
	 */
	protected $menu_edit_slug;
	/**
	 * @return string
	 */
	public function get_menu_edit_slug() {
		return $this->menu_edit_slug;
	}
	/**
	 * @param string $menu_edit_slug
	 */
	protected function set_menu_edit_slug( $menu_edit_slug ) {
		$this->menu_edit_slug = $menu_edit_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_edit_name;
	/**
	 * @return string
	 */
	public function get_menu_edit_name() {
		return $this->menu_edit_name;
	}
	/**
	 * @param string $menu_edit_name
	 */
	public function set_menu_edit_name( $menu_edit_name ) {
		$this->menu_edit_name = $menu_edit_name;
	}

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_edit_url( array $properties = array() ) {
		$properties['page'] = $this->get_menu_edit_slug();
		return add_query_arg( $properties, admin_url( 'admin.php', false ) );
	}


	/**
	 * @var string
	 */
	protected $menu_view_slug;
	/**
	 * @return string
	 */
	public function get_menu_view_slug() {
		return $this->menu_view_slug;
	}
	/**
	 * @param string $menu_view_slug
	 */
	protected function set_menu_view_slug( $menu_view_slug ) {
		$this->menu_view_slug = $menu_view_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_view_name;
	/**
	 * @return string
	 */
	public function get_menu_view_name() {
		return $this->menu_view_name;
	}
	/**
	 * @param string $menu_view_name
	 */
	public function set_menu_view_name( $menu_view_name ) {
		$this->menu_view_name = $menu_view_name;
	}

	/**
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_view_url( array $properties = array() ) {
		$properties['page'] = $this->get_menu_view_slug();
		return add_query_arg( $properties, admin_url( 'admin.php', false ) );
	}

	// endregion

	// region Ajax Actions

	/**
	 * @var string
	 */
	public $ajax_action_delete;
	/**
	 * @return string
	 */
	public function get_ajax_action_delete() {
		return $this->ajax_action_delete;
	}
	/**
	 * @param string $ajax_action_delete
	 */
	protected function set_ajax_action_delete( $ajax_action_delete ) {
		$this->ajax_action_delete = $ajax_action_delete;
	}

	// endregion

	// region Nonce

	/**
	 * @var string
	 */
	public $delete_nonce_action;
	/**
	 * @return string
	 */
	public function get_delete_nonce_action() {
		return $this->delete_nonce_action;
	}
	/**
	 * @param string $delete_nonce_action
	 */
	protected function set_delete_nonce_action( $delete_nonce_action ) {
		$this->delete_nonce_action = $delete_nonce_action;
	}

	/**
	 * @var string
	 */
	public $delete_nonce_name;
	/**
	 * @return string
	 */
	public function get_delete_nonce_name() {
		return $this->delete_nonce_name;
	}
	/**
	 * @param string $delete_nonce_name
	 */
	protected function set_delete_nonce_name( $delete_nonce_name ) {
		$this->delete_nonce_name = $delete_nonce_name;
	}


	/**
	 * @var string
	 */
	public $save_nonce_action;
	/**
	 * @return string
	 */
	public function get_save_nonce_action() {
		return $this->save_nonce_action;
	}
	/**
	 * @param string $save_nonce_action
	 */
	protected function set_save_nonce_action( $save_nonce_action ) {
		$this->save_nonce_action = $save_nonce_action;
	}

	/**
	 * @var string
	 */
	public $save_nonce_name;
	/**
	 * @return string
	 */
	public function get_save_nonce_name() {
		return $this->save_nonce_name;
	}
	/**
	 * @param string $save_nonce_name
	 */
	protected function set_save_nonce_name( $save_nonce_name ) {
		$this->save_nonce_name = $save_nonce_name;
	}


	/**
	 * @var string
	 */
	public $update_nonce_action;
	/**
	 * @return string
	 */
	public function get_update_nonce_action() {
		return $this->update_nonce_action;
	}
	/**
	 * @param string $update_nonce_action
	 */
	protected function set_update_nonce_action( $update_nonce_action ) {
		$this->update_nonce_action = $update_nonce_action;
	}

	/**
	 * @var string
	 */
	public $update_nonce_name;
	/**
	 * @return string
	 */
	public function get_update_nonce_name() {
		return $this->update_nonce_name;
	}
	/**
	 * @param string $update_nonce_name
	 */
	protected function set_update_nonce_name( $update_nonce_name ) {
		$this->update_nonce_name = $update_nonce_name;
	}

	// endregion
}