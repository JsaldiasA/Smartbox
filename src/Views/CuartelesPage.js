class CuartelesPage extends Page
{
	constructor( )
	{
		super();

		this.Id_modalUnidadVer = 'VerUnidad';

		this.Titulo = 'Unidades';

		this.FilterOptions = [ 'sirecor','all', 'milesight', 'Area externa','indefinidas','sin cuartel'];

		this.SelectFiltro = document.createElement('select');
		this.SelectFiltro.className = 'form-select';
		this.SelectFiltro.id = 'filtro';

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
		await this.CreateVerUnidadModal( this.Id_modalUnidadVer );
		 
		let mainTableDiv = document.createElement('div');
		mainTableDiv.id= 'CuartelesTable';

		this.SelectFiltro.addEventListener('change', async (event) => {

		await this.GetMainTable(mainTableDiv);
		});

		this.mainDiv.appendChild(mainTableDiv);

		await this.GetMainTable(mainTableDiv);

		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {
		clearInterval(interval_ID)
		});	

		RefreshIntervals_Ids.push( setInterval(() => this.refreshMainTable(mainTableDiv), 5000));
	}

 	async GetMainTable( containerDiv  )
	{
		containerDiv.replaceChildren();

		var filtroValue =  this.SelectFiltro.options[ this.SelectFiltro.selectedIndex ].value ;  
		
		let unidadesDataTable = [];
		let Row;

		switch ( filtroValue ) 
		{
		case 'all':

			appModel.Zonas.forEach(rowZona => {
				
				unidadesDataTable = [];			 
				appModel.Cuarteles.forEach(row => {

					if(row["Id_zona"] == rowZona["Id"])
					{
						let unidad = appModel.Unidades.find( unidad => unidad.Id ==  row["Id_unidad"]) ;
						let ultimoRegistro = unidad ? appModel.UltimosRegistros.find( ur => ur.unidad_id == unidad.Id) : null;			
						let unidadesData = new CuartelesDataTable( unidad , ultimoRegistro, row  );

						unidadesDataTable.push( unidadesData );
					}
				});

				containerDiv.appendChild( this.RenderRowContainer( rowZona["Name"], this.RenderCuartelesTable( unidadesDataTable) )  );
			}); 

			break;

		case 'sirecor':
			
			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('1');
			containerDiv.appendChild( this.RenderRowContainer( 'Estanques',  this.RenderCuartelesTable( unidadesDataTable) ) );
		
			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('2');
			containerDiv.appendChild( this.RenderRowContainer( 'Sirecor',  this.RenderCuartelesTable( unidadesDataTable) ) );
			break;

		case 'milesight':

			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('2');
			containerDiv.appendChild( this.RenderRowContainer( 'Milesight',  this.RenderCuartelesTable( unidadesDataTable) ) );

			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('6');
			containerDiv.appendChild( this.RenderRowContainer( 'Milesight Energizada',  this.RenderCuartelesTable( unidadesDataTable) ) );
			break;
		
		case 'Area externa':

			unidadesDataTable = this.GetUnidadesDataTableAreaExterna();
			containerDiv.appendChild( this.RenderRowContainer( 'AreaExterna',  this.RenderCuartelesTable( unidadesDataTable) ) );
			break;
		
		case 'indefinidas':

			unidadesDataTable = this.GetUnidadesDataTableIndefinidas();
			containerDiv.appendChild( this.RenderRowContainer( 'indefinidas',  this.RenderCuartelesTable( unidadesDataTable) ) );
			break;

		case 'sin cuartel':

			unidadesDataTable = this.GetUnidadesDataTableSinCuartel();
			containerDiv.appendChild( this.RenderRowContainer( 'Sin cuartel',  this.RenderCuartelesTable( unidadesDataTable) ) );
			break;
		
		default:

		}
	}

	async refreshMainTable( containerDiv )
	{	
		let lastUltimosRigistros = appModel.RefreshUltimosRegistros(); 
		let lastUnidades = appModel.RefreshUnidades();
		await Promise.all([appModel.RefreshUltimosRegistros(),appModel.RefreshUnidades()]);

		if( lastUnidades != appModel.Unidades && lastUltimosRigistros != appModel.UltimosRegistros )
		{
			await this.GetMainTable( containerDiv );
		}	
	}

	async CreateVerUnidadModal( Id_modal )
	{
			this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));

			const verModal = document.getElementById(Id_modal);
			const dialogModal =  document.querySelector('.modal-dialog');
			dialogModal.className = 'modal-dialog modal-xl';

			let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
			let ModalBody = document.getElementById(Id_modal+'_ModalBody');
			let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');
	
			verModal.addEventListener('show.bs.modal', async(event) => {

			const button = event.relatedTarget;
			const Id_Unidad = button.getAttribute('data-bs-unidadid');
			let thisUnidad = appModel.Unidades.find(t => t.Id == Id_Unidad) ;
			let thisCuartel = appModel.Cuarteles.find( c => c.Id_unidad == thisUnidad.Id )
			let thisChecklist = appModel.ChecklistsNew.find( ts => ts.id_unidad == thisUnidad.Id )

			ModalLabel.replaceChildren();
			ModalBody.replaceChildren();
			ModalFooter.replaceChildren();
						
			if (verModal) { 
				
			ModalBody.innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
			// clean an set intervals
			RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	});

			let tableHTML =''; 

			var unidad = thisUnidad;
			var cuartel;
			var checklist;
			var ultimosRegistro;

			// buscar la unidad	

			// get eventos
			let eventos = await GetEventosBytag(unidad["tag"]);
			let lastEvento = eventos[0]; 

			//buscar cuartel
			appModel.Cuarteles.forEach(rowCuarteles => {	if(unidad["Id"] == rowCuarteles["Id_unidad"] )	cuartel = rowCuarteles;	});	
			// buscar checklist
			appModel.ChecklistsNew.sort((a, b) => Date.parse(a["Fecha"]) - Date.parse(b["Fecha"]) ); 
			appModel.ChecklistsNew.forEach(rowChecklist => { if(unidad["Id"] == rowChecklist["id_unidad"] ) checklist = rowChecklist; });	

			if( unidad ) 
			{

				ModalLabel.textContent = `Unidad ${unidad["Serie"]}` ;

				tableHTML += '<div class="row p-3 shadow borde">'; // first row
					
					tableHTML += '<div class="row">';
						tableHTML += '<table class="table text-nowrap"><thead><tr>';
						tableHTML += `<th scope="col"> Serie </th>`;
						tableHTML += `<th scope="col"> Imei </th>`;
						tableHTML += `<th scope="col"> Cuartel </th>`;
						tableHTML += `<th scope="col"> numero </th>`;
						tableHTML += `</thead>`;

						tableHTML += `<tbody>`;
						tableHTML += '<tr>';
						tableHTML += `<td>${unidad["Serie"]}</td>`;
						tableHTML += `<td>${unidad["tag"]}</td>`;
						tableHTML += `<td>${ cuartel ? cuartel["Name"] :'Sin Cuartel' }</td>`;
						tableHTML += `<td>${ unidad["numero"] == null ? 'Sin numero' : unidad["numero"] }</td>`;
						tableHTML += '</tr>';
						tableHTML += `</tbody>`;
						tableHTML += `</table>`;			
					tableHTML += '    </div>      ';  
				tableHTML += '</div>'; // end first row

				// row checklist & ultima actualizacion

				tableHTML += '	<div class="row pb-3 shadow border">';

				if( checklist )
				{
					//col foto
					tableHTML += `<div class="col-sm-4 p-3" id="checklist_photo">`;
					//tableHTML += `<img class="img-thumbnail" src="${checklist["URL_foto"]}" "="">`;
					tableHTML += `</div>`;
					// col ultimo checklits & ultima actualizacion	
					tableHTML += ' <div class="col p-3">';
					tableHTML += '<table class="table text-nowrap"><thead>';
					tableHTML += `<th scope="col"> Ultimo checklist </th>`;
					tableHTML += `<th scope="col" class="d-flex justify-content-end" ><a onclick="NewChecklistPage(${unidad["Id"]})" class="btn btn-primary" >Nuevo Checklist</a> </th>`;
					// fecha
					tableHTML += '<tr>';
					tableHTML += `<td>Fecha</td>`;
					tableHTML += `<td>${checklist["Fecha"]}</td>`;
					tableHTML += '</tr>';
					// Observaciones
					tableHTML += '<tr>';
					tableHTML += `<td>Observaciones</td>`;
					tableHTML += `<td>${checklist["Observaciones"]}</td>`;
					tableHTML += '</tr>';
					// Revisar
					tableHTML += '<tr>';
					tableHTML += `<td>Revisar</td>`;
					tableHTML += `<td>ver</td>`;
					tableHTML += '</tr>';
					// end table
					tableHTML += `</tbody>`;
					tableHTML += `</table>`;
				}
				else
				{
					// col ultimo checklits & ultima actualizacion
					tableHTML += ' <div class="col p-3">';
					tableHTML += '<table class="table text-nowrap"><thead>';
					tableHTML += `<th scope="col"> Ultimo checklist </th>`;
					tableHTML += `<th scope="col" class="d-flex justify-content-end" ><a onclick="NewChecklistPage(${unidad["Id"]})" class="btn btn-primary" >Nuevo Checklist</a> </th>`;
					tableHTML += `</thead>`;
					tableHTML += `<tbody>`;
					tableHTML += '<tr>';
					tableHTML += `<td>Sin checklist</td>`;
					tableHTML += `<td></td>`;
					tableHTML += '</tr>';
					tableHTML += `</tbody>`;
					tableHTML += `</table>`;	
				}
				//table Ultima actualizacion
				if( IsSirecor(unidad["id_unidadTipo"]) )
				{
					tableHTML += '<div id="StatusTable" >  ';
					tableHTML += '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>';
					tableHTML += '</div>';

					// inicialize refresh thread every 1 second
					RefreshIntervals_Ids.push(setInterval(GetStatusTable, 1000, unidad["Id"]));
				}
				// table configuracion
					tableHTML += '<table class="table text-nowrap">';
						tableHTML += `<thead>`;
						tableHTML += `<th scope="col"> Configuracion </th>`;
						tableHTML += `<th scope="col"></th>`;
						tableHTML += `</thead>`;
					if(lastEvento)
					{	
						tableHTML += `<tbody>`;
							tableHTML += '<tr>';
							tableHTML += `<td>VerCodigo</td>`;
							tableHTML += `<td>${lastEvento["VerCodigo"]}</td>`;
							tableHTML += '</tr>';
							tableHTML += '<tr>';
							tableHTML += `<td>INTERNET</td>`;
							tableHTML += `<td>cada ${ Number(lastEvento["INTERNET"])*4/60} minutos </td>`;
							tableHTML += '</tr>';
							tableHTML += '<tr>';
							tableHTML += `<td>TipoBat</td>`;
							tableHTML += `<td> ${ lastEvento["TipoBat"] }</td>`;
							tableHTML += '</tr>';
						tableHTML += `</tbody>`;
					}
					tableHTML += `</table>`;			

				tableHTML += '    </div>      ';  // col end ultimo checklits & ultima actualizacion	
				tableHTML += '</div>'; //  end row checklist & ultima actualizacion

				// acordeon row
				tableHTML += '	<div class="row mt-3 shadow border">'; 
				tableHTML += ' <div class="col p-3">';

				tableHTML += '<div class="accordion" id="accordionExample">';
				tableHTML += '<div class="accordion-item">';// acordeon ITEM CONTROL
				tableHTML += '<h2 class="accordion-header" id="headingZero">';
				tableHTML += ' <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="false" aria-controls="collapseZero"> Control </button> </h2>';
										
				tableHTML += '<div id="collapseZero" class="accordion-collapse collapse" aria-labelledby="headingZero" data-bs-parent="#accordionExample">';
				
				tableHTML += '<div class="accordion-body">'; // accordion body
				tableHTML += '<div class="overflow-auto">'; // overflow

				if( !IsSirecor(unidad["id_unidadTipo"]) )
				{

				//	tableHTML += '<table class="table" > <thead >';
				//	tableHTML += '<th scope="col">Control</th>';
				//	tableHTML += '<th scope="col"></th>';
				//	tableHTML += '<th scope="col"></th>';
				//	tableHTML += '</thead><tbody>';
				//	let DisabledAbrir = "";
				//	let DisabledCerrar = "";

				//	if ($unidadDbEntity->get_Estado() == "1")
				//	{	
				//		DisabledAbrir = "disabled";
				//	}
				//	else
				//	{
				//		DisabledCerrar = "disabled";
				//	}

				//	tableHTML += `<tr><td><button type="button" onclick="FunctionComandosMilesight('Abrir V1','${unidad["tag"]}')" class="btn btn-primary" ${DisabledAbrir} >Abrir</button></td>`;
				//	tableHTML += `<td><button type="button" onclick="FunctionComandosMilesight('Cerrar V1','${unidad["tag"]}')" class="btn btn-primary" ${DisabledCerrar}  >Cerrar</button></td>`;
				//	tableHTML += `<td><button type="button" onclick="FunctionComandosMilesight('Reset Count','${unidad["tag"]}')" class="btn btn-primary">Reiniciar Contador</button></td><tr>`;
				//	tableHTML += '</tbody></table>';

				}

				else{
		
					tableHTML +='<div id="SMSTable" ></div>'; // sms table from post javascript 
					RefreshIntervals_Ids.push(setInterval(GetSMSTable, 1000, unidad["Id"] ));

					tableHTML += '<table class="table" > <thead >';
					tableHTML += '<th scope="col">SMS</th>';
					tableHTML += '<th scope="col"></th>';
					tableHTML += '</thead><tbody>';
				
					tableHTML += '<tr><td class="align-middle" > Mensaje </td>';
					tableHTML += '<td  ><div class="input-group" >';
					tableHTML += '		<input type="text" class="form-control" placeholder="Escriba el SMS en mayusculas" id="InputSMS" >';
					tableHTML += '		<div class="input-group-append">';
					tableHTML += `			<button class="btn btn-outline-secondary" type="button" onclick="FunctionCreateSMS(\'InputSMS\',${unidad["Id"]})" >Enviar</button>`;
					tableHTML += '		</div>';
					tableHTML += '	</div>';
					tableHTML += '</td><tr>';
					tableHTML += '</tbody></table>';

					tableHTML += '<table class="table" > <thead >';
					tableHTML += '<th scope="col">Controles Basicos</th>';
					tableHTML += '<th scope="col"></th>';
					tableHTML += '<th scope="col"></th>';
					tableHTML += '<th scope="col"></th>';
					tableHTML += '<th scope="col"></th>';
					tableHTML += '<th scope="col"></th>';
					tableHTML += '</thead><tbody>';

					tableHTML += `<tr><td><button type="button" onclick="FunctionCreateSMS( 'ABRIR', ${unidad["Id"]} )" class="btn btn-primary" >ABRIR</button></td>`;
					tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'CERRAR',${unidad["Id"]} )" class="btn btn-primary" >CERRAR</button></td>`;
					tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'RESET',${unidad["Id"]} )" class="btn btn-primary" >RESET</button></td><tr>`;
					tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'INTERNET15' ,${unidad["Id"]})" class="btn btn-primary" >Internet cada 1 min</button></td><tr>`;
					tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'INTERNET75',${unidad["Id"]} )" class="btn btn-primary" >Internet cada 5 min</button></td><tr>`;
					tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'INTERNET900',${unidad["Id"]} )" class="btn btn-primary" >Internet cada 2 Horas</button></td><tr>`;

					tableHTML += '</tbody></table>';		
				}

				tableHTML +='		  </div> '; // end overflow
				tableHTML +='		  </div> '; // end Acordeon body
				tableHTML +='		  </div> '; // end collapseZero
				tableHTML +='		  </div> '; // end Acordeon-item CONTROL
			
			//	accordion ITEM Registros DIARIOS
			tableHTML +=`
			<div class="accordion-item">
			<h2 class="accordion-header" id="headingOne">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  >
			Registros diarios
			</button>
			</h2>
			<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
			<div class="accordion-body">`;

			// TABLA REGISTROS DIARIOS

			tableHTML += `<button type="button" onclick="GetRegistrosDiariosTable(${unidad["Id"]})" class="btn btn-primary" >Refrescar</button>`;
			tableHTML += '<div class="overflow-auto"> <div id="RegistrosDiariosTable"></div>  </div>';

			tableHTML +='	</div>	 '; // end Acordeon body
			tableHTML +='	</div>	 '; // end collapseZero
			tableHTML +='   </div>	 '; // end Acordeon-item Registros DIARIOS

			//	accordion Registros de iniciación		
			tableHTML +=`
			<div class="accordion-item">
			<h2 class="accordion-header" id="headingTwo">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			Registros de iniciación
			</button>
			</h2>
			<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
			<div class="accordion-body">
			<div class="overflow-auto">`;

			let tableE = new DataTable("#TablaEventos");

			tableHTML += `<table id="TablaEventos" class="display""><thead>
					<th scope="col">UNIDAD</th>
					<th scope="col">INTERNET</th>
					<th scope="col">VerCodigo</th>
					<th scope="col">TipoBat</th>
					<th scope="col">TIPO</th>
					<th scope="col">TIMESTAMP</th>	
			</thead><tbody>`;

			eventos.forEach(rowE => {

				tableHTML += `<tr> <td>${rowE["UNIDAD"]}</td><td>${rowE["INTERNET"]}</td> <td>${rowE["VerCodigo"]}</td> <td>${rowE["TipoBat"]}</td> <td>${rowE["TIPO"]}</td> <td>${rowE["TIMESTAMP"]}</td> </tr>` ;
					
			});
			tableHTML += '</tbody></table>';
				
			$(document).ready(function(){
			$('#TablaEventos').dataTable();
			});

			tableHTML +='		  </div> '; // end overflow
			tableHTML +='		  </div> '; // end Acordeon body
			tableHTML +='		  </div> '; // end collapseZero
			tableHTML +='		  </div> '; // end Acordeon-item CONTROL

			//	accordion Registros de Edición	

			tableHTML += `		
			<div class="accordion-item">
			<h2 class="accordion-header" id="headingThree">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				Edición
			</button>
			</h2>
			<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
			<div class="accordion-body">`;
			
					tableHTML += '<div class="row border-bottom">';
						tableHTML += '<div class="col-auto p-3">';
								tableHTML += `Introduzca la contraseña para editar: <input type="text" id="password" name="password" class="form-control">`;
						tableHTML += '</div>';
					tableHTML += '</div>';
					
					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
								tableHTML += `<button onclick="FunctionNuevaUbicacion(${unidad["Id"]})" class="btn btn-secondary">Editar ubicación</button>`;
						tableHTML += '</div>';
						tableHTML += '<div class="col-auto py-3">';
							tableHTML += `<input type="text" id="NuevaUbicacion" name="NuevaUbicacion" class="form-control" placeholder="Ejemplo: Z1-3">`;   // Input cambio de ubicación.
						tableHTML += '</div>';
					tableHTML += '</div>';
		
					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
							tableHTML += `<button onclick="FunctionNuevoNumero('${unidad["Id"]}')" class="btn btn-secondary">Editar número</button> `;
						tableHTML += '</div>';
						tableHTML += '<div class="col-auto py-3">';
							tableHTML += `<input type="text" id="NuevoNumero" name="NuevoNumero" class="form-control" placeholder="Ejemplo: 99345469">`;   // Input cambio de número.
						tableHTML += '</div>';
					tableHTML += '</div>';

					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
							tableHTML += `<button onclick="FunctionCambiarVolMax('${unidad["Id"]}')" class="btn btn-secondary">Editar volumen máximo</button> `;
						tableHTML += '</div>';
						tableHTML += '<div class="col-auto py-3">';
							tableHTML += `<input type="text" id="VolMax" name="VolMax" class="form-control" placeholder="Ejemplo: 1000">`;   // Input cambio de volumen máximo.
						tableHTML += '</div>';
					tableHTML += '</div>';

					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
							tableHTML += `<button onclick="FunctionNuevoTipo('${unidad["Id"]}')" class="btn btn-secondary">Editar Tipo</button>`;
						tableHTML += '</div>';
						tableHTML += '<div class="col-auto py-3">';
							tableHTML += CreateSelectFromObjArray('NuevoTipo',appModel.UnidadTipo,'Id','Nombre') ;
						tableHTML += '</div>';
					tableHTML += '</div>';
					
					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
							tableHTML += `<button onclick="FunctionNuevoCuartel(${unidad["Id"]})" class="btn btn-secondary">Editar Cuartel</button>`;
						tableHTML += '</div>';
						tableHTML += '<div class="col-auto py-3">';
							tableHTML += CreateSelectFromObjArray('Cuarteles',appModel.Cuarteles,'Id','Name') ;
						tableHTML += '</div>';
					tableHTML += '</div>';

					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
								tableHTML += `<button onclick="FunctionEliminar('${unidad["Id"]}')" class="btn btn-danger">Eliminar</button>`;
						tableHTML += '</div>';
					tableHTML += '</div>';
					
				tableHTML +='		  </div> '; // end Acordeon body
				tableHTML +='		  </div> '; // end collapseZero
				tableHTML +='		  </div> '; // end Acordeon-item Edición
		
			//	accordion Registros de Checklist
			
			tableHTML += `
			<div class="accordion-item">
			<h2 class="accordion-header" id="headingFour">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
			Checklist
			</button>
			</h2>
			<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
			<div class="accordion-body">
			<div class="overflow-auto">`;   

				let table = new DataTable("#TablaChecklist");

				tableHTML += `<table id="TablaChecklist" class="display""><thead>
				<th scope="col">ID</th>
				<th scope="col">Técnico Responsable</th>
				<th scope="col">Fecha</th>
				<th scope="col"></th>
				
				</thead><tbody>`;

				appModel.ChecklistsNew.forEach(rowC => {
					if( rowC["id_unidad"] == unidad.Id )
					{
						tableHTML += `</td> <td>${rowC["Id"]}</td><td>${rowC["TecnicoResponsable"]}</td> <td>${rowC["Fecha"]}</td> <td><a href='url' onclick="ChecklistVerPage(${rowC["Id"]});return false;">Ver</a></td></tr>` ;
					}	
					
				});
					tableHTML += '</tbody></table>';
				
				$(document).ready(function(){
				$('#TablaChecklist').dataTable();
				});
				

				tableHTML +='		  </div> '; // end overflow
				tableHTML +='		  </div> '; // end Acordeon body
				tableHTML +='		  </div> '; // end collapseZero
				tableHTML +='		  </div> '; // end Acordeon-item Checklist

						//	accordion Registros de Checklist
			
			tableHTML += `
			<div class="accordion-item">
			<h2 class="accordion-header" id="headingFive">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
			Eventos
			</button>
			</h2>
			<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
			<div class="accordion-body">
			<div class="overflow-auto">`;   

				let tableM = new DataTable("#TablaEventosMessage");

				tableHTML += `<table id="TablaEventosMessage" class="display""><thead>
				<th scope="col">ID</th>
				<th scope="col">Message</th>
				<th scope="col">Fecha</th>
				<th scope="col"></th>
				
				</thead><tbody>`;

				appModel.eventMessage.forEach(rowC => {
					if( rowC["Id_unidad"] == unidad.Id )
					{
						tableHTML += `</td> <td>${rowC["Id"]}</td><td>${rowC["MessageText"]}</td> <td>${rowC["CreationDate"]}</td> <td>${rowC["Id_MessageType"]}</td></tr>` ;
					}	
					
				});
					tableHTML += '</tbody></table>';
				
				$(document).ready(function(){
				$('#TablaEventosMessage').dataTable();
				});
				

				tableHTML +='		  </div> '; // end overflow
				tableHTML +='		  </div> '; // end Acordeon body
				tableHTML +='		  </div> '; // end collapseZero
				tableHTML +='		  </div> '; // end Acordeon-item Eventos

				tableHTML += '    </div>      ';  // col
				tableHTML += '</div>'; //end acordeon row 

			}
			else
			{
				tableHTML += '	<div class="row pb-3">';
				tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
				tableHTML += `    <h2><b>Unidad no encontrada</b></h2> `;
				tableHTML += '    </div>      ';  // col
				tableHTML += '</div> '; // row
			}	

			ModalBody.innerHTML = tableHTML;

			if( checklist )
			{
				//col foto
				document.getElementById('checklist_photo').innerHTML = `<img class="img-thumbnail" src="${checklist["URL_foto"]}" "="">`;
			}	

			const myCollapsible = document.getElementById('collapseTwo');
			myCollapsible.addEventListener('shown.bs.collapse', function () {
		
				GetRegistrosDiariosTable(unidad["Id"]);
			});

			}

		});
		

	}

	GetUnidadesDataTableById_unidadTipo( unidadTipo  )
	{		
			// no considera cuarteles de area externa.
			let UnidadesFiltradas = [];

			appModel.Cuarteles.forEach(row => {

				if(row["Id_unidad"]!= '' && row["Id_unidad"]!= null && row["AreaExterna"] != '1' ) // no considera cuarteles de area externa.
				{   
					let unidad = appModel.Unidades.find( u => u.Id == row["Id_unidad"]);
		
					if( unidad && unidad["id_unidadTipo"] == unidadTipo  )
					{
						let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == unidad.Id);			
						let UnidadDataTable = new CuartelesDataTable( unidad , ultimoRegistro ?? null , row  );
						UnidadesFiltradas.push( UnidadDataTable );
					}
				}	
			});

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}

	GetUnidadesDataTableAreaExterna(   )
	{		
		let UnidadesFiltradas = [];

			appModel.Cuarteles.forEach(row => {

				if(  row["AreaExterna"] == '1' ) 
				{   
					let unidad = appModel.Unidades.find( u => u.Id == row["Id_unidad"]);
		
					let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == unidad.Id);					
					let UnidadDataTable = new CuartelesDataTable( unidad , ultimoRegistro ?? null , row  );
					UnidadesFiltradas.push( UnidadDataTable );
				
				}	
			});

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}


	GetUnidadesDataTableIndefinidas( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Unidades.forEach(rowUnidades => {
				
				if( rowUnidades.id_unidadTipo == '' || rowUnidades.id_unidadTipo == null )
				{
					let Cuartel = appModel.Cuarteles.find( c =>  c.Id_unidad == rowUnidades.Id);	
					let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == rowUnidades.Id);					
					let UnidadDataTable = new CuartelesDataTable( rowUnidades , ultimoRegistro ?? null ,Cuartel ?? null  );
					UnidadesFiltradas.push( UnidadDataTable );
				}	
			});	

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}

	GetUnidadesDataTableSinCuartel( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Unidades.forEach(rowUnidades => {
			
				let Cuartel = appModel.Cuarteles.find( c =>  c.Id_unidad == rowUnidades.Id);	

				if(!Cuartel )
				{
					let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == rowUnidades.Id);					
					let UnidadDataTable = new CuartelesDataTable( rowUnidades , ultimoRegistro ?? null , null  );
					UnidadesFiltradas.push( UnidadDataTable );
				}			
			});	

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}

	RenderCuartelesTable(  CuartelesDataTable )
	{
		let dataTable =[];
		const headers = ['<i class="bi bi-pin-map">','<i class="bi bi-motherboard"></i>','','<i class="bi bi-activity"></i>','<i class="bi bi-lightning-fill"></i>', '<i class="bi bi-wifi"></i>','[L/m]','[L]' ];

		class dTRow
		{
			constructor()
			{
				this.Ubicacion;
				this.Serie;
				this.Estado;
				this.Activity;
				this.BateryLevel;
				this.Signal;
				this.Caudal;
				this.Volumen;
			}
		}
				
		CuartelesDataTable.forEach(rowU => {
				
			let dataTableRow = new dTRow();		
		
			if( rowU.unidad )
			{  
				dataTableRow.Ubicacion = rowU.cuartel ? rowU.cuartel.Name : 'Sin cuartel' ;
				dataTableRow.Serie = `<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalUnidadVer}" data-bs-unidadid="${ rowU.unidad.Id }" >${rowU.unidad['Serie']}</button>`;

				if(rowU.ultimoRegistro)
				{	dataTableRow.Estado = FieldEstado(rowU.ultimoRegistro.ESTADO)
					dataTableRow.Activity = FieldActivity(rowU.ultimoRegistro.DATETIME);
					dataTableRow.BateryLevel =	FieldBattery(rowU.ultimoRegistro.VOLTAJE);
					dataTableRow.Signal = FieldSignal(rowU.ultimoRegistro.SENAL, rowU.ultimoRegistro.DATETIME);		
					dataTableRow.Caudal = rowU.ultimoRegistro.CAUDAL;
					dataTableRow.Volumen = rowU.ultimoRegistro.VOLUMEN;	
				}	
				else
				{
					dataTableRow.Estado = 'Milesight';
				}		
			}
			else
			{
				dataTableRow.Ubicacion = rowU.cuartel.Name;
				dataTableRow.Serie = ``;
				dataTableRow.Estado = 'Sin Dispositivo';
			}

			dataTable.push(dataTableRow);

		});

		return this.RenderTable( headers, dataTable);

	}

}


class CuartelesDataTable
{
	constructor( unidad, ultimoRegistro, cuartel )
	{	
		this.unidad =  unidad;
		this.ultimoRegistro =ultimoRegistro;
		this.cuartel  = cuartel;
	}

}




