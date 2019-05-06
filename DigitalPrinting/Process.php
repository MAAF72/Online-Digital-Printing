<?php
date_default_timezone_set('Asia/Jakarta');
//Fungsikan upload file dan kirim email

$Parameter = array("Name", "Email", "Phone", "Address", "File", "Size", "Type", "Quantity", "Note");
$Valid = true;
foreach($Parameter as $P) {
	if(!isset($_POST[$P])) {
		$Valid = false;
		break;
	}
}

if($Valid) {
	
	require_once("Connector.php");
	
    $Name = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING);
    $Email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
    $Phone = filter_input(INPUT_POST, 'Phone', FILTER_SANITIZE_STRING);
    $Address = filter_input(INPUT_POST, 'Address', FILTER_SANITIZE_STRING);
    $File = filter_input(INPUT_POST, 'File', FILTER_SANITIZE_STRING);
    $Size = filter_input(INPUT_POST, 'Size', FILTER_SANITIZE_STRING);
    $Type = filter_input(INPUT_POST, 'Type', FILTER_SANITIZE_STRING);
    $Quantity = filter_input(INPUT_POST, 'Quantity', FILTER_SANITIZE_STRING);
    $Note = filter_input(INPUT_POST, 'Note', FILTER_SANITIZE_STRING);

    $SQL = "INSERT INTO `DP_Order` (Code, Name, Email, Phone, Address, File, Size, Type, Quantity, Note, Charge, DateEstimate) 
            VALUES (:Code, :Name, :Email, :Phone, :Address, :File, :Size, :Type, :Quantity, :Note, :Charge, DATE_ADD(NOW(), INTERVAL 10 MINUTE))";
			
	/*
	INSERT INTO `DP_Order` (Code, Name, Email, Phone, Address, File, Size, Type, Quantity, Note) VALUES ('b9c2faef2a', 'Fatih', 'abdurrahmanalfatih72@gmail.com', '081295084653', 'Astra GD 1', 'Rahasiadong.png', 'A4', 'AK290', '1', 'Test Gan')       
	*/
    $Stmt = $DB->prepare($SQL);

	$Code = strtoupper(substr(md5(uniqid(mt_rand(), true)) , 0, 10));
	
	require_once("Charge.php");
	
	$Charge = GetCharge($Size, $Type, $Quantity);
	
    // bind parameter ke query
    $Params = array(
        ":Code" => $Code,
        ":Name" => $Name,
        ":Email" => $Email,
        ":Phone" => $Phone,
        ":Address" => $Address,
        ":File" => $File,
        ":Size" => $Size,
        ":Type" => $Type,
        ":Quantity" => $Quantity,
        ":Note" => $Note,
        ":Charge" => $Charge
    );
	
	echo "<br/>";
	echo $Code;
	echo "<br/>";
	if($Stmt->execute($Params)) {
		header("Location: Status.php?Code=$Code");
	} else {
		echo "GAGAL!";
		//echo "<br/>";
		//echo print_r($DB->errorCode());
		//echo print_r($Stmt);
	}
    
} else {
	echo "Gak Valid";
}

?>
