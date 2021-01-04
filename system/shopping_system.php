<?php

class Shopping
{
	var $host;
	var $username;
	var $password;
	var $database;
	var $connect;
	var $home_page;
	var $query;
	var $data;
	var $statement;
	var $filedata;

	function __construct()
	{
		$this->host = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->database = 'shopping_system';
		$this->home_page = 'http://localhost/index.php';

		$this->connect = new PDO("mysql:host=$this->host; dbname=$this->database", "$this->username", "$this->password");

		session_start();
	}

	function execute_query()
	{
		$this->statement = $this->connect->prepare($this->query);
		$this->statement->execute($this->data);
	}

	function total_row()
	{
		$this->execute_query();
		return $this->statement->rowCount();
	}

	function send_email($receiver_email, $subject, $body)
	{
		$mail = new PHPMailer(true);

		try 
		{
			//$mail->SMTPDebug  = 2;

			$mail->SMTPAuth   = true;
			
			$mail->SMTPSecure = "ssl"; 
			
			$mail->Host       = "smtp.gmail.com";   
			
			$mail->Port       = 465;   
			
			$mail->SMTPKeepAlive= true;
			
			$mail->Mailer 		= "smtp";
			
			$mail->Username   = "chauhanbhaskar51@gmail.com";  
			
			$mail->Password   = "@bhaskar123";            
			
			$mail->AddAddress($receiver_email, '');
			
			$mail->SetFrom('chauhanbhaskar51@gmail.com', 'Online Plant Store');
			
			$mail->Subject = $subject;

			//$mail->AddAttachment("../img/nokia.jpg");
			
			//$mail->Body = $body;
			
			$mail->MsgHTML($body);
			
			$mail->Send();

		} 
		catch (phpmailerException $e) 
		{
		      echo $e->errorMessage();
		} 
		catch (Exception $e) 
		{
		      echo $e->getMessage(); 
		}
	}

	function redirect($page)
	{
		header('location:'.$page.'');
		exit;
	}

	function admin_session_private()
	{
		if(!isset($_SESSION['admin_id']))
		{
			$this->redirect('login.php');
		}
	}

	function admin_session_public()
	{
		if(isset($_SESSION['admin_id']))
		{
			$this->redirect('index.php');
		}
	}

	function user_session_private()
	{
		if(!isset($_SESSION['user_id']))
		{
			$this->redirect('index.php');
		}
	}

	function user_session_public()
	{
		if(isset($_SESSION['user_id']))
		{
			$this->redirect('index.php');
		}
	}

	function query_result()
	{
		$this->execute_query();
		return $this->statement->fetchAll();
	}

	function clean_data($data)
	{
	 	$data = null;
	  	return $data;
	}

	function Profile_image()
	{
		if(isset($_SESSION['user_id']))
		{
			$this->query = "
			SELECT * FROM user_table WHERE user_id = '".$_SESSION['user_id']."'
			";

			$result = $this->query_result();

			foreach ($result as $row)
			{
				$path="img/";
				$output = "<img src='".$path.$row['user_image']."' class='rounded-circle' width='250'/>";
			}
		}
		else
		{
			$path="img/default_user.png";
			$output = "<img src='".$path."' class='rounded-circle' width='250'/>";
		}

		return $output;
	}
 
	function print_product($pid,$product_name,$product_img,$product_price)
	{
		$output = "
		<div class='col-lg-3 col-md-6 col-sm-12'>
			
				<div class='card shadow text-center'>
					<div class=''>
						<a href='current_product.php?product_id=".$pid."'><img src='".$product_img."'></a>
					</div>
					<div class='card-body'>
						<a href='current_product.php?product_id=".$pid."'><h4>".$product_name."</h4></a>
							<h5>₹ ".$product_price."</h5>
							<div class='text-center'>
								<button type='submit' class='btn btn-warning my-3' name='add' onclick='addToCart(".$pid.")'>Add to cart
									<i class='fas fa-shopping-cart'></i>
								</button>
							</div>
					</div>
				</div>
				<br>

		</div>
		";
		echo $output;
	}

	function view_product($product_id)
	{
		$output = null;

		$this->query = "SELECT * FROM product WHERE pid='".$product_id."'";

		$result = $this->query_result();

		foreach ($result as $row) 
		{
			$output = "
			<div class=\"col-lg-4 col-md-4 col-sm-4\" id=\"product_image\">
				<img src=".$row['img']." style='height:15rem;width:15rem;'>
			</div>
			<div class=\"col-lg-6 col-md-6 col-sm-6\" id='product_detail'>
				<h2>".$row['pname']."</h2><br>
				<h6>".$row['discription']."</h6>
				<h4 style=\"margin-top: 20px;\" id='price_".$row['pid']."'>".$row['price']."</h4>
				<h4 style=\"margin-top: 20px;\">Instock: ".$row['instock']."</h4>
			</div>
			<div class=\"col-lg-2 col-md-2 col-sm-2\">
				<div class=\"card\" style='width:10.5rem;'>
					<div class=\"card-body\">
						Quantity:
						<select class='form-control'>
							<option onclick=\"set_price(this.value,".$row['pid'].")\" value='1'>1</option>
							<option onclick=\"set_price(this.value,".$row['pid'].")\" value='2'>2</option>
							<option onclick=\"set_price(this.value,".$row['pid'].")\" value='3'>3</option>	
						</select>
						
						<button class=\"btn btn-primary btn-block\">Buy now</button>
						<button type='submit' class='btn btn-warning my-3' name='add' onclick='addToCart(".$product_id.")'>Add to cart
							<i class='fas fa-shopping-cart'></i>
						</button>
						
					</div>
				</div>
			</div>
			";
		}

		echo $output;
	}

	function cart_item($product_id,$product_name,$product_img,$product_price)
	{
		$output = "
		
			<div class=\"border rouded\">
				<div class=\"row bg-white\">
					<div class=\"col-md-3 pl-0\">
						<img src=$product_img alt=\"image1\" class=\"img-fluid\">
					</div>
					<div class=\"col-md-6\">
						<h5 class=\"pt-2\">$product_name</h5>
						<small class=\"text-secondary\"></small>
						<h5 class=\"pt-2\" id='price_".$product_id."'>₹ $product_price</h5>
						<button type=\"submit\" class=\"btn btn-warning\">Save for later</button>
						<button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\" onclick='remove(".$product_id.")'>Remove</button>
					</div>
					<div class=\"col-md-3 py-5\">
						<div id='quantity_".$product_id."'>
							Quantity:<input type=\"text\" class=\"form-control w-25 d-inline qty\" onkeyup=\"set_price(this.value,".$product_id.")\" id='qty_".$product_id."' name=\"quantity\" value='1'>
						</div>
					</div>
				</div>
			</div>
		
		";
		echo $output;
	}

	function get_product_price($product_id)
	{
		$output = null;
		$this->query = "
		SELECT price FROM product WHERE pid='".$product_id."'
		";

		$result = $this->query_result();
		foreach ($result as $row)
		{
			$output = $row['price'];
		}
		return $output;
	}

	function add_to_cart($product_id, $user_id, $price)
	{
		$this->query = "INSERT INTO cart(product_id,u_id,new_price) VALUES('".$product_id."','".$user_id."','".$price."')";

		$this->execute_query();
	}

	function delete_from_cart($product_id, $user_id)
	{
		$this->query = "DELETE FROM cart WHERE product_id='".$product_id."' AND u_id='".$user_id."'";

		$this->execute_query();
	}

	function update_price_in_cart($product_id, $user_id, $quantity)
	{
		$price = $this->get_product_price($product_id);

		$total = $quantity * $price;

		$this->query = "UPDATE cart SET new_price='".$total."',quantity='".$quantity."' WHERE product_id='".$product_id."' AND u_id='".$user_id."'
			";

		$this->execute_query();
	}

	function get_total_price_from_cart($user_id)
	{
		$total_price = 0;

		$this->query = "SELECT new_price FROM cart WHERE u_id='".$user_id."'";

		$result = $this->query_result();

		foreach ($result as $row) 
		{
			$total_price = $row['new_price'] + $total_price;
		}

		return $total_price;
	}

	function get_product_count_cart($user_id)
	{
		$output = null;

		$this->query = "SELECT COUNT(*) AS count FROM cart WHERE u_id='".$user_id."'";

		$result = $this->query_result();

		foreach ($result as $row) 
		{
		    $output = $row['count'];
		}
		return $output;
	}

	function get_order_id($user_id)
	{
		$this->query = "SELECT order_id FROM order_info WHERE user_id='".$user_id."'";

		$result = $this->query_result();

		if($this->total_row() > 0)
		{
			foreach ($result as $row)
			{
				return $row['order_id'];
			}
		}
		else
			return "";
	}

	function check($user_id)
	{
		$this->query = "SELECT COUNT(*) AS count FROM order_info WHERE user_id='".$user_id."'";

		$result = $this->query_result();

		foreach ($result as $row) 
		{
		      $output = $row['count'];
		}

		return $output;
	}

	function get_product_detail_from_cart($user_id)
	{
		$output = null;
		$this->query = "
		SELECT pid,pname,discription,img,instock,new_price,quantity FROM product p,cart c,user_table ut WHERE c.product_id=p.pid and c.u_id='".$user_id."'
		";

		$result = $this->query_result();

		$output .= "<div class='row'>";
		foreach ($result as $row)
		{
			$output .= "
			<div class='col-lg-10'>
				<div class='card shadow'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-lg-4'>
								<img src='".$row['img']."' class='img-fluid'>
							</div>
							<div class='col-lg-6'>
								<h2>".$row['pname']."</h2>
								<h6>".$row['discription']."</h6>
								<h5>₹ ".$row['new_price']."</h5>
								<button class='btn btn-link'>Delete</button>
								<button class='btn btn-link'>Add to wish list</button>
							</div>
							<div class='col-lg-2'>
								Quantity:
								<select onchange='quantity(this.value,".$row['pid'].")'>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			";
		}
		$output .= "</div>";
		return $output;
	}

	function view_product_for_payment($user_id)
	{
		$output = null;

		$this->query = "
		SELECT pid,pname,discription,img,new_price,quantity FROM product p,cart c,user_table ut WHERE c.product_id=p.pid and c.u_id=ut.user_id
		";

		$result = $this->query_result();

		foreach ($result as $row)
		{
			$output .= "
	        <div class='line'></div>
	            <table class='order-table'>
	              <tbody>
	            <tr>
		          <td><img src=".$row['img']." class='full-width'></img>
		          </td>
		          <td>
		            <br> <span class='thin'>".$row['pname']."</span>
		            <br>Description<br> <span class='thin small'> ".$row['discription']."</span>
		            <br>Quantity: <span class='thin'>".$row['quantity']."</span>
		          </td>

	            </tr>
	            <tr>
	              <td>
	                <div class='price'>₹".$row['new_price']."</div>
	              </td>
	            </tr>
	          </tbody>
	        </table>
			";
		}
		echo $output;

	}

	function Upload_file()
	{
		if(!empty($this->filedata['name']))
		{
			$extension = pathinfo($this->filedata['name'], PATHINFO_EXTENSION);

			$new_name = uniqid() . '.' . $extension;

			$_source_path = $this->filedata['tmp_name'];

			$target_path = 'img/' . $new_name;

			copy($_source_path, $target_path);

			return $new_name;
		}
	}

}

?>
