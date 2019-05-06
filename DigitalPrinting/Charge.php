<?php
	function GetCharge($Size, $Type, $Quantity) {
		$Charge = 0;
		$Price = 0;
		switch($Type) {
			case 'HVS':
				switch($Size) {
					case 'A4':
						if($Quantity >= 1 && $Quantity <= 100) {
							$Price = 1000;
						} else {
							$Price = 500;
						}
					break;
				}
			break;
			case 'AP120':
				switch($Size) {
					case 'A3':
						if($Quantity >= 1 && $Quantity <= 50) {
							$Price = 4000;
						} else if($Quantity >= 51 && $Quantity <= 100) {
							$Price = 3500;
						} else {
							$Price = 3000;
						}
					break;
				}
			break;
			case 'AP150':
				switch($Size) {
					case 'A3':
						if($Quantity >= 1 && $Quantity <= 50) {
							$Price = 5000;
						} else if($Quantity >= 51 && $Quantity <= 100) {
							$Price = 4500;
						} else {
							$Price = 4000;
						}
					break;
				}
			case 'AC230':
				switch($Size) {
					case 'A3':
						if($Quantity >= 1 && $Quantity <= 50) {
							$Price = 6000;
						} else if($Quantity >= 51 && $Quantity <= 100) {
							$Price = 5500;
						} else {
							$Price = 500;
						}
					break;
				}
			break;
			case 'AC260':
				switch($Size) {
					case 'A3':
						if($Quantity >= 1 && $Quantity <= 50) {
							$Price = 6500;
						} else if($Quantity >= 51 && $Quantity <= 100) {
							$Price = 6000;
						} else {
							$Price = 5500;
						}
					break;
				}
			break;
		}
		
		$Charge = $Quantity * $Price;
		return $Charge;
	}
?>