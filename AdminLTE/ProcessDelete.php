<?php
	error_reporting(E_ALL); 
	ini_set("display_errors", 1);
	if(isset($_POST['Code']) ) {
		require_once("Connector.php");
		
		$Code = filter_input(INPUT_POST, 'Code', FILTER_SANITIZE_STRING);
		
		$SQL = "DELETE FROM `DP_ORDER` WHERE `Code` = '{$Code}'";
		$Result = $DB->exec($SQL);
		if($Result) {
			$SQL = "DELETE FROM `DP_TRACK` WHERE `Code` = '{$Code}'";
			$DB->exec($SQL);
		} else {
			die("NOT FOUND");
		}
	} else {
		die("MISS PARAMETER");
	}
?>