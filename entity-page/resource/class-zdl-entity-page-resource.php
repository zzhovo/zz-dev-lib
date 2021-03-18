<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_Entity_Page_Resource implements ZDL_I_Entity_Page_Resource {
	// region Menu List

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

	// endregion

	// region Menu New

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
		// @todo: menu_page_url vs admin_url
		return add_query_arg( $properties, admin_url( 'admin.php', false ) );
	}
	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_new_link( $class = '', array $properties = array() ) {
		return '<a href="' . esc_attr( $this->get_menu_new_url( $properties ) ) . '" class="' . $class . '">'
					. esc_html( $this->get_menu_new_name() ) .
				'</a>';
	}

	// endregion

	// region Menu Edit

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
	protected function set_menu_edit_name( $menu_edit_name ) {
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
	 * @param string                $class
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_edit_link( $class = '', array $properties = array() ) {
		return '<a href="' . esc_attr( $this->get_menu_edit_url( $properties ) ) . '" class="' . $class . '">'
					. esc_html( ZDL_Common_Resource::get_instance()->get_action_edit() ) .
				'</a>';
	}

	// endregion

	// region Menu View

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
	protected function set_menu_view_name( $menu_view_name ) {
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
	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 *
	 * @return string
	 */
	public function get_menu_view_link( $class = '', array $properties = array() ) {
		return '<a href="' . esc_attr( $this->get_menu_view_url( $properties ) ) . '" class="' . $class . '">'
			. esc_html( ZDL_Common_Resource::get_instance()->get_action_view() ) .
			'</a>';
	}

	// endregion


	// region Scripts Base

	/**
	 * @var string
	 */
	protected $asset_base_path;
	/**
	 * @return string
	 */
	public function get_asset_base_path() {
		return $this->asset_base_path;
	}
	/**
	 * @param string $asset_base_path
	 */
	protected function set_asset_base_path( $asset_base_path ) {
		$this->asset_base_path = trailingslashit( $asset_base_path );
	}

	/**
	 * @var string
	 */
	protected $asset_base_url;
	/**
	 * @return string
	 */
	public function get_asset_base_url() {
		return $this->asset_base_url;
	}
	/**
	 * @param string $asset_base_url
	 */
	protected function set_asset_base_url( $asset_base_url ) {
		$this->asset_base_url = trailingslashit( $asset_base_url );
	}

	// endregion

	// region Menu List Scripts

	/**
	 * @var string
	 */
	protected $menu_list_script_slug;
	/**
	 * @return string
	 */
	public function get_menu_list_script_slug() {
		return $this->menu_list_script_slug;
	}
	/**
	 * @param string $menu_list_script_slug
	 */
	protected function set_menu_list_script_slug( $menu_list_script_slug ) {
		$this->menu_list_script_slug = $menu_list_script_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_list_style_slug;
	/**
	 * @return string
	 */
	public function get_menu_list_style_slug() {
		return $this->menu_list_style_slug;
	}
	/**
	 * @param string $menu_list_style_slug
	 */
	protected function set_menu_list_style_slug( $menu_list_style_slug ) {
		$this->menu_list_style_slug = $menu_list_style_slug;
	}


	/**
	 * @var string
	 */
	protected $menu_list_script_path;
	/**
	 * @var string
	 */
	protected $menu_list_script_url;
	/**
	 * @return string
	 */
	public function get_menu_list_script_path() {
		return $this->menu_list_script_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_list_script_url() {
		return $this->menu_list_script_url;
	}
	/**
	 * @param string $menu_list_script_file_name
	 */
	protected function set_menu_list_script_file_name( $menu_list_script_file_name ) {
		$this->menu_list_script_path = $this->get_asset_base_path() . 'script/' . $menu_list_script_file_name;
		$this->menu_list_script_url = $this->get_asset_base_url() . 'script/' . $menu_list_script_file_name;
	}


	/**
	 * @var string
	 */
	protected $menu_list_style_path;
	/**
	 * @var string
	 */
	protected $menu_list_style_url;
	/**
	 * @return string
	 */
	public function get_menu_list_style_path() {
		return $this->menu_list_style_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_list_style_url() {
		return $this->menu_list_style_url;
	}
	/**
	 * @param string $menu_list_style_file_name
	 */
	protected function set_menu_list_style_file_name( $menu_list_style_file_name ) {
		$this->menu_list_style_path = $this->get_asset_base_path() . 'style/' . $menu_list_style_file_name;
		$this->menu_list_style_url = $this->get_asset_base_url() . 'style/' . $menu_list_style_file_name;
	}

	// endregion

	// region Menu New Scripts

	/**
	 * @var string
	 */
	protected $menu_new_script_slug;
	/**
	 * @return string
	 */
	public function get_menu_new_script_slug() {
		return $this->menu_new_script_slug;
	}
	/**
	 * @param string $menu_new_script_slug
	 */
	protected function set_menu_new_script_slug( $menu_new_script_slug ) {
		$this->menu_new_script_slug = $menu_new_script_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_new_style_slug;
	/**
	 * @return string
	 */
	public function get_menu_new_style_slug() {
		return $this->menu_new_style_slug;
	}
	/**
	 * @param string $menu_new_style_slug
	 */
	protected function set_menu_new_style_slug( $menu_new_style_slug ) {
		$this->menu_new_style_slug = $menu_new_style_slug;
	}


	/**
	 * @var string
	 */
	protected $menu_new_script_path;
	/**
	 * @var string
	 */
	protected $menu_new_script_url;
	/**
	 * @return string
	 */
	public function get_menu_new_script_path() {
		return $this->menu_new_script_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_new_script_url() {
		return $this->menu_new_script_url;
	}
	/**
	 * @param string $menu_new_script_file_name
	 */
	protected function set_menu_new_script_file_name( $menu_new_script_file_name ) {
		$this->menu_new_script_path = $this->get_asset_base_path() . 'script/' . $menu_new_script_file_name;
		$this->menu_new_script_url = $this->get_asset_base_url() . 'script/' . $menu_new_script_file_name;
	}


	/**
	 * @var string
	 */
	protected $menu_new_style_path;
	/**
	 * @var string
	 */
	protected $menu_new_style_url;
	/**
	 * @return string
	 */
	public function get_menu_new_style_path() {
		return $this->menu_new_style_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_new_style_url() {
		return $this->menu_new_style_url;
	}
	/**
	 * @param string $menu_new_style_file_name
	 */
	protected function set_menu_new_style_file_name( $menu_new_style_file_name ) {
		$this->menu_new_style_path = $this->get_asset_base_path() . 'style/' . $menu_new_style_file_name;
		$this->menu_new_style_url = $this->get_asset_base_url() . 'style/' . $menu_new_style_file_name;
	}

	// endregion

	// region Menu Edit Scripts

	/**
	 * @var string
	 */
	protected $menu_edit_script_slug;
	/**
	 * @return string
	 */
	public function get_menu_edit_script_slug() {
		return $this->menu_edit_script_slug;
	}
	/**
	 * @param string $menu_edit_script_slug
	 */
	protected function set_menu_edit_script_slug( $menu_edit_script_slug ) {
		$this->menu_edit_script_slug = $menu_edit_script_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_edit_style_slug;
	/**
	 * @return string
	 */
	public function get_menu_edit_style_slug() {
		return $this->menu_edit_style_slug;
	}
	protected function set_menu_edit_style_slug( $menu_edit_style_slug ) {
		$this->menu_edit_style_slug = $menu_edit_style_slug;
	}


	/**
	 * @var string
	 */
	protected $menu_edit_script_path;
	/**
	 * @var string
	 */
	protected $menu_edit_script_url;
	/**
	 * @return string
	 */
	public function get_menu_edit_script_path() {
		return $this->menu_edit_script_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_edit_script_url() {
		return $this->menu_edit_script_url;
	}
	/**
	 * @param string $menu_edit_script_file_name
	 */
	protected function set_menu_edit_script_file_name( $menu_edit_script_file_name ) {
		$this->menu_edit_script_path = $this->get_asset_base_path() . 'script/' . $menu_edit_script_file_name;
		$this->menu_edit_script_url = $this->get_asset_base_url() . 'script/' . $menu_edit_script_file_name;
	}


	/**
	 * @var string
	 */
	protected $menu_edit_style_path;
	/**
	 * @var string
	 */
	protected $menu_edit_style_url;
	/**
	 * @return string
	 */
	public function get_menu_edit_style_path() {
		return $this->menu_edit_style_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_edit_style_url() {
		return $this->menu_edit_style_url;
	}
	/**
	 * @param string $menu_edit_style_file_name
	 */
	protected function set_menu_edit_style_file_name( $menu_edit_style_file_name ) {
		$this->menu_edit_style_path = $this->get_asset_base_path() . 'style/' . $menu_edit_style_file_name;
		$this->menu_edit_style_url = $this->get_asset_base_url() . 'style/' . $menu_edit_style_file_name;
	}

	// endregion

	// region Menu View Scripts

	/**
	 * @var string
	 */
	protected $menu_view_script_slug;
	/**
	 * @return string
	 */
	public function get_menu_view_script_slug() {
		return $this->menu_view_script_slug;
	}
	/**
	 * @param string $menu_view_script_slug
	 */
	protected function set_menu_view_script_slug( $menu_view_script_slug ) {
		$this->menu_view_script_slug = $menu_view_script_slug;
	}

	/**
	 * @var string
	 */
	protected $menu_view_style_slug;
	/**
	 * @return string
	 */
	public function get_menu_view_style_slug() {
		return $this->menu_view_style_slug;
	}
	/**
	 * @param string $menu_view_style_slug
	 */
	protected function set_menu_view_style_slug( $menu_view_style_slug ) {
		$this->menu_view_style_slug = $menu_view_style_slug;
	}


	/**
	 * @var string
	 */
	protected $menu_view_script_path;
	/**
	 * @var string
	 */
	protected $menu_view_script_url;
	/**
	 * @return string
	 */
	public function get_menu_view_script_path() {
		return $this->menu_view_script_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_view_script_url() {
		return $this->menu_view_script_url;
	}
	/**
	 * @param string $menu_view_script_file_name
	 */
	protected function set_menu_view_script_file_name( $menu_view_script_file_name ) {
		$this->menu_view_script_path = $this->get_asset_base_path() . 'script/' . $menu_view_script_file_name;
		$this->menu_view_script_url = $this->get_asset_base_url() . 'script/' . $menu_view_script_file_name;
	}


	/**
	 * @var string
	 */
	protected $menu_view_style_path;
	/**
	 * @var string
	 */
	protected $menu_view_style_url;
	/**
	 * @return string
	 */
	public function get_menu_view_style_path() {
		return $this->menu_view_style_path;
	}
	/**
	 * @return string
	 */
	public function get_menu_view_style_url() {
		return $this->menu_view_style_url;
	}
	/**
	 * @param string $menu_view_style_file_name
	 */
	protected function set_menu_view_style_file_name( $menu_view_style_file_name ) {
		$this->menu_view_style_path = $this->get_asset_base_path() . 'style/' . $menu_view_style_file_name;
		$this->menu_view_style_url = $this->get_asset_base_url() . 'style/' . $menu_view_style_file_name;
	}

	// endregion


	// region Menu Delete

	/**
	 * @param string                $class
	 * @param array<string, string> $properties
	 * @param string                $message
	 *
	 * @return string
	 */
	public function get_menu_delete_link( $class = '', array $properties = array(), $message = '' ) {
		return '<a 
							href="#"
							data-properties="' . esc_attr( json_encode( $properties ) ) . '"
							data-message="' . esc_attr( $message ) . '"
							class="' . esc_attr( $class ) . '"' .
				'>'
					. esc_html( ZDL_Common_Resource::get_instance()->get_action_remove() ) .
				'</a>';
	}

	// endregion

	// region Ajax Actions

	/**
	 * @var string
	 */
	protected $ajax_action_delete;
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
	protected $delete_nonce_action;
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
	protected $delete_nonce_name;
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
	protected $save_nonce_action;
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
	protected $save_nonce_name;
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
	protected $update_nonce_action;
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
	protected $update_nonce_name;
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