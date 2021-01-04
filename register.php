<?php

include('system/shopping_system.php');

$conn = new Shopping;

$conn->user_session_public();

//include('header.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://kit.fontawesome.com/6869632977.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="favicon_io/favicon-32x32.png">
  <link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li>
        <?php echo $conn->Profile_image();?>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
    </ul>
    <ul class="navbar-nav mr-left">
      <li class="nav-item">
        <button class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup"
          aria-expanded="false"
          aril-label="Toggle navigation"
        >
        <span class="navbar-toggle-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="mr-auto">
            <div class="navbar-nav">
              <a href="cart.php" class="nav-item nav-link active">
                <h5 class="px-5 cart">
                  <i class="fas fa-shopping-cart"></i>Cart
                    <?php
                    if(isset($_SESSION['cart']))
                    {
                      $count=count($_SESSION['cart']);
                      echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                    }
                    else
                    {
                      echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                    }
                    ?>
                </h5>
              </a>
            </div>
          </div>
        </div>
      </li>
      <li class="nav-item active">
        <?php
        if(!isset($_SESSION['user_id']))
        {
          echo "<a href='login.php' class='nav-link'>Login</a>";
        }
        else
        {
          echo "<a href='logout.php' class='nav-link'>Logout</a>";
        }
        ?>
      </li>
    </ul>
  </div>
</nav>

<div>
	<div class="contaiter">
    <div class="row">
      <div class="col-md-6"><br><br>
        <div style="margin-left: 10%;">
          <h1  style="margin-top: 50px;">Sign up right now.</h1><br>
          <h3 >Yo wassup I am Bhaksar...</h3>
          <h3>Register here now for amazing product.</h3>
        </div>
      </div>
      <div class="col-md-6">
        <div class="d-flex justify-content-center">
          <div class="card clear" style="margin-top:50px;margin-bottom: 100px; width: 30rem;">
            <div class="card-header"><h4 class="text-center">User Registration</h4></div>
              <div class="card-body">
                   <span id="message"></span>
                  <form method="post" id="user_register_form">
                    <div class="form-group">
                      <label>Enter Email Address</label>
                      <input type="text" name="user_email_address" id="user_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
                    </div>
                    <div class="form-group">
                      <label>Enter Password</label>
                      <input type="password" name="user_password" id="user_password" class="form-control" />
                    </div>
                    <div class="form-group">
                      <label>Enter Confirm Password</label>
                      <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
                    </div>
                    <div class="form-group">
                      <label>Enter Name</label>
                      <input type="text" name="user_name" id="user_name" class="form-control" /> 
                    </div>
                    <div class="form-group">
                      <label>Select Gender</label>
                      <select name="user_gender" id="user_gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select> 
                    </div>
                    <div class="form-group">
                      <label>Enter Address</label>
                      <textarea name="user_address" id="user_address" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Enter Mobile Number</label>
                      <input type="text" name="user_mobile_no" id="user_mobile_no" class="form-control" /> 
                    </div>
                    <div class="form-group">
                      <label>Select Profile Image</label>
                      <input type="file" name="user_image" id="user_image" />
                    </div>
                    <br />
                    <div class="form-group" align="center">
                      <input type="hidden" name='page' value='register' />
                      <input type="hidden" name="action" value="register" />
                      <input type="submit" name="user_register" id="user_register" class="btn btn-info" value="Register" />
                    </div>
                  </form>
                  <div align="center">
                    Already a Member..<a href="login.php">Login</a>
                  </div>
              </div>
          </div>
      </div>
		</div> 
	</div>
</div>

</body>
</html>

<script>

$(document).ready(function(){

  $('#user_register_form').parsley();

  $('#user_register_form').on('submit', function(event){
    event.preventDefault();

    $('#user_email_address').attr('required', 'required');

    $('#user_email_address').attr('data-parsley-type', 'email');

    $('#user_password').attr('required', 'required');

    $('#confirm_user_password').attr('required', 'required');

    $('#confirm_user_password').attr('data-parsley-equalto', '#user_password');

    $('#user_name').attr('required', 'required');

    $('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');

    $('#user_address').attr('required', 'required');

    $('#user_mobile_no').attr('required', 'required');

    $('#user_mobile_no').attr('data-parsley-pattern', '^[0-9]+$');

    $('#user_image').attr('required', 'required');

    $('#user_image').attr('accept', 'image/*');

    if($('#user_register_form').parsley().validate())
    {
      $.ajax({
        url:'system/ajax_function.php',
        method:"POST",
        data:new FormData(this),
        dataType:"json",
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function()
        {
          $('#user_register').attr('disabled', 'disabled');
          // $('#user_register').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            $('#message').html('<div class="alert alert-success">Please check your email</div>');
            $('#user_register_form')[0].reset();
            $('#user_register_form').parsley().reset();
          }

          $('#user_register').attr('disabled', false);

          $('#user_register').val('Register');
          window.location.href="login.php";
        }
      })
    }

  });
	
});

</script>