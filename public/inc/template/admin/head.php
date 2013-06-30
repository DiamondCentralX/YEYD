<title><?php echo $PAGE['title'] . ' | ' . $SITE['title']; ?></title>

<?php
// Echo out stylesheets from the $page_stylesheets array
foreach ($PAGE['stylesheets'] as $stylesheet) {
	echo '<link rel="stylesheet" href="'.$domain.$stylesheet.'">';
}
?>

<meta name="description" content="<?php echo $SITE['desc']; ?>">
<meta name="keywords" content="<?php echo $SITE['keywords']; ?>">
<meta name="author" content="<?php echo $SITE['author']; ?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">