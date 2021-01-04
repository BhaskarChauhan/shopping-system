<?php

include('system/shopping_system.php');

require_once('class/class.phpmailer.php');

$conn = new Shopping;

$conn->user_session_private();

if(isset($_POST['action']))
{
	if($_POST['action'] == 'remove')
	{
		foreach ($_SESSION['cart'] as $key => $value)
		{
			if($value['product_id'] == $_POST['pid'])
			{
				unset($_SESSION['cart'][$key]);
				
				$conn->delete_from_cart($_POST['pid'],$_SESSION['user_id']);
			}
		}
	}
}
?>
<?php include 'header.php' ?>
<div class="py-5 my-3">
	<div class="container-fluid py-3">
		<div class="row px-5">
			<div class="col-md-7">
				<div class="shopping-cart">
					<h3 class="text-center">Cart</h3>
					<hr>
					<?php
						$total = 0;

						if(isset($_SESSION['cart']))
						{

							$product_id = array_column($_SESSION['cart'], 'product_id');

							$conn->query = "SELECT * FROM product";

							$result = $conn->query_result();

							foreach ($result as $row)
							{
								$p_count = 0;
								foreach ($product_id as $pid)
								{
									if($row['pid'] == $pid)
									{
										$conn->cart_item($row['pid'],$row['pname'],$row['img'],$row['price'],$p_count);
										$total = $total+$row['price'];
										$p_count++;
									}
								}
							}
						}
						else
						{
							echo "<h5> Cart is empty</h5>";
						}
					?>
				</div>
			</div>
			<div class="col-md-4 offset-md-1 border-rounded mt-5 bg-white h-25">

				<div class="pt-4">
					<h6>PRICE DETAILS</h6>
					<hr>
					<div class="row price-details">
						<div class="col-md-6">
						<?php
							if(isset($_SESSION['cart']))
							{
								$count = count($_SESSION['cart']);
								echo "<h6>Price ($count items)</h6>";
							}
							else
							{
								echo "<h6>Price (0 items)</h6>";
							}
						?>
							<h6>Delivery Charges</h6>
							<hr>
							<h6>Ammount Payabel</h6>
						</div>
						<div class="col-md-6">
							<h6 id="total"><?php echo "₹ ".$total; ?></h6>
							<h6 class="text-success">FREE</h6>
							<hr>
							<h6 id="net_total"><?php echo "₹ ".$total; ?></h6>
						</div>
					</div>
					<div class="text-center my-3">
						<a class="btn btn-success btn-md" href="payment.php">Proceede for payment</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
