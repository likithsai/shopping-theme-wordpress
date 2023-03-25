<?php
    require_once ('inc/config.php');
    
    if ( function_exists( 'register_nav_menus' ) ) {
        function create_menu_options() {
            add_menu_page(
                APP_NAME,
                APP_NAME,
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
                echo esc_html(wp_get_theme());
            }
        }
    }

    add_action('admin_menu','create_menu_options');
?>