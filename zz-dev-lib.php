<?php
/**
 * Plugin Name: ZZ Dev Lib
 * Description: A Library to use to build WP plugins and themes
 * Text Domain: zz-dev-lib
 * Version: 1.0
 * Requires PHP: 7.2
 * Author: Hovhannes Ghurshudyan
 * Author URI: mailto://zz.hovo@gmail.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_Plugin_Config {
	// region singleton
	/**
	 * @var ZDL_Plugin_Config
	 */
	static private $instance = null;
	/**
	 * @return ZDL_Plugin_Config
	 */
	static public function get_instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	private function __construct() {
		$this->path = untrailingslashit( plugin_dir_path( __FILE__ ) );
		$this->url = untrailingslashit( plugin_dir_url( __FILE__ ) );
	}
	private function __clone() {}
	private function __wakeup() {}
	// endregion

	/**
	 * @var string
	 */
	private $path;
	/**
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * @var string
	 */
	private $url;
	/**
	 * @return string
	 */
	public function get_url() {
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function get_assets_path() {
		return $this->get_path() . '/assets';
	}

	/**
	 * @return string
	 */
	public function get_assets_url() {
		return $this->get_url() . '/assets';
	}

	/**
	 * @var string
	 */
	private $assets_version = '0.1';
	/**
	 * @return string
	 */
	public function get_assets_version() {
		return $this->assets_version;
	}

	/**
	 * @var string
	 */
	private $db_table_prefix = 'zdl_';
	/**
	 * @return string
	 */
	public function get_db_table_prefix() {
		return $this->db_table_prefix;
	}
}

require_once( ZDL_Plugin_Config::get_instance()->get_path() . '/main.php' );

do_action( 'zdl_loaded' );