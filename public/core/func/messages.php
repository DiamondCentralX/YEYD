<?php
// send_message ( $conn, $message )
// Sends a message
function send_message($conn, $message) {
	array_walk($message, 'array_sanitize');
	
	$fields = '`' . implode('`, `', array_keys($message)) . '`';
	$data = '\'' . implode('\', \'', $message) . '\'';
	
	$conn->exec("INSERT INTO `messages` ($fields) VALUES ($data)");
}

// mark_as_read ( $conn, $message_id )
// Marks a message as read
function mark_as_read($conn, $message_id) {
	$message_id = (int)$message_id;
	
	$conn->exec("UPDATE `messages` SET `is_read` = 1 WHERE `message_id` = $message_id");
}

// message_to ( $conn, $message_id )
// Returns the id of who the message was sendt to
function message_to($conn, $message_id) {
	$message_id = (int)$message_id;
	
	$result = $conn->query("SELECT `to` FROM `messages` WHERE `message_id` = $message_id");
	return $result->fetch(PDO::FETCH_ASSOC)['to'];
}

// display_message ( $conn, $message_id )
// Return a message ready to be displayed / echoed
function display_message($conn, $message_id) {
	$message_id = (int)$message_id;
	$return = '<p>';
	
	$result = $conn->query("SELECT `title`,`content`,`from`,`date` FROM `messages` WHERE `message_id` = $message_id");
	$result = $result->fetch(PDO::FETCH_ASSOC);
	
	$from = user_data($conn, $result['from'], 'username')['username'];
	
	$return .= '<h1>'.$result['title'].'</h1>';
	$return .= '<p>From <a href="/u/'.$from.'">'.$from.'</a><br><i>'.$result['date'].'</i></p>';
	$return .= '<p>'.nl2br($result['content']).'</p>';
	
	$return .= '</p>';
	
	return $return;
}

// display_messages_as_table ( $conn, $user_id, $where )
// Return a table containing the messages for a specific user
function display_messages_as_table($conn, $user_id, $where) {
	$user_id = (int)$user_id;
	$return = '<table class="table">';
	
	$return .= '<tr><th>Title</th><th>From</th><th>Date Sendt</th></tr>';
	
	$result = $conn->query("SELECT `message_id`,`title`,`from`,`date`,`is_read` FROM `messages` WHERE `to` = $user_id $where ORDER BY `timestamp` DESC");
	$result->setFetchMode(PDO::FETCH_ASSOC);
	
	foreach ($result as $row) {
		$from_username = user_data($conn, $row['from'], 'username');
		
		$return .= '<tr>';
		$return .= '<td>';
		$return .= ($row['is_read'] == 0) ? '[UNREAD] ' : '';
		$return .= '<a href="messages?mess='.$row['message_id'].'">'.$row['title'].'</a></td>';
		$return .= '<td><a target="_blank" href="/u/'.$from_username['username'].'">'.$from_username['username'].'</a></td>';
		$return .= '<td>'.$row['date'].'</td>';
		$return .= '</tr>';
	}
	
	$return .= '</table>';
	return $return;
}

// get_message_count( $conn, $user_id )
// Returns the amount of unread messages for a user
function get_message_count($conn, $user_id) {
	$user_id = (int)$user_id;
	
	$result = $conn->query("SELECT COUNT(`message_id`) as `count` FROM `messages` WHERE `to` = $user_id AND `is_read` = 0");
	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}
?>