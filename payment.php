<?php

include('system/shopping_system.php');

require_once('class/class.phpmailer.php');

$conn = new Shopping;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Payment</title>
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
  <link rel="shortcut icon" href="favicon_io/favicon-32x32.png">
	<link rel="stylesheet" type="text/css" href="css/payment.css">
  <script src="js/function.js"></script>
</head>
<body>

<div class='container'>
  <div class='window'>
    <div class='order-info'>
      <div class='order-info-content'>
        <h2>Order Summary</h2>
        <?php echo $conn->view_product_for_payment($_SESSION['user_id']); ?>
        <div class='line'></div>
          <div class='total'>
            <span style='float:left;'>
              <div class='thin dense'>Delivery</div>
              TOTAL
            </span>
            <span style='float:right; text-align:right;'>
              <div class='thin dense'>FREE</div>
              <?php echo "₹".$conn->get_total_price_from_cart($_SESSION['user_id']); ?>
            </span>
          </div>
      </div>
    </div>
    <div class='credit-info'>
      <div class='credit-info-content'>
        <table class='half-input-table'>
          <tr>
            <td>Please select your card: </td>
            <td>
              <div class='dropdown' id='card-dropdown'>
                <div class='dropdown-btn' id='current-card'>Visa</div>
                <div class='dropdown-select'>
                  <ul>
                    <li>Master Card</li>
                    <li>American Express</li>
                  </ul>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <img src='https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png' height='80' class='credit-card-image' id='credit-card-image'></img>

          Card Number
          <input class='input-field' type="text" id="card_number" name="card_number" maxlength="12" minlength="12" >
          Card Holder
          <input class='input-field' id="card_holder_name" name="card_holder_name"  type="text" >
          <table class='half-input-table'>
            <tr>
              <td> Expires
                <input class='input-field' type="text" id="card_expire" name="card_expire" maxlength="5" minlength="5" >
              </td>
              <td>CVC
                <input class='input-field' type="text" id="card_cvc" name="card_cvc" maxlength="3" minlength="3" >
              </td>
            </tr>
          </table>
          <div id='message'></div>   
          
          <button class='pay-btn' type='submit' onclick="payment()" name="user_payment" id="user_payment">Checkout
            <span id="spinner"></span>
          </button>

      </div>
    </div>
  </div>
</div>

</body>
</html>