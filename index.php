<?php

include('system/shopping_system.php');

require_once('class/class.phpmailer.php');

$conn = new Shopping;

if(isset($_POST['add']))
{

  if (isset($_SESSION['cart']))
  {
    $item_array_id = array_column($_SESSION['cart'], 'product_id');

    if(in_array($_POST['product_id'], $item_array_id))
    {
      echo "<script>alert('Product is already added in the cart')</script>";
    }

    else
    {
      //$conn->delete_from_cart($_SESSION['user_id']);

      $count=++$_SESSION['count'];

      $item_array = array(
        'product_id' => $_POST['product_id']
      );

      $_SESSION['cart'][$count] = $item_array;

      $product_price = $conn->get_product_price($_POST['product_id']);

      $conn->add_to_cart($_POST['product_id'],$_SESSION['user_id'],$product_price);

    }
  }
  else
  {
    $conn->query = "DELETE FROM cart WHERE u_id='".$_SESSION['user_id']."'";

    $conn->execute_query();
    
    $item_array = array(
      'product_id' => $_POST['product_id']
    );

    $_SESSION['count'] = 0;
    
    $_SESSION['cart'][$_SESSION['count']] = $item_array;

    $product_price = $conn->get_product_price($_POST['product_id']);

    $conn->add_to_cart($_POST['product_id'],$_SESSION['user_id'],$product_price);
  }
}
?>
<?php include 'header.php';?>
<div class="parallax"></div>
  <div class="container">
    <div class="py-5"></div> 
    <div class="row">
      <div class="col-md-6">
        <div class="dropdown left">
          <button type="button" class="btn dropdown-toggle btn-outline-primary" data-toggle="dropdown">
            Categories
          </button>
          <div class="dropdown-menu">
            <button class="dropdown-item" onclick="category(this.value)" value="all">All</button>
            <button class="dropdown-item" onclick="category(this.value)" value="electronic">Electronics</button>
            <button class="dropdown-item" onclick="category(this.value)" value="clothing">Men's ware</button>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right">
          <input type="text" name="search_input" id="search_input" placeholder="Product" onkeyup="search(this.value)" style="height: 38px" />
          <button class="btn btn-md btn-outline-primary">Search</button>
          <div id="search_result" class="text-center"></div>
        </div>
      </div>
    </div>

    <br>
    <hr>
    <div class="row" id="category_result">
      <?php
        $conn->query = "
				SELECT * FROM product
        ";
				$result = $conn->query_result();
				foreach ($result as $row)
				{
					$conn->print_product($row['pid'],$row['pname'],$row['img'],$row['price']);
				}
      ?>
    </div>
  </div>
  <?php include 'footer.php'?>
</body>
</html>
<script>
function category(value) 
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) 
    {
      document.getElementById('category_result').innerHTML=this.response;
    }
  };
  xmlhttp.open("POST","system/ajax_function.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("page=category&type_data="+value);
}

function search(value) 
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) 
    {
      document.getElementById('search_result').innerHTML=this.response;
    }
  };
  xmlhttp.open("POST","system/ajax_function.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("page=search&search_data="+value);
}
</script>