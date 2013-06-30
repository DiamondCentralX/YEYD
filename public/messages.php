<?php
// php-site - Messages
// Last updated: 12.07.2013

// Require init.php
require 'core/init.php';

// Set page variables
$PAGE['title'] = 'messages';

protect_page();

// Include template top
include 'inc/template/top.php';
?>
<div class="container">
	<div class="navbar" style="margin-top:10px;">
		<div class="navbar-inner">
			<ul class="nav">
				<li><a href="messages<?php echo $SITE['fileext']; ?>">Unread Messages <?php echo (get_message_count($db, $session_user_id) != 0) ? '<b>('.get_message_count($db, $session_user_id).')</b>' : ''; ?></a></li>
				<li><a href="?send">New</a></li>
			</ul>
		</div>
	</div>
	<?php
	if (isset($_GET['send']) && empty($_GET['send'])) {

		$displaySendForm = true;

		if (isset($_POST) && !empty($_POST)) {

			echo '<h1>Send Message</h1>';

			if (!user_exists($db, $_POST['to'])) {
				$errors[] = 'That user dosn\'t exists';
			}
			if (empty($_POST['title'])) {
				$errors[] = 'The title can\'t be empty';
			}

			if (empty($errors)) {
				$message = array(
					'from'		=>	$session_user_id,
					'to'		=>	user_id_from_username($db, $_POST['to']),
					'title'		=>	$_POST['title'],
					'content'	=>	$_POST['content'],
					'timestamp'	=>	time(),
					'date'		=>	date('D d.m.y H:i')
				);

				send_message($db, $message);

				echo 'Message sendt!';

				$displaySendForm = false;
			} else {
				echo output_errors($errors);
			}

		}

		if ($displaySendForm) {
			?>
			<h1>New Message</h1>
			<form action="?send" method="post">
				<input type="text" name="title" placeholder="title" value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : ''; ?>">
				<input type="text" name="to" placeholder="to" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : '';echo (isset($_GET['to'])) ? $_GET['to'] : ''; ?>">
				<textarea name="content" placeholder="content" style="min-width:100%;max-width:100%;min-height:400px;max-height:600px;"><?php
					echo (isset($_POST['content'])) ? $_POST['content'] : '';
				?></textarea>
				<input type="submit" class="btn btn-large" value="send">
			</form>
			<?php
		}

	} else if (isset($_GET['mess']) && !empty($_GET['mess'])) {
		if (message_to($db, $_GET['mess']) == $session_user_id) {
			echo display_message($db, $_GET['mess']);
			mark_as_read($db, $_GET['mess']);
		} else {
			echo 'You are not allowed to view that message';
		}
	} else if (isset($_GET['all']) && empty($_GET['all'])) {
		echo '<h1>All Messages</h1>';
		echo display_messages_as_table($db, $session_user_id, '');
	} else if (isset($_GET['q']) && !empty($_GET['q'])) {
		$q = $_GET['q'];
		echo '<h1>Messages matching "'.$q.'"</h1>';
		echo display_messages_as_table($db,$session_user_id,"AND `title` LIKE '%$q%'");
	} else {
		?>
		<h1>Unread Messages</h1>
		<form action="" method="get">
			<input style="width:980px;" type="text" name="q" placeholder="Search All Messages">
		</form>
		<?php
		echo display_messages_as_table($db, $session_user_id, 'AND `is_read` = 0');

		echo '<a class="btn" href="?all">All Messages</a>';
	}
	?>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>
