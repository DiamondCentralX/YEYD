<?php
$domain = '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
?>
<!doctype html>
<html>
	<head>
		<title>403</title>
		<link rel="stylesheet" href="<?php echo $domain; ?>/err/err.css">
		<meta charset="utf-8">
	</head>
	<body>
		<div class="header">
			<span>
				403
			</span>
		</div>
		<div class="tag">
			<span>
				Access forbidden
			</span>
		</div>
	</body>
</html>