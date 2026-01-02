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
<body>

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-light">
  <!-- Small Container (Width controlled by col-md-4) -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card shadow p-5 m-5 border-0 rounded-4">
      <div class="card-body">
		<div class="mb-3">
	 		<img src="../images/LogoPrincipal.png"  class="p-5 img-fluid"></div>
         </div>
        <form>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="name@example.com">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div>
          <button type="button" class="btn btn-primary w-100" onclick="Login()">Sign in</button>
        </form>
		<br>
		<br>
      </div>
    </div>
  </div>
</div>

</body>
</html>
