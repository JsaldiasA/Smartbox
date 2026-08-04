class RfvTicketPage extends Page
{
	constructor( )
	{
		super();
		this.Titulo = 'Rfv Tickets';
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
		buttonRightElement.className ='btn btn-primary';
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

	CreateVerTicketModal( Id_modal )
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
				dataTable.push( new newtkROW( 'Descripcion', thisTicket["Descripcion"] ));
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
				this.FunctionDeleteTicket(thisTicket.Id);
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
		
		this.mainDiv.appendChild(this.CreateModalComponent( Id_modal ));
		
		let ModalLabel = document.getElementById(Id_modal+'_ModalLabel');
		let ModalBody = document.getElementById(Id_modal+'_ModalBody');
		let ModalFooter = document.getElementById(Id_modal+'_ModalFooter');

		ModalLabel.textContent = 'Nuevo Ticket';

		let ModalBtn = document.createElement('button');
		ModalBtn.type = "button";
		ModalBtn.className = 'btn btn-success';
		ModalBtn.textContent = 'Enviar ticket';

		ModalFooter.appendChild(ModalBtn);
		
		ModalBtn.addEventListener("click", () => {
			this.CreateTicket();
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
	
		ModalBody.appendChild( this.RenderTable(null , dataTable))

	}

 	async GetMainTable( containerDiv  )
	{	
		containerDiv.replaceChildren(); 
		await appModel.RefreshTickets();

		let TicketPriorities = this.GetTicketPriority();
		
		appModel.RfvTicketStatus.sort((a, b) => a.Id - b.Id);
		
		appModel.RfvTicketStatus.forEach(TkStatus => {

			let dataTable = [];
			const headers = ['<i class="bi bi-pin-map">','Nombre','Proridad', ( TkStatus.Id == `3` ? `Fecha Cierre ` : `Hace` ), '' ];

			class dTRow
			{
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
					let CuartelName = `no name`;
					let RfvTicketPriority = `no name`;			

					appModel.Cuarteles.forEach(rowCT => {	if(rowCT["Id_unidad"] == rowTK["Id_unidad"])	CuartelName=rowCT["Name"];	});
					TicketPriorities.forEach(Tp => {	if(Tp["Id"] == rowTK["Id_RfvTicketPriority"])	RfvTicketPriority = Tp;	});

					let dataTableRow = new dTRow();

					dataTableRow.CuartelName = CuartelName;
					dataTableRow.Nombre = rowTK.Nombre;
					dataTableRow.RfvTicketPriority = this.priorityColorText( RfvTicketPriority['Id'],RfvTicketPriority["Name"]);
					dataTableRow.FechaCierre = (TkStatus.Id == `3` ? rowTK["FechaCierre"] : ( FieldFecha(rowTK["FechaInicio"]) ) );
					dataTableRow.verHref = `<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#${this.Id_modalVerTicket}" data-bs-TicketId="${rowTK.Id}">Revisar</button>`;

					dataTable.push(dataTableRow);
				}	
				
			});

			let tableContent = this.RenderTable(headers,dataTable) ;
			containerDiv.appendChild( this.RenderRowContainer( TkStatus.Estado ,tableContent ) );
			
		});

	}

		 CreateTicket()
		{
			let text = "¿Está seguro de enviar el ticket?";
			if (confirm(text) == true)
				{
					let pattern = /(^\d+\.\d+$)|(^\d+$)/;
					var URL = "https://smartbox.eco3.cl/ApiController/Rfvticket/Create.php";
					var Respuesta;

					var Nombre = document.getElementById("Nombre").value;
					
					if (Nombre == "")	return alert ("Debe especificar un dispositivo y/o plataforma.");
						
					var Descripcion = document.getElementById("Descripcion").value;
					if (Descripcion == "" )	 return alert ("Debe explicar de que se trata el problema.");

					var Usuario = document.getElementById("Usuario").value;
					if (Usuario == "" )		return alert ("Debe escribir su nombre.");
						
					var Ubicacion = document.getElementById("Ubicacion").value;
					
					if (Ubicacion == "")	return alert ("Debe especificar una ubicacion de referencia.");

					var f = document.getElementById("RfvTicketPriority");
					var Id_RfvTicketPriority = f.options[f.selectedIndex].value; 

					$.ajax(
						{
            				url:URL,
            				type:"post",
							dataType:'text',
							data:
								{
									Nombre: Nombre,
									Descripcion: Descripcion,
									Usuario: Usuario,
									Ubicacion: Ubicacion,
									Id_RfvTicketPriority: Id_RfvTicketPriority
        						},
							success: function(result)
							{
								alert (result);
								window.location.reload();
							}
						});
  				}
			else
				{
    				alert ("La operación se ha cancelado.");
  				}
		}

	


	  GetTicketPriority( )
	{

		const PrioridadGrave = {
		Id: "1",
		Name: "Alta",
		Reasons:[{Id: "1",Name:"Desconectado"},{Id: "2",Name:"No Abre"}]
		};

		const PrioridadMedia = {
		Id: "2",
		Name: "Media",
		Reasons:[{Id: "10",Name:"No marca"}]
		};

		const PrioridadBaja = {
		Id: "3",
		Name: "Baja",
		Reasons:[{Id: "3",Name:"Bateria baja"},{Id: "4",Name:"Sin condit"},{Id: "6",Name:"Sin choco"},{Id: "7",Name:"Fuga agua"},{Id: "8",Name:"Caja de energizacion"},{Id: "9",Name:"otro"}]
		};

		Priorities = [PrioridadGrave,PrioridadMedia,PrioridadBaja]

  		return Priorities;
  
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

	 FunctionDeleteTicket(id_ticket)
	{
		let text = "¿Está seguro de eliminar el ticket?";
		if (confirm(text) == true)
		{
			var MotivoCierre = document.getElementById("MotivoCierre").value;

			if (MotivoCierre == "")
			{
				return alert ("Debe escribir el motivo del cierre");
			}

			let pattern = /(^\d+\.\d+$)|(^\d+$)/;
			var URL = "https://smartbox.eco3.cl/ApiController/rfvticket/Delete.php";
			var Respuesta;
		
			$.ajax(
			{
				url:URL,
				type:"post",
				dataType:'text',
				data:
					{
						Id: id_ticket,
						MotivoDeCierre: MotivoCierre
					},
				success: function(result)
					{
						alert (result);
						window.location.reload();
					}
			});
		}
		else{
			alert ("La operación se ha cancelado.");
		}
	}
	
}






  

