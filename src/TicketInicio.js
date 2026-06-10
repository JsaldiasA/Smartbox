
async function GetMainTickets(  )
	{	
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {

		clearInterval(interval_ID)

		});	

		document.getElementById(`main`).innerHTML = GetTituloTickets();

		// data table
		document.getElementById(`main`).innerHTML += `<div id="mainTableTicket" ><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>`;
		GetTicketsMainTable('mainTableTicket');
		RefreshIntervals_Ids.push(setInterval(GetTicketsMainTable, 5000,`mainTableTicket` ));

	}	

	function GetTituloTickets(  )
	{

		return `          <div class="container">
			<div class="row pb-3">
					<div class="col p-3">
						${GetTitulo('Tickets')}
					</div>
					<div class="col">
						<tr><td><b></b></td></tr>
					</div>
					<div class="col">
						<br><br><p class="text-end"><b>Ingresar nuevo ticket.  <b><button type="button" onclick="NewTicketPage()" class="btn btn-primary btn-sm">+</button>
					</div>
				</div>
				<div id="main"></div>
			</div>`;
		
	}

async function GetTicketsMainTable( HtmlElementId  )

	{

		let [Tickets, TicketStatus, Cuarteles] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles()]);
		
		let TicketPriorities = GetTicketPriority();

		let tableHTML = ``;
		
		TicketStatus.sort((a, b) => a.Id - b.Id);


		TicketStatus.forEach(rowTKStatus => {


			tableHTML += `	<div class="row pb-3">`;
			tableHTML += ` <div class="col p-3 card shadow p-3 card shadow">`;
			tableHTML += `    <h2><b>${rowTKStatus["Estado"]}</b></h2> `;
			tableHTML += `   <div class="overflow-auto">`;
			tableHTML += `<table class="table text-nowrap"><thead><tr>`;
			tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
			tableHTML += `<th scope="col">Nombre</th>`;
			tableHTML += `<th scope="col">Proridad</th>`;
			tableHTML += `<th scope="col">${ ( rowTKStatus["Id"] == `3` ? `Fecha Cierre ` : `Fecha Inicio` ) }</th>`;
			tableHTML += `<th scope="col"></th>`;
			tableHTML += `</thead>`;

			Tickets.forEach(rowTK => {

				if(rowTKStatus["Id"] == rowTK["Id_TicketStatus"])
				{

					// GETTING cuertel name

					let CuartelName = `no name`;
					let TicketPriority = `no name`;
					

					Cuarteles.forEach(rowCT => {
						if(rowCT["Id_unidad"] == rowTK["Id_unidad"])	CuartelName=rowCT["Name"];
					});

					// Getting Priority
					TicketPriorities.forEach(Tp => {
						if(Tp["Id"] == rowTK["Id_TicketPriority"])	TicketPriority = Tp;
					});

					let TicketGRAVE = TicketPriority['Id'] == 1 ? true : false;


					tableHTML +=`<tr>`;
					tableHTML += `<td> ${CuartelName}</td>`;
					tableHTML += `<td>${rowTK["Nombre"]}</td>`;
					tableHTML += `<td>${ priorityColorText( TicketPriority['Id'],TicketPriority["Name"]) }</td>`;
					tableHTML += `<td>${ ( rowTKStatus["Id"] == `3` ? rowTK["FechaCierre"] : (rowTK["FechaInicio"] +" "+ FieldActivity(rowTK["FechaInicio"] )) ) }</td>`;
					tableHTML += `<td> <a href="url" onclick="TicketVerPage(${rowTK[`Id`]});return false" >ver</a> </td>`;
					tableHTML +=`<tr>`;
				}	
				
			});

			tableHTML += `</tbody></table>`;
			tableHTML += `          </div>`;// div overflow
			tableHTML += `    </div>      `;  // col
			tableHTML += `</div>`; // row
		});	

		document.getElementById(HtmlElementId).innerHTML= tableHTML;

	}

async function TicketVerPage ( Id_ticket )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {

		clearInterval(interval_ID)

		});	

		let tableHTML =``;
		let [Tickets, TicketStatus, Cuarteles, Unidades] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles(),GetUnidades()]);
		
		var ticket;

		Tickets.forEach(rowTK => {
			
			if(rowTK["Id"] == Id_ticket)
			{
				ticket=rowTK;
			}	
		});	

		tableHTML += `<div class="container">`;
		tableHTML += `<div class="row p-3">`;

		tableHTML += GetVolverBtn('GetMainTickets()');

		tableHTML +=    `<div class="col p-3"> <h1> Ticket: ${ticket["Nombre"]}  </h1> </div>`;
		tableHTML += GetEditBtn(`TicketEditPage(${ticket["Id"]})`);
		//display data
		tableHTML += `<table class="table border"><tbody>`;
		tableHTML += `<tr><td><b>ID:</b></td><td>${ticket["Id"]}</td></tr>`;
		tableHTML += `<tr><td><b>Título:</b></td><td> ${ticket["Nombre"]} </td></tr>`;
		tableHTML += `<tr><td><b>Descripcion: </b></td><td>${ticket["Descripcion"]}</td></tr>`;
		tableHTML += `<tr><td><b>Usuario:</b></td><td>${ticket["Usuario"]}</td></tr>`;
		tableHTML += `<tr><td><b>Fecha de ingreso:</b></td><td>${ticket["FechaInicio"] +" "+ FieldActivity(ticket["FechaInicio"] ) }</td></tr>`;
		tableHTML += `<tr><td><b>Estado de la solicitud:</b></td><td>${ticket["Id_TicketStatus"]}</td></tr>`;
		tableHTML += `</tbody></table>`;

		tableHTML += `<div class="row p-3">`;
			tableHTML += `<div class="col-sm">`;
				tableHTML += `<div class="input-group mb-3">
				<div class="input-group-prepend">
					<button type="button" class="btn btn-danger" onclick="FunctionDeleteTicket(${ticket[`Id`]})" >Cerrar ticket</button>
				</div>
				<input type="text" class="form-control" aria-describedby="basic-addon1" placeholder="Describa motivo del cierre" aria-label="" id="MotivoCierre">
				</div>`;
			tableHTML += `</div>`;
		tableHTML += `</div>`;

		document.getElementById('main').innerHTML = tableHTML;

	}

	async function TicketEditPage ( Id_ticket )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {

		clearInterval(interval_ID)

		});	

		let tableHTML =``;
		let [Tickets, TicketStatus, Cuarteles, Unidades] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles(),GetUnidades()]);
		let TicketPriorities = GetTicketPriority();

		var ticket;

		Tickets.forEach(rowTK => {
			
			if(rowTK["Id"] == Id_ticket)
			{
				ticket=rowTK;
			}	
		});	

		tableHTML += `<div class="container">`;
		tableHTML += `<div class="row p-3">`;
		tableHTML += GetVolverBtn('GetMainTickets()');
		tableHTML += `<div class="col p-3"><h1><b> ${ticket["Nombre"]}  </b></h1> </div>`;
		
		//display data
		tableHTML += `<table class="table border"><tbody>`;
		tableHTML += `<tr><td><b>ID:</b></td><td>${ticket["Id"]}</td></tr>`;
		tableHTML += `<tr><td><b>Título:</b></td><td> <input type="text" class="form-control" id="Nombre" value="${ticket["Nombre"]}">  </td></tr>`;
		tableHTML += `<tr><td><b>Descripcion: </b></td><td><input type="text" class="form-control" style="height: 200px; width: 100%" id="Descripcion" value="${ticket["Descripcion"]}"></td></tr>`;
		tableHTML += `<tr><td><b>Usuario:</b></td><td>${ticket["Usuario"]}</td></tr>`;
		tableHTML += `<tr><td><b>Fecha de ingreso:</b></td><td>${ticket["FechaInicio"] +" "+ FieldActivity(ticket["FechaInicio"] ) }</td></tr>`;
		tableHTML += `<tr><td><b>Estado de la solicitud:</b></td><td>${ticket["Id_TicketStatus"]}</td></tr>`;
		tableHTML += `<tr><td><b>Prioridad:</b></td><td>${ CreateSelectFromObjArray('TicketPriority',TicketPriorities,'Id','Name') }</td></tr>`;
		//tableHTML += `<tr><td><b>Cuartel:</b></td><td>${ CreateSelectFromObjArray('cuartel',Cuarteles,'Id_unidad','Name') }</td></tr>`;

		tableHTML += `</tbody></table>`;

		tableHTML += `<div class="row p-3">`;
			tableHTML += `<div class="col-sm">`;
				tableHTML += `
			
					<button type="button" class="btn btn-success" onclick="FunctionUpdateTicketPost(${ticket[`Id`]})" >Edit ticket</button>
				`;
			tableHTML += `</div>`;
		tableHTML += `</div>`;

		document.getElementById('main').innerHTML = tableHTML;

	}

	async function NewTicketPage (  )
	{
		document.getElementById(`main`).innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {

		clearInterval(interval_ID)

		});	

		let tableHTML =``;
		let [Tickets, TicketStatus, Cuarteles, Unidades] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles(),GetUnidades()]);
		let TicketPriorities = GetTicketPriority();

		tableHTML += `<div class="container">`;
		tableHTML += `<div class="row p-3">`;
		tableHTML += GetVolverBtn('GetMainTickets()');
		tableHTML += `<div class="col p-3"><h1><b> Nuevo ticket  </b></h1> </div>`;
		
		tableHTML += `<div class="row p-3">`;
			//display data
			tableHTML += `<table class="table border"><tbody>`;
			tableHTML += `<tr><td><b>Título:</b></td><td> <input type="text" class="form-control" id="Nombre" >  </td></tr>`;
			tableHTML += `<tr><td><b>Descripcion: </b></td><td><input type="text" class="form-control" style="height: 200px; width: 100%" id="Descripcion" ></td></tr>`;
			tableHTML += `<tr><td><b>Usuario:</b></td><td><input type="text" class="form-control" id="Usuario" placeholder="Escriba su nombre."></td></tr>`;
			tableHTML += `<tr><td><b>Prioridad:</b></td><td>${ CreateSelectFromObjArray('TicketPriority',TicketPriorities,'Id','Name') }</td></tr>`;
			tableHTML += `<tr><td><b>Cuartel:</b></td><td>${ CreateSelectFromObjArray('cuartel',Cuarteles,'Id_unidad','Name') }</td></tr>`;
			tableHTML += `</tbody></table>`;
		tableHTML += `</div>`;

		tableHTML += `<div class="row p-3">`;
			tableHTML += `<div class="col-sm">`;
				tableHTML += `<button type="button" class="btn btn-success" onclick="FunctionNuevoTicketPost()">Enviar ticket</button>`;
			tableHTML += `</div>`;
		tableHTML += `</div>`;

		document.getElementById('main').innerHTML = tableHTML;

	}

		function FunctionNuevoTicketPost()
		{
			let text = "¿Está seguro de enviar el ticket?";
			if (confirm(text) == true)
				{
					let pattern = /(^\d+\.\d+$)|(^\d+$)/;
					var URL = "https://smartbox.eco3.cl/ApiController/ticket/TicketCreate.php";
					var Respuesta;

					var Nombre = document.getElementById("Nombre").value;
					if (Nombre == "")
						{
							return alert ("Debe especificar un dispositivo y/o plataforma.");
						}

					var Descripcion = document.getElementById("Descripcion").value;
					if (Descripcion == "" )
						{
							return alert ("Debe explicar de que se trata el problema.");
						}

					var Usuario = document.getElementById("Usuario").value;
					if (Usuario == "" )
						{
							return alert ("Debe escribir su nombre.");
						}
					var f = document.getElementById("cuartel");
					var Id_unidad = f.options[f.selectedIndex].value; 	

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
									Id_unidad: Id_unidad,
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

function FunctionDeleteTicket(id_ticket)
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
		var URL = "https://smartbox.eco3.cl/ApiController/ticket/TicketDelete.php";
		var Respuesta;
	
		$.ajax(
		{
			url:URL,
			type:"post",
			dataType:'text',
			data:
				{
					Id: id_ticket,
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

function FunctionUpdateTicketPost( id_ticket )
	{
		let text = "¿Está seguro de enviar el ticket?";
		if (confirm(text) == true)
			{
				var URL = "https://smartbox.eco3.cl/ApiController/ticket/TicketUpdate.php";

				var Nombre = document.getElementById("Nombre").value;
				
				if (Nombre == "")
					{
						return alert ("Debe especificar un dispositivo y/o plataforma.");
					}
				var Descripcion = document.getElementById("Descripcion").value;

				if (Descripcion == "" )
					{
						return alert ("Debe explicar de que se trata el problema.");
					}

				var f = document.getElementById("TicketPriority");
				var Id_TicketPriority = f.options[f.selectedIndex].value; 
				
				//var f = document.getElementById("cuartel");
				//var Id_unidad = f.options[f.selectedIndex].value; 	
					
	
				$.ajax(
					{
        				url:URL,
        				type:"post",
						dataType:'text',
						data:
							{
								Id: id_ticket ,
								Nombre: Nombre,
								Descripcion: Descripcion,
								Id_TicketPriority: Id_TicketPriority,
								//Id_unidad: Id_unidad,
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

	 function GetTicketPriority( )
{

		const PrioridadGrave = {
		Id: "1",
		Name: "Alta (Inoperativo)"
		};

		const PrioridadMedia = {
		Id: "2",
		Name: "Media"
		};

		const PrioridadBaja = {
		Id: "3",
		Name: "Baja"
		};

		Priorities = [PrioridadGrave,PrioridadMedia,PrioridadBaja]

  	return Priorities;
  
}

function priorityColorText( Id_TicketPriority, text)
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