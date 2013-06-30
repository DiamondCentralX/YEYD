<?php
// Require init.php
require '../core/init.php';

//if (logged_in()) {
/*	$update_data = array(
		'clicks'	=>	$user_data['clicks'] + 1
	);

	update_user($db, $session_user_id, $update_data);
*/

	add_click($db,$session_user_id);

	echo get_user_clicks($db,$session_user_id);
//}
?>