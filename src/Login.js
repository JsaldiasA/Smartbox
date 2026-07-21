


function GetMainLogin(  )
{	
		RefreshIntervals_Ids.forEach(interval_ID => {

		 clearInterval(interval_ID)

		});	


		 document.getElementById('main').innerHTML = `    

	<div class="container vh-100 d-flex align-items-center justify-content-center">
		<!-- Small Container (Width controlled by col-md-4) -->
			<div class="card shadow-lg mt-3" style="width: 28rem;" >
					<div class="mx-5 mt-3 ">
						<img src="https://smartbox.eco3.cl/images/LogoPrincipal.png" class=" px-5 pt-3 card-img-top"  >
					</div>
					<div class="card-body m-3">
						<form>
							<div class="mb-4">
								<label class="form-label">Email address</label>
								<input type="email" class="form-control" id="email" placeholder="name@example.com">
							</div>
							<div class="mb-4">
								<label class="form-label">Password</label>
								<input type="password" class="form-control" id="password" placeholder="Password">
							</div>
							<div class="">
								<button type="button" class="btn shadow btn-primary w-100" onclick="Login();return false;">Sign in</button>
							</div>
						</form>
					</div>
			</div>
	</div>`;

}

function Login() 
	{
			
		DivLoadingState('main');

    	var URL = "https://smartbox.eco3.cl/ApiController/Login/Login.php";

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
				document.cookie = 'token='+result;
                GetMainCuarteles();
			}

		});
	}
	

