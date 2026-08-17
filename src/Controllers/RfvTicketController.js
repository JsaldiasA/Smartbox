class RfvTicketController {
	
	constructor( )	{
	}

	CreateTicket()	{

		let text = "¿Está seguro de enviar el ticket?";
		if (confirm(text) == true)
		{
			var URL = "https://smartbox.eco3.cl/ApiController/Rfvticket/Create.php";
			var Nombre = document.getElementById("Nombre").value;
			if (Nombre == "")	return alert ("Debe especificar un dispositivo y/o plataforma.");
			var Descripcion = document.getElementById("Descripcion").value;
			if (Descripcion == "" )	 return alert ("Debe explicar de que se trata el problema.");
			var Usuario = document.getElementById("Usuario").value;
			if (Usuario == "" )		return alert ("Debe escribir su nombre.");
				
			var Ubicacion = document.getElementById("Ubicacion").value;
			
			if (Ubicacion == "")	return alert ("Debe especificar una ubicacion de referencia.");
			var f = document.getElementById("RfvTicketPriority");
			var Id_RfvTicketPriority = f.options[f.selectedIndex].value; 

			let URL_foto= document.getElementById("NombreDeFoto").innerHTML == "" ? 'nofoto.jpg' : document.getElementById("NombreDeFoto").innerHTML ; 
			URL_foto='https://smartbox.eco3.cl/checklistform/Fotos/'+URL_foto;

			$.ajax( {
        		url:URL,
        		type:"post",
				dataType:'text',
				data: {
					Nombre: Nombre,
					Descripcion: Descripcion,
					Usuario: Usuario,
					Ubicacion: Ubicacion,
					Id_RfvTicketPriority: Id_RfvTicketPriority,
					URL_foto: URL_foto
    			},
				success: function(result) {
					alert (result);
					window.location.reload();
				}
			});
  		}
		else	alert ("La operación se ha cancelado.");
	}

	  GetTicketPriority( )	{

		const PrioridadGrave = {
		Id: "1",
		Name: "Alta",
		Reasons:[{Id: "1",Name:"Desconectado"},{Id: "2",Name:"No Abre"}]
		};

		const PrioridadMedia = {
		Id: "2",
		Name: "Media",
		Reasons:[{Id: "10",Name:"No marca"}]
		};

		const PrioridadBaja = {
		Id: "3",
		Name: "Baja",
		Reasons:[{Id: "3",Name:"Bateria baja"},{Id: "4",Name:"Sin condit"},{Id: "6",Name:"Sin choco"},{Id: "7",Name:"Fuga agua"},{Id: "8",Name:"Caja de energizacion"},{Id: "9",Name:"otro"}]
		};

		Priorities = [PrioridadGrave,PrioridadMedia,PrioridadBaja]

  		return Priorities;
	}


	 FunctionDeleteTicket(id_ticket)	{
		
		let text = "¿Está seguro de eliminar el ticket?";
		if (confirm(text) == true)
		{
			var MotivoCierre = document.getElementById("MotivoCierre").value;

			if (MotivoCierre == "")	{
				return alert ("Debe escribir el motivo del cierre");
			}

			let pattern = /(^\d+\.\d+$)|(^\d+$)/;
			var URL = "https://smartbox.eco3.cl/ApiController/rfvticket/Delete.php";
			var Respuesta;
		
			$.ajax(
			{
				url:URL,
				type:"post",
				dataType:'text',
				data:
					{
						Id: id_ticket,
						MotivoDeCierre: MotivoCierre
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

	async  uploadPicture( inputFile ) {
	
		var file_data = inputFile;  

		const enviarChecklistBtn = document.getElementById('EnviarTicketBtn');
		const uploadBtn = document.getElementById('upload');
		
		uploadBtn.disabled = true;
		uploadBtn.classList.remove('btn-success');
   		uploadBtn.classList.add('btn-secondary'); 
		uploadBtn.innerHTML= `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;

		
		enviarChecklistBtn.disabled = true;
		enviarChecklistBtn.classList.remove('btn-success');
   		 enviarChecklistBtn.classList.add('btn-secondary'); 
		enviarChecklistBtn.innerHTML= 'Subiendo Foto ' + `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div>`;

    	var form_data = new FormData();                  
    	form_data.append('file', file_data);                        
		$.ajax({
        url: 'https://smartbox.eco3.cl/ChecklistForm/upload.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response); // <-- display response from the PHP script, if any
			document.querySelector("#StatusFoto").innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
			document.querySelector("#NombreDeFoto").innerHTML = file_data.name;
			enviarChecklistBtn.disabled = false;
			enviarChecklistBtn.innerHTML= 'Enviar CheckList' ;
			enviarChecklistBtn.classList.remove('btn-secondary');
			enviarChecklistBtn.classList.add('btn-success');

			uploadBtn.className = 'btn btn-success';
			uploadBtn.textContent = 'Subir Foto';
			uploadBtn.disabled = false;

   		
        }
     });
	}
	
}






  

