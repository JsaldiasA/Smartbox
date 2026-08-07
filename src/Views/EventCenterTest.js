class EventCenterPage extends Page
{
	constructor( )
	{
		super();
		this.Titulo = 'EventCenterPage';


		let buttonRightElement = document.createElement('button');
		buttonRightElement.className ='btn btn-primary btn-sm';
		buttonRightElement.type = 'button';
		buttonRightElement.textContent = 'borrar Todos';
		buttonRightElement.onclick = function() {
		NewTicketPage();
		};

		this.TituloRighElement.appendChild(buttonRightElement);

	}

	async GetMain( )
	{
		super.GetMain();
		let mainTableDiv = document.createElement('div');
		mainTableDiv.id = 'EventCenterTable';
		this.mainDiv.appendChild(mainTableDiv);
		await this.GetMainTable(mainTableDiv);
	}

 	async GetMainTable( containerDiv  )
	{
		await appModel.RefresheventMessage();
	
		appModel.eventMessage.sort((a, b) => b.Id - a.Id);

			let dataTable = [];
			const headers = ['Id','Ubicacion','Tipo','Hace', 'Text' ];

			class dTRow
			{
				constructor()
				{
					this.Id;
					this.Ubicacion;
					this.Tipo;
					this.Hace;
					this.Text;
				}
			}

			appModel.eventMessage.forEach( Message => {
				if(Message['checked'] == '0')
				{
					let dataTableRow = new dTRow();

					let Unidad ;
					let Cuartel ;
					let MessageType;
					
					appModel.Unidades.forEach( unidad => {	if( unidad["Id"] == Message["Id_unidad"])	Unidad=unidad;	});
					appModel.Cuarteles.forEach( cuartel => {	if( cuartel["Id_unidad"] == Message["Id_unidad"])	Cuartel=cuartel;	});
					appModel.eventMessagesTypes.forEach( Mtype => {	if( Message["Id_MessageType"] == Mtype["Id"])	MessageType=Mtype;	});

					let UbicacionName = Cuartel ? (Cuartel['Name']) : ( Unidad ? ("{TAG}" + Unidad['tag'] ) : 'NOUNIT');
					
					
					dataTableRow.Id=  Message['Id'];
					dataTableRow.Ubicacion= UbicacionName ;
					dataTableRow.Tipo= MessageType ? MessageType["Name"] : "Indefinido " ;
					dataTableRow.Hace= FieldActivity ( Message['CreationDate'] ) ;
					dataTableRow.Text =  Message['MessageText'];

					dataTable.push(dataTableRow);
				}
			});

			
		containerDiv.replaceChildren(); 
		containerDiv.appendChild( this.RenderTable(headers,dataTable) )

	}

}

