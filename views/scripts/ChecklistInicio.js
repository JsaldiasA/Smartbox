
GetChecklistTable("Z3", 1);
GetChecklistTable("Z2", 1);
GetChecklistTable("Z1", 1);
GetChecklistTable("Z4", 1);
GetChecklistTable("FASE2",1);
GetChecklistTable("Estanques",1);

function GetChecklistTable( ZonaName, returnJson )
	{

		var checklists = (async () => {
 			 await GetChecklist(ZonaName, returnJson);
		})();

		var tickets = (async () => {
  		await GetTicket();
		})();
		
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

			tickets.forEach(rowTk => {
				if(row["Checklist"]["id_unidad"] == rowTk["Id_unidad"])
				{
					hasTicket = '1';
				}	
			})

			tableHTML += '<tr>';
			tableHTML +=`<td>${row["Checklist"]["Id"]}</td>`;
		 	tableHTML += `<td>${row["UnidadName"]}</td>`;
		 	tableHTML += `<td>${row["Checklist"]["Fecha"]}</td>`;
			tableHTML += `<td>${row["Checklist"]["Solenoide"]}</td>`;
			tableHTML += `<td>${row["Checklist"]["Flujometro"]}</td>`;
			tableHTML += `<td>${row["Checklist"]["agua"]}</td>`;
			tableHTML += `<td>${row["Checklist"]["ConduitChoco"]}</td>`;
			tableHTML += `<td>${hasTicket}</td>`;

			tableHTML += '</tr>';
		});

		tableHTML += '</tbody></table>';
		document.getElementById("mainChecklist"+ZonaName).innerHTML= tableHTML;

	}

async function GetChecklist( ZonaName, returnJson )
	{
		var URL = "ApiController/Checklist/ChecklistGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'text',
			data:				
			{     		
				Zona: ZonaName,
				returnJson: returnJson,
			},
			
		    success: function(result){

				return JSON.parse(result);

			}
		});
		

	}

async function GetTicket( )
	{
		
		var URL = "ApiController/ticket/ticketGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			
		    success: function(result){

				return  JSON.parse(result);

			}
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



