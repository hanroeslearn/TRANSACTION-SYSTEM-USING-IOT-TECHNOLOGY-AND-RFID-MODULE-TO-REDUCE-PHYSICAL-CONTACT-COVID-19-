<?php
	$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer2.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<html>
<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		<script src="jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				 $("#getUID").load("UIDContainer2.php");
				setInterval(function() {
					$("#getUID").load("UIDContainer2.php");
				}, 500);
			});
		</script>
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
		
		<title>Registration</title>
	</head>
	
	<body>

		<h2 align="center"></h2>
		<ul class="topnav">
			<li><a href="home.php">Data Penerima Bantuan</a></li>
			<li><a href="admin data.php">Data Admin</a></li>
			<li><a href="registration.php">Registrasi Modul 1</a></li>
			<li><a class="active" href="registration2.php">Registrasi Modul 2</a></li>
			<li><a href="read tag.php">Transaksi Modul 1</a></li>
			<li><a href="read tag2.php">Transaksi Modul 2</a></li>
		</ul>

		<div class="container">
			<br>
			<div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
				<div class="row">
					<h3 align="center">Formulir Pengisian Data Baru</h3>
				</div>
				<br>
				<form class="form-horizontal" action="insertDB2.php" method="post" >
					<div class="control-group">
						<label class="control-label">ID</label>
						<div class="controls">
						    <textarea name="id" id="getUID" placeholder="Please Scan your Card / Key Chain to display ID" rows="1" cols="1" required></textarea>

						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Nama</label>
						<div class="controls">
							<input id="div_refresh" name="nama" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Desa</label>
						<div class="controls">
							<select name="desa">
								<option value="Klumutan">Klumutan</option>
								<option value="Sumbersari">Sumbersari</option>
							</select>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Dukuh</label>
						<div class="controls">
							<input id="div_refresh" name="dukuh" type="text"  placeholder="" required>
							</select>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">RT</label>
						<div class="controls">
							<input id="div_refresh" name="rt" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">RW</label>
						<div class="controls">
							<input id="div_refresh" name="rw" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Saldo</label>
						<div class="controls">
							<input id="div_refresh" name="saldo" type="text"  placeholder="" required>
						</div>
					</div>
					
					<div class="form-actions">
						<button type="submit" class="btn btn-success">Save</button>
                    </div>
				</form>
				
			</div>               
		</div> <!-- /container -->	
	</body>
</html>