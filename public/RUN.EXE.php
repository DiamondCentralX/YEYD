<?php
// Require init.php
require 'core/init.php';

protect_page();

// Set page title
$PAGE['title'] = 'RUN.EXE';

// Include template top
include 'inc/template/top.php';
?>
<div class="container">
	<h1><i class="icon-fire"></i> RUN.EXE<sup>BETA</sup> <i class="icon-fighter-jet"></i></h1>
	<form action="" method="get">
		<input style="width:100%;" type="text" name="cmd" placeholder="Run a command" <?php echo (isset($_GET['cmd']) && !empty($_GET['cmd'])) ? 'value="'.$_GET['cmd'].'"' : ''; ?>>
	</form>
	<?php
	// Is a command runned??
	if (isset($_GET['cmd']) && !empty($_GET['cmd'])) {
		$cmd = sanitize($_GET['cmd']);

		// Write the command runnes
		echo '<p>You ran the command <b>"' . $cmd . '"</b></p>';

		// Search command
		if (substr($cmd,0,1) == 's') {

			// Docs
			if ($user_data['app_drive'] == 1 && substr($cmd,2,3) == 'doc' && substr($cmd,5,1) == ' ') {
				echo '<h3>My Docs</h3>';
				echo display_docs_as_table($db,$session_user_id,"AND `title` LIKE '%" . substr($cmd,6) . "%'");

			// Drive
			} else if ($user_data['app_drive'] == 1 && substr($cmd,2,5) == 'drive' && substr($cmd,7,1) == ' ') {
				echo '<h3>My Drive</h3>';
				echo display_docs_as_table($db,$session_user_id,"AND `title` LIKE '%" . substr($cmd,8) . "%'");

			// Mess
			} else if (substr($cmd,2,4) == 'mess' && substr($cmd,6,1) == ' ') {
				echo '<h3>Messages</h3>';
				echo display_messages_as_table($db,$session_user_id,"AND `title` LIKE '%" . substr($cmd,7) . "%'");

			// Error
			} else {
				echo '<div class="alert alert-error"><b>ERROR:</b> No search at <b>"' . substr($cmd,2) . '"</b></div>';
			}

		// Run command
		} else if (substr($cmd,0,3) == 'run') {

			// Docs
			if ($user_data['app_drive'] == 1 && substr($cmd,4) == 'docs') {
				header('Location: ' . $domain . '/apps/drive/');
				exit();

			// Drive
			} else if ($user_data['app_drive'] == 1 && substr($cmd,4) == 'drive') {
				header('Location: ' . $domain . '/apps/drive/');
				exit();

			// Mess
			} else if (substr($cmd,4) == 'mess') {
				header('Location: ' . $domain . '/messages' . $SITE['fileext']);
				exit();

			// Messages
			} else if (substr($cmd,4) == 'messages') {
				header('Location: ' . $domain . '/messages' . $SITE['fileext']);
				exit();

			// Error
			} else {
				echo '<div class="alert alert-error"><b>ERROR:</b> No app with the name of <b>"' . substr($cmd,4) . '"</b></div>';
			}
		}

	// What if no command is runned?
	} else {
		?>
		<h3>How to use RUN.EXE?</h3>
		Try it out and find out!<br>
		<sub>Saw what I did with the question mark there?</sub>
		<?php
	}
	?>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>