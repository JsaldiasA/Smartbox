
GetMain();

var myRefreshMain = setInterval(GetMain, 5000);

async function GetMain(  )
	{

		let [Tickets, TicketStatus, Cuarteles, Unidades] = await Promise.all([GetTicket(), GetTicketStatus(),GetCuarteles(),GetUnidades()]);

		let tableHTML = '';
		


		tableHTML += '	<div class="row pb-3">';
		tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
		tableHTML += `    <h2><b>Open Ticket</b></h2> `;
		tableHTML += '   <div class="overflow-auto">';
		tableHTML += '<table class="table text-nowrap"><thead><tr>';
		tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
		tableHTML += `<th scope="col">Nombre</th>`;
		tableHTML += `<th scope="col">Fecha Inicio</th>`;
		tableHTML += `<th scope="col">Status</th>`;
		tableHTML += `<th scope="col"></th>`;
		tableHTML += `</thead>`;

		Tickets.forEach(rowTK => {

			// GETTING cuertel name

			let CuartelName = 'no name';

			Cuarteles.forEach(rowCT => {
			
				if(rowCT["Id_unidad"] == rowTK["Id_unidad"])
				{
					CuartelName=rowCT["Name"];
				}	

			});

			// GETTING Status

			let Status = 'Undefined';

			TicketStatus.forEach(rowTs => {
			
				if(rowTs["Id"] == rowTK["Id_TicketStatus"])
				{
					Status=rowTs["Estado"];
				}	

			});


			// creating table rows

			tableHTML +='<tr>';
			tableHTML += `<td> ${CuartelName}</td>`;
			tableHTML += `<td>${rowTK["Nombre"]}</td>`;
			tableHTML += `<td>${rowTK["FechaInicio"]}</td>`;
			tableHTML += `<td>${Status}</td>`;
			tableHTML += `<td> <a href='Ticketver.php?id_ticket=${rowTK["Id"]}'>Ver</a></td></tr>`;
			tableHTML +='<tr>';
		
		});

		tableHTML += '</tbody></table>';
		tableHTML += '          </div>';// div overflow
		tableHTML += '    </div>      ';  // col
		tableHTML += '</div>'; // row

		document.getElementById('main').innerHTML= tableHTML;

	}


