<?php
if (isset($_GET['t']) && !empty($_GET['t'])) {
	sleep((int)$_GET['t']);
	echo 'loaded';
} else {
	sleep(3);
	echo 'loaded';
}
?>