<?php
// friends_send_request ( $conn, $user_1, $user_2 )
function friends_send_request ($conn,$user_1,$user_2) {
	$user_1 = (int)$user_1;
	$user_2 = (int)$user_2;
	
	$conn->exec("INSERT INTO `friends`(`user_1`,`user_2`) VALUES ($user_1,$user_2)");
}
?>