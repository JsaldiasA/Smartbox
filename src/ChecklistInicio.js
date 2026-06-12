

async function GetMainChecklist(  )
	{	
		RefreshIntervals_Ids.forEach(interval_ID => { clearInterval(interval_ID) });	

		 document.getElementById('main').innerHTML = `   <div class="row pb-3">
            <div class="col p-3">
				${GetTitulo('CheckLists')}
            </div>
			 <div class="col-sm-auto align-self-center p-2">
              <b> Filtro: </b>
            </div>
            <div class="col-auto align-self-center p-2">
               <select class="form-select" id="filtro">
                <option value="all" selected>Todos</option>
                <option value="No operativos" >No operativos</option>
                <option value="No marcan" >No marcan</option>
                </select>
            </div>	
		</div>`;

		 document.getElementById('main').innerHTML +=`<div class="row pb-3">
			<div class="col p-3 card shadow p-3 card shadow">
				<div class="overflow-auto">
					<div id="TableEstadoGeneral"></div>
				</div>
			</div>
		 </div>
    
        <div id="mainChecklist"> ${GetLoadingPage()}</div>`;
		  let DataTable = await GetPageData();	
		  await GetTableTableEstadoGeneral( DataTable );
		  await GetChecklistTables( DataTable );

		const statusSelect = document.querySelector('#filtro');

		// Listen for a change in selection
		statusSelect.addEventListener('change', (event) => {
			// Get the newly selected value
			document.getElementById('mainChecklist').innerHTML=GetLoadingPage();
		
			const newStatus = event.target.value;
			GetChecklistTables(DataTable);
			console.log(`Status changed to: ${newStatus}`);
		});

	}
	
async function GetPageData() {

	let [ Zonas, tickets, cuarteles,ChecklistsNew, Unidades] = await Promise.all([ GetZonas(),GetTicket(),GetCuarteles(),GetChecklistsNew(),GetUnidades()]);
		
		let DataTable = [] ;
		
		ChecklistsNew.sort((a, b) => Date.parse(a["Fecha"]) - Date.parse(b["Fecha"]) ); 

			// fill datatable
			cuarteles.forEach(rowCT => {

					let Checklist;
					let badChecklist = true;
					let Ticket;
					let unidad;
					let rowData;

					ChecklistsNew.forEach(rowCL => {

							if(rowCL["id_unidad"] == rowCT["Id_unidad"] )	Checklist = rowCL;
					});

					tickets.forEach(rowTk => {
						if(rowCT["Id_unidad"] == rowTk["Id_unidad"] &&  rowTk["Id_TicketStatus"] == '1' )	Ticket = rowTk;																										
					})

					Unidades.forEach(u => {
						if(rowCT["Id_unidad"] == u["Id"] )	unidad = u;																										
					})

					rowData = new checklistTableRowData(rowCT, unidad,Checklist,Ticket);
					DataTable.push(rowData);	
			});

	return DataTable;
}

async function GetChecklistTables( DataTable )
	{


		let tableHTML = '';
		
		var fil = document.getElementById("filtro");
		var filtroValue = fil ? fil.options[fil.selectedIndex].value : "";  
		
		tableHTML = await renderChecklistTable(filtroValue,DataTable);

		// Select the dropdown element
		document.getElementById("mainChecklist").innerHTML= tableHTML;


	}
	
 function CountUnidadesOK( Id_zona,ChecklistDataTable)
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

	 function CountUnidades( Id_zona ,ChecklistDataTable)
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

	function ColorOperatibilidar( operatibilidad )
	{
		return operatibilidad > 80 ? "text-success" : ( operatibilidad > 60 ? ("text-warning") : ("text-danger") );
	}

	async function GetTableTableEstadoGeneral( DataTable)
	{	

		var Operativas = await CountUnidadesOK(null,DataTable);
		var total = await CountUnidades(null,DataTable);

		var operatibilidad = Math.round( (Operativas/total)*100 );

		var Color = ColorOperatibilidar( operatibilidad );

		let tableHTML = ``        ;
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

		document.getElementById("TableEstadoGeneral").innerHTML= tableHTML;
	}	


	async function NewChecklistPage ( Id_unidad )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach( interval_ID => { clearInterval(interval_ID) });	

		let unidad;

		let [Unidades] = await Promise.all([GetUnidades()]);
		
		Unidades.forEach( u => { if( Id_unidad == u['Id'] )	unidad = u; })
		
		let tableHTML = `
	
	<div class="row p-3">
		${	GetVolverBtn('VolverCuartelesMain()')}
		${	GetTitulo(`Nuevo checklist para ${unidad["Serie"]}`)}
	</div>
	<div class="row">
		<div class="col m-3 p-3 border">
			<table class="table">
			<tbody>	
				<tr><td><b>IMEI:</b></td><td>${unidad["tag"]}</td><td></td></tr>
				<tr><td><b>ID de la unidad:</b></td><td>${unidad["Id"]}</td><td></td></tr>
				<tr><td><b>Motivo </b></td><td><select name="ChecklistMotivo" class="form-select" id="ChecklistMotivo" required=""></select></td><td></td></tr>	
				<tr><td><b>Metodo de Prueba </b></td><td><select name="MetodosDePrueba" class="form-select" id="MetodosDePrueba" required=""></select></td><td></td></tr>	
				<tr><td><b>Solenoide:</b></td><td><input type="checkbox" class="form-check-input" id="Solenoide"></td><td></td></tr>
				<tr><td><b>Flujómetro:</b></td><td><input type="checkbox" class="form-check-input" id="Flujometro"></td><td></td></tr>	
				<tr><td><b>Conduit y Choco:</b></td><td><input type="checkbox" class="form-check-input" id="ConduitChoco" ></td><td></td></tr>
				<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, coloque OK."></td><td></td></tr>
				<tr><td><b>Técnico responsable:</b></td><td><input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre"></td><td></td></tr>
				<tr><td><b>Imagen:</b></td><td><div id="NombreDeFoto"></div></td><td><div id="StatusFoto"></div></td></tr>
			</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col m-3 p-3" >
			<button id="upload" class="btn btn-success btn-lg" >Seleccionar y Subir Foto</button>
		</div>
		<div class="col m-3 p-3" >
			<input id="sortpicture" type="file" name="sortpic" style="display: none;" />
		</div>	
		<div class="col m-3 p-3" >
			<button id="enviarChecklist"type="button" class="btn btn-success btn-lg" onclick="FunctionNuevoCheckListPost(${unidad["Id"]})">Enviar CheckList</button>
		</div>
	</div>
	
	`;
		
		document.getElementById('main').innerHTML = tableHTML;

		const upload = document.getElementById('upload');
		const sortpicture = document.getElementById('sortpicture');
	
		// 1. Forward the custom button click to the hidden file input
		upload.addEventListener('click', () => {
			sortpicture.click(); 
		
		});

		// 2. Catch the exact moment a file is selected and upload it
		sortpicture.addEventListener('change', async () => {
			
			if (sortpicture.files.length === 0)  alert("archivo no encontrado");
			else  uploadPicture(sortpicture.files[0]);
	
    	 });

		// completando select html

		const selectMetodosDePrueba = document.getElementById('MetodosDePrueba');
		let MetodosDePrueba = GetMetodosDePrueba();

		MetodosDePrueba.forEach(row => {
		
		const NewOption = new Option(row["Name"], row["Id"]);
		selectMetodosDePrueba.add(NewOption);
		});

		const selectChecklistMotivo = document.getElementById('ChecklistMotivo');
		let ChecklistMotivos = GetChecklistMotivos();

		ChecklistMotivos.forEach(row => {
		
		const NewOption = new Option(row["Name"], row["Id"]);
		selectChecklistMotivo.add(NewOption);
		});

	}

	async function ChecklistVerPage ( Id_Checklist )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {

		clearInterval(interval_ID)

		});	

		let tableHTML =``;
		let unidad;
		let Unidadtipo;
		let checklist;

		let [Tickets, TicketStatus, Cuarteles, Unidades,Tipos,ChecklistsNew] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles(),GetUnidades(),GetUnidaTipo(),GetChecklistsNew()]);
		

		ChecklistsNew.sort((a, b) => Date.parse(a["Fecha"]) - Date.parse(b["Fecha"]) ); 
		
		ChecklistsNew.forEach( ck => { 

			if(	ck['Id']	== Id_Checklist )
			{
				checklist=ck;
			}	
		})

		Unidades.forEach( u => {	 
			if( checklist["id_unidad"] == u['Id'] )
			{
				unidad = u ;
			}
		})
		
		tableHTML += `
	
	<div class="row p-3">
		${	GetVolverBtn('VolverCuartelesMain()')}
			${GetTitulo( `checklist de ${unidad["Serie"]}`)}
			${GetEditBtn(`EditChecklistPage(${checklist["Id"]})`)}
	</div>
	<div class="row">
		<div class="col m-3 p-3 border">
			<table class="table">
			<tbody>	
			<tr><td><b>IMEI:</b></td><td>${unidad["tag"]}</td><td></td></tr>
			<tr><td><b>ID de la unidad:</b></td><td>${unidad["Id"]}</td><td></td></tr>
			
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
			<tr><td><b>Imagen:</b></td><td><img src='${checklist["URL_foto"]}' class='img-fluid' > </td><td></td></tr>
			</tbody>
			</table>
		</div>
	</div>
`;

		document.getElementById('main').innerHTML = tableHTML;

	}


async function EditChecklistPage ( Id_Checklist )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach( interval_ID => { clearInterval(interval_ID) });	

		let CheckList;

		let [Checklists] = await Promise.all([GetChecklistsNew()]);
		
		Checklists.forEach( c => { if( Id_Checklist == c['Id'] ) CheckList = c; });
		
		let tableHTML = `
		<div class="row p-3">
			${	GetVolverBtn('VolverCuartelesMain()')}
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


function FunctionNuevoCheckListPost( Id_unidad )
		{
			let text = "¿Está seguro de enviar el CheckList?";
			if (confirm(text) == true)
				{

					var Solenoide= Number(document.getElementById("Solenoide").checked);
					var Flujometro= Number(document.getElementById("Flujometro").checked);
					var ConduitChoco = Number(document.getElementById("ConduitChoco").checked);
					var Observaciones= document.getElementById("Observaciones").value;
					var TecnicoResponsable= document.getElementById("TecnicoResponsable").value;

					var ChecklistMotivoSelect = document.getElementById("ChecklistMotivo");
					var id_checklistMotivo = ChecklistMotivoSelect.options[ChecklistMotivoSelect.selectedIndex].value;  

					let MdpruebaSelect =document.getElementById("MetodosDePrueba"); 
					let MetodoDePrueba = MdpruebaSelect.options[MdpruebaSelect.selectedIndex].value; 
					let URL_foto= document.getElementById("NombreDeFoto").innerHTML == "" ? 'nofoto.jpg' : document.getElementById("NombreDeFoto").innerHTML ; 
					URL_foto='https://smartbox.eco3.cl/checklistform/Fotos/'+URL_foto;

					if(Observaciones == "" )
					{
						return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");
					}
					
					if(TecnicoResponsable == "" )
					{
						return alert("Técnico responsable no puede estar vacío, coloque su nombre.");
					}
					
					$.ajax(
						{
							url:'https://smartbox.eco3.cl/ApiController/checklist/checklistCreate.php',    //the page containing php script
							type: "post",    //request 
							dataType: 'text',
							data:
								{
									id_unidad: Id_unidad,
									Flujometro: Flujometro,
									Solenoide: Solenoide, 
									ConduitChoco: ConduitChoco,
									MetodoDePrueba: MetodoDePrueba, 								  
									id_checklistMotivo: id_checklistMotivo,
									Observaciones: Observaciones,
									TecnicoResponsable: TecnicoResponsable,
									URL_foto: URL_foto,	    
								},
							success: function(result)
								{
									alert(result);
									window.location.reload();
								}    
						});
				}
			else
				{
					alert("La operación se ha cancelado.");
				}
		}

	async function uploadPicture( inputFile ) {
	
		var file_data = inputFile;  

		const enviarChecklistBtn = document.getElementById('enviarChecklist');
		enviarChecklistBtn.disabled = true;
		enviarChecklistBtn.classList.remove('btn-success');
   		 enviarChecklistBtn.classList.add('btn-secondary'); 
		enviarChecklistBtn.innerHTML= 'Subiendo Foto ' + `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;

    	var form_data = new FormData();                  
    	form_data.append('file', file_data);                        
		$.ajax({
        url: 'https://smartbox.eco3.cl/ChecklistForm/upload.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response); // <-- display response from the PHP script, if any
			document.querySelector("#StatusFoto").innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
			document.querySelector("#NombreDeFoto").innerHTML = file_data.name;
			enviarChecklistBtn.disabled = false;
			enviarChecklistBtn.innerHTML= 'Enviar CheckList' ;
			enviarChecklistBtn.classList.remove('btn-secondary');
			enviarChecklistBtn.classList.add('btn-success');
   		
        }
     });
	
	}
	
    		function NumericParameterHasError(Parameter,highLimit,lowLimit) {
		let pattern = /(^\d+\.\d+$)|(^\d+$)/; 
	var noAjustarMsg = " ,vuelva a ajustarlo. SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, póngase en contacto con la oficina técnica.";
			  
	switch (true) {
	  case (Parameter.value == ""):
		Parameter.value = 0;
		return false;
		break;
	  case (Parameter.value == null):
		Parameter.value = 0;
		return false;
		break;
	  case (Parameter.value < lowLimit):
		alert(Parameter.id+" no puede ser menor a "+lowLimit+" "+noAjustarMsg);		  
		return true;
		break;
	  case (Parameter.value > highLimit ):
		alert(Parameter.id+" no puede ser mayor a "+highLimit+" "+noAjustarMsg);
		return true;
		break;
	  case (!pattern.test(Parameter.value)):
		alert("Error en " +Parameter.id+". Ingrese solo valores numéricos, no se aceptan letras o caracteres en este campo. Ej: 1 ,13 ,14.2 ,13.5");
		return true;
		break;
	 
			
	  default:
	    return false;
	}	   
}

function FunctionUpdateChecklistPost( Id_checklist ) 
		{
			let text = "¿Está seguro de editar el checklist?";
			if (confirm(text) == true)
			{
					
				var Solenoide 	= Number(document.getElementById("Solenoide").checked);
				var Flujometro         = Number(document.getElementById("Flujometro").checked);	
				var ConduitChoco = Number(document.getElementById("ConduitChoco").checked);
				var agua         = Number(document.getElementById("agua").checked);
				var Observaciones= document.getElementById("Observaciones").value;
				if(Observaciones == "" )	return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");
					
				$.ajax(
					{
            			url:`https://smartbox.eco3.cl/ApiController/checklist/checklistUpdate.php`,
            			type:"post",
						dataType:'text',
						data:
							{
								Id_checklist:Id_checklist,
								Solenoide 	: Solenoide,
								ConduitChoco: ConduitChoco,
								Flujometro : Flujometro,
								agua: agua,       
								Observaciones: Observaciones,
        					},
						success: function(result)
							{
								alert (result);
								window.location.reload();
							}
					});
  			}
			else		alert ("La operación se ha cancelado.");
		}


 function GetMetodosDePrueba( )
{
	
	let Json = `[{"Id":"1","Name":"Sin Probar"},{"Id":"2","Name":"Soplado de flujometro"},{"Id":"3","Name":"Prueba Con agua"}]`;

  	return JSON.parse(Json);
  
}

 function GetChecklistMotivos( )
{

	let Json = `[{"Id":"1","Name":"Fabricación"},{"Id":"2","Name":"Pre-instalación"},{"Id":"3","Name":"Instalación"},{"Id":"4","Name":"Revisión preventiva"}]`;

  	return JSON.parse(Json);
  
}


async function renderChecklistTable(filtroValue,ChecklistDataTable)
{	
	let tableHTML='';
	

	switch ( filtroValue ) 
		{
		case 'all':
				Zonas = await GetZonas();

				tableHTML += '<div class="accordion" id="accordionPanelsStayOpenExample"></div>';

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
						
										case '1': ColumnClassColor = `class="bg-danger text-white"`; break;
										case '2': ColumnClassColor = `class="bg-warning"`; break;									
										case '3': ColumnClassColor = `class="border border-warning border-5"`; break;
										default: ColumnClassColor = 'class=""';
										}
									} 
							
									tableHTML += `<tr ${ColumnClassColor} >` ;
									tableHTML += `<td><a href='url' onclick="ChecklistVerPage(${rowCT.checklist["Id"]});return false;" >${rowCT.cuartel["Name"]}</a></td>`;
									tableHTML += `<td>${rowCT.checklist["Fecha"]}</td>`;
									tableHTML += `<td>${rowCT.ticket == null ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle"></i>'}</td>`;
								}
								else
								{
									tableHTML += '<tr class="bg-danger text-white">';
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
				
									case '1': ColumnClassColor = `class="bg-danger text-white"`; break;
									case '2': ColumnClassColor = `class="bg-warning"`; break;									
									case '3': ColumnClassColor = `class="border border-warning border-5"`; break;
									default: ColumnClassColor = 'class=""';
									}
								} 
						
								if(badChecklist)  ColumnClassColor = `class="bg-danger text-white"`;
																
								tableHTML += `<tr ${ColumnClassColor} >` ;
								tableHTML += `<td><a href='url'  onclick="ChecklistVerPage(${rowCT.checklist["Id"]});return false;" >${rowCT.cuartel["Name"]}</a></td>`;
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
					
				Operativas = CountUnidadesOK(rowZona["Id"],ChecklistDataTable);
				total = CountUnidades(rowZona["Id"],ChecklistDataTable);
				operatibilidad = Math.round( (Operativas/total)*100 );
				Color = ColorOperatibilidar( operatibilidad );

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
						tableHTML += `<td><a href='url'  onclick="ChecklistVerPage(${row.checklist["Id"]});return false;" >${row.cuartel["Name"]}</a></td>`;
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
						tableHTML += `<td><a href='url'  onclick="ChecklistVerPage(${row.checklist["Id"]});return false;" >${row.cuartel["Name"]}</a></td>`;
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
			// Code to execute if no match is found
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






	
