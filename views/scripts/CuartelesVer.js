
GetMain();
var myRefreshMain = setInterval(GetMain, 5000);

async function GetMain(  )
	{

		var UltimosRegistros = await GetUltimosRegistros( );

		var Zonas =await GetZonas();

		var Cuarteles = await GetCuarteles( );

		var Unidades = await GetUnidades( );

		let tableHTML = '<div class="container">';
		Zonas.forEach(rowZona => {

		 tableHTML += '	<div class="row pb-3">';
        tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
        tableHTML += `    <h2><b>${rowZona["Name"]}</b></h2> `;
        tableHTML += '   <div class="overflow-auto">';
               
		 tableHTML += '<table class="table text-nowrap"><thead><tr>';
		 tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
		 tableHTML += `<th scope="col"><i class="bi bi-motherboard"></i></i></th>`;
		 tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
		 tableHTML += `<th scope="col"></th>`;
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
							tableHTML += `<td>${rowUr["DATETIME"]}</td>`;
							tableHTML += `<td>${rowUr["VOLTAJE"]}%</td>`;
							tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
							tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
						}	
					
					})

					if(!HasRegistrio)
					{
						tableHTML += '<tr >';
						tableHTML += `<td> ${row["Name"]}</td>`;
						tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
						tableHTML += `<td>Sin Registros</td>`;
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
		tableHTML += '</div>'; // container
		document.getElementById('main').innerHTML= tableHTML;

	}


async function GetUltimosRegistros(  )
	{

		var URL = "ApiController/RegistrosDiarios/UltimosRegistros.php"
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

		var URL = "ApiController/unidad/unidadGet.php"
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
		var URL = "ApiController/Checklist/ChecklistGet.php"
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
		var URL = "ApiController/zona/zonaGet.php"
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
		var URL = "ApiController/Cuarteles/CuartelesGet.php"
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
		
		var URL = "ApiController/ticket/ticketGet.php"
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



