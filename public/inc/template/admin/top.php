<?php
$PAGE['stylesheets'] = array('/css/admin.css');
?>
<!doctype html>
<html>
	<head>
		<?php include __DIR__ . '/../admin/head.php'; ?>
	</head>
	<body>
		<div class="header">
			<div class="user">
				<span class="hello">Hello, <?php echo $user_data['first_name']; ?>!</span><br>
				<span class="as">Logged in as <a href="<?php echo $domain . '/u/' . $user_data['username']; ?>"><?php echo $user_data['username']; ?></a></span>
			</div>
			<div class="title"><?php echo explode(' | ', $PAGE['title'])[0]; ?></div>
			<div class="desc"><a href="<?php echo $domain; ?>"><?php echo $SITE['title']; ?></a> admin dashboard</div>
			<br>
			<a href="home<?php echo $SITE['fileext']; ?>">Home</a> | <a href="config<?php echo $SITE['fileext']; ?>">Config</a>
		</div>