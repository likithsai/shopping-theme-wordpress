<?php
get_header();
    if ( ! function_exists( 'myfirsttheme_setup' ) ) :
        function myfirsttheme_setup() { 
            add_menu_page('My Page Title', 'My Menu Title', 'manage_options', 'my-menu', 'my_menu_output' );
            add_submenu_page('my-menu', 'Submenu Page Title', 'Whatever You Want', 'manage_options', 'my-menu' );
            add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );
        }
    endif;

    add_action( 'admin_menu', 'myfirsttheme_setup', 11 );
?>