<title><?php echo $PAGE['title'] . ' | ' . $SITE['title']; ?></title>

<?php
// Add desired theme
/*
if (logged_in()) {
	$PAGE['stylesheets'][0] = '/css/theme/'.$user_data['theme'].'.css';
} else {
	$PAGE['stylesheets'][0] = '/css/theme/default.css';
}
*/

// Add stylesheet for the set footer
/*if (logged_in()) {
	if ($user_data['footer_style'] != 'disabled') {
		$PAGE['stylesheets'] = '/css/footer.css';

		if ($user_data['footer_style'] != 'none') {
			$PAGE['stylesheets'][] = '/css/footer_'.$user_data['footer_style'].'.css';
		}
	}
}*/

// Echo out stylesheets from the $page_stylesheets array
foreach ($PAGE['stylesheets'] as $stylesheet) {
	echo '<link rel="stylesheet" href="'.$stylesheet.'">';
}
?>

<meta name="description" content="<?php echo $site_desc; ?>">
<meta name="keywords" content="<?php echo $site_keywords; ?>">
<meta name="author" content="<?php echo $site_author; ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">