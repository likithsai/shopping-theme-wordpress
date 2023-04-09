<?php
	// https://supporthost.com/wp-list-table-tutorial/

	if (!class_exists('WP_List_Table')) {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	}

	class ProductList extends WP_List_Table {
		/**
		 * Prepare the items for the table to process
		 *
		 * @return Void
		 */
		public function prepare_items() {
			$columns = $this->get_columns();
			$hidden = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();

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
				'product_id' => 'ID',
				'product_images' => 'Image',
				'product_name' => 'Name',
				'product_desc' => 'Description',
				'product_old_price' => 'Old Price',
				'product_new_price' => 'New Price',
				'product_created_date' => 'Created Date'
			);

			return $columns;
		}

		function column_cb($item) {
			return sprintf( '<input type="checkbox" name="element[]" value="%s" />', $item['product_id'] );
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
				'product_id' => array('product_id', false), 
				'product_created_date'   => array('product_created_date', true), 
				'product_old_price'   => array('product_old_price', true),
				'product_new_price'   => array('product_new_price', true)
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
			$table_name = $wpdb->prefix . 'tbl_products';
			$wk_post=$wpdb->get_results("SELECT * FROM $table_name");

			foreach($wk_post as $wp) {
				$data[] = array(
					'product_id' => $wp->product_id,
					'product_images' => $this->decode_img_json($wp->product_img),
					'product_name' => $wp->product_name,
					'product_desc' => $wp->product_desc_short,
					'product_old_price' => $wp->product_item_oldprice,
					'product_new_price' => $wp->product_item_newprice,
					'product_created_date' => $wp->product_createddate
				);
			}

			return $data;
		}

		private function decode_img_json($json) {
			$imgStr = '';
			foreach(json_decode($json)[0] -> itemimages as $img) {
				$imgStr .= "<img style='display: block;' width='100' height='100' src='{$img->imageurl}' />";
			}
			return $imgStr;
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
				case 'product_id':
				case 'product_images':
				case 'product_name':
				case 'product_desc':
				case 'product_old_price':
				case 'product_new_price':
				case 'product_created_date':
					return $item[ $column_name ];

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
		function column_product_name($item) {
			$actions = array(
				'edit'      => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Edit', 'supporthost-admin-table') . '</a>', $_REQUEST['page'], 'edit', $item['ID']),
				'delete'    => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Delete', 'supporthost-admin-table') . '</a>', $_REQUEST['page'], 'delete', $item['ID']),
			);
	
			return sprintf('%1$s %2$s', $item['product_name'], $this->bulk_row_actions($actions));
		}

		function no_items() {
			_e( 'No products found, dude.' );
		}
	}
?>

<div class="wrap">
	<h1><?php echo get_admin_page_title() ?></h1>
	<?php
		$exampleListTable = new ProductList();
        $exampleListTable->prepare_items();
		$exampleListTable->display();
	?>
</div>