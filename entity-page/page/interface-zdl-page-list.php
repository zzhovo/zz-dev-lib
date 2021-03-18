<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ZDL_I_Page_List {
	public function display();

	public function on_load();

	public function on_ajax_delete();
}