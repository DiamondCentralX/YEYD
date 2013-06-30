<?php
// php-site - Todolist App - Functions file
// Last updated: 12.07.2013

// get_uncompleted_tasks ( $conn, $user_id )
// Returns an array of a users uncompleted tasks
function get_uncompleted_tasks($conn,$user_id) {
	$user_id = (int)$user_id;

	$result = $conn->query("SELECT `task_id`,`task` FROM `todolist_tasks` WHERE `completed` = 0 AND `owner_id` = $user_id");
	$result->setFetchMode(PDO::FETCH_ASSOC);
	return $result;
}

// get_completed_tasks ( $conn, $user_id )
// Returns an array of a users completed tasks
function get_completed_tasks($conn,$user_id) {
	$user_id = (int)$user_id;

	$result = $conn->query("SELECT `task` FROM `todolist_tasks` WHERE `completed` = 1 AND `owner_id` = $user_id");
	$result->setFetchMode(PDO::FETCH_ASSOC);
	return $result;
}

// task_owner ( $conn, $task_id )
// Returns the user id of the owner of a task
function task_owner($conn,$task_id) {
	$task_id = (int)$task_id;

	$result = $conn->query("SELECT `owner_id` FROM `todolist_tasks` WHERE `task_id` = $task_id");
	$result = $result->fetch(PDO::FETCH_ASSOC);
	$result = $result['owner_id'];

	return $result;
}

// complete_task ( $conn,$task_id )
// I'm sorry but this functions dosn't complete tasks for you :( It only marks them as completed in the DB
function complete_task($conn,$task_id) {
	$task_id = (int)$task_id;

	$conn->exec("UPDATE `todolist_tasks` SET `completed` = 1 WHERE `task_id` = $task_id");
}

// add_task ( $conn, $user_id, $task )
// Adds a task to the DB
function add_task($conn,$user_id,$task) {
	$user_id = (int)$user_id;
	$task = sanitize($task);

	$conn->exec("INSERT INTO `todolist_tasks` (`task`,`owner_id`) VALUES ('$task',$user_id)");
}
?>