<?php
    require_once ('inc/config.php');
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    if ( function_exists( 'register_nav_menus' ) ) {
        function create_menu_options() {
            add_menu_page(
                'Malejo',
                'Malejo',
                'manage_options',
                'wc-shopping-theme',
                'actions_recent_bids_list',
                'dashicons-store',
                56
            );    

            add_submenu_page(
                'wc-shopping-theme',                // parent slug
                'Overview',                         // page title
                'Overview',                         // menu title
                'manage_options',                   // capability
                'wc-shopping-theme',                // slug
                'actions_recent_bids_list'
            );

            add_submenu_page(
                'wc-shopping-theme',                // parent slug
                'Products',                         // page title
                'Products',                         // menu title
                'manage_options',                   // capability
                'wc-shopping-themeproducts',        // slug
                'actions_recent_bids_list'
            );
        
            add_submenu_page(
                'wc-shopping-theme',                // parent slug
                'Categories',                       // page title
                'Categories',                       // menu title
                'manage_options',                   // capability
                'wc-shopping-themecategories',      // slug
                'actions_recent_bids_list'
            );

            add_submenu_page(
                'wc-shopping-theme',                // parent slug
                'Users',                            // page title
                'Users',                            // menu title
                'manage_options',                   // capability
                'wc-shopping-themeusers',  // slug
                'actions_recent_bids_list'
            );

            add_submenu_page(
                'wc-shopping-theme',                // parent slug
                'Settings',                         // page title
                'Settings',                         // menu title
                'manage_options',                   // capability
                'wc-shopping-themesettings',        // slug
                'actions_recent_bids_list'
            );

            function actions_recent_bids_list() {
                echo '<div class="accordion pe-3 py-3" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Accordion Item #1
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the first items accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Accordion Item #2
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the second items accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Accordion Item #3
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the third items accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
              </div>';
            }
        }

        //  create required tables
        function create_database_tables() {
            global $wpdb;
            $database_entries = [
                "tbl_users" => "user_id mediumint(9) NOT NULL AUTO_INCREMENT, user_name varchar(200) DEFAULT NULL, user_email varchar(200) DEFAULT NULL, user_password varchar(200) NOT NULL, user_createddate timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (user_id)",
                "tbl_orders" => "order_id mediumint(9) NOT NULL AUTO_INCREMENT, order_name varchar(200) DEFAULT NULL, order_item varchar(200) DEFAULT NULL, order_cusid mediumint(9) DEFAULT NULL, order_price float DEFAULT NULL, order_createddate timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (order_id), KEY talk_cusid (order_cusid), CONSTRAINT talk_cusid FOREIGN KEY (order_cusid) REFERENCES " . $wpdb -> prefix . "tbl_users(user_id) ON DELETE SET NULL ON UPDATE SET NULL",
                "tbl_categories" => "category_id mediumint(9) NOT NULL AUTO_INCREMENT, category_name varchar(200) NOT NULL, category_createddate timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (category_id)",
                "tbl_products" => "product_id mediumint(9) NOT NULL AUTO_INCREMENT, product_name varchar(200) DEFAULT NULL, product_desc_short varchar(100) DEFAULT NULL, product_desc_long varchar(200) DEFAULT NULL, product_category_id mediumint(9) DEFAULT NULL, product_item_oldprice float DEFAULT NULL, product_item_newprice float DEFAULT NULL, product_createddate timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (product_id), KEY talk_productid (product_id), CONSTRAINT talk_productcatid FOREIGN KEY (product_category_id) REFERENCES " . $wpdb -> prefix . "tbl_categories(category_id) ON DELETE SET NULL ON UPDATE SET NULL"
            ];
            $charset_collate = $wpdb -> get_charset_collate();

            foreach($database_entries as $key => $value) {
                $table_name = $wpdb -> prefix . $key;
                $sql = "CREATE TABLE IF NOT EXISTS $table_name($value)$charset_collate;"; 
                dbDelta( $sql );
            }
        }
    }

    function xobamax_resources($hook) {
        if($hook != 'toplevel_page_wc-shopping-theme') {
            return;
        }

        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
        wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.4', true );
    }

    add_action( 'admin_enqueue_scripts', 'xobamax_resources' );
    add_action( 'admin_menu', 'create_menu_options' );
    add_action( 'init', 'create_database_tables' );
?>