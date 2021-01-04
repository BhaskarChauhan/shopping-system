function remove(product_id)
{
  	var xmlhttp = new XMLHttpRequest();
  	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	location.reload();
    }
  };
  xmlhttp.open("POST","cart.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("action=remove&pid="+product_id);
}

function check_out()
{
  	var xmlhttp = new XMLHttpRequest();
  	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	window.location = this.response;
    	//console.log(this.response);
    }
  };
  xmlhttp.open("POST","system/ajax_function.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("page=payment");
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

function payment()
{
	var card_number = document.getElementById('card_number').value;
	var card_holder_name = document.getElementById('card_holder_name').value;
	var card_expire = document.getElementById('card_expire').value;
	var card_cvc = document.getElementById('card_cvc').value;

	$('#spinner').html("<span class='spinner-border spinner-border-sm'></span>");

	if(card_number == "" || card_holder_name == "" || card_expire == "" || card_cvc == "")
	{
	  $('#message').html('<div class="alert alert-danger">Please fill the details first!</div>');
	  $('#spinner').html("<span></span>");
	}
	else
	{
	  var xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) 
	    {
	      var data = this.response;
	      obj = JSON.parse(data);
	      if(obj == 'error')
	      {
	        $('#message').html('<div class="alert alert-danger">Please fill the details first!</div>');
	      }
	      else if(obj == 'success')
	      {
	        window.location = 'payment_detail.php';
	      }
	      else if(obj == 'already_paid')
	      {
	        alert(obj);
	      }
	    }
	  };
	  xmlhttp.open("POST","system/ajax_function.php",true);
	  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  xmlhttp.send("page=check_for_payment&card_number="+card_number+"&card_holder_name="+card_holder_name+"&card_expire="+card_expire+"&card_cvc="+card_cvc);
	}
}

function subscribe_email(email) 
{
  var email = document.getElementById('subscribers_email').value;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) 
    {
      document.getElementById('response').innerHTML=this.response;
    }
  };
  xmlhttp.open("POST","system/ajax_function.php",true);
  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xmlhttp.send("page=subscribe&email="+email);
}
