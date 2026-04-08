
GetMain();

var myRefreshMain = setInterval(GetMain, 5000);

async function GetMain(  )
	{

		let [UltimosRegistros, Zonas, Cuarteles, Unidades] = await Promise.all([GetUltimosRegistros(), GetZonas(),GetCuarteles(),GetUnidades()]);

		let tableHTML = '';
		
		// buscar la unidad


		switch ( filtroValue ) 
		{
		case 'all':

			Zonas.forEach(rowZona => {

			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `    <h2><b>${rowZona["Name"]}</b></h2> `;
			tableHTML += '   <div class="overflow-auto">';
				
			tableHTML += '<table class="table text-nowrap"><thead><tr>';
			tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-motherboard"></i></i></th>`;
			tableHTML += `<th scope="col"></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-lightning-fill"></i></th>`;
			tableHTML += `<th scope="col">[L/m]</th>`;
			tableHTML += `<th scope="col">[L]</th>`;
			tableHTML += `</thead>`;

			// Create table body rows
			Cuarteles.forEach(row => {

				if(row["Id_zona"] == rowZona["Id"])
				{

					if(row["Id_unidad"]!= null )
					{   
						
						let HasRegistrio = false;
						let UnidadSerie = '';
						let UnidadTag = ''; 

						Unidades.forEach(rowUnidades => {
							if(row["Id_unidad"] == rowUnidades["Id"])
							{
									UnidadSerie = rowUnidades["Serie"];
									UnidadTag = rowUnidades["tag"];
									id_unidadTipo = rowUnidades["id_unidadTipo"];
							}

						});	

							UltimosRegistros.forEach(rowUr => {
							
								if(row["Id_unidad"] == rowUr["unidad_id"])
								{
									HasRegistrio=true;

									tableHTML +='<tr>';
									tableHTML += `<td> ${row["Name"]}</td>`;
									tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
									tableHTML += `<td>${rowUr["ESTADO"]}</td>`;
									tableHTML += `<td>${FieldActivity(rowUr["DATETIME"])}</td>`;
									tableHTML += `<td>${FieldBattery(rowUr["VOLTAJE"])}</td>`;
									tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
									tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
								}	
							
							})

							if(!HasRegistrio)
							{
								tableHTML += '<tr >';
								tableHTML += `<td> ${row["Name"]}</td>`;
								tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
								tableHTML += `<td>Milesight</td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
							}
								
					}
					else
					{
						tableHTML += '<tr class="bg-danger text-white">';
						tableHTML += `<td> ${row["Name"]}</td>`;
						tableHTML += `<td>Sin Dispositivo</td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
						tableHTML += `<td></td>`;
					}

					tableHTML += '</tr>';
				}

			});

			tableHTML += '</tbody></table>';
			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row
			
			});
			break;

		case 'sirecor':
			
			tableHTML+= GetUnidadesTableById_unidadTipo('1','Estanques',Cuarteles,Unidades,UltimosRegistros);
			tableHTML+= GetUnidadesTableById_unidadTipo('2','Sirecor',Cuarteles,Unidades,UltimosRegistros);

			break;
		case 'milesight':
			
			tableHTML+= GetUnidadesTableById_unidadTipo('3','Milesight',Cuarteles,Unidades,UltimosRegistros);

			break;
		case 'indefinidas':
			
			tableHTML+= GetUnidadesTableById_unidadTipo( null ,'indefinidas',Cuarteles,Unidades,UltimosRegistros);

			break;	
		case 'sin cuartel':

				tableHTML += '	<div class="row pb-3">';
				tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
				tableHTML += `    <h2><b>Sin cuartel</b></h2> `;
				tableHTML += '   <div class="overflow-auto">';
					
				tableHTML += '<table class="table text-nowrap"><thead><tr>';
				tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
				tableHTML += `<th scope="col"><i class="bi bi-motherboard"></i></i></th>`;
				tableHTML += `<th scope="col"></th>`;
				tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
				tableHTML += `<th scope="col"><i class="bi bi-lightning-fill"></i></th>`;
				tableHTML += `<th scope="col">[L/m]</th>`;
				tableHTML += `<th scope="col">[L]</th>`;
				tableHTML += `</thead>`;

					Unidades.forEach(rowUnidades => {

						let HasRegistrio = false;
						let HasCuartel = false;
						let UnidadSerie = '';
						let UnidadTag = ''; 
				
						UnidadSerie = rowUnidades["Serie"];
						UnidadTag = rowUnidades["tag"];

						Cuarteles.forEach(rowCuarteles => {
										
							HasCuartel = (rowUnidades["Id"] == rowCuarteles["Id_unidad"] ) ? true : HasCuartel;
							
						});	
						

						if(!HasCuartel )
						{	
							UltimosRegistros.forEach(rowUr => {
							
								if(rowUnidades["Id"] == rowUr["unidad_id"])
								{
									HasRegistrio=true;

									tableHTML +='<tr>';
									tableHTML += `<td> ${rowUnidades["Serie"]}</td>`;
									tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
									tableHTML += `<td>${rowUr["ESTADO"]}</td>`;
									tableHTML += `<td>${FieldActivity(rowUr["DATETIME"])}</td>`;
									tableHTML += `<td>${FieldBattery(rowUr["VOLTAJE"])}</td>`;
									tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
									tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
									
								}
							})

							if(!HasRegistrio)
							{
								tableHTML += '<tr >';
								tableHTML += `<td> </td>`;
								tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
								tableHTML += `<td>Milesight</td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += '</tr>';
							}
						}			
					});	

				tableHTML += '</tbody></table>';
				tableHTML += '          </div>';// div overflow
				tableHTML += '    </div>      ';  // col
				tableHTML += '</div>'; // row

			break;
		
		default:
			// Code to execute if no match is found
		}

		document.getElementById('main').innerHTML= tableHTML;

	}

function GetUnidadesTableById_unidadTipo( unidadTipo ,Titulo ,Cuarteles,Unidades,UltimosRegistros  )
	{
			let tableHTML = '';

			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `    <h2><b>${Titulo}</b></h2> `;
			tableHTML += '   <div class="overflow-auto">';
				
			tableHTML += '<table class="table text-nowrap"><thead><tr>';
			tableHTML += `<th scope="col"><i class="bi bi-pin-map"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-motherboard"></i></i></th>`;
			tableHTML += `<th scope="col"></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-activity"></i></th>`;
			tableHTML += `<th scope="col"><i class="bi bi-lightning-fill"></i></th>`;
			tableHTML += `<th scope="col">[L/m]</th>`;
			tableHTML += `<th scope="col">[L]</th>`;
			tableHTML += `</thead>`;

			// Create table body rows
			Cuarteles.forEach(row => {

					if(row["Id_unidad"]!= null )
					{   
						
						let HasRegistrio = false;
						let UnidadSerie = '';
						let UnidadTag = ''; 
						var id_unidadTipo = '';
						var unidad;

						Unidades.forEach(rowUnidades => {
							if(row["Id_unidad"] == rowUnidades["Id"])
							{
									UnidadSerie = rowUnidades["Serie"];
									UnidadTag = rowUnidades["tag"];
									id_unidadTipo = rowUnidades["id_unidadTipo"];
									unidad = rowUnidades;
							}

						});	

						if( id_unidadTipo == unidadTipo )
						{	
							UltimosRegistros.forEach(rowUr => {
							
								if(row["Id_unidad"] == rowUr["unidad_id"])
								{
									HasRegistrio=true;


									tableHTML +='<tr>';
									tableHTML += `<td> ${row["Name"]}</td>`;
									tableHTML += `<td> <a href='unidadver.php?tag=${unidad['Id']}'>${UnidadSerie}</a></td>`;
									tableHTML += `<td>${rowUr["ESTADO"]}</td>`;
									tableHTML += `<td>${FieldActivity(rowUr["DATETIME"])}</td>`;
									tableHTML += `<td>${FieldBattery(rowUr["VOLTAJE"])}</td>`;
									tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
									tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
								}	
							
							})

							if(!HasRegistrio)
							{
								tableHTML += '<tr >';
								tableHTML += `<td> ${row["Name"]}</td>`;
								tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
								tableHTML += `<td>Milesight</td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += `<td></td>`;
								tableHTML += '</tr>';
							}
						}	
					}

			});

			// para unidades indefinidas unidadTipo = null

			if(unidadTipo == null)
			{
									
						Unidades.forEach(rowUnidades => {

							let HasRegistrio = false;
							let UnidadSerie = '';
							let UnidadTag = ''; 
				

		
									UnidadSerie = rowUnidades["Serie"];
									UnidadTag = rowUnidades["tag"];


							if(rowUnidades["id_unidadTipo"] == null )
							{	
								UltimosRegistros.forEach(rowUr => {
								
									if(rowUnidades["Id"] == rowUr["unidad_id"])
									{
										HasRegistrio=true;


										tableHTML +='<tr>';
										tableHTML += `<td> ${rowUnidades["Serie"]}</td>`;
										tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
										tableHTML += `<td>${rowUr["ESTADO"]}</td>`;
										tableHTML += `<td>${FieldActivity(rowUr["DATETIME"])}</td>`;
										tableHTML += `<td>${FieldBattery(rowUr["VOLTAJE"])}</td>`;
										tableHTML += `<td>${rowUr["CAUDAL"]}</td>`;
										tableHTML += `<td>${rowUr["VOLUMEN"]}</td>`;
									
									}
								})
								if(!HasRegistrio)
								{
									tableHTML += '<tr >';
									tableHTML += `<td> </td>`;
									tableHTML += `<td> <a href='unidadver.php?tag=${UnidadTag}'>${UnidadSerie}</a></td>`;
									tableHTML += `<td>Milesight</td>`;
									tableHTML += `<td></td>`;
									tableHTML += `<td></td>`;
									tableHTML += `<td></td>`;
									tableHTML += `<td></td>`;
									tableHTML += '</tr>';
								}

							}			
						});	
			
			}

			tableHTML += '</tbody></table>';
			tableHTML += '          </div>';// div overflow
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // row

		return tableHTML;
	}
