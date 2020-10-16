<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_List_Items_Per_Page_Resource {
	// region singleton
	/**
	 * @var ZDL_List_Items_Per_Page_Resource
	 */
	static private $instance = null;
	/**
	 * @return ZDL_List_Items_Per_Page_Resource
	 */
	static public function get_instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	private function __construct() {
		$this->prop_list_items_per_page = __( 'Ամեն էջում քանակը', 'zdl' );
	}
	private function __clone() {}
	private function __wakeup() {}
	// endregion

	/** @var string */
	public $prop_list_items_per_page;
	/** @var string */
	public $switch_class = 'switch_list_items_per_page';

	/** @var string */
	public $change_list_items_per_page_nonce_action = 'change_list_items_per_page';
	/** @var string */
	public $change_list_items_per_page_nonce_name = 'change_list_items_per_page_nonce';
	/** @var string */
	public $ajax_action_change_list_items_per_page = 'zdl_change_list_items_per_page';
	/** @var string */
	public $action_preference_list_items_per_page_changed = 'zdl_preference_list_items_per_page_changed';
}