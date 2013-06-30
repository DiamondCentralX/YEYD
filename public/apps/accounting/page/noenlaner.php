<?php
if (isset($_GET['add']) && empty($_GET['add'])) {
	if (isset($_POST) && !empty($_POST)) {
		$hvem = sanitize($_POST['who']);
		$forhva = sanitize($_POST['why']);
		$mengde = $_POST['amount'];
		$dato = dobbelt($_POST['y']) . dobbelt($_POST['m']) . dobbelt($_POST['d']) . dobbelt($_POST['h']) . dobbelt($_POST['min']);

		$sql = $db->prepare("INSERT INTO `accounting_noenlaner` (`hvem`,`forhva`,`mengde`,`dato`,`bruker`) VALUES ('$hvem','$forhva',$mengde,$dato,$session_user_id)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sql->execute();

		header('Location: ?page=home&mess=4');
		exit;
	} else {
		?>
		<form class="well" action="?page=noenlaner&add" method="post">
			<div class="container">
				<h3>Add loan</h3>
				<input type="text" title="Who loaned from you?" name="who" placeholder="Who">
				<br>
				<input type="text" title="Why did they loan from you?" name="why" placeholder="Why">
				<br>
				<input type="text" title="Protip: Use . for ," name="amount" placeholder="Amount (in <?php echo $user_data['pengetype']; ?>)">
				<br>
				<input type="text" title="Year" style="width:33px;" name="y" value="<?php echo date('Y'); ?>">
				<input type="text" title="Month" style="width:16px;" name="m" value="<?php echo date('m'); ?>">
				<input type="text" title="Day" style="width:16px;" name="d" value="<?php echo date('d'); ?>">
				<input type="text" title="Hour" style="width:16px;" name="h" value="<?php echo date('H'); ?>">
				:
				<input type="text" title="Minute" style="width:16px;" name="min" value="<?php echo date('i'); ?>">
				<br>
				<input class="btn btn-primary" type="submit" value="Add loan">
			</div>
		</form>
		<?php
	}
} else if (isset($_GET['loanpayed']) && !empty($_GET['loanpayed'])) {
	$lån_id = (int)$_GET['loanpayed'];
	$db->exec("UPDATE `accounting_noenlaner` SET `betalt` = 1 WHERE `lan_id` = $lån_id AND `bruker` = $session_user_id");
	header('Location: ?side=hjem&kode=5');
	exit;
} else {
	$spørring = $db->query("SELECT `lan_id`,`hvem`,`forhva`,`mengde`,`dato` FROM `accounting_noenlaner` WHERE `betalt` = 0 AND `bruker` = $session_user_id ORDER BY `dato` DESC");
	$spørring->setFetchMode(PDO::FETCH_ASSOC);
	echo '<div class="container"><a class="btn btn-primary" href="?page=noenlaner&add">Add loan</a><br>';
	echo '<table class="table table-hover"><caption><b>Noen låner</b></caption><thead><tr><th>Who</th><th>Why</th><th>Amount</th><th>Date</th><th>Ooooh</th></tr></thead><tbody>';
	foreach ($spørring as $resultat) {
		echo '<tr><td>' . $resultat['hvem'] . '</td><td>' . $resultat['forhva'] . '</td><td>' . number_format($resultat['mengde'],2,',',' ') . ' ' . $user_data['pengetype'] . '</td><td>' . skrivbrukervenneligdato($resultat['dato']) . '</td><td><a class="btn" href="?page=noenlaner&loanpayed=' . $resultat['lan_id'] . '">Loan payed</a></td></tr>';
	}
	echo '</tbody></table>';
	echo '<a class="btn btn-primary" href="?page=noenlaner&add">Add loan</a></div><br>';

	$spørring = $db->query("SELECT `lan_id`,`hvem`,`forhva`,`mengde`,`dato` FROM `accounting_noenlaner` WHERE `betalt` = 1 AND `bruker` = $session_user_id ORDER BY `dato` DESC");
	$spørring->setFetchMode(PDO::FETCH_ASSOC);
	echo '<div class="container">';
	echo '<table class="table table-hover"><caption><b>Old loans</b></caption><thead><tr><th>Who</th><th>Why</th><th>Amount</th><th>Date</th></tr></thead><tbody>';
	foreach ($spørring as $resultat) {
		echo '<tr><td>' . $resultat['hvem'] . '</td><td>' . $resultat['forhva'] . '</td><td>' . number_format($resultat['mengde'],2,',',' ') . ' ' . $user_data['pengetype'] . '</td><td>' . skrivbrukervenneligdato($resultat['dato']) . '</td></tr>';
	}
	echo '</tbody></table>';
}
?>