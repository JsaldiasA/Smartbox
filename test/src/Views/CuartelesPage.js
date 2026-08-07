class CuartelesPage extends Page
{
	constructor( )
	{
		super();
		this.Titulo = 'Unidades';

		this.FilterOptions = [ 'all', 'sirecor', 'milesight', 'AreaExterna','indefinidas','sin cuartel'];

		this.SelectFiltro = document.createElement('select');
		this.SelectFiltro.className = 'form-select';
		this.SelectFiltro.id = 'filtro';

		this.FilterOptions.forEach(text => {
		const option = document.createElement('option');
		option.value = text.toLowerCase();
		option.textContent = text;
		this.SelectFiltro.appendChild(option);
		});

		this.TituloRighElement.appendChild( this.SelectFiltro ) ;
	}

	async GetMain( )
	{
		super.GetMain();

		let mainTableDiv = document.createElement('div');
		mainTableDiv.id= 'CuartelesTable';

		this.SelectFiltro.addEventListener('change', async (event) => {

		await this.GetMainTable(mainTableDiv);
		});

		this.mainDiv.appendChild(mainTableDiv);

		await this.GetMainTable(mainTableDiv);

		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {
		clearInterval(interval_ID)
		});	

		RefreshIntervals_Ids.push( setInterval(() => this.refreshMainTable(mainTableDiv), 5000));
	}

 	async GetMainTable( containerDiv  )
	{
		containerDiv.replaceChildren();

		var FiltroDOM = document.getElementById("filtro");
		var filtroValue = FiltroDOM ? FiltroDOM.options[FiltroDOM.selectedIndex].value : "";  
		
		let unidadesDataTable = [];
		let Row;

		switch ( filtroValue ) 
		{
		case 'all':

			appModel.Zonas.forEach(rowZona => {
				
				unidadesDataTable = [];			 
				appModel.Cuarteles.forEach(row => {

					if(row["Id_zona"] == rowZona["Id"])
					{
						let unidad = appModel.Unidades.find( unidad => unidad.Id ==  row["Id_unidad"]) ;
						let ultimoRegistro = unidad ? appModel.UltimosRegistros.find( ur => ur.unidad_id == unidad.Id) : null;			
						let unidadesData = new CuartelesDataTable( unidad , ultimoRegistro, row  );

						unidadesDataTable.push( unidadesData );
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

			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('2');
			containerDiv.appendChild( this.RenderRowContainer( 'Milesight',  this.RenderCuartelesTable( unidadesDataTable) ) );

			unidadesDataTable = this.GetUnidadesDataTableById_unidadTipo('6');
			containerDiv.appendChild( this.RenderRowContainer( 'Milesight Energizada',  this.RenderCuartelesTable( unidadesDataTable) ) );
			break;
		
		case 'AreaExterna':

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
		let lastUltimosRigistros = appModel.RefreshUltimosRegistros(); 
		let lastUnidades = appModel.RefreshUnidades();
		await Promise.all([appModel.RefreshUltimosRegistros(),appModel.RefreshUnidades()]);

		if( lastUnidades != appModel.Unidades && lastUltimosRigistros != appModel.UltimosRegistros )
		{
			await this.GetMainTable( containerDiv );
		}	
		
	}

	GetUnidadesDataTableById_unidadTipo( unidadTipo  )
	{		
			// no considera cuarteles de area externa.
			let UnidadesFiltradas = [];

			appModel.Cuarteles.forEach(row => {

				if(row["Id_unidad"]!= '' && row["Id_unidad"]!= null && row["AreaExterna"] != '1' ) // no considera cuarteles de area externa.
				{   
					let unidad = appModel.Unidades.find( u => u.Id == row["Id_unidad"]);
		
					if( unidad && unidad["id_unidadTipo"] == unidadTipo  )
					{
						let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == unidad.Id);			
						let UnidadDataTable = new CuartelesDataTable( unidad , ultimoRegistro ?? null , row  );
						UnidadesFiltradas.push( UnidadDataTable );
					}
				}	
			});

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}

	GetUnidadesDataTableAreaExterna( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Cuarteles.forEach(row => {

				if(row["Id_unidad"]!= '' && row["Id_unidad"]!= null && row["AreaExterna"] == '1' ) // no considera cuarteles de area externa.
				{   
					let unidad = appModel.Unidades.find( u => u.Id == row["Id_unidad"]);
		
					if( unidad["id_unidadTipo"] == unidadTipo )
					{
						let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == unidad.Id);					
						let UnidadDataTable = new CuartelesDataTable( unidad , ultimoRegistro ?? null , row  );
						UnidadesFiltradas.push( UnidadDataTable );
					}
				}	
			});

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}


	GetUnidadesDataTableIndefinidas( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Unidades.forEach(rowUnidades => {
				
				if( rowUnidades.id_unidadTipo == '' || rowUnidades.id_unidadTipo == null )
				{
					let Cuartel = appModel.Cuarteles.find( c =>  c.Id_unidad == rowUnidades.Id);	
					let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == rowUnidades.Id);					
					let UnidadDataTable = new CuartelesDataTable( rowUnidades , ultimoRegistro ?? null ,Cuartel ?? null  );
					UnidadesFiltradas.push( UnidadDataTable );
				}	
			});	

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}

	GetUnidadesDataTableSinCuartel( unidadTipo  )
	{		
		let UnidadesFiltradas = [];

			appModel.Unidades.forEach(rowUnidades => {
			
				let Cuartel = appModel.Cuarteles.find( c =>  c.Id_unidad == rowUnidades.Id);	

				if(!Cuartel )
				{
					let ultimoRegistro = appModel.UltimosRegistros.find( ur => ur.unidad_id == rowUnidades.Id);					
					let UnidadDataTable = new CuartelesDataTable( rowUnidades , ultimoRegistro ?? null , null  );
					UnidadesFiltradas.push( UnidadDataTable );
				}			
			});	

		UnidadesFiltradas.sort((a, b) => Date.parse(b["unidad"]["UltimaActualizacion"]) - Date.parse(a["unidad"]["UltimaActualizacion"]) ); 
		UnidadesFiltradas.sort((a, b) => b["unidad"]["Estado"].localeCompare(a["unidad"]["Estado"]));
			
		return UnidadesFiltradas;
	}

	RenderCuartelesTable(  CuartelesDataTable )
	{
		let dataTable =[];
		const headers = ['<i class="bi bi-pin-map">','<i class="bi bi-motherboard"></i>','','<i class="bi bi-activity"></i>','<i class="bi bi-lightning-fill"></i>', '<i class="bi bi-wifi"></i>','[L/m]','[L]' ];

		class dTRow
		{
			constructor()
			{
				this.Ubicacion;
				this.Serie;
				this.Estado;
				this.Activity;
				this.BateryLevel;
				this.Signal;
				this.Caudal;
				this.Volumen;
			}
		}
				
		CuartelesDataTable.forEach(rowU => {
				
			let dataTableRow = new dTRow();		

			if( rowU.unidad )
			{  
				dataTableRow.Ubicacion = rowU.cuartel ? rowU.cuartel.Name : 'Sin cuartel' ;
				dataTableRow.Serie = `<button type="button" onclick="unidadVerPage(${rowU.unidad['Id']})" class="btn btn-primary btn-sm">${rowU.unidad['Serie']}</button>`;

				if(rowU.ultimoRegistro)
				{	dataTableRow.Estado = FieldEstado(rowU.ultimoRegistro.ESTADO)
					dataTableRow.Activity = FieldActivity(rowU.ultimoRegistro.DATETIME);
					dataTableRow.BateryLevel =	FieldBattery(rowU.ultimoRegistro.VOLTAJE);
					dataTableRow.Signal = FieldSignal(rowU.ultimoRegistro.SENAL, rowU.ultimoRegistro.DATETIME);		
					dataTableRow.Caudal = rowU.ultimoRegistro.CAUDAL;
					dataTableRow.Volumen = rowU.ultimoRegistro.VOLUMEN;	
				}	
				else
				{
					dataTableRow.Estado = 'Milesight';
				}		
			}
			else
			{
				dataTableRow.Ubicacion = rowU.cuartel.Name;
				dataTableRow.Serie = ``;
				dataTableRow.Estado = 'Sin Dispositivo';
			}

			dataTable.push(dataTableRow);

		});

		return this.RenderTable( headers, dataTable);

	}

}


class CuartelesDataTable
{
	constructor( unidad, ultimoRegistro, cuartel )
	{	
		this.unidad =  unidad;
		this.ultimoRegistro =ultimoRegistro;
		this.cuartel  = cuartel;
	}

}




