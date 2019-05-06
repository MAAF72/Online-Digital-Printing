<?php
	//error_reporting(E_ALL); 
	//ini_set("display_errors", 1);
	date_default_timezone_set('Asia/Jakarta');
	if(isset($_POST['Val']) && isset($_POST['Code']) ) {
		require_once("Connector.php");
		
		$Val = filter_input(INPUT_POST, 'Val', FILTER_SANITIZE_STRING);
		$Code = filter_input(INPUT_POST, 'Code', FILTER_SANITIZE_STRING);
		
		
		function GetEstimation($DB, $Code) {
			$SQL = "SELECT `DateEstimate` FROM `DP_ORDER` WHERE `Status` > 0 AND `Status` < 3 ORDER BY `DateEstimate` DESC LIMIT 1";
			
			$Stmt = $DB->query($SQL);
			$Data = $Stmt->fetch();
			$Last = new DateTime();
			if($Data != NULL) {
				$Last = new DateTime($Data[0]);
			} //NULL jika tidak ada row yg dihasilkan
			
			$SQL = "SELECT `Quantity` FROM `DP_ORDER` WHERE `Code` = '{$Code}'";
			$Stmt = $DB->query($SQL);
			$Data = $Stmt->fetch();
			if($Data != NULL) {
				$EstimationMinute = ceil(($Data[0] * 6 / 60));
				$Last->modify("+ $EstimationMinute minutes");
				//echo $EstimationMinute;
			} else {
				//Harusnya gak error
				die("Error at GetEstimation");
			}
			return $Last;
		}
		
		$Date = new DateTime();
		
		$Status = -1;
		
		if(strpos($Val, "Pesanan telah dibayar") !== false) { //Pesanan masuk antrian
			$Status = 1;
		//} else if(strpos($Val, "Pesanan masuk antrian") !== false) {
			//$Status = 1;
		} else if(strpos($Val, "Pesanan sedang dikerjakan") !== false) {
			$Status = 2;
		} else if(strpos($Val, "Pesanan selesai dicetak") !== false) {
			$Status = 3;
		} else if(strpos($Val, "Pesanan sedang diantar") !== false) {
			$Status = 4;
		} else if(strpos($Val, "Pesanan diterima") !== false) {
			$Status = 5;
		}
		
		//Setting jika Status DB < Status tidak bisa, karena gk mungkin downgrade status
		if($Status != -1) {
			$Data = "`Status` = '{$Status}'";
			if($Status == 1) {
				$DateEstimate = GetEstimation($DB, $Code);
				$Data .= ", `DateEstimate` = '{$DateEstimate->format('Y-m-d H:i:s')}'";
			}
			$SQL = "UPDATE `DP_ORDER` SET {$Data} WHERE `Code` = '{$Code}'";
			$Result = $DB->exec($SQL);
			if(!$Result) {
				die("GAGAL SET STATUS");
			}
		}
		
		$SQL = "INSERT INTO `DP_TRACK` (`Code`, `Detail`, `DateCreated`) 
            VALUES (:Code, :Val, '{$Date->format('Y-m-d H:i:s')}')";
		
		$Stmt = $DB->prepare($SQL);
		$Params = array(
			":Code" => $Code,
			":Val" => $Val
		);
		if($Stmt->execute($Params)) {
			echo "<tr>
				<td>{$Date->format('l, d F Y H:i')}</td>
				<td>{$Val}</td>
			</tr>";
		} else {
			//echo print_r($DB->errorInfo());
			//echo print_r($Stmt);
			die("GAGAL INSERT TRACK");
		}
	} else {
		die("MISS PARAMETER");
	}
?>