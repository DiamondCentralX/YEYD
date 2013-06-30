<?php
// Echo out stylesheets from the $PAGE['scripts'] array
foreach ($PAGE['scripts'] as $script) {
	echo '<script src="'.$script.'"></script>';
}
?>