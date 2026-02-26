
GetTableTableEstadoGeneral();
GetChecklistTables();


async function GetChecklistTables( )
	{

		let [checklists, Zonas, tickets, cuarteles] = await Promise.all([GetChecklists(), GetZonas(),GetTicket(),GetCuarteles()]);

		
		let tableHTML = '';



		Zonas.forEach(rowZona => {
			
			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `    <h2><b>${rowZona["Name"]}</b></h2> `;
			tableHTML += '   <div class="overflow-auto">';
			if(rowZona["Name"] != "Estanques")
			{
				tableHTML += '<table class="table"><thead><tr>';
				tableHTML += `<th>Ubicacion</th>`;
				tableHTML += `<th>Fecha</th>`;
				tableHTML += `<th>Sole</th>`;
				tableHTML += `<th>Flujo</th>`;
				tableHTML += `<th>Test agua</th>`;
				tableHTML += `<th>Condui Chocko</th>`;
				tableHTML += `<th>sin ticket</th>`;
			}
			else
			{
						tableHTML += '<table class="table"><thead><tr>';
				tableHTML += `<th>Ubicacion</th>`;
				tableHTML += `<th>Fecha</th>`;
				tableHTML += `<th>sin ticket</th>`;
			}
		
			// Create table body rows
			cuarteles.forEach(rowCT => {

				if( rowCT["Id_zona"] == rowZona["Id"])
				{
					if(rowZona["Name"] == "Estanques")
					{
			
						// Create table body rows

						let Checklist;

						checklists.forEach(rowCL => {
							
							if(rowCL["Checklist"] != null)
							{
								if(rowCL["Checklist"]["id_unidad"] == rowCT["Id_unidad"] )
								{
									Checklist = rowCL["Checklist"];
								}
							}	
					
						});
							let hasTicket = '0';
							let badChecklist = true;
						
							
							if(Checklist != null )
							{
								tickets.forEach(rowTk => {
								
									if(Checklist["id_unidad"] == rowTk["Id_unidad"])
									{
										hasTicket = '1';
									}	
								
								})

								if( hasTicket == '0' )
								{
									badChecklist = false;
								}
								
							
								tableHTML += badChecklist ?'<tr class="bg-danger text-white" >' :'<tr>';
								tableHTML += `<td><a href='unidadverCheckList.php?CheckList_Id=${Checklist["Id"]}'>${rowCT["Name"]}</a></td>`;
								tableHTML += `<td>${Checklist["Fecha"]}</td>`;
								tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
							}
							else
							{
								tableHTML += '<tr class="bg-danger text-white">';
								tableHTML +=`<td></td>`;
								tableHTML += `<td>${rowCT["Name"]}</td>`;
								tableHTML += `<td>Sin checklist</td>`;
								tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
							}	

							tableHTML += '</tr>';
							
						

					}	
					else
					{

					
						// Create table body rows

						let Checklist;

						checklists.forEach(rowCL => {
							
							if(rowCL["Checklist"] != null)
							{
								if(rowCL["Checklist"]["id_unidad"] == rowCT["Id_unidad"] )
								{
									Checklist = rowCL["Checklist"];
								}
							}	
					
						});
	

						let hasTicket = '0';
						let badChecklist = true;

						if(Checklist != null )
						{
							tickets.forEach(rowTk => {
							
								if(Checklist["id_unidad"] == rowTk["Id_unidad"])
								{
									hasTicket = '1';
								}	
						
							})

							if( hasTicket== '0' && Checklist["Solenoide"] == '1'  && Checklist["Solenoide"] == '1'  && Checklist["Flujometro"] == '1'  && Checklist["agua"] == '1'  && Checklist["ConduitChoco"] == '1' )
							{
								badChecklist = false;
							}
							
							tableHTML += badChecklist ?'<tr class="bg-danger text-white" >' :'<tr>';
							tableHTML += `<td><a href='unidadverCheckList.php?CheckList_Id=${Checklist["Id"]}'>${rowCT["Name"]}</a></td>`;
							tableHTML += `<td>${Checklist["Fecha"]}</td>`;
							tableHTML += `<td>${Checklist["Solenoide"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' } </td>`;
							tableHTML += `<td>${Checklist["Flujometro"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
							tableHTML += `<td>${Checklist["agua"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
							tableHTML += `<td>${Checklist["ConduitChoco"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
							tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						}
						else
						{
							tableHTML += '<tr class="bg-danger text-white">';
							tableHTML += `<td>${rowCT["Name"]}</td>`;
							tableHTML += `<td>Sin checklist</td>`;
							tableHTML += `<td></td>`;
							tableHTML += `<td></td>`;
							tableHTML += `<td></td>`;
							tableHTML += `<td></td>`;
							tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
						}	

						tableHTML += '</tr>';
							
					

					}

					
				}
			
			
				
			});

			tableHTML += '</tbody></table>';
			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row

		});
		document.getElementById("mainChecklist").innerHTML= tableHTML;

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


async function GetChecklistTableForEstanque( ZonaName )
	{

		var checklists = await GetChecklistByZonaName( ZonaName );

		var tickets = await GetTicket();
		
		
		let tableHTML = '<table class="table"><thead><tr>';
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
				tableHTML += `<td><a href='unidadverCheckList.php?CheckList_Id=${row["Checklist"]["Id"]}'>${row["Unidad"]["Ubicacion"]}</a></td>`;
				tableHTML += `<td>${row["Checklist"]["Fecha"]}</td>`;
				tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
			}
			else
			{
				tableHTML += '<tr class="bg-danger text-white">';
				tableHTML +=`<td></td>`;
				tableHTML += `<td>${["Unidad"]["Ubicacion"]}</td>`;
				tableHTML += `<td>Sin checklist</td>`;
				tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
			}	

			tableHTML += '</tr>';
		});

		tableHTML += '</tbody></table>';
		document.getElementById("mainChecklist"+ZonaName).innerHTML= tableHTML;

	}
	
async function CountUnidadesOK( )
	{

		var checklists = await GetChecklists( );

		var tickets = await GetTicket();
		
		var Estanqueschecklists = await GetChecklistByZonaName( 'Estanques' );
		var Count = 0;

		checklists.forEach(row => {

			let hasTicket = '0';

			if(row["Checklist"]!= null )
			{
				tickets.forEach(rowTk => {
				
					if(row["Checklist"]["id_unidad"] == rowTk["Id_unidad"])
					{
						hasTicket = '1';
					}	
		
				})

				if(  hasTicket== '0' && row["Checklist"]["Solenoide"] == '1'  && row["Checklist"]["Solenoide"] == '1'  && row["Checklist"]["Flujometro"] == '1'  && row["Checklist"]["agua"] == '1'  && row["Checklist"]["ConduitChoco"] == '1' )
				{
					Count ++; 
				}
				
			}
		
		});


		Estanqueschecklists.forEach(row => {

			let hasTicket = '0';

			if(row["Checklist"]!= null )
			{
				tickets.forEach(rowTk => {
				
					if(row["Checklist"]["id_unidad"] == rowTk["Id_unidad"])
					{
						hasTicket = '1';
					}	
		
				})

				if(  hasTicket== '0' )
				{
					Count ++; 
				}
				
			}
		
		});

		return Count; 
	}	

	async function GetTableTableEstadoGeneral()
	{	
		
		var Operativas = await CountUnidadesOK();
		var total = 122;
		var operatibilidad = Math.round( (Operativas/total)*100 );

		var ColorOperatibilidar = operatibilidad > 80 ? "text-success" : ( operatibilidad > 60 ? ("text-warning") : ("text-danger") )

	   	let tableHTML = '	<table class="table" ><thead>';
        tableHTML += `<tr>`    	;
        tableHTML += `<th scope="col">Total</th>`  	;
        tableHTML += `<th scope="col">Operativas</th>`       ;
        tableHTML += `<th scope="col">Operatibilidad</th>`        ;
        tableHTML += `</tr>`        ;
        tableHTML += `</thead><tbody>`        ;
        tableHTML += `<tr>`        ;
        tableHTML += `<td><b> ${total} </b></td>`        ;
        tableHTML += `<td><b> ${Operativas} </b></td>`        ;
        tableHTML += `<td class="${ColorOperatibilidar}"><b> ${operatibilidad} %</b></td>`        ;
        tableHTML += `</tr></tbody></table>`        ;
		
		document.getElementById("TableEstadoGeneral").innerHTML= tableHTML;
	}	


async function GetChecklistByZonaName( ZonaName)
	{
		var URL = "ApiController/Checklist/ChecklistGet.php"
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