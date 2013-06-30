<?php
require 'core/init.php';

logged_in_redirect();

$page_title = 'sign in';

if (empty($_POST) === false) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) || empty($password)) {
		$errors[] = 'You need to enter a username and password.';
	} else if (!user_exists($db, $username)) {
		$errors[] = 'We can\'t find that username. Have you registered?';
	} else {
		$login = login($db, $username, $password);
		if (!$login) {
			$errors[] = 'That username/password combination is incorrect.';
		} else {
			$_SESSION['user_id'] = $login;
			header('Location: home' . $SITE['fileext']);
			exit();
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

			<form class="form-signin" action="login<?php echo $SITE['fileext']; ?>" method="post">
				<h2 class="form-signin-heading">Please sign in</h2>
				<input type="text" name="username" class="input-block-level" required="required" placeholder="username">
				<input type="password" name="password" class="input-block-level" required="required" placeholder="password">
				<button class="btn btn-large btn-primary" type="submit">Sign in</button>
				<span class="pull-right"><a href="register<?php echo $SITE['fileext']; ?>">sign up</a> | <a href="home<?php echo $SITE['fileext']; ?>">home</a></span>
			</form>
		</div>

		<?php include __DIR__ . '/inc/template/footer.php'; ?>
	</body>
</html>