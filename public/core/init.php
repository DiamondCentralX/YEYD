<?php
// YEYD - Init
// Last updated: 30.06.2013

// Start a session
session_start();

// SUPERconfig
require __DIR__ . '/superconfig.php';

// Require database related files
require __DIR__ . '/db/connect.php';

// Require other function files
require 'func/general.php';
require 'func/users.php';
require 'func/messages.php';
require 'func/docs.php';
require 'func/drive.php';
require 'func/posts.php';
require 'func/search.php';
require 'func/friends.php';

// Require classes
require 'classes/Chat.php';

// Require LogoQuiz File
require 'func/logoquiz.php';

// If logged in
if (logged_in()) {
	// Grab user data
	$session_user_id = $_SESSION['user_id'];
	$user_data = get_all_user_data($db, $session_user_id);

	// Redirect banned users
	if ($user_data['is_banned'] == 1) {
		if (nav_is_active('banned.php') == false && nav_is_active('logout.php') == false) {
			header('Location: ' . $domain . '/banned' . $site_fileext);
			echo 'BANNED!';
			exit();
		}
	}
}

// Redirect to mobile and tablet versions
/* No need, trying to make the website responsive :D
include __DIR__ . '/notmine/Mobile_Detect.php';
$mdetect = new Mobile_Detect;
if (!isset($_SESSION['noMdetect'])) {
	if ($mdetect->isMobile() && !$mdetect->isTablet()) {
		header('Location: ' . $domain . '/mobile/');
	} else if ($mdetect->isTablet()) {
		header('Location: ' . $domain . '/tablet/');
	}
}
*/

// Merlin
$merlin = false;
if (isset($_GET['merlin'])) {
	$merlin = true;
}
if ($merlin) {
	$site_fileext .= '?merlin';
}
?>