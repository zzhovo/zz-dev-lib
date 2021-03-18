<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ZDL_Common_Resource {
	// region singleton
	static protected $instance = null;
	static public function get_instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	protected function __construct() {
		$this->action_view      = __( 'Դիտել', 'zdl' );
		$this->action_edit      = __( 'Խմբագրել', 'zdl' );
		$this->action_remove    = __( 'Ջնջել', 'zdl' );
		$this->action_save      = __( 'Պահպանել', 'zdl' );
		$this->action_filter    = __( 'Ֆիլտրել', 'zdl' );
	}
	protected function __clone() {}
	protected function __wakeup() {}
	// endregion

	// region Actions

	/**
	 * @var string
	 */
	protected $action_view;
	/**
	 * @return string
	 */
	public function get_action_view() {
		return $this->action_view;
	}

	/**
	 * @var string
	 */
	protected $action_edit;
	/**
	 * @return string
	 */
	public function get_action_edit() {
		return $this->action_edit;
	}

	/**
	 * @var string
	 */
	protected $action_remove;
	/**
	 * @return string
	 */
	public function get_action_remove() {
		return $this->action_remove;
	}

	/**
	 * @var string
	 */
	protected $action_save;
	/**
	 * @return string
	 */
	public function get_action_save() {
		return $this->action_save;
	}

	/**
	 * @var string
	 */
	protected $action_filter;
	/**
	 * @return string
	 */
	public function get_action_filter() {
		return $this->action_filter;
	}

	// endregion
}