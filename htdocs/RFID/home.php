<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<style>
		html {
			font-family: Arial;
			display: inline-block;
			margin: 0px auto;
			text-align: center;
		}

		ul.topnav {
			list-style-type: none;
			margin: auto;
			padding: 0;
			overflow: hidden;
			background-color: #3333FF;
			width: 90%;
		}

		ul.topnav li {float: left;}

		ul.topnav li a {
			display: block;
			color: white;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {background-color: #000099;}

		ul.topnav li a.active {background-color: #333;}

		ul.topnav li.right {float: right;}

		@media screen and (max-width: 600px) {
			ul.topnav li.right, 
			ul.topnav li {float: none;}
		}
		
		.table {
			margin: auto;
			width: 90%; 
		}
		
		thead {
			color: #FFFFFF;
		}
		</style>
		
		<title>Data Warga</title>
	</head>
	
	<body>
		<h2></h2>
		<ul class="topnav">
			<li><a class="active" href="home.php">Data Penerima Bantuan</a></li>
			<li><a href="admin data.php">Data Admin</a></li>
			<li><a href="registration.php">Registrasi Modul 1</a></li>
			<li><a href="registration2.php">Registrasi Modul 2</a></li>
			<li><a href="read tag.php">Transaksi Modul 1</a></li>
			<li><a href="read tag2.php">Transaksi Modul 2</a></li>
		</ul>
		<br>
		<div class="container">
            <div class="row">
                <h3>Penerima Bantuan</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr bgcolor="#000066" color="#FFFFFF">			
					<th text-align="center">ID RFID</th>
					<th>Nama</th>
					<th>Desa</th>
					<th>Saldo</th>
					<th>Transaksi</th>
					<th>Tanggal Transaksi</th>
					<th>Edit Data</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM data_warga INNER JOIN status ON status.no_rfid=data_warga.no_rfid';
                   foreach ($pdo->query($sql) as $row) {
					echo '<tr>';
					echo '<td>'. $row['no_rfid'] . '</td>';
					echo '<td>'. $row['nama'] . '</td>';
					echo '<td>'. $row['desa'] . '</td>';
					echo '<td>'. $row['saldo'] . '</td>';
					echo '<td>'. $row['tanggal_transaksi'] . '</td>';
					echo '<td>'. $row['januari']. '</td>';
					echo '<td><a class="btn btn-success" href="user data edit page.php?id='.$row['no_rfid'].'">Edit</a>';
					echo ' ';
					echo '<a class="btn btn-danger" href="user data delete page.php?id='.$row['no_rfid'].'">Delete</a>';
					echo '</td>';
					echo '</tr>';
				   }
				   
					Database::disconnect();
                  ?>
                  </tbody>
				</table>
			</div>
		</div> <!-- /container -->
		<h4><a href="grafik.php">Tampilkan Grafik</h4>
	</body>
</html>