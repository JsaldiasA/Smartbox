
GetChecklistTable("Z3", 0);
GetChecklistTable("Z2", 0);
GetChecklistTable("Z1", 0);
GetChecklistTable("Z4", 0);
GetChecklistTable("FASE2",0);
GetChecklistTable("Estanques",1);

function GetChecklistTable( ZonaName, returnJson )
	{
    	var URL = "ApiController/Checklist/ChecklistGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			data:				
			{     		
				Zona: ZonaName,
				returnJson: returnJson,
			},
			
		    success: function(result){

				if( returnJson )
				{
					parsedJson = JSON.parse(result);
					let tableHTML = '<table class="table"><thead><tr>';
					 tableHTML += `<th>Id</th>`;
					 tableHTML += `<th>Ubicacion</th>`;
					 tableHTML += `<th>Fecha</th>`;
					 tableHTML += '</tr></thead><tbody>';
					// Create table body rows
					parsedJson.forEach(row => {
						tableHTML += '<tr>';
						 tableHTML +=`<td>${row["Checklist"]["Id"]}</td>`;
					 	tableHTML += `<td>${row["UnidadName"]}</td>`;
					 	tableHTML += `<td>${row["Checklist"]["Fecha"]}</td>`;
						tableHTML += '</tr>';
					});

					tableHTML += '</tbody></table>';

					document.getElementById("mainChecklist"+ZonaName).innerHTML= tableHTML;
				}
				else
				{
					document.getElementById("mainChecklist"+ZonaName).innerHTML= result;
				}
		
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



