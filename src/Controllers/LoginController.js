class LoginController {
	
	constructor( )	{
	}

	async checkToken()
	{
    	let URL = UrlBase +"/ApiController/Login/CheckToken.php"
		let pass = false;
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			data:				
			{     		
				token: localStorage.getItem('token') ?? "",
			},
		    statusCode: {
				200: function() {
					//console.log("Success: 200 OK");
					pass = true;
				},
				404: function() {
					console.log("Error: 404 Not Found - The PHP file was not found at this URL.");
					ThisApp.LoginController.GetMainLogin();
				}
    		}
		})
	  
	}

	 GetMainLogin(  )
	{	
		RefreshIntervals_Ids.forEach(interval_ID => {

		 clearInterval(interval_ID)

		});	

		clearInterval( ThisApp.GenerateEventCenterNavbar_IntervalId );
		clearInterval( ThisApp.CheckToken_IntervalId );


		 document.getElementById('navbar').innerHTML = "";


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
								<div class="toast-container position-fixed middle-0 top-0 p-1">
  									<div id="liveToastUsuarioIncorrecto" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    									<div class="toast-header">
     										<img src="..." class="rounded me-2" alt="">
    										<strong class="me-auto">Error de login.</strong>
    										<small> </small>
    										<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    									</div>
    									<div class="toast-body">
     										Usuario incorrecto.
   										</div>
  									</div>
								</div>
								<div class="toast-container position-fixed middle-0 top-0 p-1">
  									<div id="liveToastClaveIncorrecta" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    									<div class="toast-header">
     										<img src="..." class="rounded me-2" alt="">
    										<strong class="me-auto">Error de login.</strong>
    										<small> </small>
    										<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    									</div>
    									<div class="toast-body">
     										Clave incorrecta.
   										</div>
  									</div>
								</div>

									<button type="button" class="btn shadow btn-primary w-100" onclick="ThisApp.LoginController.Login();return false;">Sign in</button>
								</div>
							</form>
						</div>
					</div>
				</div>`;
}

	 Login() 
	{

    	var URL = UrlBase +"/ApiController/Login/Login.php";
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
			
				switch(result) {
					case "Usuario desconocido":
						const toastLiveExample = document.getElementById("liveToastUsuarioIncorrecto");
						const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
						toastBootstrap.show();
						console.log('Usuario Desconocido');
						break;
					case "password Incorrecta":
						const toastLiveExample2 = document.getElementById("liveToastClaveIncorrecta");
						const toastBootstrap2 = bootstrap.Toast.getOrCreateInstance(toastLiveExample2);
						toastBootstrap2.show();
						console.log('password Incorrecta');
						break;
					default:
						window.localStorage.setItem("token", result);
						document.cookie = 'token='+result;
						ThisApp.init();
						break;
				}
			}
		});
	}
}
				
			
			