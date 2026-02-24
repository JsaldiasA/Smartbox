
	GetSMSTable();
	GetStatusTable()
	var myRefreshAplicaciones = setInterval(GetSMSTable, 1000);
	var myRefreshAplicaciones = setInterval(GetStatusTable, 1000);

async function GetRegistrosDiarios()
	{

		var URL = "ApiController/RegistrosDiarios/RegistrosDiariosGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     		
				Id_unidad: id_unidad,
				returnJson: 1,
			},
		}).then(function(response){
      console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}

function GetSMSTable()
	{
    	var URL = "ApiController/SMSToUnidades/SMSToUnidadesGet.php"
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

async function GetStatusTable()
	{
		var Registros = await GetRegistrosDiarios();

		var UltimoRegistro =  Registros[0];

		let tableHTML = '	<table class="table" ><thead>';
       	tableHTML +=  `<tr><td><b>Estado:</b></td><td>${UltimoRegistro['ESTADO']}</td></tr>`;
		tableHTML +=  `<tr><td><b>Volumen:</b></td><td>${UltimoRegistro['VOLUMEN']}</td></tr>`;
		tableHTML +=  `<tr><td><b>Caudal:</b></td><td>${UltimoRegistro['CAUDAL']}</td></tr>`;
		tableHTML +=  `<tr><td><b>Última Registro:</b></td><td>${UltimoRegistro['DATETIME']}</td></tr>`;
        tableHTML +=  `</tr></tbody></table>`        ;
		
		document.getElementById("StatusTable").innerHTML= tableHTML;

	}	

function GetRegistrosDiariosTable( id_unidad )
	{
		
		document.getElementById("RegistrosDiariosTable").innerHTML= '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>';	

		var URL = "ApiController/RegistrosDiarios/RegistrosDiariosGet.php"

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
		
function FunctionNuevoNumero(unidad)
	{
  		let text = "¿Está seguro de cambiar el número de la unidad?";
 		if (confirm(text) == true)
			{
				var URL = "UnidadCambiarNumero.php";
				var Respuesta;
				var NuevoNumero = document.getElementById("NuevoNumero").value;
				var token = document.getElementById("password").value ;
		
				$.ajax({
        			url:URL,
            		type:"post",
					dataType:'text',
					data:
						{
            				tag: unidad,
							NuevoNumero: NuevoNumero,
							token: token,
        				},
					success: function(result)
						{
							alert(result)
						}
		  		});
  			}
		else
			{
    			alert("La operación se ha cancelado.");
  			}
	}

function FunctionNuevaUbicacion(unidad) {
  let text = "¿Está seguro de cambiar la ubicación de la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarNombre.php";
	var Respuesta;
	var NuevaUbicacion = document.getElementById("NuevaUbicacion").value;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevaUbicacion: NuevaUbicacion,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}
	
function FunctionNuevoTipo(unidad) {
  let text = "¿Está seguro de cambiar el tipo de unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarTipo.php";
	var Respuesta;
	var e = document.getElementById("NuevoTipo");
	var value = e.value;
	var NuevoTipo = e.options[e.selectedIndex].text;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoTipo: NuevoTipo,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}	

function FunctionNuevoCuartel( Id_unidad ) {
  let text = "¿Está seguro de cambiar el tipo de unidad?";
  if (confirm(text) == true) {


	var e = document.getElementById("Cuarteles");
	var Id_cuartel = e.value;

	$.ajax({
            url:"ApiController/cuarteles/cuartelesUpdate.php", 
            type: "post", 
			dataType: 'text',
			  data: {
            Id: Id_cuartel,
			Id_unidad: Id_unidad,

        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}	
	
function FunctionEliminar(unidad) {
  let text = "¿Está seguro de eliminar la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadEliminar.php";
	var Respuesta;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request 
			dataType: 'text',
			  data: {
            tag: unidad,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });	 

  } else {
    alert("La operación se ha cancelado.");
  }
}
	
function FunctionComandosMilesight(ComandoNombre) {
  let text = "¿Está seguro de accionar la unidad?";
  if (confirm(text) == true) {

	var URL = "ApiController/Postcomandos_milesight.php";
	var Respuesta;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			data: {
            tag: tag_unidad,
			nombre: ComandoNombre,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionCambiarVolMax(unidad) {
  let text = "¿Está seguro de cambiar el volumen máximo de la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarVolMax.php";
	var Respuesta;
	var NuevoVolMax = document.getElementById("VolMax").value;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoVolMax: NuevoVolMax,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionCreateSMS(SMS) {
  let text = "¿Está seguro de enviar un SMS?";
  if (confirm(text) == true) {

	var URL = "Apicontroller/SMSToUnidades/SMSToUnidadesCreate.php";
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

function FunctionDeleteSMS(Id_SMSToUnidades) {
  let text = "¿Está seguro de eliminar un SMS?";
  if (confirm(text) == true) {

	var URL = "Apicontroller/SMSToUnidades/SMSToUnidadesDelete.php";
	var Respuesta;
	var token = document.getElementById("password").value;

	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			data: {
            Id: Id_SMSToUnidades,
			token: token,
        	},
		    success: function(result){alert(result);}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

