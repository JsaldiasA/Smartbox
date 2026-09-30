class ChecklistController {
	
	constructor( )	{
	}

	async AguaEditModalBtn( newValue, Id_checklist ){
  			
		const EditChecklist = {
			Id: Id_checklist.toString(),
			agua: newValue? '1' : '0',
			};

		await this.UpdateChecklist( EditChecklist );	
	}

	async SolenoideEditModalBtn( newValue, Id_checklist ){

			const EditChecklist = {
			Id: Id_checklist.toString(),
			Solenoide: newValue? '1' : '0' ,
			};
			
		await this.UpdateChecklist( EditChecklist );	
	}

	async FlujometroEditModalBtn( newValue, Id_checklist ){

			const EditChecklist = {
			Id: Id_checklist.toString(),
			Flujometro: newValue? '1' : '0',
			};
			
		await this.UpdateChecklist( EditChecklist );	
	}

	async ConduitChocoEditModalBtn( newValue, Id_checklist ){

			const EditChecklist = {
			Id: Id_checklist.toString(),
			ConduitChoco: newValue? '1' : '0',
			};
		
		await this.UpdateChecklist( EditChecklist );
	}

	async UpdateChecklist( ObjData )	{


	await	$.ajax(
		{
    		url:`https://smartbox.eco3.cl/ApiController/checklist/checklistUpdate.php`,
    		type:"post",
			dataType:'text',
			data: ObjData,
			success: function(result) {
					alert (result);
				}
		});

	}
}






  

