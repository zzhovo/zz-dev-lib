<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

abstract class ZDL_Page_List extends WP_List_Table {
	// region singleton

	static protected $instance = null;
	static public function get_instance() {
		if( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	public function __construct() {
		if( null !== static::$instance ) {
			throw new Exception( static::class . ' should be created only once.');
		}

		$this->prepare_columns();

		parent::__construct( array(
			'singular'  => 'item',
			'plural'    => 'items',
			'ajax'      => false
		) );
	}
	protected function __clone() {}
	protected function __wakeup() {}

	// endregion

	protected $filters = array( 'orderby', 'order', 'items_per_page', 'current_page' );
	protected $filter = array();
	/**
	 * @var ZDL_I_Entity_Page_Resource
	 */
	protected $resource;

	protected $permissions_new = array();
	protected $permissions_edit = array();
	protected $permissions_delete = array();

	public function display() {
		$this->prepare_items();

		if( ZDL_User_Permission::current_user_can_optimistic( $this->permissions_delete ) ) {
			wp_nonce_field( $this->resource->get_delete_nonce_action(), $this->resource->get_delete_nonce_name(), false );
		}
		?>
		<div class="wrap">
			<h1>
				<?php echo get_admin_page_title(); ?>
				<hr />
				<?php if( ZDL_User_Permission::current_user_can_optimistic( $this->permissions_new ) ) {
					echo $this->resource->get_menu_new_link( 'page-title-action' );
				} ?>
				<hr class="wp-header-end" />
			</h1>
			<?php $this->views(); ?>
			<form method="get">
				<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
				<?php parent::display(); ?>
			</form>
		</div>
		<?php
	}

	public function prepare_items() {
		$this->prepare_filter();

		$this->items = $this->_get_items();
		$total_count = $this->_get_items_total_count();

		if( 0 === count( $this->items ) && ! empty( $_REQUEST['paged'] ) && 1 < intval( $_REQUEST['paged'] ) ) {
			$url = preg_replace('/paged=\d/', 'paged=1', $_SERVER['REQUEST_URI'] );
			echo('<script>location.href = "' .site_url() . $url. '"</script>');
			exit;
		}

		$this->set_pagination_args(
			array(
				'total_items' => $total_count,
				'per_page'    => $this->filter['items_per_page']
			)
		);

		$this->_column_headers = array(
			$this->get_columns(),
			$this->get_hidden_columns(),
			$this->get_sortable_columns()
		);
	}

	abstract protected function _get_items();
	abstract protected function _get_items_total_count();

	// region Filters

	public function prepare_filter() {
		foreach( $this->filters as $filter ) {
			if( method_exists( $this, 'get_filter_value_' . $filter ) ) {
				$filter_value = call_user_func( array( $this, 'get_filter_value_' . $filter ) );
			} else {
				$filter_value = $this->get_filter_value_default( $filter );
			}

			if( null !== $filter_value ) {
				$this->filter[ $filter ] = $filter_value;
			}
		}
	}

	protected function get_filter_value_default( $column_name ) {
		if( ! empty( $_REQUEST[ $column_name ] ) ) {
			return $_REQUEST[ $column_name ];
		} else {
			return null;
		}
	}
	/**
	 * @return string
	 * @throws Exception
	 */
	protected function get_filter_value_orderby() {
		if( ! empty( $_REQUEST['orderby'] ) && in_array( $_REQUEST['orderby'], array_keys( $this->get_sortable_columns() ) ) ) {
			return $_REQUEST['orderby'];
		} else if( array_key_exists( 'date_updated', $this->_all_columns ) ) {
			return 'date_updated';
		} else if( array_key_exists( 'date_created', $this->_all_columns ) ) {
			return 'date_created';
		} else if( array_key_exists( 'id', $this->_all_columns ) ) {
			return 'id';
		} else {
			throw new Exception('please overwrite this method to always return a valid sortable column');
		}
	}
	/**
	 * @return string
	 */
	protected function get_filter_value_order() {
		if( ! empty( $_REQUEST['orderby'] ) && ! empty( $_REQUEST['order'] ) && 'asc' === strtolower( $_REQUEST['order'] ) ) {
			return 'ASC';
		}else{
			return 'DESC';
		}
	}
	/**
	 * @return int
	 */
	protected function get_filter_value_items_per_page() {
		return 100;
	}
	/**
	 * @return int
	 */
	protected function get_filter_value_current_page() {
		return $this->get_pagenum();
	}

	protected function extra_tablenav( $which ) { return;
		if ( $which == 'top' ) { ?>
			<div class="container">
				<div class="row">
					<?php // echo $this->display_filter_fname( $which ); ?>
					<?php // echo $this->display_filter_lname( $which ); ?>
					<?php // echo $this->display_filter_mname( $which ); ?>
					<?php // echo $this->display_filter_dob( $which ); ?>
					<?php // echo $this->display_filter_gender( $which ); ?>
					<?php // echo $this->display_filter_address( $which ); ?>
					<?php // echo $this->display_filter_phone( $which ); ?>
					<?php // echo $this->display_filter_email( $which ); ?>
					<?php // echo $this->display_filter_comment( $which ); ?>
					<?php // echo $this->display_filter_date_created( $which ); ?>
					<?php // echo $this->display_filter_date_updated( $which ); ?>
					<span class="filter">
						<?php // submit_button( MM_Common_Resource::get_instance()->action_filter, 'action', '', false ); ?>
					</span>
				</div>
			</div>
			<br />
		<?php }else if( $which === 'bottom' ) { ?>
			<div class="container">
				<div class="row">
					<?php
					ZDL_List_Items_Per_Page_Dropdown_Manager::get_instance()->draw_dropdown(
						RESMS_E_User_Preference_List_Items_Per_Page::LIST_ITEMS_PER_PAGE_COMPANY,
						$this->filter['items_per_page']
					);
					?>
				</div>
			</div>
		<?php }
	}
	protected function display_filter_fname( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_fname_id">
                    <?php echo esc_html( $common_resource->prop_fname ); ?>
                </label>
                <input autocomplete="off"
                       id="f_fname_id"
                       name="f_fname"
                       value="<?php echo esc_attr( $this->filter['f_fname'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_lname( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_lname_id">
                    <?php echo esc_html( $common_resource->prop_lname ); ?>
                </label>
                <input autocomplete="off"
                       id="f_lname_id"
                       name="f_lname"
                       value="<?php echo esc_attr( $this->filter['f_lname'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_mname( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_mname_id">
                    <?php echo esc_html( $common_resource->prop_mname ); ?>
                </label>
                <input autocomplete="off"
                       id="f_mname_id"
                       name="f_mname"
                       value="<?php echo esc_attr( $this->filter['f_mname'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_dob( $which ) {
		if ( $which == "top" ) {
			$common_resource = MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_dob_s_id">
                    <?php echo esc_html( $common_resource->prop_dob ); ?>
                </label>
                <input autocomplete="off"
                       id="f_dob_s_id"
                       name="f_dob_s"
                       placeholder="<?php echo esc_attr( $common_resource->input_placeholder_date ); ?>"
                       value="<?php echo esc_attr( $this->filter['f_dob_s'] ); ?>"
                />
                /
                <input autocomplete="off"
                       id="f_dob_e_id"
                       name="f_dob_e"
                       placeholder="<?php echo esc_attr( $common_resource->input_placeholder_date ); ?>"
                       value="<?php echo esc_attr( $this->filter['f_dob_e'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_gender( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_gender_id">
                    <?php echo esc_html( $common_resource->prop_gender ); ?>
                </label>
                <select id="f_gender_id" name="f_gender" >
                    <option value="" ><?php echo esc_html( $common_resource->filter_select_all ); ?></option>
                    <?php foreach( MM_Enum_Gender::get_all() as $gender ) { ?>
	                    <option value="<?php echo esc_attr( $gender ); ?>" <?php selected( $gender, $this->filter['f_gender'] ); ?> >
                            <?php echo esc_html( MM_Enum_Gender::get_display_name( $gender ) ); ?>
                        </option>
                    <?php } ?>
                </select>
            </span>
		<?php }
	}
	protected function display_filter_address( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_address_id">
                    <?php echo esc_html( $common_resource->prop_address ); ?>
                </label>
                <input autocomplete="off"
                       id="f_address_id"
                       name="f_address"
                       value="<?php echo esc_attr( $this->filter['f_address'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_phone( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_phone_id">
                    <?php echo esc_html( $common_resource->prop_phone ); ?>
                </label>
                <input autocomplete="off"
                       id="f_phone_id"
                       name="f_phone"
                       value="<?php echo esc_attr( $this->filter['f_phone'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_email( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_email_id">
                    <?php echo esc_html( $common_resource->prop_email ); ?>
                </label>
                <input autocomplete="off"
                       id="f_email_id"
                       name="f_email"
                       value="<?php echo esc_attr( $this->filter['f_email'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_comment( $which ) {
		if ( $which == "top" ) {
			$common_resource =  MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_comment_id">
                    <?php echo esc_html( $common_resource->prop_comment ); ?>
                </label>
                <input autocomplete="off"
                       id="f_comment_id"
                       name="f_comment"
                       value="<?php echo esc_attr( $this->filter['f_comment'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_date_created( $which ) {
		if ( $which == "top" ) {
			$common_resource = MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_date_created_s_id">
                    <?php echo esc_html( $common_resource->prop_date_created ); ?>
                </label>
                <input autocomplete="off"
                       id="f_date_created_s_id"
                       name="f_date_created_s"
                       placeholder="<?php echo esc_attr( $common_resource->input_placeholder_date ); ?>"
                       value="<?php echo esc_attr( $this->filter['f_date_created_s'] ); ?>"
                />
                /
                <input autocomplete="off"
                       id="f_date_created_e_id"
                       name="f_date_created_e"
                       placeholder="<?php echo esc_attr( $common_resource->input_placeholder_date ); ?>"
                       value="<?php echo esc_attr( $this->filter['f_date_created_e'] ); ?>"
                />
            </span>
		<?php }
	}
	protected function display_filter_date_updated( $which ) {
		if ( $which == "top" ) {
			$common_resource = MM_Common_Resource::get_instance();
			?>
			<span class="filter">
                <label for="f_date_updated_s_id">
                    <?php echo esc_html( $common_resource->prop_date_updated ); ?>
                </label>
                <input autocomplete="off"
                       id="f_date_updated_s_id"
                       name="f_date_updated_s"
                       placeholder="<?php echo esc_attr( $common_resource->input_placeholder_date ); ?>"
                       value="<?php echo esc_attr( $this->filter['f_date_updated_s'] ); ?>"
                />
                /
                <input autocomplete="off"
                       id="f_date_updated_e_id"
                       name="f_date_updated_e"
                       placeholder="<?php echo esc_attr( $common_resource->input_placeholder_date ); ?>"
                       value="<?php echo esc_attr( $this->filter['f_date_updated_e'] ); ?>"
                />
            </span>
		<?php }
	}

	// endregion

	// region Columns

	/**
	 * @var array<string, string>
	 */
	protected $_all_columns = array();
	/**
	 * @var string[]
	 */
	protected $_selected_columns = array();
	/**
	 * @var string[]
	 */
	protected $_default_columns = array();
	/**
	 * @var string[]
	 */
	protected $_hidden_columns = array();
	/**
	 * @var array<string, array<string, bool>>
	 */
	protected $_sortable_columns = array();

	/**
	 * @return void
	 */
	protected function prepare_columns() {
		if( empty( $_REQUEST['s_c'] ) || ! is_array( $_REQUEST['s_c'] ) || 0 === count( $_REQUEST['s_c'] ) ) {
			foreach( $this->_default_columns as $column_name ) {
				$this->_selected_columns[] = $column_name;
			}
		} else {
			foreach( array_keys( $_REQUEST['s_c'] ) as $column_name ) {
				$this->_selected_columns[] = $column_name;
			}
		}
	}

	public function get_columns() {
		$columns = array();
		foreach( $this->_selected_columns as $column_name ) {
			$columns[ $column_name ] = $this->_all_columns[$column_name ];
		}

		return $columns;
	}

	public function get_hidden_columns() {
		return $this->_hidden_columns;
	}

	public function get_sortable_columns() {
		return $this->_sortable_columns;
	}

	protected function _get_row_actions( $entity, $column_name ) {
		$actions = array();

		$actions['view'] = $this->resource->get_menu_view_link( '', $entity );
		if( ZDL_User_Permission::current_user_can_optimistic( $this->permissions_edit ) ) {
			$actions['edit'] = $this->resource->get_menu_edit_link( '', $entity );
		}

		if( ZDL_User_Permission::current_user_can_optimistic( $this->permissions_delete ) ){
			$actions['delete'] = $this->resource->get_menu_delete_link( 'action-delete', $entity );
		}

		return sprintf(
			'%1$s %2$s',
			( empty( $entity[$column_name ] ) ? '-//-' : $entity[$column_name ] ),
			$this->row_actions( $actions )
		);
	}

	public function column_default( $item, $column_name ) {
		if( $column_name === $this->_selected_columns[0] ) {
			return $this->_get_row_actions( $item, $column_name );
		}else{
			if( empty( $item[ $column_name ] ) ) {
				return '-//-';
			} else {
				return esc_html( $item[ $column_name ] );
			}
		}
	}

	// endregion
}