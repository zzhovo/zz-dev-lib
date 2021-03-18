<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_Page_Single {
	public function display_view();
	public function on_view_load();

	public function display_new();
	public function on_new_load();

	public function display_edit();
	public function on_edit_load();
}