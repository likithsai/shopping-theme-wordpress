<div class="wrap">
	<h1><?php echo get_admin_page_title() ?></h1>
	<?php
		switch(strtolower(get_admin_page_title())) {
            case 'settings':
                include_once('settings.php');
                break;
        }
	?>
</div>