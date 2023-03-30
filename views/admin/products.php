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
				'cb'            		=> '<input type="checkbox" />',
				'product_id'          	=> 'Product ID',
				'product_name'       	=> 'Product Name',
				// 'product_desc_short' 	=> 'Product Desc (Short)',
				// 'product_desc_long'     => 'Product Desc (Long)',
				'product_price'    => 'Product Price',
				'product_created_date'      => 'Product Created Date'
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
			return array('product_id' => array('product_id', false), 'product_created_date'   => array('product_created_date', true));
		}

		/**
		 * Get the table data
		 *
		 * @return Array
		 */
		private function table_data() {
			$data = array();

			$data[] = array(
						'product_id'          => 1,
						'product_name'       => '<u>The Shawshank Redemption</u><br />Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
						// 'product_desc_short' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
						// 'product_desc_long'        => '1994',
						'product_price'    => 'Frank Darabont',
						'product_created_date'      => '9.3'
						);

			$data[] = array(
						'product_id'          => 2,
						'product_name'       => '<u>The Godfather</u><br />The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
						// 'product_desc_short' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
						// 'product_desc_long'        => '1972',
						'product_price'    => 'Francis Ford Coppola',
						'product_created_date'      => '9.2'
						);

			$data[] = array(
						'product_id'          => 3,
						'product_name'       => '<u>The Godfather: Part II</u><br/>The early life and career of Vito Corleone in 1920s New York is portrayed while his son, Michael, expands and tightens his grip on his crime syndicate stretching from Lake Tahoe, Nevada to pre-revolution 1958 Cuba.',
						// 'product_desc_short' => 'The early life and career of Vito Corleone in 1920s New York is portrayed while his son, Michael, expands and tightens his grip on his crime syndicate stretching from Lake Tahoe, Nevada to pre-revolution 1958 Cuba.',
						// 'product_desc_long'        => '1974',
						'product_price'    => 'Francis Ford Coppola',
						'product_created_date'      => '9.0'
						);

			$data[] = array(
						'product_id'          => 4,
						'product_name'       => '<u>Pulp Fiction</u><br />The lives of two mob hit men, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
						// 'product_desc_short' => 'The lives of two mob hit men, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
						// 'product_desc_long'        => '1994',
						'product_price'    => 'Quentin Tarantino',
						'product_created_date'      => '9.0'
						);

			$data[] = array(
						'product_id'          => 5,
						'product_name'       => '<u>The Good, the Bad and the Ugly</u><br />A bounty hunting scam joins two men in an uneasy alliance against a third in a race to find a fortune in gold buried in a remote cemetery.',
						// 'product_desc_short' => 'A bounty hunting scam joins two men in an uneasy alliance against a third in a race to find a fortune in gold buried in a remote cemetery.',
						// 'product_desc_long'        => '1966',
						'product_price'    => 'Sergio Leone',
						'product_created_date'      => '9.0'
						);

			$data[] = array(
						'product_id'          => 6,
						'product_name'       => '<u>The Dark Knight</u><br/>When Batman, Gordon and Harvey Dent launch an assault on the mob, they let the clown out of the box, the Joker, bent on turning Gotham on itself and bringing any heroes down to his level.',
						// 'product_desc_short' => 'When Batman, Gordon and Harvey Dent launch an assault on the mob, they let the clown out of the box, the Joker, bent on turning Gotham on itself and bringing any heroes down to his level.',
						// 'product_desc_long'        => '2008',
						'product_price'    => 'Christopher Nolan',
						'product_created_date'      => '9.0'
						);

			$data[] = array(
						'product_id'          => 7,
						'product_name'       => '<u>12 Angry Men</u><br />A dissenting juror in a murder trial slowly manages to convince the others that the case is not as obviously clear as it seemed in court.',
						// 'product_desc_short' => 'A dissenting juror in a murder trial slowly manages to convince the others that the case is not as obviously clear as it seemed in court.',
						// 'product_desc_long'        => '1957',
						'product_price'    => 'Sidney Lumet',
						'product_created_date'      => '8.9'
						);

			$data[] = array(
						'product_id'          => 8,
						'product_name'       => '<u>Schindler\'s List</u><br />In Poland during World War II, Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.',
						// 'product_desc_short' => 'In Poland during World War II, Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.',
						// 'product_desc_long'        => '1993',
						'product_price'    => 'Steven Spielberg',
						'product_created_date'      => '8.9'
						);

			$data[] = array(
						'product_id'          => 9,
						'product_name'       => '<u>The Lord of the Rings: The Return of the King</u><br />Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.',
						// 'product_desc_short' => 'Gandalf and Aragorn lead the World of Men against Sauron\'s army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.',
						// 'product_desc_long'        => '2003',
						'product_price'    => 'Peter Jackson',
						'product_created_date'      => '8.9'
						);

			$data[] = array(
						'product_id'          => 10,
						'product_name'       => '<u>Fight Club</u></br>An insomniac office worker looking for a way to change his life crosses paths with a devil-may-care soap maker and they form an underground fight club that evolves into something much, much more...',
						// 'product_desc_short' => 'An insomniac office worker looking for a way to change his life crosses paths with a devil-may-care soap maker and they form an underground fight club that evolves into something much, much more...',
						// 'product_desc_long'        => '1999',
						'product_price'    => 'David Fincher',
						'product_created_date'      => '8.8'
						);

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
				case 'product_id':
				case 'product_name':
				// case 'product_desc_short':
				// case 'product_desc_long':
				case 'product_price':
				case 'product_created_date':
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
				'delete_selected' => 'Delete',
				'download_selected' => 'Download'
			);
			return $actions;
		}

		// Adding action links to column
		function column_product_name($item) {
			$actions = array(
				'edit'      => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Edit', 'supporthost-admin-table') . '</a>', $_REQUEST['page'], 'edit', $item['ID']),
				'delete'    => sprintf('<a href="?page=%s&action=%s&element=%s">' . __('Delete', 'supporthost-admin-table') . '</a>', $_REQUEST['page'], 'delete', $item['ID']),
			);
	
			return sprintf('%1$s %2$s', $item['product_name'], $this->row_actions($actions));
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