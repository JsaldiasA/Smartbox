
GetChecklistTable("Z3");
GetChecklistTable("Z2");
GetChecklistTable("Z1");
GetChecklistTable("Z4");
GetChecklistTable("FASE2");
GetChecklistTable("Estanques");

function GetChecklistTable( ZonaName )
	{
    	var URL = "ApiController/Checklist/ChecklistGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			data:				
			{     		
				Zona: ZonaName,
			},
			
		    success: function(result){document.getElementById("mainChecklist"+ZonaName).innerHTML= result;}
		});	
	}



