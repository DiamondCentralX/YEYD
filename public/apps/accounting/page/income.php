<?php
if (isset($_GET['add']) && empty($_GET['add'])) {
	if (isset($_POST) && !empty($_POST)) {
		$fra = sanitize($_POST['from']);
		$mengde = $_POST['amount'];
		$dato = dobbelt($_POST['y']) . dobbelt($_POST['m']) . dobbelt($_POST['d']) . dobbelt($_POST['h']) . dobbelt($_POST['min']);

		$sql = $db->prepare("INSERT INTO `accounting_inntekt` (`fra`,`mengde`,`dato`,`bruker`) VALUES ('$fra',$mengde,$dato,$session_user_id)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sql->execute();

		//echo "INSERT INTO `accounting_inntekt` (`fra`,`mengde`,`dato`,`bruker`) VALUES ('$fra',$mengde,$dato,$session_user_id)";
		header('Location: ?page=home&mess=2');
		exit;
	} else {
		?>
		<form class="well" action="?page=income&add" method="post">
			<div class="container">
				<h3>Add income</h3>
				<input type="text" title="How did you get it?" name="from" placeholder="From">
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
				<input class="btn btn-primary" type="submit" value="Add income">
			</div>
		</form>
		<?php
	}
} else {
	$query = $db->query("SELECT `inntekt_id`,`fra`,`mengde`,`dato` FROM `accounting_inntekt` WHERE `bruker` = $session_user_id ORDER BY `dato` DESC");
	$query->setFetchMode(PDO::FETCH_ASSOC);
	echo '<div class="container"><a class="btn btn-primary" href="?page=income&add">Add income</a><br>';
	echo '<table class="table table-hover"><caption><b>Income</b></caption><thead><tr><th>From</th><th>Amount</th><th>Date</th></tr></thead><tbody>';
	foreach ($query as $result) {
		echo '<tr><td>' . $result['fra'] . '</td><td>' . number_format($result['mengde'],2,',',' ') . $user_data['pengetype'] . '</td><td>' . skrivbrukervenneligdato($result['dato']) . '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<a class="btn btn-primary" href="?page=income&add">Add income</a></div><br>';
}
?>