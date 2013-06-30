<?php
// searchUsersQuery ( $conn, $query )
// Return search results as an array
function searchUsersQuery ($conn,$query) {
	$query = sanitize($query);
	
	$result = $conn->query("SELECT * FROM `users` WHERE `search_able` = 1 AND (`username` LIKE '%$query%' OR `first_name` LIKE '%$query%' OR `last_name` LIKE '%$query%')");
	$result->setFetchMode(PDO::FETCH_ASSOC);
	
	return $result;
}
?>