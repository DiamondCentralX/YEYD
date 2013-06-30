<title><?php echo $PAGE['title'] . ' | ' . $SITE['title']; ?></title>

<?php
// Echo out stylesheets from the $page_stylesheets array
foreach ($PAGE['stylesheets'] as $stylesheet) {
	echo '<link rel="stylesheet" href="'.$domain.$stylesheet.'">';
}
?>

<meta name="description" content="<?php echo $site_desc; ?>">
<meta name="keywords" content="<?php echo $site_keywords; ?>">
<meta name="author" content="<?php echo $site_author; ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">