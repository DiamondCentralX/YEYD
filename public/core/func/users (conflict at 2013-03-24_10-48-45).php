<?php
// update_user( $user_id, $update_data )
// Updates user data
function update_user($user_id, $update_data) {
	$user_id = (int)$user_id;
	
	$update = array();
	array_walk($update_data, 'array_sanitize');
	
	foreach ($update_data as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}
	
	$db-exec("UPDATE users SET " . implode(', ', $update) . " WHERE user_id = $user_id");
	//mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id") or die(mysql_error());
}

// change_password( $user_id, $password )
// Changes the password of a user
function change_password($user_id, $password) {
	$user_id	=	(int)$user_id;
	$password	=	md5($password);
	
	$db->exec("UPDATE users SET password = '$password' WHERE `user_id` = $user_id");
	//mysql_query("UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id");
}

// register_user( $register_data )
// Registers a new user :D
function register_user($register_data) {
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);
	
	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';
	
	$db->exec("INSERT INTO `users` ($fields) VALUES ($data)");
	//mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	//mysql_query("INSERT INTO `user_data` () VALUES ()");
}

// user_count()
// Return the amount of users registered on the page. Not including non-active users
function user_count() {
	return $db->query("SELECT COUNT(`user_id`) FROM `users`")[0];
	//return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
}

// user_data( $user_data, ...(arguments depending on information needed) )
// Return the data requested from the db
function user_data($user_id) {
	$data = array();
	$user_id = (int)$user_id;
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1) {
		unset($func_get_args[0]);
		
		$fields = '`' . implode('`, `', $func_get_args) .'`';
		
		$query = $db->query("SELECT $fields FROM `users` WHERE `user_id` = $user_id");
		//$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));
		
		return $query->fetch(SQLITE_ASSOC);
		//return $data;
	}
}

function get_all_user_data($user_id) {
	$data = array();
	$user_id = (int)$user_id;
	
	//$data = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `user_id` = $user_id"));
	$query = $db->query("SELECT * FROM `users` WHERE `user_id` = $user_id");
	
	return $query->fetch(SQLITE_ASSOC);
	//return $data;
}

// logged_in()
// Return true or false if the user is logged in or not
function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

// user_exists( $username )
// Returns true or false if the user exists or not
function user_exists($username) {
	$username = sanitize($username);
	
	$query = $db->query("SELECT COUNT(`user_id`) as `count` FROM `users` WHERE `username` = '$username'");
	//$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
	
	return ($query->fetch(SQLITE_ASSOC)['count'] == 1) ? true : false;
	//return (mysql_result($query, 0) == 1) ? true : false;
}

// email_exists( $email )
// Returns true or false if the email exists or not
function email_exists($email) {
	$email = sanitize($email);
	
	$query = $db->query("SELECT COUNT(`user_id`) as `count` FROM `users` WHERE `email` = '$email'");
	//$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
	
	return ($query->fetch(SQLITE_ASSOC)['count'] == 1) ? true : false;
	//return (mysql_result($query, 0) == 1) ? true : false;
}

// user_id_from_username( $username )
// Returns the user id that belongs to username
function user_id_from_username($username) {
	$username = sanitize($username);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0, 'user_id');
}

// login( $username, $password )
// Returns the id of the user if successful, false if unsuccessful
function login($username, $password) {
	$user_id = user_id_from_username($username);
	
	$username = sanitize($username);
	$password = md5($password);
	
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
	return (mysql_result($query, 0) == 1) ? $user_id : false;
}
?>
