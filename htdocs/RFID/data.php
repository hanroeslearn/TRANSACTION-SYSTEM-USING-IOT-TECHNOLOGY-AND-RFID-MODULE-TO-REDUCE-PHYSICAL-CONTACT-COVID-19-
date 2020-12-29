<html>
<head>
 <title>Data Warga| hata_data</title>
 <style>
 .table1 {
    font-family: sans-serif;
    color: #444;
    border-collapse: collapse;
    width: 50%;
    border: 1px solid #f2f5f7;
}

.table1 tr th{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}

.table1, th, td {
    padding: 8px 20px;
    text-align: left;
}

.table1 tr:hover {
    background-color: #f5f5f5;
}

.table1 tr:nth-child(even) {
    background-color: #f2f2f2;
}
 </style>
</head>
  <div class="container">
            <div class="row">
                <h3>User Data Table</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr bgcolor="#10a0c5" color="#FFFFFF">
                      <th>Name</th>
                      <th>ID</th>
					  <th>ID RFID</th>
					  <th>Desa</th>
                      <th>Saldo</th>
					  <th>Transaksi</th>
                      <th>Tanggal Transaksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM data_warga INNER JOIN status ON status.no_rfid=data_warga.no_rfid';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['nama'] . '</td>';
                            echo '<td>'. $row['id'] . '</td>';
                            echo '<td>'. $row['no_rfid'] . '</td>';
							echo '<td>'. $row['desa'] . '</td>';
                            echo '<td>'. $row['saldo'] . '</td>';
                            echo '<td>'. $row['tanggal_transaksi'] . '</td>';
                            echo '<td>'. $row['januari']. '</td>';
							echo '<td><a class="btn btn-success" href="user data edit page.php?id='.$row['id'].'">Edit</a>';
							echo ' ';
							echo '<a class="btn btn-danger" href="user data delete page.php?id='.$row['id'].'">Delete</a>';
							echo '</td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
				</table>
			</div>
		</div>
 </table> 
<br>
<a href="grafik.php">Tampilkan Dalam Grafik</a>
</body>
</html>