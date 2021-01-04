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
			echo "<script>window.location='index.php'</script>";
		}

		else
		{
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

<?php include 'header.php'; ?>
<div class="py-5 my-3"></div>
<div class="container">
	<div class="row">
		<?php 
		if(isset($_GET['product_id']))
			$conn->view_product($_GET['product_id']); 
		else
			echo "<script>window.location='index.php'</script>";
		?>
	</div>
</div>
</body>
<?php include 'footer.php'; ?>
<script>
	function check_login() 
	{
		var user_id = <?php if(isset($_SESSION['user_id']))echo '0'; else echo '1';?>;
		if(user_id == 1)
		{
			alert('Login First');
		}
	}

	function set_price(quantity,product_id)
	{
		if (isNaN(quantity)) 
			quantity = 1;
		if (quantity < 1) 
			quantity = 1;
		if (quantity > 4)
			quantity = 4;
	  	var xmlhttp = new XMLHttpRequest();
	  	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var price_id = 'price_'+product_id;
	    	var data = this.response;
	    	obj = JSON.parse(data);
	    	//console.log(obj.total);
	    	document.getElementById(price_id).innerHTML = "₹ "+obj.total;
	    	document.getElementById("total").innerHTML = "₹ "+obj.net_total;
	    	document.getElementById("net_total").innerHTML = "₹ "+obj.net_total;
	    	//document.getElementById(price_id).setAttribute('value',quantity);
	    }
	  	};
	  	xmlhttp.open("POST","system/ajax_function.php",true);
	  	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  	xmlhttp.send("page=set_quantity&quantity="+quantity+"&product_id="+product_id);
	}

	function addToCart(product_id)
	{
	  var xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) 
	    {
	      location.reload();
	    }
	  };
	  xmlhttp.open("POST","index.php",true);
	  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  xmlhttp.send("add=add&product_id="+product_id);
	}
</script>
</html>
