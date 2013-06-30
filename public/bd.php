<?php
if (isset($_GET['d']) && isset($_GET['m']) && isset($_GET['y'])) {
	$b_d = $_GET['d'];
	$b_m = $_GET['m'];
	$b_y = $_GET['y'];

	echo "<p>$b_d.$b_m.$b_y</p>";

	function calcAge ($b_d,$b_m,$b_y) {
		$b_d = (int)$b_d;
		$b_m = (int)$b_m;
		$b_y = (int)$b_y;
		
		$age = date('Y') - $b_y;
		
		if ($b_m > date('m')) {
			$age--;
		} else if ($b_m == date('m')) {
			if ($b_d > date('d')) {
				$age--;
			}
		}
		
		// Return the age
		return $age;
	}

	echo '<p>Calculated age: ' . calcAge($b_d,$b_m,$b_y) . '</p>';
} else {
	echo 'You must your birtday by using the get variables d for day number(1-31), m for month number(1-12) and y for year';
}
?>