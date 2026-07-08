
async function GetMainEventCenter(  )
	{	
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	});	

		document.getElementById(`main`).innerHTML = GetTituloEventCenter();

		// data table
		document.getElementById(`main`).innerHTML += `<div id="mainTableEventCenter" ><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>`;
		GetEventCenterMainTable('mainTableEventCenter');
		RefreshIntervals_Ids.push(setInterval(GetEventCenterMainTable, 5000,`mainTableEventCenter` ));

	}	

	function GetTituloEventCenter(  )
	{

		return `          <div class="container">
			<div class="row pb-3">
					<div class="col p-3">
						${GetTitulo('Eventos')}
					</div>
				</div>
				<div id="main"></div>
			</div>`;
		
	}

async function GetEventCenterMainTable( HtmlElementId  )

	{
		let [eventMessages, eventMessagesTypes, Unidades,Cuarteles] = await Promise.all([GetEventMessages(), GetEventMessagesType(), GetUnidades(), GetCuarteles()]);
		
		let tableHTML = ``;
		
		eventMessages.sort((a, b) => b.Id - a.Id);

			tableHTML += `	<div class="row pb-3">`;
			tableHTML += ` <div class="col p-3 card shadow p-3 card shadow">`;
			tableHTML += `   <div class="overflow-auto">`;
			tableHTML += `<table class="table text-nowrap"><thead><tr>`;
			tableHTML += `<th scope="col">Id</th>`;
			tableHTML += `<th scope="col">Ubicacion</th>`;
			tableHTML += `<th scope="col">Tipo</th>`;
			tableHTML += `<th scope="col">Hace</th>`;
			tableHTML += `<th scope="col">Text</th>`;
			tableHTML += `</thead>`;

			eventMessages.forEach( Message => {
				if(Message['checked'] == '0')
				{

				
				let Unidad ;
				let Cuartel ;
				let MessageType;
				
				Unidades.forEach( unidad => {	if( unidad["Id"] == Message["Id_unidad"])	Unidad=unidad;	});
				Cuarteles.forEach( cuartel => {	if( cuartel["Id_unidad"] == Message["Id_unidad"])	Cuartel=cuartel;	});
				eventMessagesTypes.forEach( Mtype => {	if( Message["Id_MessageType"] == Mtype["Id"])	MessageType=Mtype;	});

				let UbicacionName = Cuartel ? (Cuartel['Name']) : ("{Serie}" + Unidad['Serie'] );
				
				tableHTML += `<tr>`;
				tableHTML += `<td> ${ Message['Id'] }</td>`;
				tableHTML += `<td>${ UbicacionName }</td>`;
				tableHTML += `<td>${ MessageType ? MessageType["Name"] : "Indefinido " }</td>`;
				tableHTML += `<td>${ FieldActivity ( Message['CreationDate'] ) }</td>`;
				tableHTML += `<td> ${ Message['MessageText'] } </td>`;
				tableHTML += `<tr>`;
				}
			});

			tableHTML += `</tbody></table>`;
			tableHTML += `    </div>`;// div overflow
			tableHTML += `    </div>      `;  // col
			tableHTML += `</div>`; // row

		document.getElementById(HtmlElementId).innerHTML= tableHTML;

	}
