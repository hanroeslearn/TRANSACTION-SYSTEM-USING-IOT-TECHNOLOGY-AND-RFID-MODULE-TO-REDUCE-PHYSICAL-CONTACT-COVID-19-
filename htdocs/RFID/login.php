<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="css/bootstrap.min2.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
</head>
<body>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      Login Admin
      </div>  
      <div class="modal-body">
        <form action="proses_login.php" method="post" role="form">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>  
          
        </form>
      </div>
    </div>
  </div>
</body>
</html>