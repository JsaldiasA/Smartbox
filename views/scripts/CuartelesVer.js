
GetChecklistTable("1");
GetChecklistTable("2");
GetChecklistTable("3");
GetChecklistTable("4");
GetChecklistTable("5");
GetChecklistTableForEstanque("6");

async function GetTable( Id_zona )
	{

		var UltimosRegistros = await GetUltimosRegistros( );

		var Cuarteles = await GetCuartelesbyZonaId( Id_zona );
		
		let tableHTML = '<table class="table text-nowrap">thead><tr>';
		 tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
		 tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
		 tableHTML += `<th scope="col"></th>`;
		 tableHTML += `<th scope="col"></th>`;
		 tableHTML += `<th scope="col">[L/m]</th>`;
		 tableHTML += `<th scope="col">[L]</th>`;
		 tableHTML += `</thead>`;

		// Create table body rows
		Cuarteles.forEach(row => {

			if(row["Id_unidad"]!= null )
			{
				UltimosRegistros.forEach(rowUr => {
				
					if(row["Id_unidad"] == rowUr["unidad_id"])
					{
						tableHTML +='<tr>';
						tableHTML += `<td> ${row["Name"]}</td>`;
						tableHTML += `<td>${rowUr["DATETIME"]}</td>`;
						tableHTML += `<td>${rowUr["VOLTAJE"]}</td>`;
						tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
						tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
					}	
				
				})
					
			}
			else
			{
				tableHTML += '<tr class="bg-danger text-white">';
				tableHTML += `<td> ${row["Name"]}</td>`;
				tableHTML += `<td>Sin unidad</td>`;
				tableHTML += `<td></td>`;
				tableHTML += `<td></td>`;
				tableHTML += `<td></td>`;
			}	

			tableHTML += '</tr>';
		});

		tableHTML += '</tbody></table>';
		document.getElementById(Id_zona).innerHTML= tableHTML;

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

async function GetCuartelesbyZonaId( Id_zona )
	{
		var URL = "ApiController/Cuarteles/CuartelesGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{    
				Id_zona: Id_zona, 	
				returnJson: 1,
			},
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



