<?php  
 $connect = mysqli_connect('localhost', 'Pitaloka', 'Pitaloka123','nodemcu_rfid_iot_projects');  
 $query = "SELECT januari, count(*) as number
 FROM status s INNER JOIN data_warga dt USING (no_rfid)
 WHERE desa = 'sumbersari'
 GROUP BY januari";  
 $result = mysqli_query($connect, $query);
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Hata Data | Grafik Status Pencarian</title>  
           <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Status', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo "['".$row["januari"]."', ".$row["number"]."],";  
                          }  
                          ?>  
					 ]);  
				
                var options = {  
                      //title: 'Percentage of Male and Female Employee',  
                      //is3D:true,  
                      pieHole: 0.3  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script>  
      </head>  
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

		ul.topnav li {
			float: left;
			width: 25%; 
			}

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
		
		<title>Grafik</title>
	</head>
	
	<body>
		<h2></h2>
		<div class="container">
            <div class="row">
                <h3>Tampilan Grafik</h3>
            </div>
			</div>
		<ul class="topnav">
			<li><a href="home.php">Home</a></li>
			<li><a href="grafik.php">Grafik Umum</a></li>
			<li><a href="grafik_klumutan.php">Klumutan</a></li>
			<li><a class="active" href="grafik_sumbersari.php">Sumbersari</a></li>
		</ul>

           <br /><br />  
           <div style="width:100%;">  
                <h3>Grafik Status Pencairan Bantuan Sosial Desa Sumbersari</h3>  
                <div id="piechart" style="width: 1200px; height: 400px;"></div>  
           </div>  
      </body>  
 </html>  