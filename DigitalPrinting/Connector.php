<?php
$DB_Host = "localhost";
$DB_User = "root";
$DB_Pass = "";
$DB_Name = "digitalprinting";

try {    
	//create PDO connection 
	$DB = new PDO("mysql:host=$DB_Host;dbname=$DB_Name", $DB_User, $DB_Pass);
} catch(PDOException $e) {
	//show error
	die("Terjadi masalah: " . $e->getMessage());
}
?>