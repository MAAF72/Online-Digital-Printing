<?php
date_default_timezone_set('Asia/Jakarta');
require_once "Connector.php";

if(isset($_GET['Code'])) {
	$Code = filter_input(INPUT_GET, 'Code', FILTER_SANITIZE_STRING);	
	$SQL = "SELECT * FROM `DP_Order` WHERE Code=:Code LIMIT 1";
	$Stmt = $DB->prepare($SQL);
	
	// bind parameter ke query
	$Params = array(
		":Code" => $Code
	);

	$Stmt->execute($Params);
	
	$Text = "<tr><td>EMPTY</td></tr>";
	$Order = $Stmt->fetch(PDO::FETCH_ASSOC);
	if($Order) {
		if($Order['Status']) {
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
								<td>{$DateFormat->format('l, d F Y H:i')}</td>
								<td>{$Track['Detail']}</td>
							</tr>";
			}
		} else {
			//PrintPesananSukses($Order);
		}	
	} else {
		die("NOT FOUND!");
		//Tampilkan tidak ditemukan
	}
} else {
	header('location: ../DP_index.php');
	//tampilkan cari
}

function PrintData($Order) {
	$BatasBayar = new DateTime($Order['DateCreated']);
	$BatasBayar->modify('+10 minutes');
	$Charge = "Rp " . number_format($Order['Charge'], 2, ",", ".");
	print <<< PrintData
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
					<td>{$Charge}</td>
				</tr>
			</table>
PrintData;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Simple Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="DP_index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">ADMINISTRATOR</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  ADMINISTRATOR - TelPrint
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Telprint - Online Digital Printing        
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah catatan pesanan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="logform" role="form">
              <div class="box-body">
				<?= PrintData($Order) ?>
				<br />
                <div class="form-group">
                  <label for="LogInput">Log</label>
				  <input id="Val" type="text" class="form-control" list="log" placeholder="Tuliskan catatan disini"/>
				  <datalist id="log">
					<option>Pesanan telah dibayar</option>
					<option>Pesanan masuk antrian</option>
					<option>Pesanan sedang dikerjakan</option>
					<option>Pesanan selesai dicetak</option>
					<option>Pesanan sedang diantar(Kurir : NAMA_KURIR - NO_HP)</option>
					<option>Pesanan diterima</option>
				  </datalist>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
				
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
		
		<div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Catatan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			<table id="LogTable">
            <?= $Text ?>
			</table>
          </div>
        </div>
      </div>
	  
	  <div class="modal modal-success fade" id="modal-success">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penambahan berhasil!</h4>
              </div>
              <div class="modal-body">
                <p>Berhasil dimasukkan kedalam database! Silahkan close dialog ini untuk melakukan penambahan lagi</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penambahan gagal :(</h4>
              </div>
              <div class="modal-body">
                <p>Silahkan mencoba lagi atau menghubungi web master</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>AdminLTE Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="https://adminlte.io">TelPrint</a>.</strong> All rights
    reserved.
  </footer>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script>
	$(function() {
		$('#logform').on('submit', function(e) {
			e.preventDefault();
			$.post('ProcessEdit.php', {Val: $("#Val").val(), Code: "<?php echo $Code ?>"}, function (data) {
				if(data.includes("<td>")) {
					if(document.getElementById('LogTable').innerHTML.indexOf("EMPTY") != -1) {
						$("#LogTable").html("");
					}
					$("#LogTable").append(data);
					$("#modal-success").modal("show");
				} else {
					$("#modal-danger").modal("show");
				}
			});
		});
	});
</script>
</body>
</html>