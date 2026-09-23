class ChecklistPage extends Page
{
	constructor( )
	{
		super();

		this.dataTable;
		this.Titulo = 'Estado de los dispositivos';

		this.FilterOptions = [ 'all', 'No operativos', 'No marcan','Falta test agua'];

		this.SelectFiltro = document.createElement('select');
		this.SelectFiltro.className = 'form-select';
		this.SelectFiltro.id = 'filtroChecklist';
		this.FilterOptions.forEach(text => {

		const option = document.createElement('option');
		option.textContent = text;
		this.SelectFiltro.appendChild(option);

		});

		this.TituloRighElement.appendChild( this.SelectFiltro ) ;
	}

	async GetMain( )
	{
		super.GetMain();

		this.mainDiv.innerHTML +=`<div class="row pb-3">
			<div class="col p-3 card shadow p-3 card shadow">
				
					<div id="TableEstadoGeneral"></div>
			
			</div>
		 </div>
    
        <div id="mainChecklist"> ${GetLoadingPage()}</div>
		`;

		  this.DataTable = await this.GetPageData();	
		  await this.GetTableTableEstadoGeneral( this.DataTable );
		  await this.GetChecklistTables( this.DataTable );


		let filtro = document.getElementById('filtroChecklist');

		filtro.removeEventListener('change', ThisApp.ChecklistPage.HandleFilterChange);
		filtro.addEventListener('change',ThisApp.ChecklistPage.HandleFilterChange);
	}

	async HandleFilterChange()
	{
			document.getElementById('mainChecklist').innerHTML=GetLoadingPage();
		
			const newStatus = event.target.value;
			ThisApp.ChecklistPage.GetChecklistTables(ThisApp.ChecklistPage.DataTable,newStatus);
	}
	
async  GetPageData() {
	
		let DataTable = [] ;
		
		appModel.ChecklistsNew.sort((a, b) => Date.parse(a["Fecha"]) - Date.parse(b["Fecha"]) ); 
		appModel.Tickets.sort((a, b) => Date.parse(a["FechaInicio"]) - Date.parse(b["FechaInicio"]) ); 

			// fill datatable
			appModel.Cuarteles.forEach(rowCT => {

					let Checklist;
					let badChecklist = true;
					let Ticket;
					let unidad;
					let rowData;

					appModel.ChecklistsNew.forEach(rowCL => {	if(rowCL["id_unidad"] == rowCT["Id_unidad"] )	Checklist = rowCL;	});
					appModel.Tickets.forEach(rowTk => {	if(rowCT["Id_unidad"] == rowTk["Id_unidad"] &&  rowTk["Id_TicketStatus"] == '1' )	Ticket = rowTk;	});
					appModel.Unidades.forEach(u => {	if(rowCT["Id_unidad"] == u["Id"] )	unidad = u;	});

					rowData = new checklistTableRowData(rowCT, unidad,Checklist,Ticket);
					DataTable.push(rowData);	
			});

	return DataTable;
}

async  GetChecklistTables( DataTable, filtroValue )
	{
	
		let tableHTML = await this.renderChecklistTable(filtroValue?? 'all',DataTable);
		document.getElementById("mainChecklist").innerHTML= tableHTML;
	}
	
  CountUnidadesOK( Id_zona,ChecklistDataTable)
	{

		var Count = 0;
		let unidadesToCount = [];

		ChecklistDataTable.forEach( row => { 
			
			if( !Id_zona )	unidadesToCount=ChecklistDataTable;
			else
			{
				if( row.cuartel['Id_zona'] == Id_zona)	unidadesToCount.push(row);
			}				

		 })
		
		unidadesToCount.forEach( row => {
		
			let hasTicket = '0';
			if(row.ticket)
			{
				if(row.ticket["Id_TicketStatus"] == '1' && row.ticket["Id_TicketPriority"] == '1')
				{
					hasTicket = '1';
				}	
			}

			if( row.checklist != null )
			{
				if(row.unidad['id_unidadTipo'] == 1)// si es estanque
				{
					if(  hasTicket == '0' )
					{
						Count ++;			
					}
				}
				else
				{
					if(  hasTicket == '0' && row.checklist["Solenoide"] == '1' && row.checklist["Flujometro"] == '1'  && row.checklist["agua"] == '1'  )
					{
						Count ++;			
					}
				}		
			}

		});

		return Count; 
	}	

	  CountUnidades( Id_zona ,ChecklistDataTable)
	{
		var Count = 0;

		ChecklistDataTable.forEach(rowCT => {
			if( Id_zona )
			{
				if( rowCT.cuartel["Id_zona"] == Id_zona)
				{
					Count ++; 
				}								
			}
			else	Count ++;
						
		});
			
		return Count; 
	}	

	 ColorOperatibilidar( operatibilidad )
	{
		return operatibilidad > 80 ? "text-success" : ( operatibilidad > 60 ? ("text-warning") : ("text-danger") );
	}

	async  GetTableTableEstadoGeneral( DataTable)
	{	

		var Operativas = await this.CountUnidadesOK(null,DataTable);
		var total = await this.CountUnidades(null,DataTable);

		var operatibilidad = Math.round( (Operativas/total)*100 );

		var Color = this.ColorOperatibilidar( operatibilidad );

		let OperativasGrafico=Operativas;
		let totalGrafico=total;
		
		var tableHTML = '<div class="row p-3"><h1>Total</h1></div>';
	
		tableHTML += `<div class="row pb-3 justify-content-center"><div class="col-4"><canvas id="GraficoEstadoGeneral" width="400" height="100"></canvas></div></div>		`        ;
	   	
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

		tableHTML += `<div class="row p-3"><h1>Zonas</h1></div>`        ; 

		tableHTML += '	<table class="table" ><thead>';
        tableHTML += `<tr>`    	;
		tableHTML += `<th scope="col">Zona</th>`  	;
        tableHTML += `<th scope="col">Total</th>`  	;
        tableHTML += `<th scope="col">Operativas</th>`       ;
        tableHTML += `<th scope="col">Operatibilidad</th>`        ;
        tableHTML += `</tr>`        ;
        tableHTML += `</thead><tbody>`        ;

		appModel.Zonas.forEach( zona => { 
		
		Operativas =  this.CountUnidadesOK(zona.Id , DataTable);
		total =  this.CountUnidades(zona.Id , DataTable);

		operatibilidad = Math.round( (Operativas/total)*100 );

		Color = this.ColorOperatibilidar( operatibilidad );

        tableHTML += `<tr>`        ;
		 tableHTML += `<td> ${zona.Name} </td>`        ;
        tableHTML += `<td><b> ${total} </b></td>`        ;
        tableHTML += `<td><b> ${Operativas} </b></td>`        ;
        tableHTML += `<td class="${Color}"><b> ${operatibilidad} %</b></td>`        ;
		tableHTML += `</tr>`  

		});

        tableHTML += `</tbody></table>`        ; 


		document.getElementById("TableEstadoGeneral").innerHTML= tableHTML;



		const ctx = document.getElementById('GraficoEstadoGeneral');

			new Chart(ctx, {
				type: 'doughnut',
				data: {
				labels: ['Operativas', 'No operativas'],
				datasets: [{
					label: 'Unidades',
					data: [OperativasGrafico, (totalGrafico-OperativasGrafico)],
				}]
				}


			});
	}	
	

	async  ChecklistVerPage ( Id_Checklist )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	});	

		let tableHTML =``;
		let unidad;
		let Unidadtipo;
		let checklist;

		let [Tickets, TicketStatus, Cuarteles, Unidades,Tipos,ChecklistsNew] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles(),GetUnidades(),GetUnidaTipo(),GetChecklistsNew()]);
		

		ChecklistsNew.sort((a, b) => Date.parse(a["Fecha"]) - Date.parse(b["Fecha"]) ); 
		
		ChecklistsNew.forEach( ck => {	if(	ck['Id'] == Id_Checklist )	checklist=ck;	})

		Unidades.forEach( u => {	if( checklist["id_unidad"] == u['Id'] )	unidad = u ;	})
		
		tableHTML += `
	
	<div class="row p-3">
		${	GetVolverBtn('ThisApp.ChecklistPage.GetMain()')}
			${GetTitulo( `checklist de ${unidad["Serie"]}`)}
			${GetEditBtn(`ThisApp.ChecklistPage.EditChecklistPage(${checklist["Id"]})`)}
	</div>
	<div class="row">
		<div class="col m-3 p-3 border">
			<table class="table">
			<tbody>	
			<tr><td><b>Fecha:</b></td><td>${checklist["Fecha"]}</td><td></td></tr>
			
			<tr><td><b>Voltaje regulador de batería:</b></td><td>${checklist["VoltajeReguladorBat"]} </td><td>(V)</td></tr>
			<tr><td><b>Voltaje regulador de MCU:</b></td><td>${checklist["VoltajeReguladorMCU"]}</td><td>(V)</td></tr>
			<tr><td><b>Voltaje MCU:</b></td><td>${checklist["VoltajeMCU"]} </td><td>(V)</td></tr>

			<tr><td><b>Solenoide:</b></td><td>${checklist["Solenoide"]} </td><td></td></tr>
			<tr><td><b>Flujómetro:</b></td><td>${checklist["Flujometro"]} </td><td></td></tr>

			<tr><td><b>Voltaje de la batería:</b></td><td>${checklist["VoltajeBateria"]} </td><td>(V)</td></tr>
			<tr><td><b>Conduit y Choco:</b></td><td>${checklist["Flujometro"]} </td><td></td></tr>
			<tr><td><b>Probado con agua:</b></td><td>${checklist["agua"]} </td><td></td></tr>
			<tr><td><b>Observaciones:</b></td><td>${checklist["Observaciones"]} </td><td></td></tr>
			<tr><td><b>Técnico responsable:</b></td><td>${checklist["TecnicoResponsable"]} </td><td></td></tr>
			<tr><td><b>Imagen:</b></td><td class='col-4'><img src='${checklist["URL_foto"]}' class='img-thumbnail' > </td><td></td></tr>

			</tbody>
			</table>
		</div>
	</div>`;

		document.getElementById('main').innerHTML = tableHTML;

	}

async  EditChecklistPage ( Id_Checklist )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach( interval_ID => { clearInterval(interval_ID) });	

		let CheckList;

		let [Checklists] = await Promise.all([GetChecklistsNew()]);
		
		Checklists.forEach( c => { if( Id_Checklist == c['Id'] ) CheckList = c; });
		
		let tableHTML = `
		<div class="row p-3">
			${	GetVolverBtn('ThisApp.ChecklistPage.GetMain()')}
			${	GetTitulo(`Editar checklist  ${CheckList["Id"]}`)}
		</div>
		<div class="row">
			<div class="col m-3 p-3 border">
				<table class="table">
				<tbody>	
					<tr><td><b>Metodo de Prueba </b></td><td><select name="MetodosDePrueba" class="form-select" id="MetodosDePrueba" required=""></select></td><td></td></tr>	
					<tr><td><b>Prueba de agua:</b></td><td><input type="checkbox" class="form-check-input" id="agua" ></td><td></td></tr>
					<tr><td><b>Solenoide:</b></td><td><input type="checkbox" class="form-check-input" id="Solenoide" ></td><td></td></tr>
					<tr><td><b>Flujómetro:</b></td><td><input type="checkbox" class="form-check-input" id="Flujometro" value="${CheckList["Flujometro"]}"></td><td></td></tr>	
					<tr><td><b>Conduit y Choco:</b></td><td><input type="checkbox" class="form-check-input" id="ConduitChoco" value="${CheckList["ConduitChoco"]}"></td><td></td></tr>
					<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" value="${CheckList["Observaciones"]}"></td><td></td></tr>
				</tbody>
				</table>
			</div>
		</div>
		<div class="row">

			<div class="col m-3 p-3" >
				<button id="enviarChecklist"type="button" class="btn btn-success btn-lg" onclick="FunctionUpdateChecklistPost( ${CheckList["Id"]} ) ">Enviar CheckList</button>
			</div>
		</div>`;
		
		document.getElementById('main').innerHTML = tableHTML;

		// completando select html

		const selectMetodosDePrueba = document.getElementById('MetodosDePrueba');
		let MetodosDePrueba = GetMetodosDePrueba();

		MetodosDePrueba.forEach(row => {
		
		const NewOption = new Option(row["Name"], row["Id"]);
		selectMetodosDePrueba.add(NewOption);
		});

	}



async  renderChecklistTable(filtroValue,ChecklistDataTable)
{	
	let tableHTML='';
	

	switch ( filtroValue ) 
		{
		case 'all':
			
				let Zonas = appModel.Zonas;
				Zonas.sort((a, b) => a["Id"] - b["Id"] ); 

				tableHTML += '<div class="accordion" id="accordionPanelsStayOpenExample">';

				Zonas.forEach(rowZona => {

				tableHTML += `<div class="accordion-item">
				<h1 class="accordion-header" id="panelsStayOpen-heading${rowZona["Id"]}">
				<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse${rowZona["Id"]}" aria-expanded="true" aria-controls="panelsStayOpen-collapse${rowZona["Id"]}">
					<h2>${rowZona["Name"]}</h2>
				</button>
				</h1>	

				<div id="panelsStayOpen-collapse${rowZona["Id"]}" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading${rowZona["Id"]}">
      			<div class="accordion-body">`;
      
				tableHTML += '	<div class="row pb-3">';
				tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
				//tableHTML += `<h1><b>&nbsp;${rowZona["Name"]} </b> </h1>`;
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
					tableHTML += `<th>sin ticket</th></thead>`;
				}
				else
				{
					tableHTML += '<table class="table"><thead><tr>';
					tableHTML += `<th>Ubicacion</th>`;
					tableHTML += `<th>Fecha</th>`;
					tableHTML += `<th>sin ticket</th></thead>`;
				}
				// Create table body rows
				ChecklistDataTable.forEach(rowCT => {

					if( rowCT.cuartel["Id_zona"] == rowZona["Id"])
					{
						let badChecklist = true;
					
						if(rowZona["Name"] == "Estanques")
						{
							// Create table body rows
								if(rowCT.checklist != null )
								{
									let ColumnClassColor = 'class=""';

									if(rowCT.ticket){
										switch ( rowCT.ticket["Id_TicketPriority"] ) {
						
										case '1': ColumnClassColor = `class="table-danger" `; break;
										case '2': ColumnClassColor = `class="table-warning"`; break;									
										case '3': ColumnClassColor = `class="border border-warning border-5"`; break;
										default: ColumnClassColor = 'class=""';
										}
									} 
							
									tableHTML += `<tr ${ColumnClassColor} >` ;
									tableHTML += `<td><a href='url' onclick="ThisApp.ChecklistPage.ChecklistVerPage(${rowCT.checklist["Id"]});return false;" >${rowCT.cuartel["Name"]}</a></td>`;
									tableHTML += `<td>${rowCT.checklist["Fecha"]}</td>`;
									tableHTML += `<td>${rowCT.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
								}
								else
								{
									tableHTML += '<tr class="table-danger">';
									tableHTML +=`<td></td>`;
									tableHTML += `<td>${rowCT.cuartel["Name"]}</td>`;
									tableHTML += `<td>Sin checklist</td>`;
									tableHTML += `<td>${hasTicket  == '0' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
								}	

								tableHTML += '</tr>';
						}	
						else
						{				
							if(rowCT.checklist != null )
							{

								if( rowCT.checklist["Solenoide"] == '1'  && rowCT.checklist["Solenoide"] == '1'  && rowCT.checklist["Flujometro"] == '1'  && rowCT.checklist["agua"] == '1' )
								{
									badChecklist = false;
								}

								let ColumnClassColor = 'class=""';
								if(rowCT.ticket){
								switch ( rowCT.ticket["Id_TicketPriority"] ) {
						
										case '1': ColumnClassColor = `class="table-danger"`; break;
										case '2': ColumnClassColor = `class="table-warning"`; break;									
										case '3': ColumnClassColor = `class="border border-warning border-5"`; break;
										default: ColumnClassColor = 'class=""';
										}
								} 
						
								if(badChecklist)  ColumnClassColor = `class="table-danger"`;
																
								tableHTML += `<tr ${ColumnClassColor} >` ;
								tableHTML += `<td><a href='url'  onclick="ThisApp.ChecklistPage.ChecklistVerPage(${rowCT.checklist["Id"]});return false;" >${rowCT.cuartel["Name"]}</a></td>`;
								tableHTML += `<td>${rowCT.checklist["Fecha"]}</td>`;
								tableHTML += `<td>${rowCT.checklist["Solenoide"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' } </td>`;
								tableHTML += `<td>${rowCT.checklist["Flujometro"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
								tableHTML += `<td>${rowCT.checklist["agua"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
								tableHTML += `<td>${rowCT.checklist["ConduitChoco"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
								tableHTML += `<td>${rowCT.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
							}
							else
							{
								tableHTML += '<tr class="bg-danger text-white">';
								tableHTML += `<td>${rowCT.cuartel["Name"]}</td>`;
								tableHTML += `<td>${rowCT.cuartel["Id_unidad"] == null ? 'Sin Unidad' : 'Sin Checklist'}</td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td>${rowCT.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
							}	

							tableHTML += '</tr>';		
						}					
					}
							
				});

				tableHTML += '</tbody></table>';
				tableHTML += '	<table class="table" ><thead>';
				tableHTML += `<tr>`    	;
				tableHTML += `<th scope="col">Total</th>`  	;
				tableHTML += `<th scope="col">Operativas</th>`       ;
				tableHTML += `<th scope="col">Operatibilidad</th>`        ;
				tableHTML += `</tr>`        ;
				tableHTML += `</thead><tbody>`        ;
					
				let Operativas = this.CountUnidadesOK(rowZona["Id"],ChecklistDataTable);
				let total = this.CountUnidades(rowZona["Id"],ChecklistDataTable);
				let operatibilidad = Math.round( (Operativas/total)*100 );
				let Color = this.ColorOperatibilidar( operatibilidad );

				tableHTML += `<tr>`        ;
				tableHTML += `<td><b> ${total} </b></td>`        ;
				tableHTML += `<td><b> ${Operativas} </b></td>`        ;
				tableHTML += `<td class="${Color}"><b> ${operatibilidad} %</b></td>`        ;

				tableHTML += `</tr>`;
				tableHTML += `</tbody></table>`;

				tableHTML += '          </div>';// div overflow
				tableHTML += '    </div>      ';  // col
				tableHTML += '</div>'; // row

				tableHTML += '</div>'; // acordeonBody
				tableHTML += '</div>'; // panelsStayOpen-collapseOne
				tableHTML += '</div>'; // acordeonItem
			});
			tableHTML += '</div>'; // acordeon

			return tableHTML;

			case 'No operativos':
				
			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `  ${GetTitulo('No operativos')} `;
			tableHTML += '   <div class="overflow-auto">';
			
			tableHTML += '<table class="table"><thead><tr>';
			tableHTML += `<th>Ubicacion</th>`;
			tableHTML += `<th>Fecha</th>`;
			tableHTML += `<th>Sole</th>`;
			tableHTML += `<th>Flujo</th>`;
			tableHTML += `<th>Test agua</th>`;
			tableHTML += `<th>Condui Chocko</th>`;
			tableHTML += `<th>sin ticket</th></tr>`;
			tableHTML += `</thead><tbody>`        ;

			ChecklistDataTable.forEach(row => {
				if(row.checklist && row.ticket ){
				
					if(row.ticket['Id_TicketPriority'] == 1)	{

						tableHTML += `<tr class="bg-danger text-white">`        ;	
						tableHTML += `<td><a href='url'  onclick="ThisApp.ChecklistPage.ChecklistVerPage(${row.checklist["Id"]});return false;" >${row.cuartel["Name"]}</a></td>`;
						tableHTML += `<td>${row.checklist["Fecha"]}</td>`;
						tableHTML += `<td>${row.checklist["Solenoide"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' } </td>`;
						tableHTML += `<td>${row.checklist["Flujometro"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.checklist["agua"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.checklist["ConduitChoco"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;															
						tableHTML += `</tr>`;
					}
				}
			})
			tableHTML += `</tbody></table>`;

			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row

			return tableHTML;

			case 'No marcan':
				
			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `  ${GetTitulo('No marcan')} `;
			tableHTML += '   <div class="overflow-auto">';
			
			tableHTML += '<table class="table"><thead><tr>';
			tableHTML += `<th>Ubicacion</th>`;
			tableHTML += `<th>Fecha</th>`;
			tableHTML += `<th>Sole</th>`;
			tableHTML += `<th>Flujo</th>`;
			tableHTML += `<th>Test agua</th>`;
			tableHTML += `<th>Condui Chocko</th>`;
			tableHTML += `<th>sin ticket</th></tr>`;
			tableHTML += `</thead><tbody>`        ;
		
			ChecklistDataTable.forEach(row => {
				if(row.checklist && row.ticket ){
				
					if(row.ticket['Id_TicketPriority'] == 2)	{
				
						tableHTML += `<tr class="bg-warning">`        ;	
						tableHTML += `<td><a href='url'  onclick="ThisApp.ChecklistPage.ChecklistVerPage(${row.checklist["Id"]});return false;" >${row.cuartel["Name"]}</a></td>`;
						tableHTML += `<td>${row.checklist["Fecha"]}</td>`;
						tableHTML += `<td>${row.checklist["Solenoide"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' } </td>`;
						tableHTML += `<td>${row.checklist["Flujometro"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.checklist["agua"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.checklist["ConduitChoco"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;															
						tableHTML += `</tr>`;
					}
				}
			})
			tableHTML += `</tbody></table>`;

			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row

			return tableHTML;


			case 'Falta test agua':
				
			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `  ${GetTitulo('Falta test agua')} `;
			tableHTML += '   <div class="overflow-auto">';
			
			tableHTML += '<table class="table"><thead><tr>';
			tableHTML += `<th>Ubicacion</th>`;
			tableHTML += `<th>Fecha</th>`;
			tableHTML += `<th>Sole</th>`;
			tableHTML += `<th>Flujo</th>`;
			tableHTML += `<th>Test agua</th>`;
			tableHTML += `<th>Condui Chocko</th>`;
			tableHTML += `<th>sin ticket</th></tr>`;
			tableHTML += `</thead><tbody>`        ;
		
			ChecklistDataTable.forEach(row => {
				if(row.checklist ){
				
					if( row.checklist["agua"] == '0' &&  row.checklist["Solenoide"] == '1' && row.checklist["Flujometro"] == '1' )	{
				
						tableHTML += `<tr class="bg-warning">`        ;	
						tableHTML += `<td><a href='url'  onclick="ThisApp.ChecklistPage.ChecklistVerPage(${row.checklist["Id"]});return false;" >${row.cuartel["Name"]}</a></td>`;
						tableHTML += `<td>${row.checklist["Fecha"]}</td>`;
						tableHTML += `<td>${row.checklist["Solenoide"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' } </td>`;
						tableHTML += `<td>${row.checklist["Flujometro"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.checklist["agua"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.checklist["ConduitChoco"] == '1' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;
						tableHTML += `<td>${row.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>' }</td>`;															
						tableHTML += `</tr>`;
					}
				}
			})
			tableHTML += `</tbody></table>`;

			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row

			return tableHTML;
		
		default:
	
		}	
}








	

}



class checklistTableRowData
 {
  // Constructor method initializes properties
  constructor(cuartel, unidad ,	checklist,ticket) {
    this.cuartel = cuartel; // Instance property
    this.unidad = unidad;
	this.checklist = checklist; 
	this.ticket = ticket;  // Instance property
  }

}