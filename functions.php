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
                echo 'Matejo';
            }
        }

        //  create required tables
        function create_database_tables() {
            global $wpdb;
            $database_entries = [
                "shopping" => "id mediumint(9) NOT NULL AUTO_INCREMENT, time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, views smallint(5) NOT NULL, clicks smallint(5) NOT NULL, UNIQUE KEY id (id)",
                "scasc" => "id mediumint(9) NOT NULL AUTO_INCREMENT, time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, views smallint(5) NOT NULL, clicks smallint(5) NOT NULL, UNIQUE KEY id (id)"
            ];
            $charset_collate = $wpdb->get_charset_collate();

            foreach($database_entries as $key => $value) {
                $table_name = $wpdb->prefix . $key;
                $sql = "CREATE TABLE IF NOT EXISTS $table_name($value)$charset_collate;"; 
                dbDelta( $sql );
            }
        }
    }

    add_action( 'admin_menu', 'create_menu_options' );
    add_action('init', 'create_database_tables');
?>