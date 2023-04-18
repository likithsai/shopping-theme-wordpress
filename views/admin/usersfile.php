<?php
	// https://supporthost.com/wp-list-table-tutorial/

	if (!class_exists('WP_List_Table')) {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	}

	class UserList extends WP_List_Table {
		/**
		 * Prepare the items for the table to process
		 *
		 * @return Void
		 */
		public function prepare_items() {
			$columns = $this->get_columns();
			$hidden = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();

			$this->process_bulk_action();

			$data = $this->table_data();
			usort( $data, array( &$this, 'sort_data' ) );

			$perPage = 10;
			$currentPage = $this->get_pagenum();
			$totalItems = count($data);

			$this->set_pagination_args( array(
				'total_items' => $totalItems,
				'per_page'    => $perPage,
				'total_pages' => ceil( $totalItems / $perPage )
			) );

			$data = array_slice( $data, (( $currentPage-1 ) * $perPage ), $perPage );

			$this->_column_headers = array( $columns, $hidden, $sortable );
			$this->items = $data;
		}

		/**
		 * Override the parent columns method. Defines the columns to use in your listing table
		 *
		 * @return Array
		 */
		public function get_columns() {
			$columns = array(
				'cb' => '<input type="checkbox" />',
				'user_id' => 'ID',
				'user_name' => 'Name',
				'user_email' => 'Email',
				'user_created_date' => 'Created Date'
			);

			return $columns;
		}

		function column_cb($item) {
			return sprintf( '<input type="checkbox" name="element[]" value="%s" />', $item['user_id'] );
		}

		/**
		 * Define which columns are hidden
		 *
		 * @return Array
		 */
		public function get_hidden_columns() {
			return array();
		}

		/**
		 * Define the sortable columns
		 *
		 * @return Array
		 */
		public function get_sortable_columns() {
			return array(
				'user_id' => array('user_id', false), 
				'user_created_date'   => array('user_created_date', true)
			);
		}

		/**
		 * Get the table data
		 *
		 * @return Array
		 */
		private function table_data() {
			$data = array();
			global $wpdb;
			$table_name = $wpdb->prefix . 'tbl_users';
			$wk_post=$wpdb->get_results("SELECT * FROM $table_name");

			foreach($wk_post as $wp) {
				$data[] = array(
					'user_id' => $wp->user_id,
					'user_name' => $wp->user_name,
					'user_email' => $wp->user_email,
					'user_created_date' => $wp->user_createddate
				);
			}

			return $data;
		}


		/**
		 * Define what data to show on each column of the table
		 *
		 * @param  Array $item        Data
		 * @param  String $column_name - Current column name
		 *
		 * @return Mixed
		 */
		public function column_default( $item, $column_name ) {
			switch( $column_name ) {
				case 'user_id':
				case 'user_name':
				case 'user_email':
				case 'user_created_date':
					return esc_html( $item[ $column_name ] );

				default:
					return esc_html( print_r( $item, true ) );
			}
		}

		/**
		 * Allows you to sort the data by the variables set in the $_GET
		 *
		 * @return Mixed
		 */
		private function sort_data( $a, $b ) {
			// Set defaults
			$orderby = 'title';
			$order = 'asc';

			// If orderby is set, use this as the sort column
			if(!empty($_GET['orderby'])) {
				$orderby = $_GET['orderby'];
			}

			// If order is set use this as the order
			if(!empty($_GET['order'])) {
				$order = $_GET['order'];
			}


			$result = strcmp( $a[$orderby], $b[$orderby] );

			if($order === 'asc') {
				return $result;
			}

			return -$result;
		}

		function get_bulk_actions() {
			$actions = array(
				'delete_selected' => 'Delete'
			);
			return $actions;
		}

		public function process_bulk_action() {
			// security check!
			if ('delete_selected' === $this->current_action()) {
				var_dump($this->current_action());
			}
		}

		// Adding action links to column
		function column_categories_name($item) {
			$actions = array(
				'edit'      => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Edit', 'supporthost-admin-table') . '</a>', $_REQUEST['page'], 'edit', $item['ID']),
				'delete'    => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Delete', 'supporthost-admin-table') . '</a>', $_REQUEST['page'], 'delete', $item['ID']),
			);
	
			return sprintf('%1$s %2$s', $item['categories_name'], $this->bulk_row_actions($actions));
		}

		function no_items() {
			_e( 'No products found, dude.' );
		}
	}
?>

<div class="wrap">
	<h1><?php echo get_admin_page_title() ?></h1>
	<?php
		$exampleListTable = new UserList();
        $exampleListTable->prepare_items();
		$exampleListTable->display();
	?>
</div>