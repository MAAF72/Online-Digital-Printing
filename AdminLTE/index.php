<?php
date_default_timezone_set('Asia/Jakarta');
include "Connector.php";

$SQL = "SELECT * FROM `DP_ORDER`";
$Stmt = $DB->prepare($SQL);
$Stmt->execute();
$Text = "";
while($Order = $Stmt->fetch(PDO::FETCH_ASSOC)) {
	$DateCreated = new DateTime($Order['DateCreated']);
	$DateEstimate = new DateTime($Order['DateEstimate']);
	$Status = "<td><span class=\"label label-error\">ERROR!</span></td>";
	//0 : belum bayar, 1 : sudah dibayar/masuk dalam antrian, 2 : sedang dikerjakan, 3 : selesai dicetak, 4 : sedang 	diantar, 5 : pesanan selesai
	switch($Order['Status']) {
		case 0 :
			$Status = "<td><span class=\"label label-danger\">Belum dibayar</span></td>";
			break;
		case 1 :
			$Status = "<td><span class=\"label label-primary\">Dalam antrian</span></td>";
			break;
		case 2 :
			$Status = "<td><span class=\"label label-info\">Sedang dikerjakan</span></td>";
			break;
		case 3 :
			$Status = "<td><span class=\"label label-success\">Selesai dicetak</span></td>";
			break;
		case 4 :
			$Status = "<td><span class=\"label label-info\">Sedang diantar</span></td>";
			break;
		case 5 :
			$Status = "<td><span class=\"label label-success\">Pesanan selesai</span></td>";
			break;
			
	}
	$Text .= "	<tr>
                  <td>{$Order['Code']}</td>
                  <td>{$Order['Name']}</td>
                  <td>{$Order['Email']}</td>
                  <td>{$Order['Phone']}</td>
				  
                  {$Status}
                  <td>{$DateCreated->format('l, d F Y H:i:s')}</td>
                  <td>{$DateEstimate->format('l, d F Y H:i:s')}</td>
                  <td><a href=\"Edit.php?Code={$Order['Code']}\">Update</a> | <a href=\"#\" onclick=\"DeleteOrder(event, this, '{$Order['Code']}');\">Delete</a></td>
                </tr>";
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Tel-Print</title>
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Order data</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>No HP</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                  <th>Estimasi</th>
                  <th>Aksi</th>
                </tr>
                <?= $Text ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
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
	function DeleteOrder(e, elmt, Val) {
		e.preventDefault();
		$.post('ProcessDelete.php', {Code: Val}, function (data) {
			if(data != "NOT FOUND") {
				elmt.closest('tr').remove();
				alert("Delete " + Val + " Sukses!");
			} else {
				alert("Delete " + Val + " Gagal!");
			}
		});
	}
</script>
</body>
</html>