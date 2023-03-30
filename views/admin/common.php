<?php
	switch(strtolower(get_admin_page_title())) {
        case 'overview':
            include_once('overview.php');
            break;
        
        case 'products':
            include_once('products.php');
            break;

        case 'categories':
            include_once('categories.php');
            break;

        case 'users':
            include_once('usersfile.php');
            break;

        case 'settings':
            include_once('settings.php');
            break;
    }
?>