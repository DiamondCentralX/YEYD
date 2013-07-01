<?php
// php-site - Accounting App main file :D
// Last updated: 16.06.2013

// Require php-site init
require __DIR__ . '/../../core/init.php';

protect_page();

$SITE['title'] = 'Accounting - ' . $SITE['title'];

$PAGE['title'] = 'Accounting';

// Require accounting init
require __DIR__ . '/core/init.php';

if (isset($_GET['page']) && !empty($_GET['page'])) {
	$page = $_GET['page'];

	if (file_exists('page/' . $page . '.php')) {
		include '../../inc/template/top.php';
		?>
		<div class="container">
			<h1>Accounting<sup><sup>MAY BE BETA IN LIKE 50 YEARS ...</sup></sup></h1>
			<div class="navbar">
				<div class="navbar-inner">
					<ul class="nav">
						<li <?php echo ($_GET['page'] == 'home') ? 'class="active"' : ''; ?>><a href="?page=home">Home</a></li>
						<li <?php echo ($_GET['page'] == 'income') ? 'class="active"' : ''; ?>><a href="?page=income">Income</a></li>
						<li <?php echo ($_GET['page'] == 'expense') ? 'class="active"' : ''; ?>><a href="?page=expense">Expense</a></li>
						<li <?php echo ($_GET['page'] == 'noenlaner') ? 'class="active"' : ''; ?>><a href="?page=noenlaner">Someone is loaning my money!!</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php
		include 'page/' . $page . '.php';
		include '../../inc/template/bottom.php';
	} else {
		header('Location: ?page=home&err=1');
		exit;
	}
} else {
	header('Location: ?page=home');
}
?>