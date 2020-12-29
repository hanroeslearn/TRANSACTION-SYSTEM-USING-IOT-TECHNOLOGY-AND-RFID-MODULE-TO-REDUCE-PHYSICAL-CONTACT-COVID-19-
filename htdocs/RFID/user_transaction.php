<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $no_rfid = $_REQUEST['id'];
    }
     
    $pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM data_warga where no_rfid = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($no_rfid));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$transaksi = $data['saldo'];

	if($transaksi >= "200000"){
		$harga = 200000;
		$proses = $transaksi-$harga;
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$mysql = "UPDATE data_warga SET saldo= ? WHERE no_rfid = ?";
		$q = $pdo->prepare($mysql);
		$q->execute(array($proses,$no_rfid));
		Database::disconnect();

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$transaksi_sukses = "Sudah Pencairan";
		$mysql2 = "UPDATE status SET januari= ? WHERE no_rfid = ?";
		$q = $pdo->prepare($mysql2);
		$q->execute(array($transaksi_sukses,$no_rfid));
		Database::disconnect();
	}
	else{
		$proses = $transaksi;
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$transaksi_gagal = "Tidak Bisa Pencairan";
		$mysql2 = "UPDATE status SET januari= ? WHERE no_rfid = ?";
		$q = $pdo->prepare($mysql2);
		$q->execute(array($transaksi_gagal,$no_rfid));
		Database::disconnect();
	}
	Database::disconnect();
	
	$msg = null;
	if (null==$data['nama']) {
		$msg = "The ID of your Card / KeyChain is not registered !!!";
		$data['no_rfid']=$no_rfid;
		$data['nama']="--------";
		$data['desa']="--------";
		$data['saldo']="--------";
		$data['tanggal_transaksi']="--------";
	} else {
		$msg = null;
	}
	
	
	$file = fopen('name.txt', 'w');
	$text = $data['nama'];
	fwrite($file, $text);
	fclose($file);
	
	$file = fopen('balance.txt', 'w');
	$text = $data['saldo'];
	fwrite($file, $text);
	fclose($file);
	
	$trigger = fopen('trigger.txt', 'r');
	$trigger_read = fread($trigger,filesize("trigger.txt"));
	fclose($trigger);
	
	if($trigger_read == "1")
	{
		$file3 = fopen('trigger.txt', 'w');
		$text3 = "0";
		fwrite($file3, $text3);
		fclose($file3);
	}
	else if ($trigger_read == "0")
	{
		$file2 = fopen('trigger.txt', 'w');
		$text2 = "1";
		fwrite($file2, $text2);
		fclose($file2);
	}
	
	$msg = null;
	if (null==$data['nama']) {
		$msg = "The ID of your Card / KeyChain is not registered !!!";
		$data['no_rfid']=$no_rfid;
		$data['nama']="--------";
		$data['desa']="--------";
		$data['saldo']="--------";
		$data['tanggal_transaksi']="--------";
	} else {
		$msg = null;
	}

	$file = fopen('name.txt', 'w');
	$text = $data['nama'];
	fwrite($file, $text);
	fclose($file);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<style>
		td.lf {
			padding-left: 15px;
			padding-top: 12px;
			padding-bottom: 12px;
		}
	</style>
</head>
 
	<body>	
		<div>
			<form>
				<table  width="452" border="1" bordercolor="#10a0c5" align="center"  cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
					<tr>
						<td  height="40" align="center"  bgcolor="#10a0c5"><font  color="#FFFFFF">
						<b>User Data</b></font></td>
					</tr>
					<tr>
						<td bgcolor="#f9f9f9">
							<table width="452"  border="0" align="center" cellpadding="5"  cellspacing="0">
								<tr>
									<td width="113" align="left" class="lf">Nomor RFID</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['no_rfid'];?></td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Nama</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['nama'];?></td>
								</tr>
								<tr>
									<td align="left" class="lf">Desa</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['desa'];?></td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Saldo</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['saldo'];?></td>
								</tr>
								<tr>
									<td align="left" class="lf">Tanggal Transaksi Terakhir</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['tanggal_transaksi'];?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<p style="color:red;"><?php echo $msg;?></p>
	</body>
</html>