<?php
// php-site - Settings
// Last updated: 28.06.2013

// Require init.php
require 'core/init.php';

// Set page variables
$PAGE['title'] = 'settings';

if (isset($_POST) && !empty($_POST)) {
	if (isset($_POST['about'])) {
		// Gender
		if ($_POST['gender'] == 'Unknown' || $_POST['gender'] == 'Male' || $_POST['gender'] == 'Female' || $_POST['gender'] == 'Somewhere in between' || $_POST['gender'] == 'Other') { } else {
			$errors[] = 'You bugger!';
		}

		// Species
		if ($_POST['species'] == 'Unknown' || $_POST['species'] == 'Human' || $_POST['species'] == 'Monkey' || $_POST['species'] == 'Alien' || $_POST['species'] == 'Other') { } else {
			$errors[] = 'You bugger!';
		}
	} else if (isset($_POST['current_password']) && !empty($_POST['current_password']) && isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['new_password_again']) && !empty($_POST['new_password_again'])) {
		if (md5($_POST['current_password']) == $user_data['password']) {
			if (trim($_POST['new_password']) != trim($_POST['new_password_again'])) {
				$errors[] = 'Your new passwords do not match.';
			} else if (strlen($_POST['new_password']) <= 6) {
				$errors[] = 'Your password must be at least 6 characters.';
			} else if (strlen($_POST['new_password']) > 32) {
				$errors[] = 'Your password must me less than or equal to 32 characters.';
			}
		} else {
			$errors[] = 'Your current password is incorrect.';
		}
	} else if (isset($_POST['contact_info'])) {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'A valid email adress is required.';
		}

		if (email_exists($db, $_POST['email']) && $_POST['email'] != $user_data['email']) {
			$errors[] = 'Sorry, the email "' . $_POST['email'] . '" is already in use.';
		}
	} else if (isset($_POST['privacy'])) {
		if ($_POST['profile_privacy'] != 0 && $_POST['profile_privacy'] != 1 && $_POST['profile_privacy'] != 2 && $_POST['profile_privacy'] != 3) {
			$errors[] = 'You bugger!';
		}
		if ($_POST['search_able'] != 0 && $_POST['search_able'] != 1) {
			$errors[] = 'You bugger!';
		}
	} else if (isset($_POST['apps'])) {
		// Nothing to chech for apps :D
	}
}

// Include template top
include 'inc/template/top.php';
?>
<div class="container">
	<?php

		// About
		if (isset($_POST['about']) && empty($errors)) {
			$update_data = array(
				'about'				=>	$_POST['about'],
				'gender'			=>	$_POST['gender'],
				'species'			=>	$_POST['species'],
				'job'				=>	$_POST['job'],
				'address'			=>	$_POST['address']
			);
			update_user($db, $session_user_id, $update_data);

			header('Location: ?success');
			exit();

		// Password
		} else if (isset($_POST['current_password']) && !empty($_POST['current_password']) && isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['new_password_again']) && !empty($_POST['new_password_again']) && empty($errors)) {
			change_password($db, $session_user_id, $_POST['new_password']);
			header('Location: ?success');

		// Contact Info
		} else if (isset($_POST['contact_info']) && empty($errors)) {
			$update_data = array(
				'website'			=>	$_POST['website'],
				'email'				=>	$_POST['email'],
				'twitter'			=>	$_POST['twitter'],
				'facebook'			=>	$_POST['facebook'],
				'google+'			=>	$_POST['google+'],
				'steam'				=>	$_POST['steam'],
				'skype'				=>	$_POST['skype'],
				'minecraft'			=>	$_POST['minecraft'],
				'youtube'			=>	$_POST['youtube']
			);
			update_user($db, $session_user_id, $update_data);

			header('Location: ?success');
			exit();

		// Privacy
		} else if (isset($_POST['privacy']) && empty($errors)) {
			$update_data = array(
				'profile_privacy'	=>	$_POST['profile_privacy'],
				'search_able'		=>	$_POST['search_able']
			);

			update_user($db, $session_user_id, $update_data);

			header('Location: ?success');
			exit();
			
		// Apps
		} else if (isset($_POST['apps']) && empty($errors)) {
			$update_data = array(
				'app_docs'			=>	(isset($_POST['app_docs'])) ? 1 : 0,
				'app_accounting'	=>	(isset($_POST['app_accounting'])) ? 1 : 0,
				'app_logoquiz'		=>	(isset($_POST['app_logoquiz'])) ? 1 : 0,
				'app_todolist'		=>	(isset($_POST['app_todolist'])) ? 1 : 0
			);

			update_user($db, $session_user_id, $update_data);

			header('Location: ?success');
			exit();

		// Output errors
		} else if (!empty($errors)) {
			echo '<div class="page-header"><h1>We tried to update your data, but ...</h1>'.output_errors($errors).'</div>';
		}

		// Output success message :D
		if (empty($errors) && isset($_GET['success']) && empty($_GET['success'])) {
			echo '<div class="page-header"><h1>Your settings have been updated <small>You\'re awesome!</small></h1></div>';
		}
		?>

	<?php
	?>
	<div class="row-fluid">
			<div class="span2">
				<h1>Quick links</h1>
				<ul style="list-style:none;margin:0;">
					<li><a href="#about">about</a></li>
					<li><a href="#change_password">change password</a></li>
					<li><a href="#contact_info">contact info & social</a></li>
					<li><a href="#privacy">privacy</a></li>
					<li><a href="#customization">customization</a></li>
					<li><a><a href="#apps">Apps</a></li>
				</ul>
			</div>
			<div class="span10">
				<p id="about">
					<b>About</b>
					<form action="" method="post">
						<textarea name="about" style="
							min-width:100%;
							max-width:100%;
							min-height:200px;
							max-height:400px;
						"><?php echo $user_data['about']; ?></textarea>
						<!--Gender & Species should be inline using row-fluid -->
						<div class="row-fluid">
							<div class="span4">
								Gender<br>
								<select name="gender">
									<option value="Unknown" <?php echo ($user_data['gender'] == 'Unknown') ? 'selected="selected"' : ''; ?>>Unknown</option>
									<option value="Male" <?php echo ($user_data['gender'] == 'Male') ? 'selected="selected"' : ''; ?>>Male</option>
									<option value="Female" <?php echo ($user_data['gender'] == 'Female') ? 'selected="selected"' : ''; ?>>Female</option>
									<option value="Somewhere in between" <?php echo ($user_data['gender'] == 'Somehwere in between') ? 'selected="selected"' : ''; ?>>Somewhere in between</option>
									<option value="Other" <?php echo ($user_data['gender'] == 'Other') ? 'selected="selected"' : ''; ?>>Other</option>
								</select>
							</div>
							<div class="span4">
								Species<br>
								<select name="species">
									<option value="Unknown" <?php echo ($user_data['species'] == 'Unknown') ? 'selected="selected"' : ''; ?>>Unknown</option>
									<option value="Human" <?php echo ($user_data['species'] == 'Human') ? 'selected="selected"' : ''; ?>>Human</option>
									<option value="Monkey" <?php echo ($user_data['species'] == 'Monkey') ? 'selected="selected"' : ''; ?>>Monkey</option>
									<option value="Alien" <?php echo ($user_data['species'] == 'Alien') ? 'selected="selected"' : ''; ?>>Alien</option>
									<option value="Other" <?php echo ($user_data['species'] == 'Other') ? 'selected="selected"' : ''; ?>>Other</option>
								</select>
							</div>
							<div class="span4">
								Address<br>
								<input type="text" name="address" value="<?php echo $user_data['address']; ?>">
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								Job<br>
								<input type="text" name="job" value="<?php echo $user_data['job']; ?>">
							</div>
							<div class="span4"></div>
							<div class="span4"></div>
						</div>
						<input class="btn" type="submit" value="update">
					</form>
				</p>
				<hr>
				<p id="change_password">
					<b>Change Password</b>
					<form action="" method="post">
						<input type="password" name="current_password" required placeholder="current password">
						<input type="password" name="new_password" required placeholder="new password">
						<input type="password" name="new_password_again" required placeholder="new password again">
						<br>
						<input class="btn" type="submit" value="update">
					</form>
				</p>
				<hr>
				<p id="contact_info">
					<b>Contact Info & Social</b>
					<form action="" method="post">
						<div class="row-fluid">
							<div class="span4">
								Your Website<br><input type="text" name="website" value="<?php echo $user_data['website']; ?>" placeholder="your website">
							</div>
							<div class="span4">
								Twitter<br><input type="text" name="twitter" value="<?php echo $user_data['twitter']; ?>" placeholder="twitter">
							</div>
							<div class="span4">
								Skype<br><input type="text" name="skype" value="<?php echo $user_data['skype']; ?>" placeholder="skype">
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								Email<br><input type="text" name="email" value="<?php echo $user_data['email']; ?>" placeholder="email">
							</div>
							<div class="span4">
								Facebook<br><input type="text" name="facebook" value="<?php echo $user_data['facebook']; ?>" placeholder="facebook">
							</div>
							<div class="span4">
								Minecraft<br><input type="text" name="minecraft" value="<?php echo $user_data['minecraft']; ?>" placeholder="minecraft">
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								Steam<br><input type="text" name="steam" value="<?php echo $user_data['steam']; ?>" placeholder="steam">
							</div>
							<div class="span4">
								Google+<br><input type="text" name="google+" value="<?php echo $user_data['google+']; ?>" placeholder="google+">
							</div>
							<div class="span4">
								YouTube<br><input type="text" name="youtube" value="<?php echo $user_data['youtube']; ?>" placeholder="youtube">
							</div>
						</div>
						<input class="btn" type="submit" name="contact_info" value="update">
					</form>

					<!-- Create a better implementation of this ;-) -->
					<style>
						.row-fluid input[type=text] {
							width:100%;
						}
					</style>
				</p>
				<hr>
				<p id="privacy">
					<b>Privacy</b>
					<form action="" method="post">
						<div class="row-fluid">
							<div class="span4">
								Profile<br>
								<select name="profile_privacy">
									<option value="0" <?php echo ($user_data['profile_privacy'] == 0) ? 'selected="selected"' : ''; ?>>public</option>
									<option value="1" <?php echo ($user_data['profile_privacy'] == 1) ? 'selected="selected"' : ''; ?>>logged in users only</option>
									<option value="2" <?php echo ($user_data['profile_privacy'] == 2) ? 'selected="selected"' : ''; ?>>friends only</option>
									<option value="3" <?php echo ($user_data['profile_privacy'] == 3) ? 'selected="selected"' : ''; ?>>private</option>
								</select>
							</div>
							<div class="span4">
								SearchAble<br>
								<select name="search_able">
									<option value="0" <?php echo ($user_data['search_able'] == 0) ? 'selected="selected"' : ''; ?>>false (no)</option>
									<option value="1" <?php echo ($user_data['search_able'] == 1) ? 'selected="selected"' : ''; ?>>true (yes)</option>
								</select>
							</div>
							<div class="span4"></div>
						</div>
						<input class="btn" type="submit" name="privacy" value="update">
					</form>
				</p>
				<hr>
				<p id="apps">
					<b>Apps</b>
					<form action="" method="post">
						<div class="row-fluid">
							<div class="span4">
								<input type="checkbox" <?php echo ($user_data['app_docs'] == 1) ? 'checked="checked"' : ''; ?> name="app_docs"> Docs<br>
							</div>
							<div class="span4">
								<input type="checkbox" <?php echo ($user_data['app_accounting'] == 1) ? 'checked="checked"' : ''; ?> name="app_accounting"> Accounting
							</div>
							<div class="span4">
								<input type="checkbox" <?php echo ($user_data['app_logoquiz'] == 1) ? 'checked="checked"' : ''; ?> name="app_logoquiz"> Logoquiz
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<input type="checkbox" <?php echo ($user_data['app_todolist'] == 1) ? 'checked="checked"' : ''; ?> name="app_todolist"> Todolist
							</div>
							<div class="span4">
							</div>
							<div class="span4">
							</div>
						</div>
						<input class="btn" type="submit" name="apps" value="Update">
					</form>
				</p>
			</div>
		</div>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>