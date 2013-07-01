<?php
// Require init.php
require __DIR__ . '/../core/init.php';

// Set page title
$page_title = 'do';

require __DIR__ . '/../inc/admin.php';

// Include top part of the admin template
include __DIR__ . '/../inc/template/admin/top.php';

echo '<a href="home">&larr; back</a>';
echo '<p>';

if (isset($_GET['action']) && !empty($_GET['action'])) {
	
	// Ban
	if ($_GET['action'] == 'ban') {
		if (isset($_GET['user']) && !empty($_GET['user'])) {
			if (user_exists($db, $_GET['user'])) {
				if (user_id_from_username($db, $_GET['user']) != 1) {
					ban_user($db, user_id_from_username($db, $_GET['user']));
					echo 'The user "'.$_GET['user'].'" is now banned';
				} else {
					echo 'You can\'t ban the admin!';
				}
			} else {
				echo 'The user "'.$_GET['user'].'" dosn\'t exist';
			}
		} else {
			echo 'The user is not set';
		}
	}
	
	// Pardon
	if ($_GET['action'] == 'pardon') {
		if (isset($_GET['user']) && !empty($_GET['user'])) {
			if (user_exists($db, $_GET['user'])) {
				pardon_user($db, user_id_from_username($db, $_GET['user']));
				echo 'The user "'.$_GET['user'].'" is now unbanned';
			} else {
				echo 'The user "'.$_GET['user'].'" dosn\'t exist';
			}
		} else {
			echo 'The user is not set';
		}
	}
	
} else {
	echo 'No data received';
}
echo '</p>';

// Include bottom part of the admin template
include __DIR__ . '/../inc/template/admin/bottom.php';
?>