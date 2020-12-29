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
        $status_sekarang = "Belum Pencairan";
        
		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO data_warga (nama,no_rfid,desa,dukuh,rt,rw,saldo) values(?, ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($nama,$id,$desa,$dukuh,$rt,$rw,$saldo));
		Database::disconnect();
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$mysql = "INSERT INTO status (no_rfid,nama,januari) values(?, ?, ?)";
		$qu = $pdo->prepare($mysql);
		$qu->execute(array($id,$nama,$status_sekarang));
		Database::disconnect();
		header("Location: home.php");
    }
?>