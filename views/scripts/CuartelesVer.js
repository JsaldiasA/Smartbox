
GetMain();

var myRefreshMain = setInterval(GetMain, 5000);

async function GetMain(  )
	{

		let [UltimosRegistros, Zonas, Cuarteles, Unidades] = await Promise.all([GetUltimosRegistros(), GetZonas(),GetCuarteles(),GetUnidades()]);

		var e = document.getElementById("filtro");
		var filtroValue = e.options[e.selectedIndex].value;  

		let tableHTML = '';
		
		switch ( filtroValue ) 
		{
		case 'all':

			Zonas.forEach(rowZona => {

			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `    <h2><b>${rowZona["Name"]}</b></h2> `;
			tableHTML += '   <div class="overflow-auto">';
				
			tableHTML += '<table class="table text-nowrap"><thead><tr>';
			tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-motherboard"></i></i></th>`;
			tableHTML += `<th scope="col"></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-lightning-fill"></i></th>`;
			tableHTML += `<th scope="col">[L/m]</th>`;
			tableHTML += `<th scope="col">[L]</th>`;
			tableHTML += `</thead>`;

			// Create table body rows
			Cuarteles.forEach(row => {

				if(row["Id_zona"] == rowZona["Id"])
				{

					if(row["Id_unidad"]!= null )
					{   
						
						let HasRegistrio = false;
						let UnidadSerie = '';
						let UnidadTag = ''; 

						Unidades.forEach(rowUnidades => {
							if(row["Id_unidad"] == rowUnidades["Id"])
							{
									UnidadSerie = rowUnidades["Serie"];
									UnidadTag = rowUnidades["tag"];
									id_unidadTipo = rowUnidades["id_unidadTipo"];
							}

						});	

							UltimosRegistros.forEach(rowUr => {
							
								if(row["Id_unidad"] == rowUr["unidad_id"])
								{
									HasRegistrio=true;


									tableHTML +='<tr>';
									tableHTML += `<td> ${row["Name"]}</td>`;
									tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
									tableHTML += `<td>${rowUr["ESTADO"]}</td>`;
									tableHTML += `<td>${FieldActivity(rowUr["DATETIME"])}</td>`;
									tableHTML += `<td>${FieldBattery(rowUr["VOLTAJE"])}</td>`;
									tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
									tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
								}	
							
							})

							if(!HasRegistrio)
							{
								tableHTML += '<tr >';
								tableHTML += `<td> ${row["Name"]}</td>`;
								tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
								tableHTML += `<td>Milesight</td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
							}
								
					}
					else
					{
						tableHTML += '<tr class="bg-danger text-white">';
						tableHTML += `<td> ${row["Name"]}</td>`;
						tableHTML += `<td>Sin Dispositivo</td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
					}

					tableHTML += '</tr>';
				}

			});

			tableHTML += '</tbody></table>';
			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row
			
			});
			break;

		case 'sirecor':
			
			tableHTML+= GetUnidadesTableById_unidadTipo('1','Estanques',Cuarteles,Unidades,UltimosRegistros);
			tableHTML+= GetUnidadesTableById_unidadTipo('2','Sirecor',Cuarteles,Unidades,UltimosRegistros);

			break;
		case 'Milesight':
			
			tableHTML+= GetUnidadesTableById_unidadTipo('3','Milesight',Cuarteles,Unidades,UltimosRegistros);

			break;	
		default:
			// Code to execute if no match is found
		}

		document.getElementById('main').innerHTML= tableHTML;

	}

function GetUnidadesTableById_unidadTipo( unidadTipo ,Titulo ,Cuarteles,Unidades,UltimosRegistros  )
	{
			let tableHTML = '';

			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `    <h2><b>${Titulo}</b></h2> `;
			tableHTML += '   <div class="overflow-auto">';
				
			tableHTML += '<table class="table text-nowrap"><thead><tr>';
			tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-motherboard"></i></i></th>`;
			tableHTML += `<th scope="col"></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-lightning-fill"></i></th>`;
			tableHTML += `<th scope="col">[L/m]</th>`;
			tableHTML += `<th scope="col">[L]</th>`;
			tableHTML += `</thead>`;

			// Create table body rows
			Cuarteles.forEach(row => {

					if(row["Id_unidad"]!= null )
					{   
						
						let HasRegistrio = false;
						let UnidadSerie = '';
						let UnidadTag = ''; 

						Unidades.forEach(rowUnidades => {
							if(row["Id_unidad"] == rowUnidades["Id"])
							{
									UnidadSerie = rowUnidades["Serie"];
									UnidadTag = rowUnidades["tag"];
									id_unidadTipo = rowUnidades["id_unidadTipo"];
							}

						});	

						if(id_unidadTipo == unidadTipo)
						{	
							UltimosRegistros.forEach(rowUr => {
							
								if(row["Id_unidad"] == rowUr["unidad_id"])
								{
									HasRegistrio=true;


									tableHTML +='<tr>';
									tableHTML += `<td> ${row["Name"]}</td>`;
									tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
									tableHTML += `<td>${rowUr["ESTADO"]}</td>`;
									tableHTML += `<td>${FieldActivity(rowUr["DATETIME"])}</td>`;
									tableHTML += `<td>${FieldBattery(rowUr["VOLTAJE"])}</td>`;
									tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
									tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
								}	
							
							})

							if(!HasRegistrio)
							{
								tableHTML += '<tr >';
								tableHTML += `<td> ${row["Name"]}</td>`;
								tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
								tableHTML += `<td>Milesight</td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
							}
						}	
					}
					else
					{
						tableHTML += '<tr class="bg-danger text-white">';
						tableHTML += `<td> ${row["Name"]}</td>`;
						tableHTML += `<td>Sin Dispositivo</td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
					}

					tableHTML += '</tr>';
				

			});

			tableHTML += '</tbody></table>';
			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row

		return tableHTML;
	}


async function GetUltimosRegistros(  )
	{

		var URL = "../ApiController/RegistrosDiarios/UltimosRegistros.php"
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

		var URL = "../ApiController/unidad/unidadGet.php"
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
		var URL = "../ApiController/Checklist/ChecklistGet.php"
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
		var URL = "../ApiController/zona/zonaGet.php"
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
		var URL = "../ApiController/Cuarteles/CuartelesGet.php"
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
		
		var URL = "../ApiController/ticket/ticketGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'json',

		}).then(function(response){
      console.log("getRecord response: "+JSON.stringify(response));
      return response;
  	  });

	}


	
function jsonToHtmlTable(data) {
    if (!Array.isArray(data) || data.length === 0) {
        return "<p>No data to display.</p>";
    }

    // Extract column headers from the first object's keys
    const columns = Object.keys(data[0]);

    let tableHTML = '<table class="my-table"><thead><tr>';

    // Create table header row
    columns.forEach(col => {
        tableHTML += `<th>${col}</th>`;
    });
    tableHTML += '</tr></thead><tbody>';

    // Create table body rows
    data.forEach(row => {
        tableHTML += '<tr>';
        columns.forEach(col => {
            // Use a value or an empty string if null/undefined
            const value = row[col] !== null && row[col] !== undefined ? row[col] : "";
            tableHTML += `<td>${value}</td>`;
        });
        tableHTML += '</tr>';
    });

    tableHTML += '</tbody></table>';

    return tableHTML;
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
				ImgUrl = '/images/BatFull.jpg';
				break;
			case levelParsed < 80 && levelParsed >= 30:
				// Code to execute if expression === value2
				ImgUrl ='/images/BatMedio.jpg';
				break;
			case levelParsed < 30 && levelParsed >= 10:
				// Code to execute if expression === value2
				ImgUrl= '/images/BatBajo.jpg'; 
				break;
			case levelParsed < 10 && levelParsed >= 1:
			// Code to execute if expression === value2
				ImgUrl = '/images/BatEmpty.jpg'; 
				break;
			default:
				// Code to execute if expression matches no cases
				return 'NULL';
			}

			return '<div  class="d-inline" >'+level+'%</div><img  src="'+ImgUrl+'" width="30" height="20">';

  
   
}


