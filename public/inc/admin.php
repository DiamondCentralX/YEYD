<?php
$PAGE['title'] .= ' | admin';

if (!logged_in()) {
	echo 'You must log in to view this page!';
	exit();
} else {
	if ($session_user_id != 1) {
		echo 'You\'re not an admin!';
		exit();
	}
}
?>