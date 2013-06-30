<?php
if (isset($_GET['u']) && !empty($_GET['u'])) {
	$u = $_GET['u'];
	
	if (file_exists('profile/' . $u . '.png')) {
		header('Content-type: image/png');
		readfile('profile/' . $u . '.png');
	} else {
		echo 'No image found ...';
	}
} else {
	echo 'You need to set the username as a GET paramter(?u="username here")';
}
?>