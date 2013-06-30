<?php
$domain = '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
?>
<!doctype html>
<html>
	<head>
		<title>500</title>
		<link rel="stylesheet" href="<?php echo $domain; ?>/err/err.css">
		<meta charset="utf-8">
	</head>
	<body>
		<div class="header">
			<span>
				500
			</span>
		</div>
		<div class="tag">
			<span>
				Internal server error
			</span>
			<span class="extracomment">
				Wow, this is embarrassing ...
			</span>
		</div>
	</body>
</html>