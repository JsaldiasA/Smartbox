
GetChecklistTable("Z3", 0);
GetChecklistTable("Z2", 0);
GetChecklistTable("Z1", 0);
GetChecklistTable("Z4", 0);
GetChecklistTable("FASE2",0);
GetChecklistTable("Estanques",1);

function GetChecklistTable( ZonaName, returnJson )
	{
    	var URL = "ApiController/Checklist/ChecklistGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			data:				
			{     		
				Zona: ZonaName,
				returnJson: returnJson,
			},
			
		    success: function(result){
				document.getElementById("mainChecklist"+ZonaName).innerHTML= result;
			}
		});	
	}



