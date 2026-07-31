//checkToken();

async function checkToken()
	{
    	let URL = "https://smartbox.eco3.cl/ApiController/Login/CheckToken.php"
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
					GetMainLogin();
				}
    		}
		})
	  
	}
	
async function GetChecklistByZonaName( ZonaName)
	{
		var URL = "https://smartbox.eco3.cl/ApiController/Checklist/ChecklistGet.php"
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

async function GetUltimosRegistros(  )
	{

		var URL = "https://smartbox.eco3.cl/ApiController/RegistrosDiarios/UltimosRegistros.php"
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

		var URL = "https://smartbox.eco3.cl/ApiController/unidad/unidadGet.php"
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
		var URL = "https://smartbox.eco3.cl/ApiController/Checklist/ChecklistGet.php"
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
		var URL = "https://smartbox.eco3.cl/apiController/checklist/get.php"
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
		var URL = "https://smartbox.eco3.cl/apiController/eventos/get.php"
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
		var URL = "https://smartbox.eco3.cl/ApiController/zona/zonaGet.php"
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
		var URL = "https://smartbox.eco3.cl/ApiController/Cuarteles/CuartelesGet.php"
	
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
		
		var URL = "https://smartbox.eco3.cl/ApiController/ticket/ticketGet.php"
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
		
		var URL = "https://smartbox.eco3.cl/ApiController/ticket_status/ticket_statusGet.php"
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
		
		var URL = "https://smartbox.eco3.cl/ApiController/unidadtipo/Get.php"
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
		
		var URL = "https://smartbox.eco3.cl/ApiController/eventMessage/Get.php"
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
		
		var URL = "https://smartbox.eco3.cl/ApiController/eventMessageType/Get.php"
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

		var URL = "https://smartbox.eco3.cl/ApiController/RegistrosDiarios/RegistrosDiariosGet.php"
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

	var URL = "https://smartbox.eco3.cl/Apicontroller/Login/CheckToken.php";

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

	var URL = "https://smartbox.eco3.cl/ApiController/eventMessage/update.php";

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

	var minutesAgo = Math.floor((now - pastDate) / 60000) + 10;// 15 min mas que agregea la base de datos a la tabla unidades_lastortolas, se desconoce el porque.

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
   
function FieldBattery( level ) {
	  
	  		var ImgUrl;
			let levelParsed = parseInt(level);

			switch (true) {

			case levelParsed < 101 && levelParsed >= 80:
				// Code to execute if expression === value1
				ImgUrl = 'public/BatFull.jpg';
				break;
			case levelParsed < 80 && levelParsed >= 30:
				// Code to execute if expression === value2
				ImgUrl ='public/BatMedio.jpg';
				break;
			case levelParsed < 30 && levelParsed >= 10:
				// Code to execute if expression === value2
				ImgUrl= 'public/BatBajo.jpg'; 
				break;
			case levelParsed < 10 && levelParsed >= 1:
			// Code to execute if expression === value2
				ImgUrl = 'public/BatEmpty.jpg'; 
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