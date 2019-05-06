<?php
date_default_timezone_set('Asia/Jakarta');
function PrintPesananSukses($Order) {
	$BatasBayar = new DateTime($Order['DateCreated']);
	$BatasBayar->modify('+10 minutes');
	print <<< PrintPS
	<style>
		table{
			border-spacing:0;
		}

		tr:first-of-type{
			font-weight:bold;
		}

		td:nth-child(odd){
			font-weight:bold;
		}

		th,td{
			padding:5px;
		}
		
		.clearfix:after {
			clear:both;
			content:".";
			display:block;
			font-size:0;
			height:0;
			visibility:hidden;
		}
		
		.clearfix { display:block; }
	</style>
	<div class="contact100-status">
		<span class="contact100-status-title">
			Pesanan Sukses!
			<h6>Kode Pembayaran : {$Order['Code']}</h6>
		</span>
		<div class="clearfix">
			<p>
				Sebuah email notifikasi pembayaran sudah dikirim ke <b>{$Order['Email']}</b>, segera melakukan pembayaran.
				<br><b>Batas waktu pembayaran : </b><b style="color: red">{$BatasBayar->format('l, d F Y H:i:s')}</b>
			</p>
			<br>
			<table>
				<tr>
					<td>Detail Pesanan :</td>
					<td></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>{$Order['Name']}</td>
				</tr>
				<tr>
					<td>No HP</td>
					<td>{$Order['Phone']}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>{$Order['Address']}</td>
				</tr>
				<tr>
					<td>Ukuran Kertas</td>
					<td>{$Order['Size']}</td>
				</tr>
				<tr>
					<td>Tipe Kertas</td>
					<td>{$Order['Type']}</td>
				</tr>
				<tr>
					<td>Jumlah</td>
					<td>{$Order['Quantity']}</td>
				</tr>
				<tr>
					<td>Note</td>
					<td>{$Order['Note']}</td>
				</tr>
				<tr>
					<td>Biaya</td>
					<td>{$Order['Charge']}</td>
				</tr>
			</table>
		</div>
	</div>
PrintPS;
}

function PrintCariPesanan() {
	print <<< PrintCP
	<div class="contact100-status">
		<span class="contact100-status-title">
			Tracking Pesanan
		</span>
		
		<form style="width: 100%; padding: 0px" class="contact100-form validate-form">
			<label class="label-input100" for="Code">Masukkan kode pemesanan *</label>
			<div style="width: 80.15%" class="wrap-input100 validate-input" data-validate="Tuliskan kode pemesanan anda">
				<input id="Code" class="input100" type="text" name="Code" placeholder="Code">
				<span class="focus-input100"></span>
			</div>

			<div style="padding: 0px" class="container-contact100-form-btn2">
				<button class="contact100-form-btn2">
					Submit
				</button>
			</div>
		</form>
	</div>
PrintCP;
}

function PrintPesananTidakDitemukan() {
	print <<< PrintPTD
	<div class="contact100-status">
		<span class="contact100-status-title">
			Pesanan tidak ditemukan :(
		</span>
		
		<form style="width: 100%; padding: 0px" class="contact100-form validate-form">
			<label class="label-input100" for="Code">Masukkan kode pemesanan *</label>
			<div style="width: 80.15%" class="wrap-input100 validate-input" data-validate="Tuliskan kode pemesanan anda">
				<input id="Code" class="input100" type="text" name="Code" placeholder="Code">
				<span class="focus-input100"></span>
			</div>

			<div style="padding: 0px" class="container-contact100-form-btn2">
				<button class="contact100-form-btn2">
					Submit
				</button>
			</div>
		</form>
	</div>
PrintPTD;
}

function PrintTrackingPesanan($DB, $Order) {
	$Estimasi = new DateTime($Order['DateCreated']);
	$Estimasi->modify('+500 minutes');
	
	$SQL = "SELECT * FROM `DP_Track` WHERE Code=:Code";
	$Stmt = $DB->prepare($SQL);
	$Params = array(
		":Code" => $Order['Code']
	);

	$Stmt->execute($Params);
	$Text = "";
	while($Track = $Stmt->fetch(PDO::FETCH_ASSOC)) {
		$DateFormat = new DateTime($Track['DateCreated']);
		$Text .= "	<tr>
						<td>{$DateFormat->format('l, d F Y H:i:s')}</td>
						<td>{$Track['Detail']}</td>
					</tr>";
	}
	
	
	print <<< PrintTP
	<style>
		table{
			border-spacing:0;
		}

		tr:first-of-type{
			font-weight:bold;
		}

		td:nth-child(odd){
			font-weight:bold;
		}

		th,td{
			padding:5px;
		}
		
		.clearfix:after {
			clear:both;
			content:".";
			display:block;
			font-size:0;
			height:0;
			visibility:hidden;
		}
		
		.clearfix { display:block; }
	</style>
	<div class="contact100-status">
		<span class="contact100-status-title">
			Tracking Pesanan
			<h6>Kode Pembayaran : {$Order['Code']}</h6>
			<br>
			<h6>Estimasi Selesai : <div style="color: red">{$Estimasi->format('l, d F Y H:i:s')}</div>Antrian : {$Order['ID']} dari 100</h6>
		</span>
		<div class="clearfix">
			<table>
				<tr>
					<td>Detail Pesanan :</td>
					<td></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>{$Order['Name']}</td>
				</tr>
				<tr>
					<td>No HP</td>
					<td>{$Order['Phone']}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>{$Order['Address']}</td>
				</tr>
				<tr>
					<td>Ukuran Kertas</td>
					<td>{$Order['Size']}</td>
				</tr>
				<tr>
					<td>Tipe Kertas</td>
					<td>{$Order['Type']}</td>
				</tr>
				<tr>
					<td>Jumlah</td>
					<td>{$Order['Quantity']}</td>
				</tr>
				<tr>
					<td>Note</td>
					<td>{$Order['Note']}</td>
				</tr>
				<tr>
					<td>Biaya</td>
					<td>{$Order['Charge']}</td>
				</tr>
			</table>
			<br>
			<table>
				<tr>
					<td>Detail tracking </td>
					<td></td>
				</tr>
				{$Text}
			</table>
		</div>
	</div>
PrintTP;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Digital Printing</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<?php 
			require_once("Connector.php");
			if(isset($_GET['Code'])) {
				$Code = filter_input(INPUT_GET, 'Code', FILTER_SANITIZE_STRING);
				
				$SQL = "SELECT * FROM `DP_Order` WHERE Code=:Code LIMIT 1";
				$Stmt = $DB->prepare($SQL);
				
				// bind parameter ke query
				$Params = array(
					":Code" => $Code
				);

				$Stmt->execute($Params);

				$Order = $Stmt->fetch(PDO::FETCH_ASSOC);
				if($Order) {
					if($Order['Status']) {
						PrintTrackingPesanan($DB, $Order);
						//Tampilkan tracking
					} else {
						PrintPesananSukses($Order);
					}
					
				} else {
					PrintPesananTidakDitemukan();
					//Tampilkan tidak ditemukan
				}
			} else {
				PrintCariPesanan();
				//tampilkan cari
			}
			?>
			
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
</body>
</html>