
<?php

include('../system/shopping_system.php');

$conn = new Shopping;

$conn->admin_session_private();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<title>Online Shopping System</title>
  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/guillaumepotier/Parsley.js@2.9.1/dist/parsley.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  	<link rel="stylesheet" href="../css/style.css" />
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <b><a class="navbar-brand" href="index.php">Admin</a></b>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <b><a style="color:white;" class="btn btn-link" id="view_products">Product list</a></b>
            </li>
            <li class="nav-item">
               <b><a style="color:white;" class="btn btn-link" id="view_users">Users List</a></b>
            </li>
            <li class="nav-item">
               <b><a style="color:white;" class="btn btn-link" id="view_orders">View Orders</a></b>
            </li>
            <li class="nav-item">
                <?php
                if(!isset($_SESSION['admin_id']))
                  echo "<b><a style='color:white;' class='btn btn-link' href='logout.php'>Login</a></b>";
                else
                  echo "<b><a style='color:white;' class='btn btn-link' href='logout.php'>Logout</a></b>";
                ?>
                
            </li>   
        </ul>
    </div>  
</nav>
