class Page
{

  constructor( ) {
	this.Titulo = 'blank page';
	this.TituloRighElementEnable = true;
	this.TituloRighElement = document.createElement('div');
	this.mainDiv = document.getElementById(`main`);
  }

 async  GetMain(  )
	{	
		// clean an set intervals
		RefreshIntervals_Ids.forEach(interval_ID => {	clearInterval(interval_ID)	});	
	
		const tituloDiv = this.GetTituloDiv();
		this.mainDiv.replaceChildren(tituloDiv)  ;

	}	

	GetTituloDiv(   )
	{
	
		let TituloRow = document.createElement('div');
		TituloRow.className ='row p-4';

		let TituloLeftCol = document.createElement('div');
		TituloLeftCol.classList.add ('col');
		const TituloH1 = document.createElement('b');
		TituloH1.textContent = this.Titulo;
		TituloH1.className = 'h1';

		TituloLeftCol.appendChild(TituloH1);


		let TituloRightCol = document.createElement('div');
		TituloRightCol.classList.add('col-auto','align-self-center');
		if(this.TituloRighElementEnable)
		{
			TituloRightCol.appendChild(this.TituloRighElement);
		}

		TituloRow.appendChild(TituloLeftCol);
		
		TituloRow.appendChild(TituloRightCol);

		return TituloRow;

	}

	RenderTable(headers,dataTable)
	{
			const table = document.createElement("table");
			table.className="table border table-striped table-hover text-nowrap";
			
			if(headers)
			{
				const thead = document.createElement("thead");
				thead.className ='table-secondary';
				const headerRow = document.createElement("tr");
				headers.forEach(headerText => {
					const th = document.createElement("th");
					th.innerHTML = headerText;
					headerRow.appendChild(th);
				});
				
				thead.appendChild(headerRow);
				table.appendChild(thead);
			}

			const tbody = document.createElement("tbody");
			dataTable.forEach(row => {

				const rowDiv = document.createElement("tr");

				Object.values(row).forEach(text => {
				const td = document.createElement("td");
				td.innerHTML = text; 
				rowDiv.appendChild(td);
				});
    
				tbody.appendChild(rowDiv);
			});
			
			table.appendChild(tbody);
		
			return table;
	}	
	

	RenderRowContainer( Title , Content)
	{
			const Row = document.createElement('div');
			Row.className = 'row pb-3';

			const Col = document.createElement('div');
			Col.className = 'col p-3 card shadow ';

			const title = document.createElement('h2');
			title.textContent = Title;
			title.className = 'p-2';

			const contentDiv = document.createElement('div');
			contentDiv.className = 'overflow-auto';
			contentDiv.appendChild(Content);
			   
			Col.appendChild(title);
			Col.appendChild(contentDiv);

			Row.appendChild(Col);

		return Row;
		
	}

	CreateModalComponent( id )
	{
		let modal = document.createElement('div');
		modal.innerHTML = `	
		<!-- Modal -->
		<div class="modal fade" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}ModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="${id}_ModalLabel"></h2>
					<button id="${id}" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="${id}_ModalBody">
					
				</div>
				<div class="modal-footer" id="${id}_ModalFooter">
					
				</div>
				</div>
			</div>
		</div>`;
		
		return modal

	}


}




  

