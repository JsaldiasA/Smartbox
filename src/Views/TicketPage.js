class TicketPage extends Page
{
	constructor( )
	{
		super();
		this.Titulo = 'Tickets';
		this.Id_modalNewTicket = 'NewTk';
		this.Id_modalVerTicket = 'VerTk';

		
	}

	async GetMain( )
	{
		super.GetMain();

		this.CreateNewTicketModal( this.Id_modalNewTicket );
		this.CreateVerTicketModal( this.Id_modalVerTicket );
		
		let rightElement = document.createElement('div');

		let buttonRightElement = document.createElement('button');
		buttonRightElement.className ='btn btn-success';
		buttonRightElement.type = 'button';
		buttonRightElement.textContent = ' Ingresar nuevo Ticket';
		buttonRightElement.setAttribute('data-bs-toggle', 'modal') ;
		buttonRightElement.setAttribute('data-bs-target', '#'+this.Id_modalNewTicket) ;

		const iconAdd = document.createElement('i');
		iconAdd.className = 'bi bi-plus-lg';
		buttonRightElement.prepend(iconAdd);

		this.TituloRighElement.replaceChildren();
		this.TituloRighElement.appendChild(buttonRightElement);
		
		let mainTableDiv = document.createElement('div');
		mainTableDiv.id= 'TicketTable';
		this.mainDiv.appendChild(mainTableDiv);
		await this.GetMainTable(mainTableDiv);
	}

	async CreateVerTicketModal( Id_modal )
	{
			this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));

			const verModal = document.getElementById(Id_modal);

			let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
			let ModalBody = document.getElementById(Id_modal+'_ModalBody');
			let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');
	
			verModal.addEventListener('show.bs.modal', event => {

			const button = event.relatedTarget;
			const Id_ticket = button.getAttribute('data-bs-TicketId');
			let thisTicket = appModel.Tickets.find(t => t.Id == Id_ticket) ;
			let thisCuartel = appModel.Cuarteles.find( c => c.Id_unidad == thisTicket.Id_unidad )
			let thisTicketStatus = appModel.TicketStatus.find( ts => ts.Id == thisTicket.Id_TicketStatus  )

			ModalLabel.replaceChildren();
			ModalBody.replaceChildren();
			ModalFooter.replaceChildren();
						
			if (verModal) { 

				ModalLabel.textContent =  thisTicket.Nombre + ' en ' + thisCuartel.Name ;

				class newtkROW
				{
					constructor(Nombre , Input )
					{
						this.Nombre = Nombre ;
						this.Input = Input ;
					}
				}

				let StatusCerrado = '3';
				let StatusAbierto = '1';

				let dataTable =[];
				dataTable.push( new newtkROW( 'ID', thisTicket["Id"] ));
				dataTable.push( new newtkROW( 'Título',	thisTicket["Nombre"]	));
				dataTable.push( new newtkROW( 'Descripcion', thisTicket["Descripcion"]  ));
				dataTable.push( new newtkROW( 'Usuario', thisTicket["Usuario"] ));
				dataTable.push( new newtkROW( 'Fecha de ingreso',  thisTicket["FechaInicio"] +" "+ FieldActivity(thisTicket["FechaInicio"])  ));
				dataTable.push( new newtkROW( 'Estado de la solicitud', thisTicketStatus.Descripcion ));
				if ( thisTicket["Id_TicketStatus"] == StatusCerrado ) dataTable.push( new newtkROW( 'Motivo del cierre', thisTicket["MotivoDeCierre"] ));
				
				ModalBody.appendChild( this.RenderTable(null , dataTable));

				let inpGropPrependEliminar = document.createElement('div');
				inpGropPrependEliminar.className = 'input-group-prepend'; 

				let InputGroupEliminar = document.createElement('div');
				InputGroupEliminar.className = 'input-group mb-3';

				let MotivoCierreInput = document.createElement('input');
				MotivoCierreInput.type = 'text';
				MotivoCierreInput.className =  "form-control";
				MotivoCierreInput.setAttribute("aria-describedby", "basic-addon1");
				MotivoCierreInput.placeholder="Describa motivo del cierre";
				MotivoCierreInput.id = "MotivoCierre";

				let ModalBtn = document.createElement('button');
				ModalBtn.type = "button";
				ModalBtn.className = 'btn btn-danger';
				ModalBtn.textContent = 'Eliminar ticket';
				ModalBtn.onclick = function() {
				FunctionDeleteTicket(thisTicket.Id);
				};

				inpGropPrependEliminar.appendChild(ModalBtn);
				InputGroupEliminar.appendChild(inpGropPrependEliminar);
				InputGroupEliminar.appendChild(MotivoCierreInput);

				if ( thisTicket["Id_TicketStatus"] == StatusAbierto ) ModalFooter.appendChild(InputGroupEliminar);

				}

			});
		

	}

	CreateNewTicketModal( Id_modal )
	{	
		
		this.mainDiv.appendChild( this.CreateModalComponent( Id_modal ) );
		
		let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
		let ModalBody = document.getElementById(Id_modal+'_ModalBody');
		let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');

		ModalLabel.textContent = 'Nuevo Ticket';

		let EnviarTicketBtn = document.createElement('button');
		EnviarTicketBtn.type = "button";
		EnviarTicketBtn.className = 'btn btn-success';
		EnviarTicketBtn.textContent = 'Enviar ticket';
		EnviarTicketBtn.id = 'EnviarTicketBtn';

		EnviarTicketBtn.addEventListener('click', () => {
			
			this.BtnWaitingStauts(EnviarTicketBtn, 'Enviando..');
			FunctionNuevoTicketPost();
		});


		ModalFooter.appendChild(EnviarTicketBtn);
		
		class newtkROW
		{
			constructor(Nombre , Input )
			{
				this.Nombre = Nombre ;
				this.Input = Input ;
			}
		}

		let dataTable =[];
		dataTable.push( new newtkROW( 'Prioridad', CreateSelectFromObjArray('TicketPriority',appModel.TicketPriorities,'Id','Name') ));
		dataTable.push( new newtkROW( 'Título',	' <div id="NombreSelectDOM" > '	));
		dataTable.push( new newtkROW( 'Descripcion', '<input type="text" class="form-control" style="height: 200px; width: 100%" id="Descripcion" >'));
		dataTable.push( new newtkROW( 'Usuario', '<input type="text" class="form-control" id="Usuario" placeholder="Escriba su nombre.">'	));
		dataTable.push( new newtkROW( 'Cuartel', CreateSelectFromObjArray('cuartel',appModel.Cuarteles,'Id_unidad','Name') ));
	
		ModalBody.appendChild( this.RenderTable(null , dataTable))

		var f = document.getElementById("TicketPriority");
		var Id_TicketPriority = f.options[f.selectedIndex].value; 
		let SelectedPriority = appModel.TicketPriorities.find(Tkp => Tkp.Id == Id_TicketPriority );

		document.getElementById('NombreSelectDOM').innerHTML= CreateSelectFromObjArray('Nombre',SelectedPriority['Reasons'],'Id','Name');

		const statusSelect = document.querySelector('#TicketPriority');

		statusSelect.addEventListener('change', (event) => {
			let f = document.getElementById("TicketPriority");
			let Id_TicketPriority = f.options[f.selectedIndex].value; 
			let SelectedPriority = appModel.TicketPriorities.find(Tkp => Tkp.Id == Id_TicketPriority );

			document.getElementById('NombreSelectDOM').innerHTML= CreateSelectFromObjArray('Nombre',SelectedPriority['Reasons'],'Id','Name');
		});

	}

 	async GetMainTable( containerDiv  )
	{	
		containerDiv.replaceChildren(); 
		await appModel.RefreshTickets();

		let TicketPriorities = GetTicketPriority();
		
		appModel.TicketStatus.sort((a, b) => a.Id - b.Id);
		
		appModel.TicketStatus.forEach(TkStatus => {

			let dataTable = [];
			const headers = ['<i class="bi bi-pin-map">','Nombre','Proridad', ( TkStatus.Id == `3` ? `Fecha Cierre ` : `Hace` ), '' ];

			class dTRow
			{
				constructor()
				{
					this.CuartelName;
					this.Nombre;
					this.TicketPriority;
					this.FechaCierre;
					this.verHref;
				}
			}

			appModel.Tickets.forEach(rowTK => {

				if( TkStatus.Id == rowTK["Id_TicketStatus"])
				{
					let CuartelName = `no name`;
					let TicketPriority = `no name`;			

					appModel.Cuarteles.forEach(rowCT => {	if(rowCT["Id_unidad"] == rowTK["Id_unidad"])	CuartelName=rowCT["Name"];	});
					TicketPriorities.forEach(Tp => {	if(Tp["Id"] == rowTK["Id_TicketPriority"])	TicketPriority = Tp;	});

					let dataTableRow = new dTRow();

					dataTableRow.CuartelName = CuartelName;
					dataTableRow.Nombre = rowTK.Nombre;
					dataTableRow.TicketPriority = priorityColorText( TicketPriority['Id'],TicketPriority["Name"]);
					dataTableRow.FechaCierre = (TkStatus.Id == `3` ? rowTK["FechaCierre"] : ( FieldFecha(rowTK["FechaInicio"]) ) );
					dataTableRow.verHref = `<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalVerTicket}" data-bs-TicketId="${rowTK.Id}">Revisar</button>`;

					dataTable.push(dataTableRow);
				}	
				
			});

			let tableContent = this.RenderTable(headers,dataTable) ;
			containerDiv.appendChild( this.RenderRowContainer( TkStatus.Estado ,tableContent ) );
			
		});

	}
	
}






  

