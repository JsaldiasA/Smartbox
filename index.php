<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
//require_once 'views/navbar.php';	
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
<body style="background-color: #213A58;">

	<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
		<!-- Small Container (Width controlled by col-md-4) -->
		<div class="col-12 col-md-6 col-lg-4 ratio ratio-1x1">
			<div class="card shadow-lg p-4 border-0 rounded-5 ">
					<div class="m-3">
						<img src="../images/LogoPrincipal.png" style=" max-width: auto; height: 100%;" >
					</div>
					<div class="m-3">
						<form>
							<div class="my-3">
								<label class="form-label">Email address</label>
								<input type="email" class="form-control" id="email" placeholder="name@example.com">
							</div>
							<div class="mb-4">
								<label class="form-label">Password</label>
								<input type="password" class="form-control" id="password" placeholder="Password">
							</div>
							<div class="my-3">
								<button type="button" class="btn shadow btn-primary w-100" onclick="Login()">Sign in</button>
							</div>
						</form>
					</div>
			</div>
		</div>
	</div>

</body>
</html>
