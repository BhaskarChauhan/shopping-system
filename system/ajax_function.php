<?php

include('shopping_system.php');

require_once('../class/class.phpmailer.php');

include("../class/class.smtp.php");

$conn = new Shopping();

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));

if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$user_verfication_code = md5(rand());

			$receiver_email = $_POST['user_email_address'];

			$conn->filedata = $_FILES['user_image'];

			$user_image = $conn->Upload_file();

			$conn->data = array(
				':user_email_address'	=>	$receiver_email,
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code'=>	$user_verfication_code,
				':user_name'			=>	$_POST['user_name'],
				':user_gender'			=>	$_POST['user_gender'],
				':user_address'			=>	$_POST['user_address'],
				':user_mobile_no'		=>	$_POST['user_mobile_no'],
				':user_image'			=>	$user_image,
				':user_created_on'		=>	$current_datetime
			);

			$conn->query = "
			INSERT INTO user_table 
			(user_email_address, user_password, user_verfication_code, user_name, user_gender, user_address, user_mobile_no, user_image, user_created_on)
			VALUES 
			(:user_email_address, :user_password, :user_verfication_code, :user_name, :user_gender, :user_address, :user_mobile_no, :user_image, :user_created_on)
			";

			$conn->execute_query();

			$subject= 'Online Plant store Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="localhost/mysite/verify_email.php?type=user&code='.$user_verfication_code.'" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Plant Store</p>
			';

			$conn->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$conn->data = array(
				':user_email_address'	=>	$_POST['user_email_address']
			);

			$conn->query = "
			SELECT * FROM user_table
			WHERE user_email_address = :user_email_address
			";

			$total_row = $conn->total_row();

			if($total_row > 0)
			{
				$result = $conn->query_result();

				foreach($result as $row)
				{
					if($row['user_email_verified'] == 'yes')
					{
						$_SESSION['receiver_email'] = $row['user_email_address'];

						if(password_verify($_POST['user_password'], $row['user_password']))
						{
							$_SESSION['user_id'] = $row['user_id'];

							$output = array(
								'success'	=>	true
							);
						}
						else
						{
							$output = array(
								'error'		=>	'Wrong Password'
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

	if($_POST['page'] == "profile")
	{
		if($_POST['action'] == "profile")
		{
			$user_image = $_POST['hidden_user_image'];

			if($_FILES['user_image']['name'] != '')
			{
				$conn->filedata = $_FILES['user_image'];

				$user_image = $conn->Upload_file();
			}

			$conn->data = array(
				':user_name'				=>	$conn->clean_data($_POST['user_name']), 
				':user_gender'				=>	$_POST['user_gender'],
				':user_address'				=>	$conn->clean_data($_POST['user_address']),
				':user_mobile_no'			=>	$_POST['user_mobile_no'],
				':user_image'				=>	$user_image,
				':user_id'					=>	$_SESSION['user_id']		
			);

			$conn->query = "
			UPDATE user_table 
			SET user_name = :user_name, user_gender = :user_gender, user_address = :user_address, user_mobile_no = :user_mobile_no, user_image = :user_image 
			WHERE user_id = :user_id
			";
			$conn->execute_query();

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);

		}
	}

	if($_POST['page'] == 'change_password')
	{
		if($_POST['action'] == 'change_password')
		{
			$conn->data = array(
				':user_password'	=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_id'			=>	$_SESSION['user_id']
			);

			$conn->query = "
			UPDATE user_table 
			SET user_password = :user_password 
			WHERE user_id = :user_id
			";

			$conn->execute_query();

			session_destroy();

			$output = array(
				'success'		=>	'Password has been change'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'search')
	{
		$output = null;
		if($_POST['search_data'] == "")
			echo "";
		else
		{
			$search_data=$_POST['search_data'];
			$conn->query = "SELECT * FROM product WHERE pname like '".$search_data."%'";
			$result = $conn->query_result();
			foreach ($result as $row) 
			{
				$output="<a href='#'>".$row['pname']."</a>";
			}
			if($output==null)
				echo "No match found";
			else
				echo $output;
		}
	}

	if($_POST["page"] == 'category')
	{
		if(isset($_POST['type_data']))
		{
			if ($_POST['type_data'] == 'all') 
			{
				$conn->query = "SELECT * FROM product";
				$result = $conn->query_result();
				foreach ($result as $row)
				{
					$conn->print_product($row['pid'],$row['pname'],$row['img'],$row['price']);
				}	
			}
			else
			{
				$conn->query = "SELECT * FROM product WHERE type='".$_POST['type_data']."'";
				$result=$conn->query_result();
				foreach ($result as $row)
				{
					$conn->print_product($row['pid'],$row['pname'],$row['img'],$row['price']);
				}
			}
		}
	}

	if ($_POST['page'] == 'set_quantity') 
	{
		if (isset($_POST['quantity']) && isset($_POST['product_id']))
		{
			$quantity = $_POST['quantity'];

			$product_id = $_POST['product_id'];

			$price = $conn->get_product_price($product_id);

			$total = number_format($quantity*$price,2);

			$conn->update_price_in_cart($product_id, $_SESSION['user_id'], $quantity);

			$net_total = $conn->get_total_price_from_cart($_SESSION['user_id']);

			$output = array( "total" => $total, "net_total" => $net_total);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'check_for_payment')
	{
		if(isset($_POST['card_number']) && isset($_POST['card_holder_name']) && isset($_POST['card_expire']) &&   isset($_POST['card_cvc']))
		{
			$card_number 		= $_POST['card_number'];
			$card_holder_name 	= $_POST['card_holder_name'];
			$card_expire 		= $_POST['card_expire'];
			$card_cvc 			= $_POST['card_cvc'];

			$count = $conn->get_product_count_cart($_SESSION['user_id']);

			$total_price = $conn->get_total_price_from_cart($_SESSION['user_id']);

			$conn->query = "SELECT * FROM user_table ut,cart c WHERE c.u_id=ut.user_id";

			$result = $conn->query_result();

			$user_id = $user_email = $user_name = $user_address = $user_phone = null;

			foreach ($result as $row) 
			{
				$user_id 		= 	$row["user_id"];
				$user_email 	= 	$row["user_email_address"];
				$user_name 		= 	$row["user_name"];
				$user_address 	= 	$row['user_address'];
				$user_phone 	= 	$row["user_mobile_no"];
			}

			$conn->data = array(
			  ':user_id'              => $user_id,
			  ':user_email_address'   => $user_email,
			  ':user_name'            => $user_name,
			  ':user_address'         => $user_address,
			  ':user_mobile_no'       => $user_phone,
			  ':card_holder_name'     => $card_holder_name, 
			  ':card_number'          => $card_number,
			  ':card_expire'          => $card_expire,
			  ':cvv'                  => $card_cvc,
			  ':product_count'        => $count,
			  ':total_amt'            => $total_price
			);

			$conn->query = "
			INSERT INTO order_info(user_id, f_name, email, phone, address, card_holder_name, card_number, card_expire, cvv, product_count, total_amt) 
			VALUES (:user_id, :user_name, :user_email_address, :user_mobile_no, :user_address, :card_holder_name, :card_number, :card_expire, :cvv,:product_count, :total_amt )";

			$conn->execute_query();

			//Insert into orders table

			$conn->clean_data($conn->data);

			$conn->query = "SELECT * FROM cart WHERE u_id='".$_SESSION['user_id']."'";

			$cart_result = $conn->query_result();

			$order_id = $conn->get_order_id($_SESSION['user_id']);

			foreach ($cart_result as $row) 
			{
				$conn->clean_data($conn->query);
	
				$conn->query = "INSERT INTO orders(order_id,user_id,product_id,quantity) VALUES('".$order_id."','".$row['u_id']."','".$row['product_id']."','".$row['quantity']."')";
	
				$conn->execute_query();

				$conn->delete_from_cart($row['product_id'],$row['u_id']);
			}

			//send confirmation email

			$body = '
			<h3 class=text-center>Payment Successful</h3><br><h3>Your Order Details</h3><br><a href="localhost/mysite/track_order.php?order_id='.$order_id.'" target="_blank">
			';

			$subject= 'Transaction Details';

			$conn->send_email($_SESSION['receiver_email'], $subject, $body);

			$redirect = array( "success");

			echo json_encode($redirect);

		}
		else
		{
			$err_msg = "error";
			echo json_encode($err_msg);
		}

	}

	if($_POST['page'] == 'subscribe')
	{
		$conn->query = "INSERT INTO subscribers(email) VALUES('".$_POST['email']."')";

		$conn->execute_query();

		echo "Thank you for subscribing";
	}
}
?>