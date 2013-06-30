<?php
// Require awesome init files
require '../core/init.php';

protect_page();

// Get id from url
$id = (int)$_GET['id'];

// Set content-type to png
header('Content-type: image/png');

if (logoquiz_user_solved_logo($db,$session_user_id,$id)) {
	readfile('logo/'.$id.'/solved.png');
} else {
	readfile('logo/'.$id.'/unsolved.png');
}
?>