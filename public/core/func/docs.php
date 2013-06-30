<?php
// php-site - Docs Functions
// Last updated: 12.07.2013

// doc_new ( $conn, $user_id )
// Creates a new document
function doc_new ( $conn, $user_id) {
	$user_id = (int)$user_id;

	$conn->exec("INSERT INTO `docs` (`owner_id`, `title`, `content`) VALUES ($user_id,'New Document','(empty)')");
}
/*function doc_new ( $conn, $user_id, $folder ) {
	$user_id = (int)$user_id;
	$folder = sanitize($folder);

	$folder = dir_id_from_string($conn,$user_id,$folder);

	$conn->exec("INSERT INTO `docs` (`doc_id`, `owner_id`, `title`, `content`, `folder`) VALUES (NULL,$user_id,'New Document',NULL,'$folder')");
}*/

// doc_del ( $conn, $doc_id )
// Deletes a document
function doc_del ( $conn, $doc_id ) {
	$doc_id = (int)$doc_id;

	$conn->exec("DELETE FROM `docs` WHERE `doc_id` = $doc_id");
}

// doc_save ( $conn, $doc_id, $title, $content )
// Saves a document
function doc_save ( $conn, $doc_id, $title, $content ) {
	$doc_id = (int)$doc_id;
	$title = sanitize($title);
	$content = sanitize_doc($content);

	$conn->exec("UPDATE `docs` SET `title` = '$title', `content` = '$content' WHERE `doc_id` = $doc_id");
}

// doc_info ( $conn, $doc_id )
// Return the title and content of a document
function doc_info ( $conn, $doc_id ) {
	$doc_id = (int)$doc_id;

	$result = $conn->query("SELECT `title`,`content` FROM `docs` WHERE `doc_id` = $doc_id");

	return $result->fetch(PDO::FETCH_ASSOC);
}

// doc_view ( $conn, $doc_id )
// Returns a documents ready to be displayed / echoed
function view_doc ( $conn, $doc_id ) {
	$doc_id = (int)$doc_id;

	$return = '<div class="doc">';

	$result = $conn->query( "SELECT `title`, `content` FROM `docs` WHERE `doc_id` = $doc_id" );
	$result->setFetchMode(PDO::FETCH_ASSOC);

	foreach ( $result as $row ) {
		$return .= '<h1 class="doc-title">'.$row['title'].'</h1>';
		$return .= '<div class="doc-content" style="white-space:pre-wrap;line-height:12px;">'.$row['content'].'</div>';
	}

	$return .= '</div>';
	return $return;
}

// doc_owner ( $conn, $doc_id )
// Return the owner of a document
function doc_owner ($conn, $doc_id) {
	$doc_id = (int)$doc_id;

	$query = $conn->query("SELECT `owner_id` FROM `docs` WHERE `doc_id` = $doc_id");

	return $query->fetch(PDO::FETCH_ASSOC)['owner_id'];
}

// display_docs_as_table( $conn, $user_id, $where )
// Display a list of all the documents belonging to a user as a table
function display_docs_as_table($conn, $user_id, $where) {
	global $domain,$site_fileext;

	$user_id = (int)$user_id;
	$return = '<table class="table">';
	$return .= '<tr><th>Title</th><th colspan="3">Actions</th></tr>';

	$result = $conn->query("SELECT `doc_id`,`title` FROM `docs` WHERE `owner_id` = $user_id $where ORDER BY `title`");
	$result->setFetchMode(PDO::FETCH_ASSOC);

	foreach ($result as $row) {
		$return .= '<tr>';
		$return .= '<td>'.$row['title'].'</td>';
		$return .= '<td><a class="btn" href="'.$domain.'/docs'.$site_fileext.'?view='.$row['doc_id'].'"><i class="icon-search"></i></a> ';
		$return .= '<a class="btn" href="'.$domain.'/docs'.$site_fileext.'?edit='.$row['doc_id'].'"><i class="icon-edit"></i></a> ';
		$return .= '<a class="btn" href="'.$domain.'/docs'.$site_fileext.'?dl='.$row['doc_id'].'"><i class="icon-download"></i></a></td>';
		$return .= '</tr>';
	}

	$return .= '</table>';
	return $return;
}
?>