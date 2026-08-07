class RfvTicketPage extends Page
{
	constructor( )
	{
		super();
		this.Titulo = 'Rfv Tickets';
		this.Id_modaVerImg = 'VerImg';
		this.Id_modalNewTicket = 'NewTk';
		this.Id_modalVerTicket = 'VerTk';
		this.Controller = new RfvTicketController();
	}

	async GetMain( )
	{
		super.GetMain();

		this.CreateVerImgenModal( this.Id_modaVerImg );
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

	CreateVerImgenModal( Id_modal )
	{
			this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));

			const verModal = document.getElementById(Id_modal);
			const dialogModal =  document.querySelector('.modal-dialog');
			dialogModal.className = 'modal-dialog modal-xl';

			let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
			let ModalBody = document.getElementById(Id_modal+'_ModalBody');
			let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');
	
			verModal.addEventListener('show.bs.modal', event => {

				const button = event.relatedTarget;
				const Id_ticket = button.getAttribute('data-bs-RfvTicketId');
				let thisTicket = appModel.RfvTickets.find(t => t.Id == Id_ticket) ;

				ModalLabel.replaceChildren();
				ModalBody.replaceChildren();
				ModalFooter.replaceChildren();
							
				if (verModal) { 

					ModalLabel.textContent =  'foto de ' + thisTicket.Nombre  ;

					let foto = document.createElement('img');
					foto.src = thisTicket.URL_foto;
					foto.className = 'img-thumbnail';

					ModalBody.appendChild(foto);

					let ModalBtn = document.createElement('button');
					ModalBtn.type = "button";
					ModalBtn.id = 'EnviarTicketBtn'
					ModalBtn.className = 'btn btn-success';
					ModalBtn.innerHTML = '<i class="bi bi-arrow-left"> Atras</i>';
					ModalBtn.setAttribute('data-bs-RfvTicketId', thisTicket.Id );
					ModalBtn.setAttribute('data-bs-target','#'+this.Id_modalVerTicket );
					ModalBtn.setAttribute('data-bs-toggle', "modal" );

					ModalFooter.appendChild(ModalBtn);
				}
			});
	}

	CreateVerTicketModal( Id_modal )
	{
			this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));

			const verModal = document.getElementById(Id_modal);

			let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
			let ModalBody = document.getElementById(Id_modal+'_ModalBody');
			let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');
	
			verModal.addEventListener('show.bs.modal', event => {

				const button = event.relatedTarget;
				const Id_ticket = button.getAttribute('data-bs-RfvTicketId');
				let thisTicket = appModel.RfvTickets.find(t => t.Id == Id_ticket) ;
		
				let thisTicketStatus = appModel.RfvTicketStatus.find( ts => ts.Id == thisTicket.Id_RfvTicketStatus  )

				ModalLabel.replaceChildren();
				ModalBody.replaceChildren();
				ModalFooter.replaceChildren();
							
				if (verModal) { 

					ModalLabel.textContent =  thisTicket.Nombre  ;

					class newtkROW
					{
						constructor(Nombre , Input )
						{
							this.Nombre = Nombre ;
							this.Input = Input ;
						}
					}

					let StatusCerrado = '2';
					let StatusAbierto = '1';

					let dataTable =[];
					dataTable.push( new newtkROW( 'ID', thisTicket["Id"] ));
					dataTable.push( new newtkROW( 'Título',	thisTicket["Nombre"]	));
					dataTable.push( new newtkROW( 'Descripcion', `<div class="text-wrap"> ${thisTicket["Descripcion"]} </div>` ));
					dataTable.push( new newtkROW( 'Ubicacion', thisTicket["Ubicacion"] ));
					dataTable.push( new newtkROW( 'Usuario', thisTicket["Usuario"] ));
					dataTable.push( new newtkROW( 'Fecha de ingreso',  thisTicket["FechaInicio"] +" "+ FieldActivity(thisTicket["FechaInicio"])  ));
					dataTable.push( new newtkROW( 'Estado de la solicitud', thisTicketStatus.Descripcion ));
					dataTable.push( new newtkROW( 'Imagen', `<img id="preview" src="${thisTicket.URL_foto}" alt="Image Preview" class="img-thumbnail"  data-bs-toggle="modal" data-bs-target="#${this.Id_modaVerImg}" data-bs-RfvTicketId="${thisTicket.Id}"  > `  ));

					if ( thisTicket["Id_RfvTicketStatus"] == StatusCerrado ) dataTable.push( new newtkROW( 'Motivo del cierre', thisTicket["MotivoDeCierre"] ));
					
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
					ModalBtn.addEventListener("click", () => {
					this.Controller.FunctionDeleteTicket(thisTicket["Id"]);
					});

					inpGropPrependEliminar.appendChild(ModalBtn);
					InputGroupEliminar.appendChild(inpGropPrependEliminar);
					InputGroupEliminar.appendChild(MotivoCierreInput);

					if ( thisTicket["Id_RfvTicketStatus"] == StatusAbierto ) ModalFooter.appendChild(InputGroupEliminar);

				}
			});
	}

	CreateNewTicketModal( Id_modal ) {	
		
		this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));
		
		let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
		let ModalBody = document.getElementById(Id_modal+'_ModalBody');
		let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');

		ModalLabel.textContent = 'Nuevo Ticket';

		let uploadBtn = document.createElement('button');
		uploadBtn.type = "button";
		uploadBtn.id = "upload";
		uploadBtn.className = 'btn btn-success';
		uploadBtn.textContent = 'Subir Foto';

		ModalFooter.appendChild(uploadBtn);

		let sortpicture = document.createElement('input');
		sortpicture.type = "file";
		sortpicture.name = 'sortpic';
		sortpicture.style = "display: none;";

		ModalFooter.appendChild(sortpicture);

		let ModalBtn = document.createElement('button');
		ModalBtn.type = "button";
		ModalBtn.id = 'EnviarTicketBtn'
		ModalBtn.className = 'btn btn-success';
		ModalBtn.textContent = 'Enviar ticket';

		ModalFooter.appendChild(ModalBtn);

		// 1. Forward the custom button click to the hidden file input
		upload.addEventListener('click', () => {
			sortpicture.click(); 
		});

		// 2. Catch the exact moment a file is selected and upload it
		sortpicture.addEventListener('change', async () => {
			if (sortpicture.files.length === 0)  alert("archivo no encontrado");
			else  this.Controller.uploadPicture(sortpicture.files[0]);
    	});
		
		ModalBtn.addEventListener("click", () => {
			this.Controller.CreateTicket();
		});

		class newtkROW
		{
			constructor(Nombre , Input )
			{
				this.Nombre = Nombre ;
				this.Input = Input ;
			}
		}

		let dataTable =[];
		dataTable.push( new newtkROW( 'Prioridad', CreateSelectFromObjArray('RfvTicketPriority', appModel.TicketPriorities,'Id','Name') ));
		dataTable.push( new newtkROW( 'Título',	' <input type="text" class="form-control" id="Nombre" placeholder="Titulo para el ticket"> '	));
		dataTable.push( new newtkROW( 'Descripcion', '<input type="text" class="form-control" style="height: 200px; width: 100%" id="Descripcion" >'));
		dataTable.push( new newtkROW( 'Usuario', '<input type="text" class="form-control" id="Usuario" placeholder="Escriba su nombre.">'	));
		dataTable.push( new newtkROW( 'Ubicacion', '<input type="text" class="form-control" id="Ubicacion" placeholder=" Referencia de ubicacion">' ));
		dataTable.push( new newtkROW( 'Imagen', '<div id="NombreDeFoto" class="d-inline" ></div> <div id="StatusFoto" class="d-inline" ><p class="fst-italic">No foto</p></div>' ));
		ModalBody.appendChild( this.RenderTable(null , dataTable))

	}

 	async GetMainTable( containerDiv ) {	

		containerDiv.replaceChildren(); 
		await appModel.RefreshTickets();
		let TicketPriorities = this.Controller.GetTicketPriority();
		appModel.RfvTicketStatus.sort((a, b) => a.Id - b.Id);
		appModel.RfvTicketStatus.forEach(TkStatus => {

			let dataTable = [];
			const headers = ['<i class="bi bi-pin-map">','Nombre','Proridad', ( TkStatus.Id == `3` ? `Fecha Cierre ` : `Hace` ), '' ];

			class dTRow{
				constructor()
				{
					this.CuartelName;
					this.Nombre;
					this.RfvTicketPriority;
					this.FechaCierre;
					this.verHref;
				}
			}

			appModel.RfvTickets.forEach(rowTK => {

				if( TkStatus.Id == rowTK["Id_RfvTicketStatus"])
				{
		
					let RfvTicketPriority = `no name`;			

					TicketPriorities.forEach(Tp => {	if(Tp["Id"] == rowTK["Id_RfvTicketPriority"])	RfvTicketPriority = Tp;	});

					let dataTableRow = new dTRow();

					dataTableRow.CuartelName = rowTK.Ubicacion;
					dataTableRow.Nombre = rowTK.Nombre;
					dataTableRow.RfvTicketPriority = this.priorityColorText( RfvTicketPriority['Id'],RfvTicketPriority["Name"]);
					dataTableRow.FechaCierre = (TkStatus.Id == `3` ? rowTK["FechaCierre"] : ( FieldFecha(rowTK["FechaInicio"]) ) );
					dataTableRow.verHref = `<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalVerTicket}" data-bs-RfvTicketId="${rowTK.Id}">Revisar</button>`;

					dataTable.push(dataTableRow);
				}	
			});

			let tableContent = this.RenderTable(headers,dataTable) ;
			containerDiv.appendChild( this.RenderRowContainer( TkStatus.Estado ,tableContent ) );
		});
	}
	
 	priorityColorText( Id_TicketPriority, text)
	{

		switch ( Id_TicketPriority ) {
		
			case '1':
				return `<div class="text-danger"><b> ${text} </b></div>`
				
			case '2':
				return `<div class="text-warning"><b> ${text} </b></div>`

			case '3':
				return `<div class="text-success"><b> ${text} </b></div>`

			default:
				// Code to execute if expression matches no cases
				return text;
		}
	}
	
}






  

