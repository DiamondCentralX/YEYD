<?php
// php-site - Accounting App - init
// Last updated: 16.06.2013

// pengemengde (  )
function pengemengde($conn,$user_id) {
	 $user_id = (int)$user_id;

	// Sett pengemengden til 0 til å starte med
	$pengemengde = 0;

	// Legg til inntekter til pengemengden
	$pengemengde += inntekt($conn,$user_id);

	// Fjern utgifter fra pengemengden
	$pengemengde += utgift($conn,$user_id);

	// Returner pengemengden
	return $pengemengde;
}

function inntekt($conn,$user_id) {
	$user_id = (int)$user_id;
	// Legg til inntekter til pengemengden
	$inntekter = $conn->query("SELECT SUM(`mengde`) AS `total` FROM `accounting_inntekt` WHERE `bruker` = $user_id");
	$inntekter = $inntekter->fetch(PDO::FETCH_ASSOC);
	return $inntekter['total'];
}

function utgift($conn,$user_id) {
	$user_id = (int)$user_id;
	// Legg til inntekter til pengemengden
	$utgifter = $conn->query("SELECT 0-SUM(`mengde`) AS `total` FROM `accounting_utgift` WHERE `bruker` = $user_id");
	$utgifter = $utgifter->fetch(PDO::FETCH_ASSOC);
	return $utgifter['total'];

	// For å få utgiftene i pluss gjør du dette
	//return $inntekter['total']+(-$inntekter['total'])*2;
}

function noenlaner($conn,$user_id) {
	$user_id = (int)$user_id;
	$utgifter = $conn->query("SELECT 0-SUM(`mengde`) AS `total` FROM `accounting_noenlaner` WHERE `betalt` = 0 AND `bruker` = $user_id");
	$utgifter = $utgifter->fetch(PDO::FETCH_ASSOC);
	return $utgifter['total'];
}

function skrivbrukervenneligdato($dato) {
	return substr($dato,6,2) . '-' . substr($dato,4,2) . '-' . substr($dato,0,4) . ' ' . substr($dato,8,2) . ':' . substr($dato,10,2);
}
?>