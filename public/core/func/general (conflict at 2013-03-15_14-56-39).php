<?php
function logged_in_redirect() {
	if (logged_in()) {
		header('Location: home' . $site_fileext);
		exit();
	} else {
		return false;
	}
}

// sanitize_array( &$item )
// Returns the same array sanitized (use array_walk($array, 'array_sanitize'))
function array_sanitize(&$item) {
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

// sanitize( $data )
// Returns the same data sanitized
function sanitize($data) {
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

// output_errors( $errors )
// Returns a list of the error array parsed for a nicely output
function output_errors($errors) {
	return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}
?>