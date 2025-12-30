<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
require_once 'views/navbar.php';	
?>	
<script>

	

//Funciones

//GetBodega
	
function Login() 
	{
    		var URL = "ApiController/Login.php";

	var email =  document.getElementById("email").value;
	var password = document.getElementById("password").value ;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            email: email,
			password: password,
        	},

		    success: function(result){
				window.localStorage.setItem("token", result);
				window.location.replace("http://smartbox.eco3.cl/main.php");
				document.cookie = 'token='+result;
				//window.location.replace("http://smartbox.eco3.cl/main.php?tk="+result);
			}

		  });
	}
	
</script>
<body>
<br>
<div class="container-fluid vh-75 d-flex align-items-center justify-content-center">
		
		<div class="col-lg-4">  
			<H1>Login</H1>  	
			<form>
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" aria-describedby="emailHelp">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password">
			</div>
			<div class="form-group form-check">
				<input type="checkbox" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Check me out</label>
			</div>
			<button button type="button" onclick="Login()" >Submit</button>
			</form>
		</div>
	</div>
</div>
</body>
</html>
