<!DOCTYPE html>
<html>
<head>
  <title>Shopping System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://kit.fontawesome.com/6869632977.js" crossorigin="anonymous"></script>
  <script src="js/function.js"></script> 
  <link rel="shortcut icon" href="favicon_io/favicon-32x32.png">
  <link rel="stylesheet" type="text/css" href="css/index.css">
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