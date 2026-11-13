class CuartelesPage extends Page
{
	constructor( )
	{
		super();
		this.Controller = new CuartelesController();

		this.Id_modalUnidadVer = 'VerUnidad';
		this.Id_modalNewChecklist = 'NewChecklist';
		this.Id_modalVerChecklist = 'VerChecklist';

		this.Titulo = 'Unidades';

		this.FilterOptions = [ 'all','sirecor','milesight', 'Area externa','indefinidas','sin cuartel'];

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
		await this.CreateNewChecklistModal( this.Id_modalNewChecklist );
		await this.CreateVerChecklistModal( this.Id_modalVerChecklist );
 
		let mainTableDiv = document.createElement('div');
		mainTableDiv.id= 'CuartelesTable';

		this.SelectFiltro.removeEventListener('change', this.HandleFilterChange);
		this.SelectFiltro.addEventListener('change',this.HandleFilterChange);

		this.mainDiv.appendChild(mainTableDiv);

		await this.GetMainTable(mainTableDiv);

		RefreshIntervals_Ids.push( setInterval(() => this.refreshMainTable(mainTableDiv), 5000));

		$(`#${this.Id_modalUnidadVer}`).on('hidden.bs.modal', function (e) {
		
		RefreshIntervals_Ids.forEach(interval_ID => { clearInterval(interval_ID) }); // clean an set intervals	 
		RefreshIntervals_Ids.push( setInterval(() => ThisApp.CuartelesPage.refreshMainTable(mainTableDiv), 5000));

		})
	}

	async HandleFilterChange(){
		let mainTableDiv = document.getElementById('CuartelesTable');
		await ThisApp.CuartelesPage.GetMainTable(mainTableDiv);
	}

	async  GetStatusTable( unidad_id )
	{
		let thisUnidad = appModel.Unidades.find(t => t.Id == unidad_id) ;
		let UltimoRegistro = await ThisApp.CuartelesPage.Controller.GetDiarioById( thisUnidad.Id_Last_RegistroDiario );
		let headers = [ 'Ultimo registro' , ' '];
		let DataTable = [];

		DataTable.push( { Item: "Estado",  Value: FieldEstado(UltimoRegistro['ESTADO']) } );
		DataTable.push( { Item: "Caudal",  Value: UltimoRegistro['CAUDAL']} );
		DataTable.push( { Item: "Senal",  Value: UltimoRegistro['SENAL']} );
		DataTable.push( { Item: "Volumen",  Value: UltimoRegistro['VOLUMEN']} );
		DataTable.push( { Item: "Último Registro", Value:  FieldActivity(UltimoRegistro['DATETIME']) } );
		let statusTableDiv = document.getElementById("StatusTable");
		statusTableDiv.replaceChildren(  ThisApp.CuartelesPage.RenderTable( headers, DataTable) )
	}	

 	async GetMainTable( containerDiv  )
	{
		containerDiv.replaceChildren();

		var filtroValue =  this.SelectFiltro.options[ this.SelectFiltro.selectedIndex ].value ;
		let unidadesDataTable = [];

		switch ( filtroValue ) {

		case 'all':

			appModel.Zonas.forEach(rowZona => {
				
				unidadesDataTable = [];			 
				appModel.Cuarteles.forEach(row => {
				let unidad = appModel.Unidades.find(t => t.Id == row.Id_unidad) ;
					
				    if( (row["Id_zona"] == rowZona["Id"]) && unidad) {
						unidadesDataTable.push( unidad );
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

			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('3');
			containerDiv.appendChild( this.RenderRowContainer( 'Milesight',  this.RenderCuartelesTable( unidadesDataTable) ) );

			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('5');
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
		let lastUltimosRigistros = appModel.UltimosRegistros; 
		let lastUnidades = appModel.Unidades;
		await Promise.all([appModel.RefreshUltimosRegistros(),appModel.RefreshUnidades()]);

		if( lastUnidades != appModel.Unidades && lastUltimosRigistros != appModel.UltimosRegistros ){
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
			const Id_cuartel = button.getAttribute('data-bs-cuartelid') ?? null;

			let unidad = appModel.Unidades.find(t => t.Id == button.getAttribute('data-bs-unidadid') ) ;
			let cuartel = button.getAttribute('data-bs-cuartelid') != null ? appModel.Cuarteles.find( c => c.Id == button.getAttribute('data-bs-cuartelid') ) : appModel.Cuarteles.find( c => c.Id_unidad == unidad.Id )
		
			ModalLabel.replaceChildren();
			ModalBody.replaceChildren();
			ModalFooter.replaceChildren();
						
			if (verModal) { 
				
			ModalBody.innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
			// clean an set intervals
			RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	});

			let tableHTML =''; 
			// get eventos
			let eventos = await GetEventosBytag(unidad["tag"]);
			let lastEvento = eventos[0]; 
	
			// buscar checklist
			let checklist = appModel.ChecklistsNew.find( ts => ts.id_unidad == unidad.Id )

			if( unidad ) 
			{
				ModalLabel.textContent = `Unidad ${unidad["Serie"]}` ;
				tableHTML += '<div class="row pb-3 shadow borde">'; // first row
					const Grid = new BootstrapGrid();
					Grid.rows.push( ['<b>Serie</b>','<b>Imei</b>','<b>Cuartel</b>','<b>numero</b>']);
					Grid.rows.push([ unidad["Serie"],unidad["tag"], (cuartel ? cuartel["Name"] :'Sin Cuartel') , (unidad["numero"] ?? 'sin numero')]  );
					tableHTML += Grid.RenderGrid().innerHTML;
				tableHTML += '</div>'; // end first row

				tableHTML += '	<div class="row p-3 shadow border">'; // row checklist & ultima actualizacion
				if( checklist ) {
					//col foto
					tableHTML += `<div class="col-sm-4 p-3" id="checklist_photo"></div>`;
					tableHTML += ' <div class="col p-3">';
					const Grid = new BootstrapGrid();
					Grid.headers = ['Ultimo checklist',`<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalNewChecklist}" data-bs-unidadid="${ unidad.Id }" >Nuevo Checklist </button>`];
					Grid.rows.push(['Fecha',checklist["Fecha"]]);
					Grid.rows.push(['Observaciones',checklist["Observaciones"]]);
					tableHTML += Grid.RenderGrid().innerHTML;
				}
				else {
					tableHTML += ' <div class="col p-3">';// col ultimo checklits & ultima actualizacion
					const Grid = new BootstrapGrid();
					Grid.headers = ['Ultimo checklist',`<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalNewChecklist}" data-bs-unidadid="${ unidad.Id }" >Nuevo Checklist </button>`];
					Grid.rows.push(['sin Checklist','']);
					tableHTML += Grid.RenderGrid().innerHTML;					
				}
				tableHTML += '<div id="StatusTable"  class="col pt-3" >  ';
				tableHTML += '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>';
				tableHTML += '</div>';

				RefreshIntervals_Ids.push(setInterval(ThisApp.CuartelesPage.GetStatusTable, 1000, unidad["Id"]));// inicialize refresh thread every 1 second
					
				if(this.IsSirecor(unidad["id_unidadTipo"]) && lastEvento ) // table configuracion
				{	
					const GridConfiguracion = new BootstrapGrid();
					GridConfiguracion.headers = ['Configuracion',''];
					GridConfiguracion.rows.push(['VerCodigo',lastEvento["VerCodigo"]]);
					GridConfiguracion.rows.push(['INTERNET',`cada ${ Number(lastEvento["INTERNET"])*4/60} minutos `]);
					GridConfiguracion.rows.push(['VerCodigo',lastEvento["TipoBat"]]);
					GridConfiguracion.rows.push(['TipoBat',lastEvento["VerCodigo"]]);
					GridConfiguracion.rows.push(['Bateria',`${ unidad["Id_bateriaTipo"] ? appModel.BateriaTipos.find(bt => bt.Id == unidad.Id_bateriaTipo).Name : 'No registrada' }`]);
					GridConfiguracion.rows.push(['Fecha de bateria',`${ unidad["BateriaDate"] ?? 'No registrada'  }`]);
					tableHTML += GridConfiguracion.RenderGrid().innerHTML;
				}	

				tableHTML += '    </div>      ';  // col end ultimo checklits & ultima actualizacion	
				tableHTML += '</div>'; //  end row checklist & ultima actualizacion

				tableHTML += '	<div class="row mt-3 shadow border">';  // acordeon row
				tableHTML += ' <div class="col p-3">';

				tableHTML += '<div class="accordion" id="accordionExample">';
				tableHTML += '<div class="accordion-item">';// acordeon ITEM CONTROL
				tableHTML += '<h2 class="accordion-header" id="headingZero">';
				tableHTML += ' <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="false" aria-controls="collapseZero"> Control </button> </h2>';
										
				tableHTML += '<div id="collapseZero" class="accordion-collapse collapse" aria-labelledby="headingZero" data-bs-parent="#accordionExample">';
				
				tableHTML += '<div class="accordion-body">'; // accordion body
				tableHTML += '<div class="overflow-auto">'; // overflow

				if( !this.IsSirecor(unidad["id_unidadTipo"]) )
				{	
					const GridControl = new BootstrapGrid();
					GridControl.headers = [`Control ${ cuartel.Interface != null ? 'Interface '+ cuartel.Interface  : ''}`,'',''];

					let ComandosMilesightDefault;
					let AbirBtn = document.createElement('button');
					AbirBtn.className ='btn btn-primary';
					let CerrarBtn = document.createElement('button');
					CerrarBtn.className = 'btn btn-primary';
					AbirBtn.disabled = unidad.Estado == "1" ? "disabled" : "";
					CerrarBtn.disabled = unidad.Estado != "1" ? "disabled" : "";
					AbirBtn.textContent = 'Abrir';
					CerrarBtn.textContent ='Cerrar';
					
					switch (cuartel.Interface) {
						case null:
						case "0":
							AbirBtn.setAttribute( "onclick", `FunctionComandosMilesight('Abrir V0','${unidad["tag"]}')`) ;
							CerrarBtn.setAttribute( "onclick", `FunctionComandosMilesight('Cerrar V0','${unidad["tag"]}')`);

						case null:
							ComandosMilesightDefault = appModel.Comandos_Milesight.filter(C => C.Default == 1 || C.Default == null);
						break;

						case "0":
							ComandosMilesightDefault = appModel.Comandos_Milesight.filter(C => C.Interface == 0 || C.Interface == null);
						break;

						case "1":
							AbirBtn.setAttribute( "onclick", `FunctionComandosMilesight('Abrir V1','${unidad["tag"]}')`) ;
							CerrarBtn.setAttribute( "onclick", `FunctionComandosMilesight('Cerrar V1','${unidad["tag"]}')`);
							ComandosMilesightDefault = appModel.Comandos_Milesight.filter(C => C.Interface == 1 || C.Interface == null);
						break; 	
					}

					GridControl.rows.push([AbirBtn.outerHTML,'',CerrarBtn.outerHTML]);
					tableHTML += GridControl.RenderGrid().innerHTML;

					tableHTML += '<div class="row border-bottom ">';
						tableHTML += '<div class="col-auto p-3">';
							tableHTML += `<button onclick="FunctionComandosMilesightDesdeSelect('${unidad["tag"]}')" class="btn btn-secondary">Enviar Comando</button>`;
						tableHTML += '</div>';
						tableHTML += '<div class="col-auto py-3">';
							tableHTML += CreateSelectFromObjArray('SelectComandosMilesight',ComandosMilesightDefault,'Nombre','Nombre') ;
						tableHTML += '</div>';
					tableHTML += '</div>';
				}
				else {
		
					tableHTML +='<div id="SMSTable" ></div>'; // sms table from post javascript 
					RefreshIntervals_Ids.push(setInterval(this.Controller.GetSMSTable, 1000, unidad["Id"] ));

					const GridSmS = new BootstrapGrid();

					GridSmS.headers = ['SMS' , '' ];

					GridSmS.rows.push(['Mensaje',
						`<div class="input-group mb-3"><div class="input-group-append"><button class="btn btn-outline-secondary" type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS(\'InputSMS\',${unidad["Id"]})" >Enviar</button></div><input type="text" class="form-control" placeholder="Escriba el SMS en mayusculas" id="InputSMS" ></div></div>`,
					]);
					tableHTML += GridSmS.RenderGrid().innerHTML;
	
					const GridSmSControlesBasicos = new BootstrapGrid();	
					GridSmSControlesBasicos.headers = ['Controles Basicos' , '' , ''  ];

					GridSmSControlesBasicos.rows.push([`<button type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS( 'ABRIR', ${unidad["Id"]} )" class="btn btn-primary" >ABRIR</button>`,
						`<button type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS( 'CERRAR',${unidad["Id"]} )" class="btn btn-primary" >CERRAR</button>`,
					`<button type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS( 'RESET',${unidad["Id"]} )" class="btn btn-primary" >RESET</button></td>`]);

					GridSmSControlesBasicos.rows.push([`<button type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS( 'INTERNET15' ,${unidad["Id"]})" class="btn btn-primary" >Internet cada 1 min</button>`,
						`<button type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS( 'INTERNET75',${unidad["Id"]} )" class="btn btn-primary" >Internet cada 5 min</button>`,
						`<button type="button" onclick="ThisApp.CuartelesPage.Controller.FunctionCreateSMS( 'INTERNET900',${unidad["Id"]} )" class="btn btn-primary" >Internet cada 2 Horas</button>`]);
					
					tableHTML += GridSmSControlesBasicos.RenderGrid().innerHTML;	
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

			tableHTML += `<button type="button" onclick="ThisApp.CuartelesPage.Controller.GetRegistrosDiariosTable(${unidad["Id"]})" class="btn btn-primary" >Refrescar</button>`;
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
			
			const GridEdit = new BootstrapGrid();
			GridEdit.headers = ['Editar',''];
			GridEdit.rows.push(['Introduzca la contraseña para editar:','<input type="text" id="password" name="password" class="form-control">']);
			GridEdit.rows.push([`<button onclick="FunctionFactorFlujometro(${unidad["Id"]})" class="btn btn-secondary">Editar FactorFlujometro</button>`,`<input type="text" id="FactorFlujometro" name="FactorFlujometro" class="form-control" placeholder="Ejemplo: 0.4 (use . no ,)">`]);
			GridEdit.rows.push([`<button onclick="FunctionNuevaUbicacion(${unidad["Id"]})" class="btn btn-secondary">Editar ubicación</button>`,`<input type="text" id="NuevaUbicacion" name="NuevaUbicacion" class="form-control" placeholder="Ejemplo: Z1-3">`]);
			GridEdit.rows.push([`<button onclick="FunctionNuevoNumero('${unidad["Id"]}')" class="btn btn-secondary">Editar número</button> `,`<input type="text" id="NuevoNumero" name="NuevoNumero" class="form-control" placeholder="Ejemplo: 99345469">`]);
			GridEdit.rows.push([`<button onclick="FunctionCambiarVolMax('${unidad["Id"]}')" class="btn btn-secondary">Editar volumen máximo</button> `,`<input type="text" id="VolMax" name="VolMax" class="form-control" placeholder="Ejemplo: 1000">`]);
			GridEdit.rows.push([`<button onclick="FunctionNuevoTipo('${unidad["Id"]}')" class="btn btn-secondary">Editar Tipo</button>`,CreateSelectFromObjArray('NuevoTipo',appModel.UnidadTipo,'Id','Nombre')]);
			GridEdit.rows.push([`<button onclick="FunctionNuevoCuartel(${unidad["Id"]})" class="btn btn-secondary">Editar Cuartel</button>`,CreateSelectFromObjArray('Cuarteles',appModel.Cuarteles,'Id','Name')]);
			GridEdit.rows.push([`<button onclick="FunctionEliminar('${unidad["Id"]}')" class="btn btn-danger">Eliminar</button>`,'']);
			
			tableHTML += GridEdit.RenderGrid().innerHTML;
					
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
					if( rowC["id_unidad"] == unidad.Id ){
						tableHTML += `</td> <td>${rowC["Id"]}</td><td>${rowC["TecnicoResponsable"]}</td> <td>${rowC["Fecha"]}</td> <td><button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalVerChecklist}" data-bs-checklistid="${ rowC.Id }" >ver</button></td></tr>` ;
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
					if( rowC["Id_unidad"] == unidad.Id ){
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

			if( checklist ) {//col foto checlist
				document.getElementById('checklist_photo').innerHTML = `<img class="img-thumbnail" src="${checklist["URL_foto"]}" "="">`;
			}	

			const myCollapsible = document.getElementById('collapseTwo');
			myCollapsible.addEventListener('shown.bs.collapse', function () {
				ThisApp.CuartelesPage.Controller.GetRegistrosDiariosTable(unidad["Id"]);
			});
			}
		});
	}

	async CreateNewChecklistModal( Id_modal )
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
			let unidad = appModel.Unidades.find(t => t.Id == Id_Unidad) ;
			let cuartel = appModel.Cuarteles.find( c => c.Id_unidad == unidad.Id )
			let thisChecklist = appModel.ChecklistsNew.find( ts => ts.id_unidad == unidad.Id )

			ModalLabel.replaceChildren();
			ModalBody.replaceChildren();
			ModalFooter.replaceChildren();
						
			if (verModal) { 
				
				ModalBody.innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
				RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	}); // clean an set intervals
				ModalLabel.textContent = `Nuevo Checklist` ;
				
				const GridChecklistNew = new BootstrapGrid();
				GridChecklistNew.headers = ['','',''];
				GridChecklistNew.rows.push(['<b>IMEI:</b>', unidad["tag"],'']);
				GridChecklistNew.rows.push([`<b>ID de la unidad:</b>`,unidad["Id"],'']);
				GridChecklistNew.rows.push([`<b>Motivo:</b>`,`<select name="ChecklistMotivo" class="form-select" id="ChecklistMotivo" required=""></select>`,'']);											
				GridChecklistNew.rows.push([`<b>Probado con agua:</b>`,`<input type="checkbox" class="form-check-input" id="agua">`,'']);
				GridChecklistNew.rows.push([`<b>Solenoide:</b>`,`<input type="checkbox" class="form-check-input" id="Solenoide">`,'']);
				GridChecklistNew.rows.push([`<b>Flujómetro:</b>`,`<input type="checkbox" class="form-check-input" id="Flujometro">`,'']);
				GridChecklistNew.rows.push([`<b>Conduit y Choco:</b>`,`<input type="checkbox" class="form-check-input" id="ConduitChoco" >`,'']);
				GridChecklistNew.rows.push([`<b>Reemplazo Bateria:</b>`,`<input type="checkbox" class="form-check-input" id="chBox_reemplazoBateria" >`,'']);
				GridChecklistNew.rows.push([`<b>Tipo de bateria:</b>`,`<select name="BateriaTipo" class="form-select" id="BateriaTipo" disabled></select>`,'']);
				GridChecklistNew.rows.push([`<b>Observaciones:</b>`,`<input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, coloque OK.">`,'']);
				GridChecklistNew.rows.push([`<b>Técnico responsable:</b>`,`<input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre">`,'']);
				GridChecklistNew.rows.push([`<b>Imagen:</b>`,`<div id="NombreDeFoto"></div>`,`<div id="StatusFoto"></div>` ,'']);
				GridChecklistNew.rows.push([`<button id="upload" class="btn btn-success btn-lg" >Seleccionar y Subir Foto</button>`,`<input id="sortpicture" type="file" name="sortpic" style="display: none;" />`,`<div id="StatusFoto"></div>` ,`<button id="enviarChecklist"type="button" class="btn btn-success btn-lg" onclick="FunctionNuevoCheckListPost(${unidad["Id"]})">Enviar CheckList</button>`]);

				let tableHTML = GridChecklistNew.RenderGrid().innerHTML;

					const BtnClose =  document.getElementById(this.Id_modalNewChecklist+'_BtnClose');
					BtnClose.removeAttribute('data-bs-dismiss');
					BtnClose.setAttribute('data-bs-target','#'+this.Id_modalUnidadVer);
					BtnClose.setAttribute('data-bs-unidadid',unidad.Id);
					BtnClose.setAttribute('data-bs-toggle','modal');
					
					ModalBody.innerHTML = tableHTML;

					// Si hace click en reemplazo de bateria, desplegar select de opciones de bateria tipo.
					const chBox_reemplazoBateria = document.getElementById('chBox_reemplazoBateria');
					const BateriaTipo = document.getElementById('BateriaTipo');

					appModel.BateriaTipos.forEach(row => {
						const NewOption = new Option(row["Name"], row["Id"]);
						BateriaTipo.add(NewOption);
					});

					chBox_reemplazoBateria.addEventListener('click', () => {
						BateriaTipo.disabled = chBox_reemplazoBateria.checked ? false : true ;				
					});
			
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

					const selectChecklistMotivo = document.getElementById('ChecklistMotivo');
					appModel.ChecklistMotivos.forEach(row => {
						const NewOption = new Option(row["Name"], row["Id"]);
						selectChecklistMotivo.add(NewOption);
					});	
			}
		});
	}
	async CreateVerChecklistModal( Id_modal )
	{
			this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));

			const verModal = document.getElementById(Id_modal);

			let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
			let ModalBody = document.getElementById(Id_modal+'_ModalBody');
			let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');
	
			verModal.addEventListener('show.bs.modal', async(event) => {

			ModalLabel.replaceChildren();
			ModalBody.replaceChildren();
			ModalFooter.replaceChildren();

			const button = event.relatedTarget;
			const Id_checklist = button.getAttribute('data-bs-checklistid');
	
			var checklist = appModel.ChecklistsNew.find( checklist => checklist.Id == Id_checklist );
			var unidad = appModel.Unidades.find( u => u.Id = checklist.id_unidad  );
						
			if (verModal) { 
				
				ModalBody.innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
				
				RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	}); // clean an set intervals

				if( unidad ) {
					ModalLabel.textContent = `checklist de ${unidad["Serie"]}` ;
				}

				const GridChecklistVer = new BootstrapGrid();
				GridChecklistVer.headers = ['',''];
				GridChecklistVer.rows.push(['<b>Fecha:</b>', checklist["Fecha"]]);
				GridChecklistVer.rows.push([`<b>Solenoide:</b>`,checklist["Solenoide"]]);
				GridChecklistVer.rows.push([`<b>Flujómetro:</b>`,checklist["Flujometro"]]);
				GridChecklistVer.rows.push([`<b>Conduit y Choco:</b>`,checklist["ConduitChoco"]]);
				GridChecklistVer.rows.push([`<b>Probado con agua:</b>`,checklist["agua"]]);
				GridChecklistVer.rows.push([`<b>Observaciones:</b>`,checklist["Observaciones"]]);
				GridChecklistVer.rows.push([`<b>Técnico responsable:</b>`,checklist["TecnicoResponsable"]]);
				GridChecklistVer.rows.push([`<b>Imagen:</b>`,`<div class='col-4'><img src='${checklist["URL_foto"]}' class='img-thumbnail' > </div>`]);
					
			let tableHTML = GridChecklistVer.RenderGrid().innerHTML;
			
			const BtnClose =  document.getElementById(this.Id_modalVerChecklist+'_BtnClose');
				BtnClose.removeAttribute('data-bs-dismiss');
				BtnClose.setAttribute('data-bs-target','#'+this.Id_modalUnidadVer);
				BtnClose.setAttribute('data-bs-unidadid',unidad.Id);
				BtnClose.setAttribute('data-bs-toggle','modal');
					
				ModalBody.innerHTML = tableHTML;
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
		
					if( unidad && unidad["id_unidadTipo"] == unidadTipo  ) {
						UnidadesFiltradas.push( unidad );
					}
				}	
			});
			
		return UnidadesFiltradas;
	}

	GetUnidadesDataTableAreaExterna(   )
	{		
		let UnidadesFiltradas = [];

			appModel.Cuarteles.forEach(row => {

				if(  row["AreaExterna"] == '1' ) 
				{   
					let unidad = appModel.Unidades.find( u => u.Id == row["Id_unidad"]);
					UnidadesFiltradas.push( unidad );
				}	
			});
			
		return UnidadesFiltradas;
	}


	GetUnidadesDataTableIndefinidas( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Unidades.forEach(Unidad => {
				
				if( Unidad.id_unidadTipo == '' || Unidad.id_unidadTipo == null ) {
					UnidadesFiltradas.push( Unidad );
				}	
			});	
			
		return UnidadesFiltradas;
	}

	GetUnidadesDataTableSinCuartel( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Unidades.forEach(Unidad => {
			
				let Cuartel = appModel.Cuarteles.find( c =>  c.Id_unidad == Unidad.Id);	
				if(!Cuartel ) {
					UnidadesFiltradas.push( Unidad );
				}			
			});	
		return UnidadesFiltradas;
	}

	RenderCuartelesTable(  UnidadesFiltradas )
	{

		UnidadesFiltradas.sort((a, b) => Date.parse(b["UltimaActualizacion"]) - Date.parse(a["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["Estado"].localeCompare(a["Estado"]));

		let dataTable =[];

		let HeaderUbicacion 	=  '<i class="bi bi-pin-map">';
		let HeaderSerie			=  '<i class="bi bi-motherboard"></i>';
		let HeaderEstado		=  '';		
		let HeaderActivity		=  '<i class="bi bi-activity"></i>';	
		let HeaderBateryLevel	=  '<i class="bi bi-lightning-fill"></i>';
		let HeaderSignal		=  '<i class="bi bi-wifi"></i>';			
		let HeaderCaudal		=  '[L/m]';			
		let HeaderVolumen		=  '[L]' ;
			
		const headers = [HeaderUbicacion,HeaderSerie,HeaderEstado,HeaderActivity,HeaderBateryLevel,HeaderSignal,HeaderCaudal,HeaderVolumen];
				
		UnidadesFiltradas.forEach(rowU => {
			
			let	Ubicacion = '',Serie = '' ,Estado= '' ,Activity = '',BateryLevel = '',Signal = '',Caudal = '',Volumen = '' ;	

			let Cuartel = appModel.Cuarteles.find( c => c.Id_unidad == rowU.Id);

			Ubicacion = Cuartel ? Cuartel.Name : 'Sin cuartel' ;
			Serie = `<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalUnidadVer}" data-bs-unidadid="${ rowU.Id }"  ${ Cuartel ? ( "data-bs-cuartelid=" +Cuartel.Id) : "" } >${rowU['Serie']}</button>`;

			if(rowU.Id_Last_RegistroDiario)
			{	
				Estado = FieldEstado(rowU.Estado);
				Activity = FieldActivity(rowU.UltimaActualizacion);
				BateryLevel =	FieldBattery(rowU.BatNivel);
				Signal = FieldSignal(rowU.Senal, rowU.UltimaActualizacion);		
				Caudal = FieldCaudal(rowU.Caudal);
				Volumen = FieldVolumen(rowU);	
			}	
			else{
				Estado = 'Sin Registros';
			}		
			
			dataTable.push({Ubicacion: Ubicacion ,Serie: Serie,Estado: Estado,Activity: Activity,BateryLevel: BateryLevel, Signal: Signal,Caudal: Caudal,Volumen: Volumen});
		});

		return this.RenderTable( headers, dataTable);
	}

	IsSirecor( Id_UnidadTipo ) {
		return ( Id_UnidadTipo == '1' ||  Id_UnidadTipo == '2' ) ? true : false; // Sirecor7600 or EStanque7600
	}
}

class BootstrapAccordeon
{
	constructor( ItemsTitles, Id   ) {
		this.ItemsTitles  = ItemsTitles;
		this.accordionElement = document.createElement('div');
		this.accordionElement.className = 'accordion';
		this.AcordionItems;
	}

}


