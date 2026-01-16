
GetSMSTable();
var myRefreshAplicaciones = setInterval(GetSMSTable, 1000);
function GetSMSTable()
	{
    	var URL = "ApiController/SMSToUnidades/SMSToUnidadesGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			data:
				{
            		Id_unidad: "'.$unidadDbEntity->get_id().'",
        		},
			
		    success: function(result){document.getElementById("SMSTable").innerHTML= result;}
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
            tag: '.$unidadDbEntity->get_Tag().',
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
            Id_unidad: '.$unidadDbEntity->get_id().',
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

