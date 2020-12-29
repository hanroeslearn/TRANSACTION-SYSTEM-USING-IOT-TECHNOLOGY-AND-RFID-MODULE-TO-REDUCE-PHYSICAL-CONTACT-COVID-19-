<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track post values
        $nama = $_POST['nama'];
		$id = $_POST['id'];
		$desa = $_POST['desa'];
        $dukuh = $_POST['dukuh'];
        $rt = $_POST['rt'];
        $rw = $_POST['rw'];
		$saldo = $_POST['saldo'];
		$status_sekarang = $_POST['status'];
        
		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE data_warga SET nama=?, desa=?, dukuh=?, rt=?, rw=?, saldo=?, tanggal_transaksi=CURRENT_TIMESTAMP WHERE no_rfid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($nama,$desa,$dukuh,$rt,$rw,$saldo,$id));
		Database::disconnect();
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$mysql = "UPDATE status SET nama=?, januari=? WHERE no_rfid=?";
		$qu = $pdo->prepare($mysql);
		$qu->execute(array($nama,$status_sekarang,$id));
		Database::disconnect();
		header("Location: home.php");
    }
?>