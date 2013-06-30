<?php
// php-site - User function
// Last updated: 12.07.2013

function get_amount_of_users($conn) {
	$result = $conn->query("SELECT COUNT(`user_id`) as count FROM `users`");

	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}

/*function get_amount_of_clicks($conn) {
	$result = $conn->query("SELECT SUM(`clicks`) as count FROM `users`");

	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}*/

/*unction get_average_clicks_per_user($conn) {
	return number_format(get_amount_of_clicks($conn)/get_amount_of_users($conn), 0);
}*/

// display_states_as_ul( $conn, $where )
function display_states_as_ul ($conn,$where) {
	$return = '<ul class="unstyled">';

	if ($where != '') {
		$where = 'WHERE ' . $where;
	}

	$result = $conn->query("SELECT `content`,`date` FROM `status` $where ORDER BY `timestamp` DESC LIMIT 10");
	$result->setFetchMode(PDO::FETCH_ASSOC);

	foreach ($result as $row) {
		$return .= '<li><p>' . nl2br($row['content']) . '<br>&nbsp;&nbsp;&nbsp;&nbsp;- <i>' . $row['date'] . '</i></p></li>';
	}

	return $return . '</ul>';
}

// post_status( $conn, $user_id, $status )
// Posts a status for a user (uses the current timestamp and date)
function post_status($conn,$user_id,$status) {
	$user_id = (int)$user_id;
	$status = substr(sanitize($status),0,200);

	$timestamp = time();
	$date = date('D d.m.y H:i');

	$conn->exec("INSERT INTO `status` (`owner_id`,`content`,`timestamp`,`date`) VALUES ($user_id, '$status',$timestamp,'$date')");
}

// pardon_user( $conn, $user_id )
// Pardons/Unbans an user :D
function pardon_user($conn, $user_id) {
	$update_data = array(
		'is_banned' => 0
	);
	update_user($conn, $user_id, $update_data);
}

// ban_user( $conn, $user_id )
// Bans an user :(
function ban_user($conn, $user_id) {
	$update_data = array(
		'is_banned' => 1
	);
	update_user($conn, $user_id, $update_data);
}

// update_user( $user_id, $update_data )
// Updates user data
function update_user($conn, $user_id, $update_data) {
	$user_id = (int)$user_id;

	$update = array();
	array_walk($update_data, 'array_sanitize');

	foreach ($update_data as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}

	$conn->exec("UPDATE users SET " . implode(', ', $update) . " WHERE user_id = $user_id");
	//mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id") or die(mysql_error());
}

// change_password( $user_id, $password )
// Changes the password of a user
function change_password($conn, $user_id, $password) {
	$user_id	=	(int)$user_id;
	$password	=	md5($password);

	$conn->exec("UPDATE users SET password = '$password' WHERE `user_id` = $user_id");
	//mysql_query("UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id");
}

// register_user( $register_data )
// Registers a new user :D
function register_user($conn, $register_data) {
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);

	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';

	$conn->exec("INSERT INTO `users` ($fields) VALUES ($data)");
	//mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	//mysql_query("INSERT INTO `user_data` () VALUES ()");
}

// user_count()
// Return the amount of users registered on the page. Not including non-active users
function user_count($conn) {
	return $conn->query("SELECT COUNT(`user_id`) FROM `users`")[0];
	//return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
}

// user_data( $user_data, ...(arguments depending on information needed) )
// Return the data requested from the db
function user_data($conn, $user_id) {
	$data = array();
	$user_id = (int)$user_id;

	$func_num_args = func_num_args();
	$func_get_args = func_get_args();

	if ($func_num_args > 2) {
		unset($func_get_args[0]);
		unset($func_get_args[1]);

		$fields = '`' . implode('`, `', $func_get_args) .'`';

		$query = $conn->query("SELECT $fields FROM `users` WHERE `user_id` = $user_id");
		//$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));

		return $query->fetch(PDO::FETCH_ASSOC);
		//return $data;
	}
}

function get_all_user_data($conn, $user_id) {
	$data = array();
	$user_id = (int)$user_id;

	//$data = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `user_id` = $user_id"));
	$query = $conn->query("SELECT * FROM `users` WHERE `user_id` = $user_id");

	return $query->fetch(PDO::FETCH_ASSOC);
	//return $data;
}

// logged_in()
// Return true or false if the user is logged in or not
function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

// user_exists( $username )
// Returns true or false if the user exists or not
function user_exists($conn, $username) {
	$username = sanitize($username);

	$query = $conn->query("SELECT COUNT(`user_id`) as `count` FROM `users` WHERE `username` = '$username'");
	//$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");

	return ($query->fetch(PDO::FETCH_ASSOC)['count'] == 1) ? true : false;
	//return (mysql_result($query, 0) == 1) ? true : false;
}

// email_exists( $email )
// Returns true or false if the email exists or not
function email_exists($conn, $email) {
	$email = sanitize($email);

	$query = $conn->query("SELECT COUNT(`user_id`) as `count` FROM `users` WHERE `email` = '$email'");
	//$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");

	return ($query->fetch(PDO::FETCH_ASSOC)['count'] == 1) ? true : false;
	//return (mysql_result($query, 0) == 1) ? true : false;
}

// user_id_from_username( $username )
// Returns the user id that belongs to username
function user_id_from_username($conn, $username) {
	$username = sanitize($username);

	$query = $conn->query("SELECT `user_id` FROM `users` WHERE `username` = '$username'");

	return $query->fetch(PDO::FETCH_ASSOC)['user_id'];
	//return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0, 'user_id');
}

// login( $username, $password )
// Returns the id of the user if successful, false if unsuccessful
function login($conn, $username, $password) {
	$user_id = user_id_from_username($conn, $username);

	$username = sanitize($username);
	$password = md5($password);

	$query = $conn->query("SELECT COUNT(`user_id`) as `count` FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
	//$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");

	return ($query->fetch(PDO::FETCH_ASSOC)['count'] == 1) ? $user_id : false;
	//return (mysql_result($query, 0) == 1) ? $user_id : false;
}
?>
