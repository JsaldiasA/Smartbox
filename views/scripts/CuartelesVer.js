
GetMain();

var myRefreshMain = setInterval(GetMain, 5000);

async function GetMain(  )
	{

		let [UltimosRegistros, Zonas, Cuarteles, Unidades] = await Promise.all([GetUltimosRegistros(), GetZonas(),GetCuarteles(),GetUnidades()]);

		var e = document.getElementById("filtro");
		var filtroValue = e.options[e.selectedIndex].value;  

		let tableHTML = '';
		
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

							UltimosRegistros.forEach(rowUr => {
							
								if(row["Id_unidad"] == rowUr["unidad_id"])
								{
									HasRegistrio=true;

									tableHTML +='<tr>';
									tableHTML += `<td> ${row["Name"]}</td>`;
									tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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
								tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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
									tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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
								tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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

						Unidades.forEach(rowUnidades => {
							if(row["Id_unidad"] == rowUnidades["Id"])
							{
									UnidadSerie = rowUnidades["Serie"];
									UnidadTag = rowUnidades["tag"];
									id_unidadTipo = rowUnidades["id_unidadTipo"];
									unidad=rowUnidades;
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
									tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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
								tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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
					unidad=rowUnidades;

					if(rowUnidades["id_unidadTipo"] == null )
					{	
						UltimosRegistros.forEach(rowUr => {
								
							if(rowUnidades["Id"] == rowUr["unidad_id"])
							{
								HasRegistrio=true;


								tableHTML +='<tr>';
								tableHTML += `<td> ${rowUnidades["Serie"]}</td>`;
								tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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
							tableHTML += `<td> <button type="button" onclick="unidadVerPage(${unidad['Id']})" class="btn btn-primary btn-sm">${UnidadSerie}</button> </td>`;
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

	async function unidadVerPage ( Id_unidad )
	{
		clearInterval(myRefreshMain);

		let tableHTML ='';
		let [ Zonas, Cuarteles, Unidades, Checklists,Tipos,ChecklistsNew] = await Promise.all([ GetZonas(),GetCuarteles(),GetUnidades(), GetChecklists(),GetUnidaTipo(), GetChecklistsNew(),]);

		var unidad;
		var cuartel;
		var checklist;
		var ultimosRegistro;

		// buscar la unidad
		Unidades.forEach(rowUnidades => {

			if(Id_unidad == rowUnidades["Id"])
			{
				unidad = rowUnidades;
			}		
	
		});	

		//buscar cuartel

		Cuarteles.forEach(rowCuarteles => {
									
			if(unidad["Id"] == rowCuarteles["Id_unidad"] )
			{
				cuartel = rowCuarteles;
			} 
						
		});	

		// buscar checklist

		Checklists.forEach(rowChecklist => {
			if(rowChecklist["Checklist"])
			{
				if(unidad["Id"] == rowChecklist["Checklist"]["id_unidad"] )
				{
					checklist = rowChecklist;
				} 
			}						
		});	



		if( unidad ) 
		{
			// first row

			tableHTML += '	<div class="row pb-3">';
			tableHTML += ' <div class="col p-3 card shadow p-3 card shadow">';
			tableHTML += `    <h2><b>${unidad["Serie"]}</b></h2> `;

			tableHTML += '<table class="table text-nowrap"><thead><tr>';
			tableHTML += `<th scope="col"> Serie </th>`;
			tableHTML += `<th scope="col"> Imei </th>`;
			tableHTML += `<th scope="col"> Cuartel </th>`;
			tableHTML += `</thead>`;

			tableHTML += `<tbody>`;
			tableHTML += '<tr>';
			tableHTML += `<td>${unidad["Serie"]}</td>`;
			tableHTML += `<td>${unidad["tag"]}</td>`;
			tableHTML += `<td>${ cuartel ? cuartel["Name"] :'Sin Cuartel' }</td>`;
			tableHTML += '</tr>';
			tableHTML += `</tbody>`;
			tableHTML += `</table>`;
			
			
			tableHTML += '    </div>      ';  // col
			tableHTML += '</div>'; // end first row

			// row checklist & ultima actualizacion

			tableHTML += '	<div class="row pb-3 shadow border">';
			

			if( checklist )
			{
			
				//col foto
				tableHTML += `<div class="col-sm-4 p-3" >`;
				tableHTML += `<img class="img-thumbnail" src="${checklist["Checklist"]["URL_foto"]}" "="">`;
				tableHTML += `</div>`;
				// col ultimo checklits & ultima actualizacion	
				tableHTML += ' <div class="col p-3">';
				tableHTML += '<table class="table text-nowrap"><thead><tr>';
				tableHTML += `<th scope="col"> Ultimo checklist </th>`;
				tableHTML += `<th scope="col" class="d-flex justify-content-end" ><a href="https://smartbox.eco3.cl/checklistform/checklistform.php?tag=${unidad["tag"]}" class="btn btn-primary" >Nuevo Checklist</a> </th>`;
				// fecha
				tableHTML += '<tr>';
				tableHTML += `<td>Fecha</td>`;
				tableHTML += `<td>${checklist["Checklist"]["Fecha"]}</td>`;
				tableHTML += '</tr>';
				// Observaciones
				tableHTML += '<tr>';
				tableHTML += `<td>Observaciones</td>`;
				tableHTML += `<td>${checklist["Checklist"]["Observaciones"]}</td>`;
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
				tableHTML += '<table class="table text-nowrap"><thead><tr>';
				tableHTML += `<th scope="col"> Ultimo checklist </th>`;
				tableHTML += `<th scope="col"> </th>`;
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
				var myRefreshStatusTable = setInterval(GetStatusTable, 1000, unidad["Id"] );
			}

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
				var myRefreshSMSTable = setInterval(GetSMSTable, 1000, unidad["Id"] );

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
				tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'INTERNET30' ,${unidad["Id"]})" class="btn btn-primary" >Riego mode ON</button></td><tr>`;
				tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'INTERNET75',${unidad["Id"]} )" class="btn btn-primary" >Riego mode OFF</button></td><tr>`;
				tableHTML += `	<td><button type="button" onclick="FunctionCreateSMS( 'INTERNET900',${unidad["Id"]} )" class="btn btn-primary" >Standby mode</button></td><tr>`;

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
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
        Registros diarios
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
		`;
	// TABLA REGISTROS DIARIOS
	tableHTML += `<button type="button" onclick="GetRegistrosDiariosTable(${unidad["Id"]})" class="btn btn-primary" >Refrescar</button>`;
	tableHTML += '<div class="overflow-auto"> <div id="RegistrosDiariosTable"></div>  </div>';

			tableHTML +='		  </div> '; // end Acordeon body
    		tableHTML +='		  </div> '; // end collapseZero
  			tableHTML +='		  </div> '; // end Acordeon-item Registros DIARIOS

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
		  
				 tableHTML += `<div class="subContainer">`;
				 tableHTML += `Introduzca la contraseña para editar: <input type="text" id="password" name="password" class="form-control">`;
				 tableHTML += `</div>`;   // Input de contraseña.
				 tableHTML += `<div class="subContainer">`;
				 tableHTML += `<button onclick="FunctionNuevaUbicacion(${unidad["Id"]})" class="btn btn-secondary">Editar</button> Nueva ubicación:`;
				 tableHTML += `<input type="text" id="NuevaUbicacion" name="NuevaUbicacion" class="form-control">`;   // Input cambio de ubicación.
				 tableHTML += `</div>`;
				 tableHTML += `<div class="subContainer">`;
				 tableHTML += `<button onclick="FunctionNuevoNumero('${unidad["tag"]}')" class="btn btn-secondary">Editar</button> Nuevo número:`;
				 tableHTML += `<input type="text" id="NuevoNumero" name="NuevoNumero" class="form-control">`;   // Input cambio de número.
				 tableHTML += `</div>`;
				 tableHTML += `<div class="subContainer">`;
				 tableHTML += `<button onclick="FunctionCambiarVolMax('${unidad["tag"]}')" class="btn btn-secondary">Editar</button> Nuevo volumen máximo:`;
				 tableHTML += `<input type="text" id="VolMax" name="VolMax" class="form-control">`;   // Input cambio de volumen máximo.
				 tableHTML += `</div>`;
				 tableHTML += `<div class="subContainer">`;
				 tableHTML += `<button onclick="FunctionNuevoTipo('${unidad["tag"]}')" class="btn btn-secondary">Editar</button>`;

				 tableHTML += ' <select name="NuevoTipo" id="NuevoTipo" required>';
		
				Tipos.forEach(rowTipo => {
											
					 tableHTML += `<option value='${rowTipo["Id"]}'>${rowTipo["Name"]}</option>`;
								
				});	
				
				 tableHTML += "<option value='NULL'>Unidad Indefinida</option>";
				 tableHTML += '</select>';
				 tableHTML += '</div>';
				
				 tableHTML += '<div class="subContainer">';
				 tableHTML += `<button onclick="FunctionNuevoCuartel((${unidad["Id"]})" class="btn btn-secondary">Editar</button>`;
				tableHTML += ' <select name="Cuarteles" id="Cuarteles" required>';

				Cuarteles.forEach(rowCuarteles => {
											
					 tableHTML += `<option value='${rowCuarteles["Id"]}'>${rowCuarteles["Name"]}</option>`;
								
				});	
				 
				 tableHTML += '</select>';
				 tableHTML += '</div>';

				 tableHTML += '<div class="subContainer">';
				 tableHTML += `<button onclick="FunctionEliminar('${unidad["tag"]}')" class="btn btn-danger">Eliminar</button> Eliminar unidad...`;
				 tableHTML += '</div>';   // Función para eliminar unidad.
				
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

			ChecklistsNew.forEach(rowC => {
				if( rowC["id_unidad"] == Id_unidad )
				{
					tableHTML += `</td> <td>${rowC["Id"]}</td><td>${rowC["TecnicoResponsable"]}</td> <td>${rowC["Fecha"]}</td> <td><a href='unidadverCheckList.php?CheckList_Id="${rowC["Id"]}"'>Ver</a></td></tr>` ;
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

		document.getElementById('main').innerHTML= tableHTML;

	}

	async function GetStatusTable( unidad_id )
	{
		var Registros = await GetRegistrosDiarios( unidad_id );

		var UltimoRegistro =  Registros[0];

		let tableHTML = '	<table class="table" ><thead>';
       	tableHTML +=  `<tr><td><b>Estado:</b></td><td>${UltimoRegistro['ESTADO']}</td></tr>`;
		tableHTML +=  `<tr><td><b>Volumen:</b></td><td>${UltimoRegistro['VOLUMEN']}</td></tr>`;
		tableHTML +=  `<tr><td><b>Caudal:</b></td><td>${UltimoRegistro['CAUDAL']}</td></tr>`;
		tableHTML +=  `<tr><td><b>Última Registro:</b></td><td>${UltimoRegistro['DATETIME']}</td></tr>`;
        tableHTML +=  `</tr></tbody></table>`        ;
		
		document.getElementById("StatusTable").innerHTML= tableHTML;
	}	

	function IsSirecor( Id_UnidadTipo )
	{
		if( Id_UnidadTipo == '1' ||  Id_UnidadTipo == '2' ) // Sirecor7600 or EStanque7600
		{
			return true;
		}
		else{
			return false;
		}
	}

	function GetRegistrosDiariosTable( id_unidad )
	{

		document.getElementById("RegistrosDiariosTable").innerHTML= '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>';	

		var URL = "https://smartbox.eco3.cl/ApiController/RegistrosDiarios/RegistrosDiariosGet.php"

		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
			dataType:'text',
			data:
				{
            		Id_unidad: id_unidad,
        		},
			
		    	success: 
				function(result){

				let table = new DataTable("#TablaRegistros");
				document.getElementById("RegistrosDiariosTable").innerHTML= result;
				$(document).ready(function(){
				$('#TablaRegistros').dataTable();
				});
			
			}
		});	
	}	

	function GetSMSTable(id_unidad)
	{
    	var URL = "https://smartbox.eco3.cl/ApiController/SMSToUnidades/SMSToUnidadesGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			data:
				{
            		Id_unidad: id_unidad,
        		},
			
		    success: function(result){document.getElementById("SMSTable").innerHTML= result;}
		});	
 	}

	function FunctionNuevoNumero(unidad)
	{
  		let text = "¿Está seguro de cambiar el número de la unidad?";
 		if (confirm(text) == true)
			{
				var URL = "UnidadCambiarNumero.php";
				var Respuesta;
				var NuevoNumero = document.getElementById("NuevoNumero").value;
				var token = document.getElementById("password").value ;
		
				$.ajax({
        			url:URL,
            		type:"post",
					dataType:'text',
					data:
						{
            				tag: unidad,
							NuevoNumero: NuevoNumero,
							token: token,
        				},
					success: function(result)
						{
							alert(result)
						}
		  		});
  			}
		else
			{
    			alert("La operación se ha cancelado.");
  			}
	}

function FunctionNuevaUbicacion(unidad) {
  let text = "¿Está seguro de cambiar la ubicación de la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarNombre.php";
	var Respuesta;
	var NuevaUbicacion = document.getElementById("NuevaUbicacion").value;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevaUbicacion: NuevaUbicacion,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}
	
function FunctionNuevoTipo(unidad) {
  let text = "¿Está seguro de cambiar el tipo de unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarTipo.php";
	var Respuesta;
	var e = document.getElementById("NuevoTipo");
	var value = e.value;
	var NuevoTipo = e.options[e.selectedIndex].text;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoTipo: NuevoTipo,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}	

function FunctionNuevoCuartel( Id_unidad ) {
  let text = "¿Está seguro de cambiar el tipo de unidad?";
  if (confirm(text) == true) {


	var e = document.getElementById("Cuarteles");
	var Id_cuartel = e.value;

	$.ajax({
            url:"https://smartbox.eco3.cl/ApiController/cuarteles/cuartelesUpdate.php", 
            type: "post", 
			dataType: 'text',
			  data: {
            Id: Id_cuartel,
			Id_unidad: Id_unidad,

        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}	
	
function FunctionEliminar(unidad) {
  let text = "¿Está seguro de eliminar la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadEliminar.php";
	var Respuesta;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request 
			dataType: 'text',
			  data: {
            tag: unidad,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });	 

  } else {
    alert("La operación se ha cancelado.");
  }
}
	
function FunctionComandosMilesight(ComandoNombre, tag_unidad ) {
  let text = "¿Está seguro de accionar la unidad?";
  if (confirm(text) == true) {

	var URL = "https://smartbox.eco3.cl/ApiController/Postcomandos_milesight.php";
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			data: {
            tag: tag_unidad,
			nombre: ComandoNombre,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionCambiarVolMax(unidad) {
  let text = "¿Está seguro de cambiar el volumen máximo de la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarVolMax.php";
	var NuevoVolMax = document.getElementById("VolMax").value;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoVolMax: NuevoVolMax,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionCreateSMS(SMS,id_unidad) {
  let text = "¿Está seguro de enviar un SMS?";
  if (confirm(text) == true) {

	var URL = "https://smartbox.eco3.cl/Apicontroller/SMSToUnidades/SMSToUnidadesCreate.php";
	var Respuesta;
	var NuevoVolMax = document.getElementById("VolMax").value;
	var token = document.getElementById("password").value;

	var SMStoCreate = SMS == "InputSMS" ? document.getElementById("InputSMS").value : SMS;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			data: {
            Id_unidad: id_unidad,
			SMS: SMStoCreate,
			token: token,
        	},
		    success: function(result){alert(result);}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionDeleteSMS(Id_SMSToUnidades) {
  let text = "¿Está seguro de eliminar un SMS?";
  if (confirm(text) == true) {

	var URL = "https://smartbox.eco3.cl/Apicontroller/SMSToUnidades/SMSToUnidadesDelete.php";
	var Respuesta;
	var token = document.getElementById("password").value;

	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: 'text',
			data: {
            Id: Id_SMSToUnidades,
			token: token,
        	},
		    success: function(result){alert(result);}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

