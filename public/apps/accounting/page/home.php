<?php
$mess = array(
	'...',
	'Du er nå logget inn! :D',
	'Income added',
	'Expense added',
	'Loan added',
	'Load marked as payed :)'
);
$err = array(
	'...',
	'The page you tried to enter dosn\'t exist! :('
);

if (isset($_GET['mess']) && !empty($_GET['mess'])) {
	echo '<div class="container"><div class="alert alert-success">' . $mess[(int)$_GET['mess']] . '</div></div>';
}
if (isset($_GET['err']) && !empty($_GET['err'])) {
	echo '<div class="container"><div class="alert alert-error">' . $err[(int)$_GET['err']] . '</div></div>';
}
?>

<div class="container">
	<div class="row-fluid">
		<div class="span4 well">
			<div class="row-fluid">
				<div class="span4">
					Inntekt
				</div>
				<div class="span8 text-right">
					<?php echo number_format(inntekt($db,$session_user_id),2,',',' ') . ' ' . $user_data['pengetype']; ?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					Utgift
				</div>
				<div class="span8 text-right">
					<div style="border-bottom:1px solid #ccc;"><?php echo number_format(utgift($db,$session_user_id),2,',',' ') . ' ' . $user_data['pengetype']; ?></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<b>Total</b>
				</div>
				<div class="span8 text-right">
					<div style="border-bottom:3px double #ccc;"><?php echo number_format(pengemengde($db,$session_user_id),2,',',' ') . ' ' . $user_data['pengetype']; ?></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					Noen låner!
				</div>
				<div class="span8 text-right">
					<div style="border-bottom:1px solid #ccc;"><?php echo number_format(noenlaner($db,$session_user_id),2,',',' ') . ' ' . $user_data['pengetype']; ?></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<b>I kassa</b>
				</div>
				<div class="span8 text-right">
					<div style="border-bottom:3px double #ccc;"><?php echo number_format(pengemengde($db,$session_user_id)+noenlaner($db,$session_user_id),2,',',' ') . ' ' . $user_data['pengetype']; ?></div>
				</div>
			</div>
		</div>
		<div class="span8 well">
			Hello! :D
		</div>
	</div>
</div>