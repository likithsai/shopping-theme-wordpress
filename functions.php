<?php
    if ( function_exists( 'register_nav_menus' ) ) {
        function create_menu_options() {
            add_menu_page(
                'Recent Bids',
                'Auction Reports',
                'manage_options',
                'wc-auction-reports',
                'actions_recent_bids_list',
                'dashicons-store',
                56
            );    

            add_submenu_page(
                'wc-auction-reports',               // parent slug
                'Recent Bids',                      // page title
                'Recent Bids',                      // menu title
                'manage_options',                   // capability
                'wc-auction-reports',               // slug
                'actions_recent_bids_list'
            );

            add_submenu_page(
                'wc-auction-reports',               // parent slug
                'Customer Spending',                // page title
                'Customer Spending',                // menu title
                'manage_options',                   // capability
                'wc-acutions-customers-spendings',  // slug
                'actions_recent_bids_list'
            );
        
            add_submenu_page(
                'wc-auction-reports',          // parent slug
                'Customer Bids',               // page title
                'Customer Bids',               // menu title
                'manage_options',              // capability
                'wc-acutions-customers-bids',  // slug
                'actions_recent_bids_list'
            );

            function actions_recent_bids_list() {
                echo 'sdvbd';
            }
        }
    }

    add_action('admin_menu','create_menu_options');
?>