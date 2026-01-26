
GetChecklistTable();

function GetChecklistTable()
	{
    	var URL = "ApiController/Checklist/ChecklistGet.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType:'text',
			//data:				{     		},
			
		    success: function(result){document.getElementById("mainChecklist").innerHTML= result;}
		});	
	}


