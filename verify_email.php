<?php


include('system/shopping_system.php');

$conn = new Shopping;

if(isset($_GET['type'], $_GET['code']))
{
	if($_GET['type'] == 'master')
	{
		$conn->data = array(
			':email_verified'	=>	'yes'
		);

		$conn->query = "
		UPDATE admin_table 
		SET email_verified = :email_verified 
		WHERE admin_verfication_code = '".$_GET['code']."'
		";

		$conn->execute_query();

		$conn->redirect('admin/login.php?verified=success');
	}

	if($_GET['type'] == 'user')
	{
		$conn->data = array(
			':user_email_verified'	=>	'yes'
		);

		$conn->query = "
		UPDATE user_table 
		SET user_email_verified = :user_email_verified 
		WHERE user_verfication_code = '".$_GET['code']."'
		";

		$conn->execute_query();

		$conn->redirect('login.php?verified=success');
	}
}


?>