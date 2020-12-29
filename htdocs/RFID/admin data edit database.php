<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
		$nama = $_POST['nama'];
		$email = $_POST['email'];
        $password = $_POST['pass'];
        
		// insert data
        $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE admin SET nama_admin=?, email_admin=?, password=? WHERE id_admin=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($nama,$email,$password,$id));
		Database::disconnect();

		header("Location: admin data.php");
    }
?>