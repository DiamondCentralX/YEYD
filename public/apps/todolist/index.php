<?php
// php-site - Todolist App - Home
// Last updated: 12.07.2013

ob_start();

// Require important files!
require __DIR__ . '/../../core/init.php';
require __DIR__ . '/core/todolist.php';

// Here you can turn TROLLING on or off :D
$troll = false;

// Set page variables
$PAGE['title']		=	'Todolist';
$PAGE['scripts'][]	=	'/apps/todolist/todolist.js';

// Protect the page from not logged in users!
protect_page();

// Include the top of the page :D
include __DIR__ . '/../../inc/template/top.php';
?>
<div class="container">
	<div class="navbar" style="margin-top:10px;">
		<div class="navbar-inner">
			<ul class="nav">
				<li><a href="?uncompleted">Uncompleted</a></li>
				<li><a href="?new">New</a></li>
			</ul>
			<ul class="nav pull-right">
				<li><a href="?completed">Completed</a></li>
			</ul>
		</div>
	</div>
	<h1><i class="icon-tasks"></i> Todolist</h1>
	<?php
	if (isset($_GET['uncompleted']) && empty($_GET['uncompleted'])) {
		if (isset($_GET['mess']) && !empty($_GET['mess'])) {
			echo '<div class="alert alert-success">' . $_GET['mess'] . '</div>';
		} else if (isset($_GET['err']) && !empty($_GET['err'])) {
			echo '<div class="alert alert-error">' . $_GET['err'] . '</div>';
		}
		?>
		<table>
			<tr>
				<th style="width:15px;"></th>
				<th>
					Task
				</th>
			</tr>
			<?php
			foreach (get_uncompleted_tasks($db,$session_user_id) as $row) {
				echo '<tr><td><a style="color:#000;text-decoration:none;" href="?complete=' . $row['task_id'] . '"><i class="icon-check-empty"></i></a></td><td>' . $row['task'] . '</td></tr>';
			}
			?>
		</table>
		<?php
	} else if (isset($_GET['new']) && empty($_GET['new'])) {
		if (isset($_POST) && !empty($_POST)) {
			add_task($db,$session_user_id,$_POST['task']);

			header('Location: ?uncompleted&mess=Task successfully added! :D');
			exit();
		} else {
			?>
			<form action="?new" method="post">
				Task<br>
				<input type="text" name="task"><br>
				<button class="btn">Add task</button>
			</form>
			<?php
		}
	} else if (isset($_GET['complete']) && !empty($_GET['complete'])) {
		if (!$troll) {
			$task_id = (int)$_GET['complete'];
			if (task_owner($db,$task_id) == $session_user_id) {
				complete_task($db,$task_id);

				header('Location: ?uncompleted&mess=Task marked as completed! :D');
				exit();
			} else {
				header('Location: ?uncompleted&err=That\'s not your task ...');
				exit();
			}
		} else {
			echo 'You can\'t complete tasks yet, coming soon! MOHAHAHA!!';
		}
	} else if (isset($_GET['completed']) && empty($_GET['completed'])) {
		?>
		<table>
			<tr>
				<th>
					Task
				</th>
			</tr>
			<?php
			foreach (get_completed_tasks($db,$session_user_id) as $row) {
				echo '<tr><td>' . $row['task'] . '</td></tr>';
			}
			?>
		</table>
		<?php
	} else {
		// Redirect to ?uncompleted
		header('Location: ?uncompleted');
		exit();
	}
	?>
</div>
<?php
// Include the bottom of the page :D
include __DIR__ . '/../../inc/template/bottom.php';
?>