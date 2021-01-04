<?php include 'header.php'; ?>
<div class="py-3"></div>
<h2 class="text-center">Admin Dashoard</h2>
<div class="container">
    <div id="data_result">
    </div>
</div>
</body>
</html>
<script>
	$(document).ready(function() {
		$("#view_users").click(function(){
			$.ajax({
				url:'ajax_action.php',
				method:'POST',
				data:{page:'user_list'},
				dataType:"json",
				success:function(data)
				{
					document.getElementById('data_result').innerHTML=data;
				}
			});
		});
	});

	$(document).ready(function() {
		$("#view_products").click(function(){
			$.ajax({
				url:'ajax_action.php',
				method:'POST',
				data:{page:'product_list'},
				dataType:"json",
				success:function(data)
				{
					document.getElementById('data_result').innerHTML=data;
				}
			});
		});
	});

	$(document).ready(function() {
		$("#view_orders").click(function(){
			$.ajax({
				url:'ajax_action.php',
				method:'POST',
				data:{page:'order_list'},
				dataType:"json",
				success:function(data)
				{
					document.getElementById('data_result').innerHTML=data;
				}
			});
		});
	});

	function remove_product(product_id)
	{
	  	var xmlhttp = new XMLHttpRequest();
	  	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById('data_result').innerHTML=this.response;
	    }
	  };
	  xmlhttp.open("POST","ajax_action.php",true);
	  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  xmlhttp.send("page=remove_product&product_id="+product_id);
	}

	function remove_user(user_id) 
	{
		var xmlhttp = new XMLHttpRequest();
	  	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById('data_result').innerHTML=this.response;
	    }
	  };
	  xmlhttp.open("POST","ajax_action.php",true);
	  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  xmlhttp.send("page=remove_user&user_id="+user_id);
	}

	function remove_order(order_id) 
	{
		var xmlhttp = new XMLHttpRequest();
	  	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById('data_result').innerHTML=this.response;
	    }
	  };
	  xmlhttp.open("POST","ajax_action.php",true);
	  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  xmlhttp.send("page=remove_order&order_id="+order_id);
	}

	function add_product() 
	{
		var xmlhttp = new XMLHttpRequest();
	  	xmlhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById('data_result').innerHTML=this.response;
	    }
	  };
	  xmlhttp.open("POST","ajax_action.php",true);
	  xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	  xmlhttp.send("page=add_product");
	}

	$(document).ready(function(){
		if($('#product_form').parsley())
		{
	      $.ajax({
	        url:"ajax_action.php",
	        method:"POST",
	        data:$(this).serialize(),
	        dataType:"json",
	        beforeSend:function(){
	          $('#product_btn').attr('disabled', 'disabled');
	          $('#product_btn').val('please wait...');
	        },
	        success:function(data)
	        {
	          if(data.success)
	          {
	            $('#message').html('<div class="alert alert-success">Product successfully added</div>');
	            $('#product_form')[0].reset();
	            $('#product_form').parsley().reset();
	          }

	          $('#product_btn').attr('disabled', false);
	        }
	    });
	  }
  	});
</script>