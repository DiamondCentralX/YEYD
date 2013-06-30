<?php
// Require init.php
require 'core/init.php';

protect_page();

if (isset($_GET['p'])) {
	$getp = sanitize($_GET['p']);
	
	$query = "SELECT id, title FROM `pages` WHERE `title` = '$getp'";
	
	if ($result = $sqlite->query($query)) {
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id = $row['id'];
			$title = $row['title'];
		}
	} 
	
	if (!isset($title)) {
		$title = 'error';
		$id = 'error';
	}
} else {
	header('Location: home' . $site_fileext);
}

if (isset($_GET['f'])) {
	$file = $_GET['f'];
} else {
	header('Location: '.$domain.'/s/'.$title.'/home');
}

// Set page variables
$page_title = $title;

// Include template top
include 'inc/template/top.php';

echo '<div class="page">';
include 'inc/page/'.$id.'/'.$file.'.php';
echo '</div>';

// Include template bottom
include 'inc/template/bottom.php';
?>