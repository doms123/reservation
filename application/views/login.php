<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login | Hacienda Galea</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/favicon.png'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/toast.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body data-url="<?php echo base_url('Admin'); ?>">
  <div class="container loginPage">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="box-header with-border">
          <h3 class="box-title">Hacienda Galea | Admin Login</h3>
        </div>
        <form class="form loginForm">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control pass" placeholder="Password">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary loginBtn">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/toast.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/login.js');?>"></script>

  <script>
    document.addEventListener('contextmenu', event => event.preventDefault());

    $(document).keydown(function (event) {
        if (event.keyCode == 123) { // Prevent F12
            return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
            return false;
        }
    });
  </script>
</body>
</html>