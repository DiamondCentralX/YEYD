<?php
// php-site - General functions
// Last updated: 16.06.2013

function dobbelt($tall) {
	$tall = (int)$tall;

	if (strlen($tall) <= 1) {
		return '0' . $tall;
	} else {
		return $tall;
	}
}

function get_clicks_date($conn,$user_id,$date) {
	$user_id = (int)$user_id;
	$date = sanitize($date);

	$result = $conn->query("SELECT COUNT(`click_id`) AS `count` FROM `clicks` WHERE `user_id` = $user_id AND `date` = '$date'");

	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}

function get_user_clicks($conn,$user_id) {
	$user_id = (int)$user_id;

	$result = $conn->query("SELECT COUNT(`click_id`) AS `count` FROM `clicks` WHERE `user_id` = $user_id");

	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}

function add_click($conn,$user_id) {
	$user_id = (int)$user_id;

	$time = time();
	$date = date('d-m-Y');

	$conn->exec("INSERT INTO `clicks` (`user_id`,`timestamp`,`date`) VALUES ($user_id,$time,'$date')");
}

function startsWith ($haystack, $needle) {
	return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith ($haystack, $needle) {
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}

// new_is_active ( $page )
// Random function I use to make the nav-bar look nicer :D
function nav_is_active($page) {
	if ($page == basename($_SERVER['PHP_SELF'])) {
		return 'class="active"';
	} else {
		return false;
	}
}

// protect_page ()
// Protects a page from not logged in users by redirecting them to a page telling them to log in
function protect_page() {
	if (!logged_in()) {
		header('Location: ' . $domain . '/protected' . $site_fileext);
		exit();
	} else {
		return false;
	}
}

// logged_in_redirect ()
// Redirect a logged in user to the homepage
function logged_in_redirect() {
	if (logged_in()) {
		header('Location: home' . $site_fileext);
		exit();
	} else {
		return false;
	}
}

// sanitize_array( &$item )
// Returns the same array sanitized (use array_walk($array, 'array_sanitize'))
function array_sanitize(&$item) {
	$item = str_replace('\'', '&#39', htmlentities($item));
	//$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

// sanitize( $data )
// Returns the same data sanitized
function sanitize($data) {
	return str_replace('\'', '&#39;', htmlentities($data));
	//return htmlentities(strip_tags(mysql_real_escape_string($data)));
}
function sanitize_doc($data) {
	return str_replace('\'', '&#39;', strip_tags($data, '<p><a><img><strong><h2><sup><sub><h1><h2><h3><h4><h5><h6><pre><address><div><big><small><code><kbd><samp><var><ol><ul><li><br><span><hr>'));
}

// output_errors( $errors )
// Returns a list of the error array parsed for a nicely output
function output_errors($errors) {
	return '<ul class="unstyled"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}
?>