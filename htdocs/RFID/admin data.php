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
		
		<title>Data Admin</title>
	</head>
	
	<body>
		<h2></h2>
		<ul class="topnav">
			<li><a href="home.php">Data Penerima Bantuan</a></li>
			<li><a class="active" href="admin data.php">Data Admin</a></li>
			<li><a href="registration.php">Registrasi Modul 1</a></li>
			<li><a href="registration2.php">Registrasi Modul 2</a></li>
			<li><a href="read tag.php">Transaksi Modul 1</a></li>
			<li><a href="read tag2.php">Transaksi Modul 2</a></li>
		</ul>
		<br>
		<div class="container">
            <div class="row">
                <h3>Data Admin Dengan Hak Akses</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr bgcolor="#10a0c5" color="#FFFFFF">
                      <th text-align=center>ID</th>
                      <th>Nama</th>
					  <th>Alamat Email</th>
					  <th>Password</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM admin ORDER BY id_admin ASC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['id_admin'] . '</td>';
                            echo '<td>'. $row['nama_admin'] . '</td>';
                            echo '<td>'. $row['email_admin'] . '</td>';
							echo '<td>'. $row['password'] . '</td>';
							echo '<td><a class="btn btn-success" href="admin data edit page.php?id='.$row['id_admin'].'">Edit</a>';
							echo ' ';
							echo '<a class="btn btn-danger" href="admin data delete page.php?id='.$row['id_admin'].'">Delete</a>';
							echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
				</table>
			</div>
		</div> <!-- /container -->
	</body>
</html>