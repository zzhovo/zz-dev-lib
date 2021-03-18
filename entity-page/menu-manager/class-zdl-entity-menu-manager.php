<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class ZDL_Entity_Menu_Manager implements ZDL_I_Entity_Menu_Manager{
	// region singleton

	static protected $instance = null;
	static public function get_instance() {
		if( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	static public function setup() {
		static::get_instance();
	}
	protected function __construct() {
		add_action( 'admin_menu', array( $this, 'zdl_on_hook_admin_menu_setup_entity_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'zdl_on_hook_admin_enqueue_entity_scripts' ) );
		add_action( 'admin_init', array( $this, 'zdl_on_admin_init_strip_wp_http_referrer' ) );
		add_filter( 'submenu_file', array( $this, 'zdl_on_hook_submenu_file_fix_entity_menu' ) );

		if( defined('DOING_AJAX') && DOING_AJAX ) {
			add_action(
				'wp_ajax_' . $this->get_entity_page_resource()->get_ajax_action_delete(),
				function() {
					$this->get_entity_list_page_instance()->on_ajax_delete();
				}
			);
		}
	}
	protected function __clone() {}
	protected function __wakeup() {}

	// endregion

	// region Callbacks

	public function zdl_on_hook_admin_menu_setup_entity_menu() {
		$this->setup_menu();
		$this->setup_submenu_list();
		$this->setup_submenu_view();
		$this->setup_submenu_new();
		$this->setup_submenu_edit();
	}

	public function zdl_on_hook_admin_enqueue_entity_scripts() {
		$this->enqueue_scripts();
	}

	public function zdl_on_admin_init_strip_wp_http_referrer() {
		$this->strip_wp_http_referrer();
	}

	public function zdl_on_hook_submenu_file_fix_entity_menu( $submenu_file ) {
		return $this->fix_entity_menu( $submenu_file );
	}

	// endregion

	// region Setup Menu

	protected function setup_menu() {
		add_menu_page(
			$this->get_entity_page_resource()->get_menu_list_name(),
			$this->get_entity_page_resource()->get_menu_list_name(),
			$this->get_entity_page_resource()->get_menu_list_permission(),
			$this->get_entity_page_resource()->get_menu_list_slug()
		);
	}
	protected function setup_submenu_list() {
		$page_hook = add_submenu_page(
			$this->get_entity_page_resource()->get_menu_list_slug(),
			$this->get_entity_page_resource()->get_menu_list_name(),
			$this->get_entity_page_resource()->get_menu_list_name(),
			$this->get_entity_page_resource()->get_menu_list_permission(),
			$this->get_entity_page_resource()->get_menu_list_slug(),
			function() {
				$this->get_entity_list_page_instance()->display();
			}
		);
		add_action(
			'load-' . $page_hook,
			function() {
				$this->get_entity_list_page_instance()->on_load();
			}
		);
	}
	protected function setup_submenu_view() {
		$page_hook = add_submenu_page(
			$this->get_entity_page_resource()->get_menu_list_slug(),
			$this->get_entity_page_resource()->get_menu_view_name(),
			$this->get_entity_page_resource()->get_menu_view_name(),
			$this->get_entity_page_resource()->get_menu_list_permission(),
			$this->get_entity_page_resource()->get_menu_view_slug(),
			function() {
				$this->get_entity_single_page_instance()->display_view();
			}
		);
		add_action(
			'load-' . $page_hook,
			function() {
				$this->get_entity_single_page_instance()->on_view_load();
			}
		);
	}
	protected function setup_submenu_new() {
		$page_hook = add_submenu_page(
			$this->get_entity_page_resource()->get_menu_list_slug(),
			$this->get_entity_page_resource()->get_menu_new_name(),
			$this->get_entity_page_resource()->get_menu_new_name(),
			$this->get_entity_page_resource()->get_menu_new_permission(),
			$this->get_entity_page_resource()->get_menu_new_slug(),
			function() {
				$this->get_entity_single_page_instance()->display_new();
			}
		);
		add_action(
			'load-' . $page_hook,
			function() {
				$this->get_entity_single_page_instance()->on_new_load();
			}
		);
	}
	protected function setup_submenu_edit() {
		$page_hook = add_submenu_page(
			$this->get_entity_page_resource()->get_menu_list_slug(),
			$this->get_entity_page_resource()->get_menu_edit_name(),
			$this->get_entity_page_resource()->get_menu_edit_name(),
			$this->get_entity_page_resource()->get_menu_edit_permission(),
			$this->get_entity_page_resource()->get_menu_edit_slug(),
			function() {
				$this->get_entity_single_page_instance()->display_edit();
			}
		);
		add_action(
			'load-' . $page_hook,
			function() {
				$this->get_entity_single_page_instance()->on_edit_load();
			}
		);
	}

	// endregion

	protected function enqueue_scripts() {
		global $plugin_page;

		if( $this->get_entity_page_resource()->get_menu_list_slug() === $plugin_page ) {
			if( file_exists( $this->get_entity_page_resource()->get_menu_list_script_path() ) ) {
				wp_enqueue_script(
					$this->get_entity_page_resource()->get_menu_list_script_slug(),
					$this->get_entity_page_resource()->get_menu_list_script_url(),
					array( 'jquery' ),
					RESMS_Plugin_Config::get_instance()->get_assets_version(),
					true
				);
			}

			if( file_exists( $this->get_entity_page_resource()->get_menu_list_style_path() ) ) {
				wp_enqueue_style(
					$this->get_entity_page_resource()->get_menu_list_style_slug(),
					$this->get_entity_page_resource()->get_menu_list_style_url(),
					array(),
					RESMS_Plugin_Config::get_instance()->get_assets_version()
				);
			}
			return;
		}else if( $this->get_entity_page_resource()->get_menu_view_slug() === $plugin_page ) {
			if( file_exists( $this->get_entity_page_resource()->get_menu_view_script_path() ) ) {
				wp_enqueue_script(
					$this->get_entity_page_resource()->get_menu_view_script_slug(),
					$this->get_entity_page_resource()->get_menu_view_script_url(),
					array( 'jquery' ),
					RESMS_Plugin_Config::get_instance()->get_assets_version(),
					true
				);
			}

			if( file_exists( $this->get_entity_page_resource()->get_menu_view_style_path() ) ) {
				wp_enqueue_style(
					$this->get_entity_page_resource()->get_menu_view_style_slug(),
					$this->get_entity_page_resource()->get_menu_view_style_url(),
					array(),
					RESMS_Plugin_Config::get_instance()->get_assets_version()
				);
			}
			return;
		}else if( $this->get_entity_page_resource()->get_menu_new_slug() === $plugin_page ) {
			if( file_exists( $this->get_entity_page_resource()->get_menu_new_script_path() ) ) {
				wp_enqueue_script(
					$this->get_entity_page_resource()->get_menu_new_script_slug(),
					$this->get_entity_page_resource()->get_menu_new_script_url(),
					array( 'jquery' ),
					RESMS_Plugin_Config::get_instance()->get_assets_version(),
					true
				);
			}

			if( file_exists( $this->get_entity_page_resource()->get_menu_new_style_path() ) ) {
				wp_enqueue_style(
					$this->get_entity_page_resource()->get_menu_new_style_slug(),
					$this->get_entity_page_resource()->get_menu_new_style_url(),
					array(),
					RESMS_Plugin_Config::get_instance()->get_assets_version()
				);
			}
			return;
		}else if( $this->get_entity_page_resource()->get_menu_edit_slug() === $plugin_page ) {
			if( file_exists( $this->get_entity_page_resource()->get_menu_edit_script_path() ) ) {
				wp_enqueue_script(
					$this->get_entity_page_resource()->get_menu_edit_script_slug(),
					$this->get_entity_page_resource()->get_menu_edit_script_url(),
					array( 'jquery' ),
					RESMS_Plugin_Config::get_instance()->get_assets_version(),
					true
				);
			}

			if( file_exists( $this->get_entity_page_resource()->get_menu_edit_style_path() ) ) {
				wp_enqueue_style(
					$this->get_entity_page_resource()->get_menu_edit_style_slug(),
					$this->get_entity_page_resource()->get_menu_edit_style_url(),
					array(),
					RESMS_Plugin_Config::get_instance()->get_assets_version()
				);
			}
			return;
		}
	}

	protected function fix_entity_menu( $submenu_file ) {
		global $plugin_page;

		if (
			$this->get_entity_page_resource()->get_menu_view_slug() === $plugin_page
			|| $this->get_entity_page_resource()->get_menu_new_slug() === $plugin_page
			|| $this->get_entity_page_resource()->get_menu_edit_slug() === $plugin_page
		) {
			$submenu_file = $this->get_entity_page_resource()->get_menu_list_slug();
		}

		remove_submenu_page( $this->get_entity_page_resource()->get_menu_list_slug(), $this->get_entity_page_resource()->get_menu_list_slug() );
		remove_submenu_page( $this->get_entity_page_resource()->get_menu_list_slug(), $this->get_entity_page_resource()->get_menu_view_slug() );
		remove_submenu_page( $this->get_entity_page_resource()->get_menu_list_slug(), $this->get_entity_page_resource()->get_menu_new_slug() );
		remove_submenu_page( $this->get_entity_page_resource()->get_menu_list_slug(), $this->get_entity_page_resource()->get_menu_edit_slug() );

		return $submenu_file;
	}

	protected function strip_wp_http_referrer() {
		global $pagenow;

		if( 'admin.php' === $pagenow && isset( $_GET['_wp_http_referer'] ) ) {
			if( ! empty( $_REQUEST['page'] ) ) {
				if(
					$_REQUEST['page'] === $this->get_entity_page_resource()->get_menu_list_slug()
					|| $_REQUEST['page'] === $this->get_entity_page_resource()->get_menu_view_slug()
					|| $_REQUEST['page'] === $this->get_entity_page_resource()->get_menu_new_slug()
					|| $_REQUEST['page'] === $this->get_entity_page_resource()->get_menu_edit_slug()
				) {
					wp_safe_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce' ), wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
					exit;
				}
			}
		}
	}
}

// todo: check all singletons to contain __construct, __clone, __wakeup