<?php
function getLogoQuizScore($conn,$user_id) {
	$user_id = (int)$user_id;
	
	$result = $conn->query("SELECT COUNT(`solved_id`) as `count` FROM `logoquiz_solved` WHERE `user_id` = $user_id");
	
	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}

function getLogoAmount($conn) {
	$result = $conn->query("SELECT COUNT(`logo_id`) as `count` FROM `logoquiz_logos`");
	
	return $result->fetch(PDO::FETCH_ASSOC)['count'];
}

function correct_answer($conn,$logo_id,$answer) {
	$logo_id = (int)$logo_id;
	$answer = sanitize($answer);
	
	$result = $conn->query("SELECT `name` FROM `logoquiz_logos` WHERE `logo_id` = $logo_id");
	
	if ($result->fetch(PDO::FETCH_ASSOC)['name'] == $answer) {
		return true;
	} else {
		return false;
	}
}

function answer_logo($conn,$user_id,$logo_id,$answer) {
	$user_id = (int)$user_id;
	$logo_id = (int)$logo_id;
	$answer = sanitize($answer);
	$time = time();
	
	if (!logoquiz_user_solved_logo($conn,$user_id,$logo_id)) {
		if (correct_answer($conn,$logo_id,$answer)) {
			$conn->exec("INSERT INTO `logoquiz_solved` (`logo_id`,`user_id`,`timestamp`) VALUES ($logo_id,$user_id,$time)");
			return true;
		} else {
			return false;
		}
	}
}

function logoquiz_user_solved_logo($conn,$user_id,$logo_id) {
	$user_id = (int)$user_id;
	$logo_id = (int)$logo_id;
	
	$result = $conn->query("SELECT COUNT(`solved_id`) as `count` FROM `logoquiz_solved` WHERE `user_id` = $user_id AND `logo_id` = $logo_id");
	
	$count = $result->fetch(PDO::FETCH_ASSOC)['count'];
	
	if ($count >= 1) {
		return true;
	} else {
		return false;
	}
}
?>