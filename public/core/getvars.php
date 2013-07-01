<?php
// YEYD - Get Vars
// Last updated: 01.07.2013

// Sets vars
$vars = $db->query("SELECT `thingy`,`value` FROM `site`");
$vars->setFetchMode(PDO::FETCH_ASSOC);
foreach($vars as $row) {
	$SITE[$row['thingy']] = $row['value'];
}
?>