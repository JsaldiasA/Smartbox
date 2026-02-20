
GetChecklistTable("Z3", 1);
GetChecklistTable("Z2", 1);
GetChecklistTable("Z1", 1);
GetChecklistTable("Z4", 1);
GetChecklistTable("FASE2",1);
GetChecklistTableForEstanque("Estanques",1);

async function GetChecklistTable( ZonaName, returnJson )
	{

		var checklists = await GetChecklist(ZonaName, returnJson);

		var tickets = await GetTicket();
		
		
		let tableHTML = '<table class="table"><thead><tr>';
		 tableHTML += `<th>Id</th>`;
		 tableHTML += `<th>Ubicacion</th>`;
		 tableHTML += `<th>Fecha</th>`;
		 tableHTML += `<th>Sole</th>`;
		 tableHTML += `<th>Flujo</th>`;
		 tableHTML += `<th>Test agua</th>`;
		 tableHTML += `<th>Condui Chocko</th>`;
		 tableHTML += `<th>sin ticket</th>`;
		// Create table body rows
		checklists.forEach(row => {

			let hasTicket = '0';
			let badChecklist = true;

			if(row["Checklist"]!= null )
			{
				tickets.forEach(rowTk => {
				
					if(row["Checklist"]["id_unidad"] == rowTk["Id_unidad"])
					{
						hasTicket = '1';
					}	
				
				})

				if( hasTicket== '0' && row["Checklist"]["Solenoide"] == '1'  && row["Checklist"]["Solenoide"] == '1'  && row["Checklist"]["Flujometro"] == '1'  && row["Checklist"]["agua"] == '1'  && row["Checklist"]["ConduitChoco"] == '1' )
				{
					 badChecklist = false;
				}
				
				<i class="bi bi-check-circle"></i>

				tableHTML += badChecklist ?'<tr class="bg-danger text-white" >' :'<tr>';
				tableHTML +=`<td>${row["Checklist"]["Id"]}</td>`;
				tableHTML += `<td>${row["Unidad"]["Ubicacion"]}</td>`;
				tableHTML += `<td>${row["Checklist"]["Fecha"]}</td>`;
				tableHTML += `<td>${row["Checklist"]["Solenoide"] == '1' ? '<i class="bi bi-check-circle"></i>' : <i class="bi bi-x-circle"></i> } </td>`;
				tableHTML += `<td>${row["Checklist"]["Flujometro"] == '1' ? '<i class="bi bi-check-circle"></i>' : <i class="bi bi-x-circle"></i> }</td>`;
				tableHTML += `<td>${row["Checklist"]["agua"] == '1' ? '<i class="bi bi-check-circle"></i>' : <i class="bi bi-x-circle"></i> }</td>`;
				tableHTML += `<td>${row["Checklist"]["ConduitChoco"] == '1' ? '<i class="bi bi-check-circle"></i>' : <i class="bi bi-x-circle"></i> }</td>`;
				tableHTML += `<td>${hasTicket ? '<i class="bi bi-check-circle"></i>' : <i class="bi bi-x-circle"></i> }</td>`;
			}
			else
			{
				tableHTML += '<tr class="bg-danger text-white">';
				tableHTML +=`<td></td>`;
				tableHTML += `<td>${row["Unidad"]["Ubicacion"]}</td>`;
				tableHTML += `<td>Sin checklist</td>`;
				tableHTML += `<td></td>`;
				tableHTML += `<td></td>`;
				tableHTML += `<td></td>`;
				tableHTML += `<td></td>`;
				tableHTML += `<td>${hasTicket ? '<i class="bi bi-check-circle"></i>' : <i class="bi bi-x-circle"></i>}</td>`;
			}	

			tableHTML += '</tr>';
		});

		tableHTML += '</tbody></table>';
		document.getElementById("mainChecklist"+ZonaName).innerHTML= tableHTML;

	}

async function GetChecklistTableForEstanque( ZonaName, returnJson )
	{

		var checklists = await GetChecklist(ZonaName, returnJson);

		var tickets = await GetTicket();
		
		
		let tableHTML = '<table class="table"><thead><tr>';
		 tableHTML += `<th>Id</th>`;
		 tableHTML += `<th>Ubicacion</th>`;
		 tableHTML += `<th>Fecha</th>`;
		 tableHTML += `<th>sin ticket</th>`;
		// Create table body rows
		checklists.forEach(row => {

			let hasTicket = '0';
			let badChecklist = true;

			if(row["Checklist"]!= null )
			{
				tickets.forEach(rowTk => {
				
					if(row["Checklist"]["id_unidad"] == rowTk["Id_unidad"])
					{
						hasTicket = '1';
					}	
				
				})

				if( hasTicket== '0' )
				{
					 badChecklist = false;
				}
				
				
				
				tableHTML += badChecklist ?'<tr class="bg-danger text-white" >' :'<tr>';
				tableHTML +=`<td>${row["Checklist"]["Id"]}</td>`;
				tableHTML += `<td>${row["Unidad"]["Ubicacion"]}</td>`;
				tableHTML += `<td>${row["Checklist"]["Fecha"]}</td>`;
				tableHTML += `<td>${hasTicket}</td>`;
			}
			else
			{
				tableHTML += '<tr class="bg-danger text-white">';
				tableHTML +=`<td></td>`;
				tableHTML += `<td>${["Unidad"]["Ubicacion"]}</td>`;
				tableHTML += `<td>Sin checklist</td>`;
				tableHTML += `<td>${hasTicket}</td>`;
			}	

			tableHTML += '</tr>';
		});

		tableHTML += '</tbody></table>';
		document.getElementById("mainChecklist"+ZonaName).innerHTML= tableHTML;

	}	

async function GetChecklist( ZonaName, returnJson )
	{
		var URL = "ApiController/Checklist/ChecklistGet.php"
		return $.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'json',
			data:				
			{     		
				Zona: ZonaName,
				returnJson: returnJson,
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



