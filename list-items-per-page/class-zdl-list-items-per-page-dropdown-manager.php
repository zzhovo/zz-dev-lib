<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ZDL_List_Items_Per_Page_Dropdown_Manager {
	// region singleton
	/**
	 * @var ZDL_List_Items_Per_Page_Dropdown_Manager
	 */
	static private $instance = null;
	/**
	 * @return ZDL_List_Items_Per_Page_Dropdown_Manager
	 */
	static public function get_instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	private function __construct() {
		add_action(
			'wp_ajax_' . ZDL_List_Items_Per_Page_Resource::get_instance()->ajax_action_change_list_items_per_page,
			array( $this, 'zdl_change_preference_list_items_per_page' )
		);
		add_action( 'admin_enqueue_scripts', array( $this, 'zdl_enqueue_list_items_per_page_scripts' ) );
	}
	private function __clone() {}
	private function __wakeup() {}
	// endregion

	private $nonce_already_put = false;

	/**
	 * @param string    $preference_name
	 * @param int       $selected_value
	 */
	public function draw_dropdown( $preference_name, $selected_value ) {
		$resource = ZDL_List_Items_Per_Page_Resource::get_instance();
		if( false === $this->nonce_already_put ) {
			$this->nonce_already_put = true;
			wp_nonce_field( $resource->change_list_items_per_page_nonce_action, $resource->change_list_items_per_page_nonce_name, false );
		}
	?>
		<label class="<?php echo $resource->switch_class; ?>" >
			<?php echo $resource->prop_list_items_per_page; ?>
			<select data-preference="<?php echo $preference_name; ?>" >
				<?php foreach( ZDL_E_List_Items_Per_Page::get_all() as $value ) { ?>
					<option value="<?php echo $value; ?>" <?php selected( $selected_value, $value ); ?> >
						<?php echo ZDL_E_List_Items_Per_Page::get_display_name( $value ); ?>
					</option>
				<?php } ?>
			</select>
		</label>
	<?php }

	/**
	 * action callback, should not be called directly
	 */
	public function zdl_change_preference_list_items_per_page() {
		$resource = ZDL_List_Items_Per_Page_Resource::get_instance();

		if( wp_verify_nonce( $_POST[ $resource->change_list_items_per_page_nonce_name ], $resource->change_list_items_per_page_nonce_action ) ) {
			do_action( $resource->action_preference_list_items_per_page_changed, $_POST['preference'], $_POST['value'] );
		}

		exit;
	}

	/**
	 * action callback, should not be called directly
	 */
	public function zdl_enqueue_list_items_per_page_scripts() {
		$plugin_config =  ZDL_Plugin_Config::get_instance();
		$resource = ZDL_List_Items_Per_Page_Resource::get_instance();

		wp_enqueue_script(
			'zdl-list-items-per-page-script',
			$plugin_config->get_url() . '/list-items-per-page/assets/js/zdl-list-items-per-page.js',
			array( 'jquery' ),
			$plugin_config->get_assets_version(),
			true
		);

		wp_localize_script(
			'zdl-list-items-per-page-script',
			'zdl_list_items_per_page_data',
			array(
				'ajax_url'                  => admin_url( 'admin-ajax.php' ),
				'switch_container_class'    => $resource->switch_class,
				'change_action'             => $resource->ajax_action_change_list_items_per_page,
				'nonce_name'                => $resource->change_list_items_per_page_nonce_name
			)
		);
	}
}