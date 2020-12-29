<?php 
  session_start();
  $conn = mysqli_connect('localhost', 'Pitaloka', 'Pitaloka123','nodemcu_rfid_iot_projects');
  
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query = mysqli_query($conn, "SELECT id_admin FROM admin WHERE email_admin='$email'");
  $count = mysqli_num_rows($query);
  if($count > 0){
    $queryId = mysqli_query($conn, "SELECT id_admin FROM admin WHERE email_admin='$email' AND password = '$password'");
    $numRow = mysqli_num_rows($queryId);
    if($numRow == 0){
      echo '
        <script>
          alert("Password Salah.");
          window.location = "login.php"
        </script>
      ';
    }else{
      $arrayId = mysqli_fetch_array($queryId);
      $_SESSION['id_admin'] = $arrayId['id_admin'];
      if(isset($_SESSION['id_admin'])){
        echo '
          <script>
          window.location = "home.php";
          </script>
        ';
      }
    }
  }else {
    echo '
      <script>
      alert("Email tidak terdaftar !");
      window.location = "login.php"
      </script>
    ';
  }
 ?>