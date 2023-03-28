
<form method="post" action="options.php">
	<?php
		settings_fields( 'rudr_slider_settings' ); // settings group name
		do_settings_sections( 'rudr_slider' ); // just a page slug
		submit_button(); // "Save Changes" button
	?>
</form>