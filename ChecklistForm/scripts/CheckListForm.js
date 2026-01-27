
	function FunctionNuevoCheckListPost()
		{
			let text = "¿Está seguro de enviar el CheckList?";
			if (confirm(text) == true)
				{
					let pattern = /(^\d+\.\d+$)|(^\d+$)/;

					var URL = "NuevoCheckListPost.php"; 
					var Respuesta;
					var token = "eco3spa";
					var noAjustarMsg = " ,vuelva a ajustarlo. SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, póngase en contacto con la oficina técnica.";
					var IMEI= Tag_unidad;
					var id_unidad= Id_unidad;
					var VoltajeReguladorBat= document.getElementById("VoltajeReguladorBat");
					var hasError = NumericParameterHasError(VoltajeReguladorBat,14.2,12.4) ; 
			
					if(hasError)
						{
							document.getElementById('VoltajeReguladorBat').className += ' border border-danger';return;
						}
					else
						{
							document.getElementById('VoltajeReguladorBat').className='form-control';
						}  
		
					var VoltajeReguladorMCU= document.getElementById("VoltajeReguladorMCU");
					hasError = NumericParameterHasError(VoltajeReguladorMCU,5.3,5) ; 	    
			
					if(hasError)
						{
							document.getElementById('VoltajeReguladorMCU').className += ' border border-danger';return;
						}
					else
						{
							document.getElementById('VoltajeReguladorMCU').className='form-control';
						}  
			
					var SmartBox= Number(document.getElementById("SmartBox").checked);
					var SMSenvio= Number(document.getElementById("SMSenvio").checked);
					var SMSrecibo= Number(document.getElementById("SMSrecibo").checked);
					var Flujometro= Number(document.getElementById("Flujometro").checked);
					var Solenoide= Number(document.getElementById("Solenoide").checked);
					var SensorNivelBajo= Number(document.getElementById("SensorNivelBajo").checked);
					var SensorNivelAlto= Number(document.getElementById("SensorNivelAlto").checked);   
					var VoltajeMCU= document.getElementById("VoltajeMCU");
					hasError = NumericParameterHasError(VoltajeMCU,4,3.3);

					if(hasError)
						{
							document.getElementById('VoltajeMCU').className += ' border border-danger';return;
						}
					else
						{
							document.getElementById('VoltajeMCU').className='form-control';
						} 
			
					var VoltajeBateria= document.getElementById("VoltajeBateria");
					hasError = NumericParameterHasError(VoltajeBateria,15,12);

					var BateriaTest= Number(document.getElementById("BateriaTest").checked);
					var Toolbox      = Number(document.getElementById("Toolbox").checked);		
					var ConduitChoco = Number(document.getElementById("ConduitChoco").checked);
					var agua         = Number(document.getElementById("agua").checked);

					var e = document.getElementById("ChecklistMotivo");
					var id_checklistMotivo = e.options[e.selectedIndex].value;  
					var Observaciones= document.getElementById("Observaciones").value;
					if(Observaciones == "" )
						{
							return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");
						}

					var f = document.getElementById("unidadtipo");
					var id_unidadtipo = f.options[f.selectedIndex].value;   
					var TecnicoResponsable= document.getElementById("TecnicoResponsable").value;
					if(TecnicoResponsable == "" )
						{
							return alert("Técnico responsable no puede estar vacío, coloque su nombre.");
						}

					var URL_foto= document.getElementById("NombreDeFoto").innerHTML;	  
		
					$.ajax(
						{
							url:URL,    //the page containing php script
							type: "post",    //request 
							dataType: 'text',
							data:
								{
									token: token,
									IMEI: IMEI,
									id_unidad: id_unidad,
									VoltajeReguladorBat: VoltajeReguladorBat.value,
									VoltajeReguladorMCU: VoltajeReguladorMCU.value,
									SmartBox: SmartBox,
									SMSenvio: SMSenvio,
									SMSrecibo: SMSrecibo,
									Flujometro: Flujometro,
									Solenoide: Solenoide,
									SensorNivelBajo: SensorNivelBajo,
									SensorNivelAlto: SensorNivelAlto,
									VoltajeMCU: VoltajeMCU.value,
									VoltajeBateria: VoltajeBateria.value,
									BateriaTest: BateriaTest,
									Toolbox:      Toolbox,        
									ConduitChoco: ConduitChoco,
									agua:        agua,   
									id_checklistMotivo: id_checklistMotivo,
									Observaciones: Observaciones,
									id_unidadtipo: id_unidadtipo,
									TecnicoResponsable: TecnicoResponsable,
									URL_foto: URL_foto,	    
								},
							success: function(result)
								{
									alert(result);
									window.location.href = "https://smartbox.eco3.cl/main.php";
								}    
						});

						//window.location.href = "https://smartbox.eco3.cl/";
				}
			else
				{
					alert("La operación se ha cancelado.");
				}
		}

	function uploadPicture() {
	
		var URL = "upload.php"; 
		var inputFiles = document.getElementById("sortpicture");
		var file_data = inputFiles.files[0];  
		
		

    	var form_data = new FormData();                  
    	form_data.append('file', file_data);
   		 alert(form_data);                          
		   $.ajax({
        url: 'upload.php', // <-- point to server-side PHP script 
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response); // <-- display response from the PHP script, if any
        }
     });

	 	document.querySelector("#NombreDeFoto").innerHTML = file_data.name;
	
	}
	
    		function NumericParameterHasError(Parameter,highLimit,lowLimit) {
		let pattern = /(^\d+\.\d+$)|(^\d+$)/; 
	var noAjustarMsg = " ,vuelva a ajustarlo. SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, póngase en contacto con la oficina técnica.";
			  
	switch (true) {
	  case (Parameter.value < lowLimit):
		alert(Parameter.id+" no puede ser menor a "+lowLimit+" "+noAjustarMsg);		  
		return true;
		break;
	  case (Parameter.value > highLimit ):
		alert(Parameter.id+" no puede ser mayor a "+highLimit+" "+noAjustarMsg);
		return true;
		break;
	  case (!pattern.test(Parameter.value)):
		alert("Error en " +Parameter.id+". Ingrese solo valores numéricos, no se aceptan letras o caracteres en este campo. Ej: 1 ,13 ,14.2 ,13.5");
		return true;
		break;
	  case (Parameter.value == ""):
		alert("Error en" +Parameter.id+". este campo no puede estar vacío");
		return true;
		break;
	  case (Parameter.value == null):
		alert("Error en" +Parameter.id+". este campo no puede estar vacío");
		return true;
		break;
			
	  default:
	    return false;
	}	   
}

function FunctionUpdateChecklistPost( Id_checklist ) 
		{
			let text = "¿Está seguro de enviar el ticket?";
			if (confirm(text) == true)
				{
					let pattern = /(^\d+\.\d+$)|(^\d+$)/;
					var URL = "/ApiController/checklist/checklistUpdate.php";
					var Respuesta;

					var Smartbox      = Number(document.getElementById("Smartbox").checked);	
					var Solenoide 	= Number(document.getElementById("Solenoide").checked);
					var Flujometro         = Number(document.getElementById("Flujometro").checked);	
					var ConduitChoco = Number(document.getElementById("ConduitChoco").checked);
					var agua         = Number(document.getElementById("agua").checked);

					var Observaciones= document.getElementById("Observaciones").value;
					if(Observaciones == "" )
						{
							return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");
						}
				
					$.ajax(
						{
            				url:URL,
            				type:"post",
							dataType:'text',
							data:
								{
									Id_checklist:Id_checklist,
									Solenoide 	: Solenoide,
									ConduitChoco: ConduitChoco,
									Flujometro : Flujometro,
									Smartbox: Smartbox ,
									agua: agua,       
									Nombre: Nombre,
									Observaciones: Observaciones,
        						},
							success: function(result)
								{
									alert (result);
									window.location.href = "https://smartbox.eco3.cl/Checklistinicio.php";
								}
						});
  				}
			else
			{
    			alert ("La operación se ha cancelado.");
  			}
		}