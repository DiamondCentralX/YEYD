<?php
// php-site - Register page
// Last updated: 12.07.2013

require __DIR__.'/core/init.php';

logged_in_redirect();

$PAGE['title'] = 'Sign up';

if (!empty($_POST)) {
	$required_fields = array('username', 'password', 'password_again', 'first_name', 'email');

	foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields)) {
			$errors[] = 'Fields marked with an asterisk(<span class="required">*</span>) are required.';
			break 1;
		}
	}

	if (empty($errors)) {
		if (user_exists($db, $_POST['username'])) {
			$errors[] = 'Sorry, the username "' . $_POST['username'] . '" is already in use.';
		}

		if (preg_match("/\\s/", $_POST['username'])) {
			$errors[] = 'Your username can\'t contain any spaces.';
		}

		if (strlen($_POST['username']) <= 6) {
			$errors[] = 'Your username must be at least 6 characters.';
		}

		if (strlen($_POST['username']) > 32) {
			$error[] = 'Your username must me less than or equal to 32 characters.';
		}

		if (strlen($_POST['password']) <= 6) {
			$errors[] = 'Your password must be longer than 6 characters.';
		}

		if (strlen($_POST['password']) > 32) {
			$error[] = 'Your password must me less than or equal to 32 characters.';
		}

		if ($_POST['password'] != $_POST['password_again']) {
			$errors[] = 'Your password do not match.';
		}

		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'A valid email adress is required.';
		}

		if (email_exists($db, $_POST['email'])) {
			$errors[] = 'Sorry, the email "' . $_POST['email'] . '" is already in use.';
		}
	}
}
?>
<!doctype html>
<html>
	<head>
		<?php include __DIR__ . '/inc/template/head.php'; ?>

		<style type="text/css">
		body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}

		.form-signin {
			max-width: 300px;
			padding: 19px 29px 29px;
			margin: 0 auto 20px;
			background-color: #fff;
			border: 1px solid #e5e5e5;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			box-shadow: 0 1px 2px rgba(0,0,0,.05);
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
			margin-bottom: 10px;
		}
		.form-signin input[type="text"],
		.form-signin input[type="password"] {
			font-size: 16px;
			height: auto;
			margin-bottom: 15px;
			padding: 7px 9px;
		}
		</style>
	</head>
	<body>
		<?php
		if (isset($_GET['success']) && empty($_GET['success'])) {
			echo '<div class="form-signin"><h2>You\'ve been registrered successfully!</h2><a href="home'.$SITE['fileext'].'">home</a></div>';
		} else {
			if (!empty($_POST) && empty($errors)) {
				// register random dude! :D

				$register_data = array(
					'username'		=> $_POST['username'],
					'password'		=> $_POST['password'],
					'first_name'	=> $_POST['firstname'],
					'last_name'		=> $_POST['lastname'],
					'email'			=> $_POST['email'],
					'about'			=> '...'
				);

				register_user($db, $register_data);

				header('Location: ?success');
				exit();
			}
		?>

		<div class="container">
			<?php
			if (!empty($errors)) {
			?>
				<div class="form-signin">
					<h2>We tried to log you in, but ...</h2>
					<?php echo output_errors($errors); ?>
				</div>
			<?php
			}
			?>

			<form class="form-signin" action="register<?php echo $SITE['fileext']; ?>" method="post">
				<h2 class="form-signin-heading">Sign up</h2>
				<input class="input-block-level" type="text" name="username" required placeholder="username" title="username" <?php if (!empty($_POST)) { echo 'value="' . $_POST['username'] . '"'; } ?>>
				<input class="input-block-level" type="text" name="email" required placeholder="email" title="email" <?php if (!empty($_POST)) { echo 'value="' . $_POST['email'] . '"'; } ?>>
				<input class="input-block-level" type="text" name="firstname" required placeholder="first name" title="first name" <?php if (!empty($_POST)) { echo 'value="' . $_POST['firstname'] . '"'; } ?>>
				<input class="input-block-level" type="text" name="lastname" placeholder="last name" title="last name" <?php if (!empty($_POST)) { echo 'value="' . $_POST['lastname'] . '"'; } ?>>
				<input class="input-block-level" type="password" name="password" required placeholder="password" title="password">
				<input class="input-block-level" type="password" name="password_again" required placeholder="password again" title="password again">
				<button class="btn btn-large btn-primary" type="submit">Sign up</button>
				<span class="pull-right"><a href="login<?php echo $SITE['fileext']; ?>">sign in</a> | <a href="home<?php echo $SITE['fileext']; ?>">home</a></span>
			</form>
		</div>
		<?php
		}
		include __DIR__ . '/inc/template/footer.php';
		?>
	</body>
</html>