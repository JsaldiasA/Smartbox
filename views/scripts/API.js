//checkToken();

function checkToken()
	{
    	var URL = "https://smartbox.eco3.cl/ApiController/Login/CheckToken.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    statusCode: {
				200: function() {
					console.log("Success: 200 OK");
				},
				404: function(result) {
					console.log("Error: 404 Not Found - The PHP file was not found at this URL.");
					window.location.href = "https://smartbox.eco3.cl/";
				}
    		}
		});	
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });
		

	}	

async function GetCuarteles( )
	{
		var URL = "https://smartbox.eco3.cl/ApiController/Cuarteles/CuartelesGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
		}).then(function(response){
      console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });
		

	}		

async function GetTicket( )
	{
		
		var URL = "https://smartbox.eco3.cl/ApiController/ticket/ticketGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      console.log("getRecord response: "+JSON.stringify(response));
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
      	console.log("getRecord response: "+JSON.stringify(response));
      	return response;
  	  	});

	}	

	

	function FieldActivity( date ) {

	var pastDate = new Date(date);
	var now = new Date(new Date().toLocaleString('en', {timeZone: 'America/Santiago'}))

	var minutesAgo = Math.floor((now - pastDate) / 60000) + 15;// 15 min mas que agregea la base de datos a la tabla unidades_lastortolas, se desconoce el porque.

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

function FieldBattery( level ) {
	  
	  		var ImgUrl;
			let levelParsed = parseInt(level);

			switch (true) {

			case levelParsed < 101 && levelParsed >= 80:
				// Code to execute if expression === value1
				ImgUrl = 'images/BatFull.jpg';
				break;
			case levelParsed < 80 && levelParsed >= 30:
				// Code to execute if expression === value2
				ImgUrl ='images/BatMedio.jpg';
				break;
			case levelParsed < 30 && levelParsed >= 10:
				// Code to execute if expression === value2
				ImgUrl= 'images/BatBajo.jpg'; 
				break;
			case levelParsed < 10 && levelParsed >= 1:
			// Code to execute if expression === value2
				ImgUrl = 'images/BatEmpty.jpg'; 
				break;
			default:
				// Code to execute if expression matches no cases
				return 'NULL';
			}

			return '<div  class="d-inline" >'+level+'%</div><img  src="'+ImgUrl+'" width="30" height="20">';
   
}





