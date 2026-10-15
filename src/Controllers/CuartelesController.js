class CuartelesController {
	
	constructor( )	{
	}

	async  GetRegistrosDiarios( id_unidad )
	{

		var URL = UrlBase +"/ApiController/RegistrosDiarios/RegistrosDiariosGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     		
				Id_unidad: id_unidad,
				returnJson: 1,
				limit: 3,
			},
		}).then(function(response){
      	//console.log("getRecord response: "+JSON.stringify(response));
      	return response;
  	  	});

	}	
	
	 GetRegistrosDiariosTable( id_unidad )
	{

		document.getElementById("RegistrosDiariosTable").innerHTML= '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>';	

		var URL = UrlBase +"/ApiController/RegistrosDiarios/RegistrosDiariosGet.php"

		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'text',
			data:
				{
            		Id_unidad: id_unidad,
        		},
			
		    	success: 
				function(result){

				let table = new DataTable("#TablaRegistros");
				document.getElementById("RegistrosDiariosTable").innerHTML= result;
				$(document).ready(function(){
				$('#TablaRegistros').dataTable();
				});
			
			}
		});	
	}	

	GetSMSTable(id_unidad)
	{
    	var URL = UrlBase +"/ApiController/SMSToUnidades/SMSToUnidadesGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			data:
				{
            		Id_unidad: id_unidad,
        		},
			
		    success: function(result){document.getElementById("SMSTable").innerHTML= result;}
		});	
 	}


	 FunctionCreateSMS(SMS,id_unidad) {
	let text = "¿Está seguro de enviar un SMS?";
	if (confirm(text) == true) {

		var URL = UrlBase +"/Apicontroller/SMSToUnidades/SMSToUnidadesCreate.php";
		var Respuesta;
		var NuevoVolMax = document.getElementById("VolMax").value;
		var token = document.getElementById("password").value;

		var SMStoCreate = SMS == "InputSMS" ? document.getElementById("InputSMS").value : SMS;
		$.ajax({
				url:URL, //the page containing php script
				type: "post", //request
				dataType: 'text',
				data: {
				Id_unidad: id_unidad,
				SMS: SMStoCreate,
				token: token,
				},
				success: function(result){alert(result);}
			});

	} else {
		alert("La operación se ha cancelado.");
	}

	}
}






  

