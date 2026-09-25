
	function GetRegistrosDiariosTable( id_unidad )
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

	function GetSMSTable(id_unidad)
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

	function FunctionNuevoNumero(Id_unidad)
	{
  		let text = "¿Está seguro de cambiar el número de la unidad?";
 		if (confirm(text) == true)
			{
				var URL = UrlBase +"/ApiController/unidad/UnidadUpdate.php";
				
				var NuevoNumero = document.getElementById("NuevoNumero").value;
		
				$.ajax({
        			url:URL,
            		type:"post",
					dataType:'text',
					data:
						{
            				Id: Id_unidad,
							numero: NuevoNumero,
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

	function FunctionNuevaUbicacion(Id_unidad) {
  		let text = "¿Está seguro de cambiar la ubicación de la unidad?";
  		if (confirm(text) == true) {

		var URL = UrlBase +"/ApiController/unidad/UnidadUpdate.php";

		var NuevaUbicacion = document.getElementById("NuevaUbicacion").value;

		$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            Id: Id_unidad,
			Ubicacion : NuevaUbicacion,
        	},
		    success: function(result){alert(result)}
		  });

  		} else {
   		 alert("La operación se ha cancelado.");
  		}
	}
	
function FunctionNuevoTipo(Id_unidad) {

  	let text = "¿Está seguro de cambiar el tipo de unidad?";
  	if (confirm(text) == true) {

	var URL = UrlBase +"/ApiController/unidad/UnidadUpdate.php";
	var Respuesta;
	var e = document.getElementById("NuevoTipo");
	var id_unidadTipo = e.value;

	$.ajax({
        url:URL, //the page containing php script
        type: "post", //request
		dataType: 'text',
		  data: {
        Id: Id_unidad,
		id_unidadTipo: id_unidadTipo,
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
            url:UrlBase +"/ApiController/cuarteles/cuartelesUpdate.php", 
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
	
function FunctionComandosMilesight(ComandoNombre, tag_unidad ) {

  let text = "¿Está seguro de accionar la unidad?";
  if (confirm(text) == true) {

	var URL = UrlBase +"/ApiController/Postcomandos_milesight.php";
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

function FunctionCambiarVolMax(Id_unidad) {
  let text = "¿Está seguro de cambiar el volumen máximo de la unidad?";
  if (confirm(text) == true) {

	var URL = UrlBase +"/ApiController/unidad/UnidadUpdate.php";
	var NuevoVolMax = document.getElementById("VolMax").value;

	$.ajax({
            url:URL,  //the page containing php script
            type: "post",  //request
			dataType: 'text',
			  data: {
            Id: Id_unidad,
			VolMax: NuevoVolMax,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionCreateSMS(SMS,id_unidad) {
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

function FunctionDeleteSMS(Id_SMSToUnidades) {
  let text = "¿Está seguro de eliminar un SMS?";
  if (confirm(text) == true) {

	var URL = UrlBase +"/Apicontroller/SMSToUnidades/SMSToUnidadesDelete.php";
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

function VolverCuartelesMain()
{
	GetMainCuarteles();

}
	
async function GetChecklistByZonaName( ZonaName)
	{
		var URL = UrlBase +"/ApiController/Checklist/ChecklistGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     		
				ZonaName: ZonaName,
				returnJson: 1,
			},
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });
	}	

 function GetMetodosDePrueba( )
{
	
	let Json = `[{"Id":"1","Name":"Sin Probar"},{"Id":"2","Name":"Soplado de flujometro"},{"Id":"3","Name":"Prueba Con agua"}]`;

  	return JSON.parse(Json);
  
}

 function GetChecklistMotivos( )
{

	let Json = `[{"Id":"1","Name":"Fabricación"},{"Id":"2","Name":"Pre-instalación"},{"Id":"3","Name":"Instalación"},{"Id":"4","Name":"Revisión preventiva"}]`;

  	return JSON.parse(Json);
  
}

function GetTicketPriority( )
{

		const PrioridadGrave = {
		Id: "1",
		Name: "Alta",
		Reasons:[{Id: "1",Name:"Desconectado"},{Id: "2",Name:"No Abre"}]
		};

		const PrioridadMedia = {
		Id: "2",
		Name: "Media",
		Reasons:[{Id: "10",Name:"No marca"}]
		};

		const PrioridadBaja = {
		Id: "3",
		Name: "Baja",
		Reasons:[{Id: "3",Name:"Bateria baja"},{Id: "4",Name:"Sin condit"},{Id: "6",Name:"Sin choco"},{Id: "7",Name:"Fuga agua"},{Id: "8",Name:"Caja de energizacion"},{Id: "9",Name:"otro"}]
		};

		Priorities = [PrioridadGrave,PrioridadMedia,PrioridadBaja]

  	return Priorities;
  
}

function GetBateriaTipos()
{
		const Afel1800 = {
		Id: "1",
		Name: "Afel1800",
		};

		const Afel2600 = {
		Id: "2",
		Name: "Afel2600",
		};

		const PlomasHobby = {
		Id: "3",
		Name: "PlomasHobby",
		};

		const Mix = {
		Id: "4",
		Name: "MixPilas",
		};

		const BateriaTipos = [Afel1800,Afel2600,PlomasHobby,Mix];

  	return BateriaTipos;

}
async function GetUltimosRegistros(  )
	{

		var URL = UrlBase +"/ApiController/RegistrosDiarios/UltimosRegistros.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}

async function GetUnidades(  )
	{

		var URL = UrlBase +"/ApiController/unidad/unidadGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}
	
async function GetChecklists()
	{
		var URL = UrlBase +"/ApiController/Checklist/ChecklistGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     	
				returnJson: 1,
			},
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });
		
	}

async function GetChecklistsNew()
	{
		var URL = UrlBase +"/apiController/checklist/get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     	
				returnJson: 1,
			},
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}	

async function GetEventosBytag( tag )
	{
		var URL = UrlBase +"/apiController/eventos/get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     	
				tag: tag,
			},
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });
		
	}		
	
async function GetZonas()
	{
		var URL = UrlBase +"/ApiController/zona/zonaGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     	
				returnJson: 1,
			},
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });
		
	}	

async function GetCuarteles( )
	{
		var URL = UrlBase +"/ApiController/Cuarteles/CuartelesGet.php"
	
	try {

			return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  }  
	);
		
	} catch (error) {
		console.error(error.message)
	}	

	}		

async function GetTicket( )
	{
		
		var URL = UrlBase +"/ApiController/ticket/ticketGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}

async function GetTicketStatus( )
	{
		
		var URL = UrlBase +"/ApiController/ticket_status/ticket_statusGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}

async function GetRfvTicket( )
	{
		
		var URL = UrlBase +"/ApiController/rfvticket/Get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}

async function GetRfvTicketStatus( )
	{
		
		var URL = UrlBase +"/ApiController/rfvticket_status/Get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}	

async function GetUnidaTipo( )
	{
		
		var URL = UrlBase +"/ApiController/unidadtipo/Get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}	

async function GetEventMessages( )
	{
		
		var URL = UrlBase +"/ApiController/eventMessage/Get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}
async function GetEventMessagesType( )
	{
		
		var URL = UrlBase +"/ApiController/eventMessageType/Get.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      //console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}	


async function GetRegistrosDiarios( id_unidad )
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

function FunctionDeleteSMS(Id_SMSToUnidades) {
  	let text = "¿Está seguro de eliminar un SMS?";
  if (confirm(text) == true) {

	var URL = UrlBase +"/Apicontroller/Login/CheckToken.php";

	$.ajax({
            url:URL, //the page containing php script
            type: "get", //request
			dataType: 'text',
			data: {
        	},
		    success: function(result){alert(result);}
		  });

 	 } else {
   		 alert("La operación se ha cancelado.");
 	 }

	}

async function UpdateEventMessage( EventMsg ) {

	var URL = UrlBase +"/ApiController/eventMessage/update.php";

	$.ajax({
            url:URL,  //the page containing php script
            type: "post",  //request
			dataType: 'text',
			data: EventMsg,

		    success: function(result){ alert(result) }
		  });

}	



function VolverCuartelesMain()
{
	GetMain();
}
	
function FieldActivity( date ) {

	var pastDate = new Date(date);
	var now = new Date(new Date().toLocaleString('en', {timeZone: 'America/Santiago'}))

	var minutesAgo = Math.floor((now - pastDate) / 60000) ;// 15 min mas que agregea la base de datos a la tabla unidades_lastortolas, se desconoce el porque.

	if( minutesAgo < 60 )
	{
		return '<a style="color: green;">' +minutesAgo.toString() + ' min</a>';
	}
	else
	{
		var hoursAgo = Math.floor((now - pastDate) / 3600000);

		if( hoursAgo < 24 )
		{
			return '<a style="color: red;">' +hoursAgo.toString() + ' Horas</a>';
		}
		else
		{
			var DaysAgo = Math.floor((now - pastDate) / (3600000*24));

			return '<a style="color: red;">' +DaysAgo.toString() + ' Dias</a>';
		}
	}	
   
}

function FieldFecha( date ) {
	
	var pastDate = new Date(date);
	var now = new Date(new Date().toLocaleString('en', {timeZone: 'America/Santiago'}))

	var hoursAgo = Math.floor((now - pastDate) / 3600000);
	var DaysAgo = Math.floor((now - pastDate) / (3600000*24));
	var weeksAgo = Math.floor((now - pastDate) / (3600000*24*7));
	var monthsAgo = Math.floor((now - pastDate) / (3600000*24*30));

	switch (true) {

		case  hoursAgo < 24:
			return hoursAgo == 1 ? hoursAgo.toString() + ' Hora' : +hoursAgo.toString() + ' Horas';

		case DaysAgo < 7:
			return DaysAgo == 1 ? DaysAgo.toString() + ' Dia' :DaysAgo.toString() + ' Dias';
			
		case weeksAgo < 10:
			return weeksAgo == 1 ? weeksAgo.toString() + ' Semana' :weeksAgo.toString() + ' Semanas';
			
		default:
			return monthsAgo == 1 ? monthsAgo.toString() + ' Mes' :monthsAgo.toString() + ' Meses';
		}
   
}


function FieldEstado( Estado ) {

	return Estado == 'ON' ? '<div class="bg-danger text-white">ON</div>' : Estado;
	
}
   

function FieldCaudal( Caudal ) {
	  

			switch (Caudal) {

			case '999':
				// Code to execute if expression === value1
				return  ' <div class="bg-danger text-white">Mayor a 140!</div>  ';
			
			case '-999':
				// Code to execute if expression === value2
				return  ' <div class="bg-danger text-white">Menor a 5!</div>  ';
			
			default:
				// Code to execute if expression matches no cases
				return Caudal;
			}

}

function FieldBattery( level ) {
	  
	  		var ImgUrl;
			let levelParsed = parseInt(level);

			switch (true) {

			case levelParsed < 101 && levelParsed >= 80:
				// Code to execute if expression === value1
				ImgUrl = 'src/Views/Resources/BatFull.jpg';
				break;
			case levelParsed < 80 && levelParsed >= 30:
				// Code to execute if expression === value2
				ImgUrl ='src/Views/Resources/BatMedio.jpg';
				break;
			case levelParsed < 30 && levelParsed >= 10:
				// Code to execute if expression === value2
				ImgUrl= 'src/Views/Resources/BatBajo.jpg'; 
				break;
			case levelParsed < 10 && levelParsed >= 1:
			// Code to execute if expression === value2
				ImgUrl = 'src/Views/Resources/BatEmpty.jpg'; 
				break;
			default:
				// Code to execute if expression matches no cases
				return 'NULL';
			}

			return '<div  class="d-inline" >'+level+'%</div><img  src="'+ImgUrl+'" width="30" height="20">';
}

function FieldSignal( level , FechaUltimaActualizacion ) {
	  
	  		var ImgUrl;
			let SignalLevel = parseInt(level);

			if( FieldActivity(FechaUltimaActualizacion).includes("Dias") )
			{
				return '<i class="bi bi-wifi-off text-danger fs-3"></i>';
			}

			switch (true) {
			
			case SignalLevel < 32 && SignalLevel >= 26:
				
				return '<i class="bi bi-reception-4 text-success fs-3"></i>';

			case SignalLevel < 26 && SignalLevel >= 21:
				
				return '<i class="bi bi-reception-3 text-success fs-3"></i>';
			
			case SignalLevel < 21 && SignalLevel >= 16:
		
				return '<i class="bi bi-reception-2 text-warning fs-3"></i>'; 
			
			case SignalLevel < 16 :
			
				return  '<i class="bi bi-reception-1 text-danger fs-3"></i>'; 
			
			default:
				// Code to execute if expression matches no cases
				return 'NULL';
			}
}


function GetVolverBtn(  OnclickFunction ) {
	  

	return 	`<div class="col-auto align-self-center">
		 <button type="button" class="btn btn-primary " onclick=${ OnclickFunction } > Volver <i class="bi bi-arrow-left"></i> </button> 
	 	</div>`;

}

function GetEditBtn(  OnclickFunction ) {
	  

	return 	`<div class="col p-3 d-flex justify-content-end  align-self-center ">
	 <a href="url" onclick="${OnclickFunction};return false;" > <i class="bi bi-pencil-square fs-3"></i> </a> 
	 </div>`;

}


function GetTitulo(  Titulo ) {
	  
	return 	`<div class="col p-3"><h1><b> ${Titulo}  </b></h1> </div>`;

}

function DangerText( text ){

	return `<div class="text-danger"><b>${text} </b></div>`
}

function WarningText( text ){

	return `<div class="text-warning"><b>${text} </b></div>`
}

function CreateSelectFromObjArray(Id_name, ObjArray,valueKey,displayKey){

	let HTMLtext = ` <select name="${Id_name}" id="${Id_name}" class="form-select" required>`;
	ObjArray.forEach(row => {	HTMLtext += `<option value='${row[valueKey]}'>${row[displayKey]}</option>`;} );	 
	HTMLtext += '</select>';

	return HTMLtext;

}

function GetLoadingPage(  ) {
	  
	return 	` <div class="spinner-border text-success" role="status"></div>`;

}


async function pushNotification( text )
{
	 if (!('serviceWorker' in navigator) || !('Notification' in window)) {
    console.error('Service Workers or Notifications are not supported.');
    return;
  }

  try {
    // Register the background script file
    const registration = await navigator.serviceWorker.register('sw.js');
    console.log('Service Worker registered successfully:', registration);

    // Step 2: Request user permission
    const permission = await Notification.requestPermission();
    if (permission === 'granted') {
      console.log('Notification permission granted.');
      
     registration.showNotification( 'Alerta', {
		body: text,
      icon: "https://eco3.cl/wp-content/uploads/2025/07/cropped-ECO3-Empresa-de-tecnologia-y-gestion-de-recursos-%E2%80%A8naturales-en-Chile-32x32.png",
      } ) ;

    	} else {
      console.warn('Notification permission denied.');
    	}
 	 } catch (error) {
    console.error('Initialization failed:', error);
  }

}

function DivLoadingState( HtmlElementId )
{
	document.getElementById(HtmlElementId).innerHTML = `<div class="spinner-border text-success" role="status"></div> `;

}





		function FunctionNuevoTicketPost()
		{
			let text = "¿Está seguro de enviar el ticket?";
			if (confirm(text) == true)
				{
					let pattern = /(^\d+\.\d+$)|(^\d+$)/;
					var URL = UrlBase +"/ApiController/ticket/TicketCreate.php";
					var Respuesta;

					var NombreSelectDOM = document.getElementById("Nombre");
					var Nombre = NombreSelectDOM.options[ NombreSelectDOM.selectedIndex ].text;
					if (Nombre == "")	return alert ("Debe especificar un dispositivo y/o plataforma.");
						
					var Descripcion = document.getElementById("Descripcion").value;
					if (Descripcion == "" )	 return alert ("Debe explicar de que se trata el problema.");

					var Usuario = document.getElementById("Usuario").value;
					if (Usuario == "" )		return alert ("Debe escribir su nombre.");
						
					var f = document.getElementById("cuartel");
					var Id_unidad = f.options[f.selectedIndex].value; 	

					var f = document.getElementById("TicketPriority");
					var Id_TicketPriority = f.options[f.selectedIndex].value; 

					$.ajax(
						{
            				url:URL,
            				type:"post",
							dataType:'text',
							data:
								{
									Nombre: Nombre,
									Descripcion: Descripcion,
									Usuario: Usuario,
									Id_unidad: Id_unidad,
									Id_TicketPriority: Id_TicketPriority
        						},
							success: function(result)
							{
								alert (result);
								window.location.reload();
							}
						});
  				}
			else
				{
    				alert ("La operación se ha cancelado.");
  				}
		}

function FunctionDeleteTicket(id_ticket)
{
	let text = "¿Está seguro de eliminar el ticket?";
	if (confirm(text) == true)
	{
		var MotivoCierre = document.getElementById("MotivoCierre").value;

		if (MotivoCierre == "")
		{
			return alert ("Debe escribir el motivo del cierre");
		}

		let pattern = /(^\d+\.\d+$)|(^\d+$)/;
		var URL = UrlBase +"/ApiController/ticket/TicketDelete.php";
		var Respuesta;
	
		$.ajax(
		{
			url:URL,
			type:"post",
			dataType:'text',
			data:
				{
					Id: id_ticket,
					MotivoDeCierre: MotivoCierre
				},
			success: function(result)
				{
					alert (result);
					window.location.reload();
				}
		});
	}
	else{
		alert ("La operación se ha cancelado.");
	}
}

function FunctionUpdateTicketPost( id_ticket )
	{
		let text = "¿Está seguro de enviar el ticket?";
		if (confirm(text) == true)
			{
				var URL = UrlBase +"/ApiController/ticket/TicketUpdate.php";

				var Nombre = document.getElementById("Nombre").value;
				
				if (Nombre == "")
					{
						return alert ("Debe especificar un dispositivo y/o plataforma.");
					}
				var Descripcion = document.getElementById("Descripcion").value;

				if (Descripcion == "" )
					{
						return alert ("Debe explicar de que se trata el problema.");
					}

				var f = document.getElementById("TicketPriority");
				var Id_TicketPriority = f.options[f.selectedIndex].value; 
				
				//var f = document.getElementById("cuartel");
				//var Id_unidad = f.options[f.selectedIndex].value; 	
	
				$.ajax(
					{
        				url:URL,
        				type:"post",
						dataType:'text',
						data:
							{
								Id: id_ticket ,
								Nombre: Nombre,
								Descripcion: Descripcion,
								Id_TicketPriority: Id_TicketPriority,
								//Id_unidad: Id_unidad,
    						},
						success: function(result)
							{
								alert (result);
								window.location.reload();
							}
					});
			}
		else
		{
			alert ("La operación se ha cancelado.");
		}
	}

	 function GetTicketPriority( )
{

		const PrioridadGrave = {
		Id: "1",
		Name: "Alta",
		Reasons:[{Id: "1",Name:"Desconectado"},{Id: "2",Name:"No Abre"}]
		};

		const PrioridadMedia = {
		Id: "2",
		Name: "Media",
		Reasons:[{Id: "10",Name:"No marca"}]
		};

		const PrioridadBaja = {
		Id: "3",
		Name: "Baja",
		Reasons:[{Id: "3",Name:"Bateria baja"},{Id: "4",Name:"Sin condit"},{Id: "6",Name:"Sin choco"},{Id: "7",Name:"Fuga agua"},{Id: "8",Name:"Caja de energizacion"},{Id: "9",Name:"otro"}]
		};

		Priorities = [PrioridadGrave,PrioridadMedia,PrioridadBaja]

  	return Priorities;
  
}

function priorityColorText( Id_TicketPriority, text)
{

	switch ( Id_TicketPriority ) {
	
	case '1':
		
		return `<div class="text-danger"><b> ${text} </b></div>`
		
	case '2':
		
		return `<div class="text-warning"><b> ${text} </b></div>`
	
	case '3':

		return `<div class="text-success"><b> ${text} </b></div>`
	
	default:
		// Code to execute if expression matches no cases
		return text;
	}
}


 async function FunctionNuevoCheckListPost( Id_unidad )
		{
			let text = "¿Está seguro de enviar el CheckList?";
			if (confirm(text) == true)
				{
					var agua= Number(document.getElementById("agua").checked);
					var Solenoide= Number(document.getElementById("Solenoide").checked);
					var Flujometro= Number(document.getElementById("Flujometro").checked);
					var ConduitChoco = Number(document.getElementById("ConduitChoco").checked);
					var Observaciones= document.getElementById("Observaciones").value;
					var TecnicoResponsable= document.getElementById("TecnicoResponsable").value;

					var ChecklistMotivoSelect = document.getElementById("ChecklistMotivo");
					var id_checklistMotivo = ChecklistMotivoSelect.options[ChecklistMotivoSelect.selectedIndex].value;  

					var reemplazoBateria= Number(document.getElementById("chBox_reemplazoBateria").checked);
					var BateriaTipoSelect = document.getElementById("BateriaTipo");
					var Id_bateriaTipo = reemplazoBateria ? BateriaTipoSelect.options[BateriaTipoSelect.selectedIndex].value : "";  

					//let MdpruebaSelect =document.getElementById("MetodosDePrueba"); 
					//let MetodoDePrueba = MdpruebaSelect.options[MdpruebaSelect.selectedIndex].value; 
					let URL_foto= document.getElementById("NombreDeFoto").innerHTML == "" ? 'nofoto.jpg' : document.getElementById("NombreDeFoto").innerHTML ; 
					URL_foto='https://smartbox.eco3.cl/checklistform/Fotos/'+URL_foto;

					if(Observaciones == "" )
					{
						return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");
					}
					
					if(TecnicoResponsable == "" )
					{
						return alert("Técnico responsable no puede estar vacío, coloque su nombre.");
					}
					
					$.ajax(
						{
							url:'https://smartbox.eco3.cl/ApiController/checklist/checklistCreate.php',    //the page containing php script
							type: "post",    //request 
							dataType: 'text',
							data:
								{
									id_unidad: Id_unidad,
									Flujometro: Flujometro,
									Solenoide: Solenoide, 
									ConduitChoco: ConduitChoco,
									//MetodoDePrueba: MetodoDePrueba,
									agua: agua, 								  
									id_checklistMotivo: id_checklistMotivo,
									Observaciones: Observaciones,
									TecnicoResponsable: TecnicoResponsable,
									URL_foto: URL_foto,
									Id_bateriaTipo: Id_bateriaTipo,	    
								},
							success: function(result)
								{
									alert(result);
									window.location.reload();
								}    
						});
				}
			else
				{
					alert("La operación se ha cancelado.");
				}
		}

	async  function  uploadPicture( inputFile ) {
	
		var file_data = inputFile;  

		const enviarChecklistBtn = document.getElementById('enviarChecklist');
		enviarChecklistBtn.disabled = true;
		enviarChecklistBtn.classList.remove('btn-success');
   		 enviarChecklistBtn.classList.add('btn-secondary'); 
		enviarChecklistBtn.innerHTML= 'Subiendo Foto ' + `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;

    	var form_data = new FormData();                  
    	form_data.append('file', file_data);                        
		$.ajax({
        url: 'https://smartbox.eco3.cl/ChecklistForm/upload.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response); // <-- display response from the PHP script, if any
			document.querySelector("#StatusFoto").innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
			document.querySelector("#NombreDeFoto").innerHTML = file_data.name;
			enviarChecklistBtn.disabled = false;
			enviarChecklistBtn.innerHTML= 'Enviar CheckList' ;
			enviarChecklistBtn.classList.remove('btn-secondary');
			enviarChecklistBtn.classList.add('btn-success');
   		
        }
     });
	
	}
	
    function 		 NumericParameterHasError(Parameter,highLimit,lowLimit) {
		let pattern = /(^\d+\.\d+$)|(^\d+$)/; 
	var noAjustarMsg = " ,vuelva a ajustarlo. SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, póngase en contacto con la oficina técnica.";
			  
	switch (true) {
	  case (Parameter.value == ""):
		Parameter.value = 0;
		return false;
		break;
	  case (Parameter.value == null):
		Parameter.value = 0;
		return false;
		break;
	  case (Parameter.value < lowLimit):
		alert(Parameter.id+" no puede ser menor a "+lowLimit+" "+noAjustarMsg);		  
		return true;
		break;
	  case (Parameter.value > highLimit ):
		alert(Parameter.id+" no puede ser mayor a "+highLimit+" "+noAjustarMsg);
		return true;
		break;
	  case (!pattern.test(Parameter.value)):
		alert("Error en " +Parameter.id+". Ingrese solo valores numéricos, no se aceptan letras o caracteres en este campo. Ej: 1 ,13 ,14.2 ,13.5");
		return true;
		break;
	 
	  default:
	    return false;
	}	   
}

 function FunctionUpdateChecklistPost( Id_checklist ) 
		{
			let text = "¿Está seguro de editar el checklist?";
			if (confirm(text) == true)
			{
					
				var Solenoide 	= Number(document.getElementById("Solenoide").checked);
				var Flujometro         = Number(document.getElementById("Flujometro").checked);	
				var ConduitChoco = Number(document.getElementById("ConduitChoco").checked);
				var agua         = Number(document.getElementById("agua").checked);
				var Observaciones= document.getElementById("Observaciones").value;
				if(Observaciones == "" )	return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");
					
				$.ajax(
					{
            			url:`https://smartbox.eco3.cl/ApiController/checklist/checklistUpdate.php`,
            			type:"post",
						dataType:'text',
						data:
							{
								Id_checklist:Id_checklist,
								Solenoide 	: Solenoide,
								ConduitChoco: ConduitChoco,
								Flujometro : Flujometro,
								agua: agua,       
								Observaciones: Observaciones,
        					},
						success: function(result)
							{
								alert (result);
								window.location.reload();
							}
					});
  			}
			else		alert ("La operación se ha cancelado.");
		}



