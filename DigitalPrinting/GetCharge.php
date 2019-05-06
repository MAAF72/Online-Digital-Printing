<?php
	if(isset($_POST["Size"]) && isset($_POST["Size"]) && isset($_POST["Size"])) {
		require_once("Charge.php");
		
		$Size = filter_input(INPUT_POST, 'Size', FILTER_SANITIZE_STRING);
		$Type = filter_input(INPUT_POST, 'Type', FILTER_SANITIZE_STRING);
		$Quantity = filter_input(INPUT_POST, 'Quantity', FILTER_SANITIZE_STRING);
		
		echo "Rp " . number_format(GetCharge($Size, $Type, $Quantity), 2, ",", ".");
	} else {
		die("ERROR");
	}
?>