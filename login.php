<?php

include('system/shopping_system.php');

require_once('class/class.phpmailer.php');

$conn = new Shopping;

//include('header.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

	<link rel="shortcut icon" href="favicon_io/favicon-32x32.png">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div class="bg-img"></div>
	<div class="text-light">
		<div class="card">
			<div class="card-header">
				<div class="card-title"><h3>Login</h3></div>
			</div>
			<div class="card-body px-5">
				<form method="POST" id="user_login_form">
					<input type="text" name="user_email_address" class="form-control" placeholder="Email" id="user_email_address"required><br>
					<input type="password" name="user_password" class="form-control" placeholder="Password" id="user_password" required><br>
					<span id="error_message" class="span-danger"></span><br>
					<hr>
          <input type="hidden" name="page" value="login" />
          <input type="hidden" name="action" value="login" />
					<input type="submit" value="Login" class="btn btn-md btn-primary btn-block" name="user_login" id="user_login">
					<label>Not registered yet. </label><a href="register.php"> Register?</a><br>
					<a href="" style="text-decoration: none;color: white">Forgot your password?</a>
				</form>
			</div>
			<div class="card-footer px-5">
			</div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">

$(document).ready(function(){

  $('#user_login_form').parsley();

  $('#user_login_form').on('submit', function(event){
    event.preventDefault();

    if($('#user_login_form').parsley().validate())
    {
      $.ajax({
        url:"system/ajax_function.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function()
        {
          $('#user_login').attr('disabled', 'disabled');
          $('#user_login').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            location.href='index.php';
          }
          else
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
          }

          $('#user_login').attr('disabled', false);

          $('#user_login').val('Login');
        }
      })
    }

  });

});
</script>