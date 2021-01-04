<?php

//ajax_action.php

include('../system/shopping_system.php');

$conn = new Shopping;

require_once('../class/class.phpmailer.php');

include("../class/class.smtp.php");

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:s')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$conn->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $conn->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$admin_verification_code = md5(rand());

			$receiver_email = $_POST['admin_email_address'];

			$conn->data = array(
				':admin_email_address'		=>	$receiver_email,
				':admin_password'			=>	password_hash($_POST['admin_password'], PASSWORD_DEFAULT),
				':admin_verfication_code'	=>	$admin_verification_code,
				':admin_type'				=>	'sub_master', 
				':admin_created_on'			=>	$current_datetime
			);

			$conn->query = "
			INSERT INTO admin_table 
			(admin_email_address, admin_password, admin_verfication_code, admin_type, admin_created_on) 
			VALUES 
			(:admin_email_address, :admin_password, :admin_verfication_code, :admin_type, :admin_created_on)
			";

			$conn->execute_query();

			$subject= 'Online Plant store Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="localhost/mysite/verify_email.php?type=master&code='.$admin_verification_code.'" target="_blank"> link.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Plant Store</p>
			';

			$conn->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'	=>	true
			);

			echo json_encode($output,JSON_FORCE_OBJECT);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$conn->data = array(
				':admin_email_address'	=>	$_POST['admin_email_address']
			);

			$conn->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = :admin_email_address
			";

			$total_row = $conn->total_row();

			if($total_row > 0)
			{
				$result = $conn->query_result();

				foreach($result as $row)
				{
					if($row['email_verified'] == 'yes')
					{
						if(password_verify($_POST['admin_password'], $row['admin_password']))
						{
							$_SESSION['admin_id'] = $row['admin_id'];
							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'	=>	'Wrong Password'
							);
						}
					}
					else
					{
						$output = array(
							'error'		=>	'Your Email is not verify'
						);
					}
				}
			}
			else
			{
				$output = array(
					'error'		=>	'Wrong Email Address'
				);
			}
			echo json_encode($output);
		}

	}

	if($_POST['page'] == 'user_list')
	{
		$output = null;
		$output .="
		<div class='col-md-12'>
            <div class='card shadow'>
                <div class='card-header'><h3 class='text-center'>Users</h3></div>
                <div class='card-body'>
                	<div class='container'>
	                	<table>
	                		<tr><th>#id</th><th>Name</th><th>Email</th><th>Mobile number</th><th>User created on</th><th>Action</th></tr>";
	                		$conn->query = "SELECT * FROM user_table";
	                		$total_row = $conn->total_row();
							if ($total_row > 0) 
							{
		                		$result = $conn->query_result();
		                		foreach ($result as $row)
		                		{
		                			$output .= "<tr><td>".$row['user_id']."</td><td>".$row['user_name']."</td><td>".$row['user_email_address']."</td><td>".$row['user_mobile_no']."</td><td>".$row['user_created_on']."</td><td><button class='btn btn-sm btn-danger' onclick='remove_user(".$row['user_id'].")'>Remove</button></td><tr>";
		                		}
		                	}
		                	else
		                		$output .= "<tr><td></td><td></td><td><h3 class='text-danger'>Empty</h3></tr>";
	                	$output .= "	
	                	</table>
                	</div>
                </div>
            </div>
        </div>";

        echo json_encode($output);
	}

	if($_POST['page'] == 'product_list')
	{
		$output = null;
		$output .="
		<div class='col-md-12'>
            <div class='card shadow'>
                <div class='card-header'><h3 class='text-center'>Products</h3></div>
                <div class='card-body'>
                	<div class='container'>
	                	<table>
	                		<tr><th>#id</th><th>Name</th><th>Discription</th><th>Price</th><th>Instock</th><th>Action</th></tr>";
	                		$conn->query = "SELECT * FROM product";
	                		$total_row = $conn->total_row();
							if ($total_row > 0) 
							{
		                		$result = $conn->query_result();
		                		foreach ($result as $row)
		                		{
		                			$output .= "<tr><td>".$row['pid']."</td><td>".$row['pname']."</td><td>".$row['discription']."</td><td>".$row['price']."</td><td>".$row['instock']."</td><td><button class='btn btn-sm btn-danger' onclick='remove_product(".$row['pid'].")'>Remove</button></td><tr>";
		                		}
		                	}
		                	else
		                		$output .= "<tr><td></td><td></td><td><h3 class='text-danger'>Empty</h3></tr>";
	                	$output .= "
	                		<tr><td></td><td></td><td><div class='text-center'><button class='btn btn-info' onclick='add_product()'>Add Product</button></div></td></tr>	
	                	</table>
                	</div>
                </div>
            </div>
        </div>";

        echo json_encode($output);
	}

	if($_POST['page'] == 'order_list')
	{
		$output = null;
		$output .="
		<div class='col-md-12'>
            <div class='card shadow'>
                <div class='card-header'><h3 class='text-center'>Orders</h3></div>
                <div class='card-body'>
                	<div class='container'>
	                	<table>
	                		<tr><th>#id</th><th>Customer</th><th>Product</th><th>Quantity</th><th>Price</th><th>Action</th></tr>";
	                		$conn->query = "SELECT * FROM order_info of,orders o,product p WHERE o.product_id=p.pid";
	                		$total_row = $conn->total_row();
							if ($total_row > 0) 
							{
		                		$result = $conn->query_result();
		                		foreach ($result as $row)
		                		{
		                			$price = $conn->get_product_price($row['product_id']);
									$total = number_format($row['quantity']*$price,2);
		                			$output .= "<tr><td>".$row['order_id']."</td><td>".$row['f_name']."</td><td>".$row['pname']."</td><td>".$row['quantity']."</td><td>₹ ".$total."</td><td><button class='btn btn-sm btn-danger' onclick='remove_order(".$row['order_id'].")'>Remove</button></td><tr>";
		                		}
		                	}
		                	else
		                		$output .= "<tr><td></td><td></td><td><h3 class='text-danger'>Empty</h3></tr>";
	                	$output .= "	
	                	</table>
                	</div>
                </div>
            </div>
        </div>";

        echo json_encode($output);
	}

	if($_POST['page'] == 'remove_product')
	{
		$conn->query = "DELETE FROM product WHERE pid='".$_POST['product_id']."'";
		$conn->execute_query();

		$output = null;
		$output .="
		<div class='col-md-12'>
            <div class='card shadow'>
                <div class='card-header'><h3 class='text-center'>Products</h3></div>
                <div class='card-body'>
                	<div class='container'>
	                	<table>
	                		<tr><th>#id</th><th>Name</th><th>Discription</th><th>Price</th><th>Instock</th><th>Action</th></tr>";
	                		$conn->query = "SELECT * FROM product";
	                		$total_row = $conn->total_row();
							if ($total_row > 0) 
							{
		                		$result = $conn->query_result();
		                		foreach ($result as $row)
		                		{
		                			$output .= "<tr><td>".$row['pid']."</td><td>".$row['pname']."</td><td>".$row['discription']."</td><td>".$row['price']."</td><td>".$row['instock']."</td><td><button class='btn btn-sm btn-danger' onclick='remove_product(".$row['pid'].")'>Remove</button></td><tr>";
		                		}
		                	}
		                	else
		                		$output .= "<tr><td></td><td></td><td><h3 class='text-danger'>Empty</h3></tr>";
	                	$output .= "	
	                	<tr><td></td><td></td><td><div class='text-center'><button class='btn btn-info' onclick='add_product()'>Add Product</button></div></td></tr>
	                	</table>
                	</div>
                </div>
            </div>
        </div>";

        echo $output;
	}

	if($_POST['page'] == 'remove_user')
	{
		$conn->query = "DELETE FROM user_table WHERE user_id='".$_POST['user_id']."'";
		$conn->execute_query();

		$output = null;
		$output .="
		<div class='col-md-12'>
            <div class='card shadow'>
                <div class='card-header'><h3 class='text-center'>Users</h3></div>
                <div class='card-body'>
                	<div class='container'>
	                	<table>
	                		<tr><th>#id</th><th>Name</th><th>Email</th><th>Mobile number</th><th>User created on</th><th>Action</th></tr>";
	                		$conn->query = "SELECT * FROM user_table";
	                		$total_row = $conn->total_row();
							if ($total_row > 0) 
							{
		                		$result = $conn->query_result();
		                		foreach ($result as $row)
		                		{
		                			$output .= "<tr><td>".$row['user_id']."</td><td>".$row['user_name']."</td><td>".$row['user_email_address']."</td><td>".$row['user_mobile_no']."</td><td>".$row['user_created_on']."</td><td><button class='btn btn-sm btn-danger' onclick='remove_user(".$row['user_id'].")'>Remove</button></td><tr>";
		                		}
		                	}
		                	else
		                		$output .= "<tr><td></td><td></td><td><h3 class='text-danger'>Empty</h3></tr>";
	                	$output .= "	
	                	</table>
                	</div>
                </div>
            </div>
        </div>";

        echo $output;
	}

	if($_POST['page'] == 'remove_order')
	{
		$conn->query = "DELETE FROM order_info WHERE order_id='".$_POST['order_id']."'";
		$conn->execute_query();
		$conn->query = "DELETE FROM orders WHERE order_id='".$_POST['order_id']."'";
		$conn->execute_query();

		$output = null;
		$output .="
		<div class='col-md-12'>
            <div class='card shadow'>
                <div class='card-header'><h3 class='text-center'>Orders</h3></div>
                <div class='card-body'>
                	<div class='container'>
	                	<table>
	                		<tr><th>#id</th><th>Customer</th><th>Product</th><th>Quantity</th><th>Price</th><th>Action</th></tr>";
	                		$conn->query = "SELECT * FROM order_info of,orders o,product p WHERE o.product_id=p.pid";
	                		$total_row = $conn->total_row();
							if ($total_row > 0) 
							{
		                		$result = $conn->query_result();
		                		foreach ($result as $row)
		                		{
		                			$price = $conn->get_product_price($row['product_id']);
									$total = number_format($row['quantity']*$price,2);
		                			$output .= "<tr><td>".$row['order_id']."</td><td>".$row['f_name']."</td><td>".$row['pname']."</td><td>".$row['quantity']."</td><td>₹ ".$total."</td><td><button class='btn btn-sm btn-danger' onclick='remove_order(".$row['order_id'].")'>Remove</button></td><tr>";
		                		}
		                	}
		                	else
		                		$output .= "<tr><td></td><td></td><td><h3 class='text-danger'>Empty</h3></tr>";
	                	$output .= "	
	                	</table>
                	</div>
                </div>
            </div>
        </div>";

        echo $output;
	}

	if($_POST['page'] == 'add_product')
	{
		$output="

			<div class='card shadow' style='width:30rem; margin-left:30%;'>
				<div class='card-header'><h2 class='text-center'>Enter Product Details</h2></div>
				<div class='card-body'>
					<form method='POST' id='product_form'>
					 <label>Name:</label>
					 <input type='text' name='product_name' id='product_name' class='form-control' /><br />
					 <label>Discription:</label>
					 <input type='textarea' name='product_desc' id='product_desc' class='form-control' /><br />
					 <label>Price:</label>
					 <input type='text' name='product_price' id='product_price' class='form-control' onkeypress='return onlyNumberKey(event)'/><br />
					 <label>Stock:</label>
					 <input type='text' name='product_stock' id='product_stock' class='form-control' onkeypress='return onlyNumberKey(event)'/><br />
					 <label>Upload Image:</label>
					 <input type='file' name='product_image' id='product_image'/><br />
					
					 <input type='hidden' name='page' value='upload_product_data' value='Product' />
					 <input type='submit' class='btn btn-primary btn-lg btn-block' name='product_btn' id='product_btn'>
					</form>
				</div>
			</div>";
		echo $output;
	}

	if($_POST == 'upload_product_data')

}

?>