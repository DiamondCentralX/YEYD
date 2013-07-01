<?php
// Require init.php
require 'core/init.php';

protect_page();

$PAGE['title'] = 'Logoquiz';

// Include template top
include 'inc/template/top.php';
?>
<style>
.logolist-logo {
	display:block;
	position:relative;
}

.logolist-logo .logo {
	display:block;

	margin:5px;
	padding:5px;
	border:1px solid #ccc;
	background:#fff;
}

.logolist-logo .solved {
	display:block;
	width:50px;
	position:absolute;
	left:20px;
	bottom:10px;
}

.logo-container {
	margin-bottom:10px;
}
</style>
<div class="container">
	<h1>Logoquiz</h1><div><?php echo getLogoQuizScore($db,$session_user_id) . ' of ' . getLogoAmount($db); ?></div>
	<div class="logos">
	<?php
	if (isset($_GET['logo']) && !empty($_GET['logo'])) {
		$id = (int)$_GET['logo'];

		?>
		<a href="?home">&larr; Back</a>

		<div class="logolist-logo">
			<img class="logo" src="img/getLogoImage.php?id=<?php echo $id; ?>">
		</div>
		<?php
		if (logoquiz_user_solved_logo($db,$session_user_id,$id)) {
			$solvetime = $db->query("SELECT `timestamp` FROM `logoquiz_solved` WHERE `logo_id` = $id AND `user_id` = $session_user_id")->fetch(PDO::FETCH_ASSOC)['timestamp'];
			$logoanswer = $db->query("SELECT `name` FROM `logoquiz_logos` WHERE `logo_id` = $id")->fetch(PDO::FETCH_ASSOC)['name'];
			?>You already answered this logo correctly the <?php echo date('j. F Y H:i', $solvetime); ?> with the answer <span id="solv" style="color:#3d88c7;font-weight:bold;" onclick="$('#solv').html('&quot;<?php echo $logoanswer; ?>&quot;');" title="Click to reveal the answer! :D">****</span>.<?php
		} else {
			?>
			<div class="answer-form">
				<form action="?answer" method="post">
					<input type="hidden" name="logo_id" value="<?php echo $id; ?>">
					<input type="text" name="answer" autocomplete="off" placeholder="Write your answer here :D">
					<br>
					<input class="btn btn-primary" type="submit" value="answer">
				</form>
			</div>
			<?php
		}
	} else if (isset($_GET['answer']) && empty($_GET['answer'])) {
		if (isset($_POST) && !empty($_POST)) {
			$id = (int)$_POST['logo_id'];

			echo '<a href="?home">&larr; Back</a> <a href="?logo='.$id.'">&larr; Back to logo</a>';

			if (!logoquiz_user_solved_logo($db,$session_user_id,$id)) {
				if (answer_logo($db,$session_user_id,$id,strtolower($_POST['answer']))) {
					echo '<p>You answered the logo correctly! :D</p>';
				} else {
					echo '<p>That answer is not correct :(</p>';
				}
			} else {
				echo '<p>You\'ve already solved that logo</p>';
			}
		} else {
			echo '<a href="?home">&larr; Back</a><p>No data recieved.</p>';
		}
	} else {
		$result = $db->query("SELECT `logo_id`,`name` FROM `logoquiz_logos`");

		$result->setFetchMode(PDO::FETCH_ASSOC);

		$x = 1;
		foreach ($result as $row) {
			if ($x == 1) {
				echo '<div class="row-fluid">';
			}
			?>
				<div class="span3">
					<a class="logolist-logo" href="?logo=<?php echo $row['logo_id']; ?>">
						<img class="logo" src="img/getLogoImage.php?id=<?php echo $row['logo_id']; ?>">
						<?php
						if (logoquiz_user_solved_logo($db,$session_user_id,$row['logo_id'])) {
							echo '<img class="solved" src="img/solved.png">';
						}
						?>
					</a>
				</div>
			<?php
			$x++;
			if ($x > 4) {
				$x = 1;
				echo '</div>';
			}
		}
		if ($x <= 4) {
			echo '</div>';
		}
	}
	?>
	</div>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>