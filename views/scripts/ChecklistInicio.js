
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
						
							tickets.forEach(rowTk => {
								if( rowTk["Id_TicketStatus"] == '1' )
								{
									if(rowCT["Id_unidad"] == rowTk["Id_unidad"])
									{
										hasTicket = '1';
									}
								}	
																						
							})

							if(Checklist != null )
							{
	
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

						tickets.forEach(rowTk => {
						
							if( rowTk["Id_TicketStatus"] == '1' )
							{
								if(rowCT["Id_unidad"] == rowTk["Id_unidad"])
								{
									hasTicket = '1';
								}
							}	
									
						})

						if(Checklist != null )
						{
						

							if( hasTicket== '0' && Checklist["Solenoide"] == '1'  && Checklist["Solenoide"] == '1'  && Checklist["Flujometro"] == '1'  && Checklist["agua"] == '1' )
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
							tableHTML += `<td>${rowCT["Id_unidad"] == null ? 'Sin Unidad' : 'Sin Checklist'}</td>`;
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
	
 function CountUnidadesOK( Id_zona, checklists,Cuarteles, tickets, Estanqueschecklists)
	{

	
		var Count = 0;

			checklists.forEach(row => {

				let hasTicket = '0';

				if(row["Checklist"]!= null )
				{
					tickets.forEach(rowTk => {
					
						if( rowTk["Id_TicketStatus"] == '1' )
						{					
							if(row["Checklist"]["id_unidad"] == rowTk["Id_unidad"])
							{
								hasTicket = '1';
							}	
						}
			
					})

					if(  hasTicket== '0' && row["Checklist"]["Solenoide"] == '1'  && row["Checklist"]["Solenoide"] == '1'  && row["Checklist"]["Flujometro"] == '1'  && row["Checklist"]["agua"] == '1'  )
					{
						if( Id_zona )
						{
							Cuarteles.forEach(rowCT => {
						
								if(row["Checklist"]["id_unidad"] == rowCT["Id_unidad"])
								{
									if( rowCT["Id_zona"] == Id_zona)
									{
										Count ++; 
									}
								}	
								
							})

						}
						else
						{
							Count ++;
						}		
						
					}
					
				}
		
			});

			if( !Id_zona )
			{
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
			}

		return Count; 
	}	

	 function CountUnidades( Id_zona ,Cuarteles)
	{

		var Count = 0;

		Cuarteles.forEach(rowCT => {
			if( Id_zona )
			{
				if( rowCT["Id_zona"] == Id_zona)
				{
					Count ++; 
				}								
			}
			else
			{
				Count ++;
			}						
		});
			
		return Count; 
	}	

	function ColorOperatibilidar( operatibilidad )
	{
		return operatibilidad > 80 ? "text-success" : ( operatibilidad > 60 ? ("text-warning") : ("text-danger") );
	}

	async function GetTableTableEstadoGeneral()
	{	
		
		let [Zonas,checklists,Cuarteles, tickets, Estanqueschecklists] = await Promise.all([GetZonas(),GetChecklists(), GetCuarteles(),GetTicket(),GetChecklistByZonaName( 'Estanques' )]);


		var Operativas = await CountUnidadesOK(null,checklists,Cuarteles, tickets, Estanqueschecklists);
		var total = await CountUnidades(null,Cuarteles);

		var operatibilidad = Math.round( (Operativas/total)*100 );

		var Color = ColorOperatibilidar( operatibilidad );

		let tableHTML = `<br><h2>Total</h2><br>`        ;
	   	 tableHTML += '	<table class="table" ><thead>';
        tableHTML += `<tr>`    	;
        tableHTML += `<th scope="col">Total</th>`  	;
        tableHTML += `<th scope="col">Operativas</th>`       ;
        tableHTML += `<th scope="col">Operatibilidad</th>`        ;
        tableHTML += `</tr>`        ;
        tableHTML += `</thead><tbody>`        ;
        tableHTML += `<tr>`        ;
        tableHTML += `<td><b> ${total} </b></td>`        ;
        tableHTML += `<td><b> ${Operativas} </b></td>`        ;
        tableHTML += `<td class="${Color}"><b> ${operatibilidad} %</b></td>`        ;
        tableHTML += `</tr></tbody></table>`        ;

		tableHTML += `<br><h2> Detalle Por zona </h2><br>`        ;

		tableHTML += '	<table class="table" ><thead>';
		tableHTML += `<tr>`    	;
		tableHTML += `<th scope="col">Zona</th>`  	;
        tableHTML += `<th scope="col">Total</th>`  	;
        tableHTML += `<th scope="col">Operativas</th>`       ;
        tableHTML += `<th scope="col">Operatibilidad</th>`        ;
        tableHTML += `</tr>`        ;
        tableHTML += `</thead><tbody>`        ;



		Zonas.forEach(rowZ => {
			
			Operativas = CountUnidadesOK(rowZ["Id"],checklists,Cuarteles, tickets, Estanqueschecklists);
			total = CountUnidades(rowZ["Id"],Cuarteles);
			operatibilidad = Math.round( (Operativas/total)*100 );
			Color = ColorOperatibilidar( operatibilidad );

			 tableHTML += `<tr>`        ;
			tableHTML += `<td><b> ${rowZ["Name"]}  </b></td>`        ;
        	tableHTML += `<td><b> ${total} </b></td>`        ;
        	tableHTML += `<td><b> ${Operativas} </b></td>`        ;
        	tableHTML += `<td class="${Color}"><b> ${operatibilidad} %</b></td>`        ;

			
		});
       

        tableHTML += `</tr>`;
		tableHTML += `</tbody></table>`;

		
		document.getElementById("TableEstadoGeneral").innerHTML= tableHTML;
	}	












	
