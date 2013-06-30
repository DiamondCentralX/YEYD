<?php
// post_post ( $conn, $user_id, $title, $content )
// Posts a post
function post_post ($conn, $user_id, $title, $content) {
	$user_id = (int)$user_id;
	$title = sanitize($title);
	$content = sanitize_doc($content);
	
	$timestamp = time();
	$date = date('D d.m.y H:i');
	
	$conn->exec("INSERT INTO `posts` (`owner_id`, `title`, `content`, `timestamp`, `date`) VALUES ($user_id,'$title','$content',$timestamp,'$date')");
}

// get_latest_posts ( $conn, $user_id, $num_of_posts )
// Returns the first 150 characters of a users most recent posts(specified in the $num_of_post variable)
// Returned as a ul ready to be displayed
function get_latest_posts ($conn,$user_id,$num_of_posts) {
	global $domain,$site_fileext;
	
	$user_id = (int)$user_id;
	$num_of_posts = (int)$num_of_posts;
	
	$return = '<ul class="unstyled">';
	
	$result = $conn->query("SELECT `post_id`,`title`,SUBSTR(`content`,1,150) as `content`,`date` FROM `posts` WHERE `owner_id` = $user_id ORDER BY `timestamp` DESC LIMIT $num_of_posts");
	$result->setFetchMode(PDO::FETCH_ASSOC);
	
	foreach ($result as $row) {
		$return .= '<li>';
		
		$return .= '<b><a href="'.$domain.'/post'.$site_fileext.'?view='.$row['post_id'].'">'.$row['title'].'</a></b>';
		$return .= '<span class="pull-right">'.$row['date'].'</span>';
		$return .= '<p>';
		$return .= nl2br($row['content']);
		
		if (strlen($row['content']) == 150) {
			$return .= '...';
		}
		
		$return .= '</p>';
		
		$return .= '</li>';
	}
	
	return $return . '</ul>';
}

// getPost ( $conn, $post_id )
// Returns a post in the form of an array
function getPost ($conn, $post_id) {
	$post_id = (int)$post_id;
	
	$result = $conn->query("SELECT * FROM `posts` WHERE `post_id` = $post_id");
	
	return $result->fetch(PDO::FETCH_ASSOC);
}

// post_exists ( $conn, $post_id )
// Checks if a post exists
function post_exists ($conn, $post_id) {
	$post_id = (int)$post_id;
	
	$result = $conn->query("SELECT COUNT(`post_id`) AS `count` FROM `posts` WHERE `post_id` = $post_id");
	
	return ($result->fetch(PDO::FETCH_ASSOC)['count'] >= 1) ? true : false;
}
?>