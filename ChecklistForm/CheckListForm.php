<!DOCTYPE html>
<html lang="en">
<?php
$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/views/head.php";
require_once $sitebasepath."/views/navbar.php";
require_once $sitebasepath."/Model/model.php";

?>
<?php

$UnidadTag= $_GET['tag'];
$Model = new Model();
$unidadDbEntity=$Model->unidadByTag($UnidadTag);
	?>	
	
<script>

	function FunctionNuevoCheckListPost() {
		let text = "¿Está seguro de enviar el CheckList?";
		if (confirm(text) == true) { 
		
		let pattern = /(^\d+\.\d+$)|(^\d+$)/; 
		var URL = "NuevoCheckListPost.php"; 
		var Respuesta;
		var token = "eco3spa";
		var noAjustarMsg = " ,vuelva a ajustarlo. SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, póngase en contacto con la oficina técnica.";
		var IMEI= "<?php echo $unidadDbEntity->get_tag();?>";
		var id_unidad= "<?php echo $unidadDbEntity->get_id();?>";
			
		var VoltajeReguladorBat= document.getElementById("VoltajeReguladorBat");
		var hasError = NumericParameterHasError(VoltajeReguladorBat,14.2,12.4) ; 
		
		if(hasError){document.getElementById('VoltajeReguladorBat').className += ' border border-danger';return;}
		else {document.getElementById('VoltajeReguladorBat').className='form-control';}  
	
		var VoltajeReguladorMCU= document.getElementById("VoltajeReguladorMCU");
		hasError = NumericParameterHasError(VoltajeReguladorMCU,5.3,5) ; 	    
		
		if(hasError){document.getElementById('VoltajeReguladorMCU').className += ' border border-danger';return;}
		else {document.getElementById('VoltajeReguladorMCU').className='form-control';}  
		
		var SmartBox= Number(document.getElementById("SmartBox").checked);
		var SMSenvio= Number(document.getElementById("SMSenvio").checked);
		var SMSrecibo= Number(document.getElementById("SMSrecibo").checked);
		var Flujometro= Number(document.getElementById("Flujometro").checked);
		var Solenoide= Number(document.getElementById("Solenoide").checked);
		var SensorNivelBajo= Number(document.getElementById("SensorNivelBajo").checked);
		var SensorNivelAlto= Number(document.getElementById("SensorNivelAlto").checked);   
		var VoltajeMCU= document.getElementById("VoltajeMCU");
		hasError = NumericParameterHasError(VoltajeMCU,4,3.3) ; 	    
		
		if(hasError){document.getElementById('VoltajeMCU').className += ' border border-danger';return;}
		else {document.getElementById('VoltajeMCU').className='form-control';} 
		
		var BateriaTest= Number(document.getElementById("BateriaTest").checked);
		var e = document.getElementById("ChecklistMotivo");
		var id_checklistMotivo = e.options[e.selectedIndex].value;  
		var Observaciones= document.getElementById("Observaciones").value;
		if(Observaciones == "" ){ return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");}    
		var f = document.getElementById("unidadtipo");
		var id_unidadtipo = f.options[f.selectedIndex].value;   
		var TecnicoResponsable= document.getElementById("TecnicoResponsable").value;
		if(TecnicoResponsable == "" ){ return alert("Técnico responsable no puede estar vacío, coloque su nombre.");}
		var URL_foto= document.getElementById("NombreDeFoto").innerHTML;	  
	  
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			data: {
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
			BateriaTest: BateriaTest,
			id_checklistMotivo: id_checklistMotivo,
			Observaciones: Observaciones,
			id_unidadtipo: id_unidadtipo,
			TecnicoResponsable: TecnicoResponsable,
			URL_foto: URL_foto,	    
        	},
		    success: function(result){alert(result)}    
		  });

		window.location.href = "https://smartbox.eco3.cl/";
		} else {
			alert("La operación se ha cancelado.");
		}
	}



	function uploadPicture() {
	
		var URL = "upload.php"; 
		  
		var file_data = file;  

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

	
	}
	

</script>

<div class="container">
	<div class="row">
		<div class="col">	
			<br>
			<h1 class="display-2"><b>Checklist para </b><?php echo $UnidadTag;?></h1>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col border">
		<table class="table">
		<tbody>	
		<tr><td><b>IMEI:</b></td><td><?php echo $unidadDbEntity->get_tag();?></td><td></td></tr>
		<tr><td><b>ID de la unidad:</b></td><td><?php echo $unidadDbEntity->get_id();?></td><td></td></tr>
		<tr><td><b>Tipo de unidad:</b></td><td>
		<select name="unidadtipo" class="form-select" id="unidadtipo" required>	
			<?php
				$UnidadesTipos = $Model->get_unidadtipos();
				foreach($UnidadesTipos as $Ut){ echo '<option value="'.$Ut->get_Id().'">'.$Ut->get_Nombre().'</option>'; }
			?>		
    	</select>   </td><td></td></tr>
		<tr><td><b>Motivo del checklist:</b></td><td>
		<select name="ChecklistMotivo" class="form-select" id="ChecklistMotivo" required>
			<?php
			$checklistmotivos = $Model->get_checklistmotivos();	
			foreach($checklistmotivos as $Cm){ echo '<option value="'.$Cm->get_Id().'">'.$Cm->get_Nombre().'</option>'; }?>
    	</select> </td><td></td></tr>
		<tr><td><b>Voltaje regulador de batería:</b></td><td><input type="text" class="form-control" id="VoltajeReguladorBat" placeholder="13.9-14.2 Pb 12.4-12.8 Li" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" ></td><td>(V)</td></tr>
		<tr><td><b>Voltaje regulador de MCU:</b></td><td><input type="text" class="form-control" id="VoltajeReguladorMCU" placeholder="5-5.3" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros"></td><td>(V)</td></tr>
		<tr><td><b>Voltaje MCU:</b></td><td><input type="text" class="form-control" id="VoltajeMCU" placeholder="3.3-4V" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros"></td><td>(V)</td></tr>
		<tr><td><b>SmartBox:</b></td><td><input type="checkbox" class="form-check-input" id="SmartBox" ></td><td></td></tr>
		<tr><td><b>Envío SMS:</b></td><td><input type="checkbox" class="form-check-input" id="SMSenvio" ></td><td></td></tr>
		<tr><td><b>Recepción SMS:</b></td><td><input type="checkbox" class="form-check-input" id="SMSrecibo" ></td><td></td></tr>
		<tr><td><b>Solenoide:</b></td><td><input type="checkbox" class="form-check-input" id="Solenoide"></td><td></td></tr>
		<tr><td><b>Flujómetro:</b></td><td><input type="checkbox" class="form-check-input" id="Flujometro"></td><td></td></tr>
		<tr><td><b>Sensor nivel bajo:</b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelBajo"></td><td></td></tr>
		<tr><td><b>Sensor nivel alto:</b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelAlto" ></td><td></td></tr>
		<tr><td><b>Medidor de batería:</b></td><td><input type="checkbox" class="form-check-input" id="BateriaTest" ></td><td></td></tr>
		<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, coloque OK."></td><td></td></tr>
		<tr><td><b>Técnico responsable:</b></td><td><input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre"></td><td></td></tr>
		<tr><td><b>Imagen:</b></td><td><div id="NombreDeFoto"></div></td><td></td></tr>
		</tbody>
		</table>
		</div>
	</div>

	<div class="row">
		<div class="col" >
			<button type="button" class="btn btn-success btn-lg" onclick="FunctionNuevoCheckListPost()">Enviar CheckList</button>
		</div>
		
	<div class="col">
		<!--<select name="listaDeDispositivos" id="listaDeDispositivos"></select>-->
		<button id="boton"  class="btn btn-success btn-lg" >Tomar foto</button>
		<p id="estado"></p>
	</div>
	<br>
		<div class="col">
			<video autoplay playsinline ></video>
			<canvas id="canvas" style="display: none;"></canvas>
		</div>
	</div>
	<div class="row">
		<div class="col" >
			<input id="sortpicture" type="file" name="sortpic" />
			<button id="upload" onclick="uploadPicture()" >Upload</button>
		</div>
	</div>
	
</div>
</body>
<!--<script src="script.js"></script>-->
<script> 
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

	function iOS() {
  return [
    'iPad Simulator',
    'iPhone Simulator',
    'iPod Simulator',
    'iPad',
    'iPhone',
    'iPod'
  ].includes(navigator.platform)
  // iPad on iOS 13 detection
  || (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}
	
	function iOSversion() {

  if (iOS()) { // <-- Use the function above here
    if (window.indexedDB) { return 'iOS 8 and up'; }
    if (window.SpeechSynthesisUtterance) { return 'iOS 7'; }
    if (window.webkitAudioContext) { return 'iOS 6'; }
    if (window.matchMedia) { return 'iOS 5'; }
    if (window.history && 'pushState' in window.history) { return 'iOS 4'; }
    return 'iOS 3 or earlier';
  }

  return 'Not an iOS device';
}
	
	
	const   $listaDeDispositivos = document.querySelector("#listaDeDispositivos"),
	
    $canvas = document.querySelector("#canvas"),
    $estado = document.querySelector("#estado"),
    $boton = document.querySelector("#boton");
 
		
	
	navigator.permissions.query({ name: 'camera' })
  .then(function(permissionStatus) {
    if (permissionStatus.state === 'granted') {
      // Camera access is granted
    } else {
      // Camera access is not granted; request permission as needed
    }
  })
	
	if(iOSversion() === 'Not an iOS device' )
	{
			navigator.mediaDevices.getUserMedia({video:{facingMode: {exact: 'environment'}} })
  .then(function (stream) {
  // Stream the camera feed to a video element on the page
  var videoElement = document.querySelector('video');
  videoElement.srcObject = stream;
})
	}
	else
	{
		
	navigator.mediaDevices.getUserMedia({     video: {
        facingMode: {
            exact: 'environment'
        }
    } })
  .then(function (stream) {
  // Stream the camera feed to a video element on the page
  var videoElement = document.querySelector('video');
  videoElement.srcObject = stream;
})
	}
	
	if (!navigator.mediaDevices?.enumerateDevices) {
  console.log("enumerateDevices() not supported.");
} else {
  // List cameras and microphones.
  navigator.mediaDevices
    .enumerateDevices()
    .then(dispositivos => {
            const dispositivosDeVideo = [];
            dispositivos.forEach(dispositivo => {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            if (dispositivosDeVideo.length > 0) {
                // Llenar el select
				
			
				var FirstDispositivo =dispositivosDeVideo[0];
				const Firstoption = document.createElement('option');
				Firstoption.value = FirstDispositivo.deviceId;
                Firstoption.text = FirstDispositivo.label;
				$listaDeDispositivos.appendChild(Firstoption);
				/*
                dispositivosDeVideo.forEach(dispositivo => {
                    const option = document.createElement('option');
                    option.value = dispositivo.deviceId;
                    option.text = dispositivo.label;
                    $listaDeDispositivos.appendChild(option);
                });*/
            }
        })
	

}
		  $video = document.querySelector('video');
	
	       $boton.addEventListener("click", function() {

                    //Pausar reproducción
                    $video.pause();

                    //Obtener contexto del canvas y dibujar sobre él
                    let contexto = $canvas.getContext("2d");
                    $canvas.width = $video.videoWidth;
                    $canvas.height = $video.videoHeight;
                    contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                    let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
                    $estado.innerHTML = "Enviando foto... Por favor, espere...";
                    fetch("./guardar_foto.php", {
                            method: "POST",
                            body: encodeURIComponent(foto),
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded",
                            }
                        })
                        .then(resultado => {
                            // A los datos los decodificamos como texto plano
                            return resultado.text()
                        })
                        .then(nombreDeLaFoto => {
                            // nombreDeLaFoto trae el nombre de la imagen que le dio PHP
                            console.log("La foto fue enviada correctamente");
                            $estado.innerHTML = `Foto guardada con éxito. Puede verla <a target='_blank' href='./${nombreDeLaFoto}'> aquí</a>`;
						document.querySelector("#NombreDeFoto").innerHTML = nombreDeLaFoto;

                        })

                    //Reanudar reproducción
                    $video.play();
                });
            

	const fileInput = document.getElementById('sortpicture');

	fileInput.addEventListener('change', (event) => {
		// Get the FileList object
		const fileList = event.target.files;
		
		// Access the first file (if selected)
	if (fileList.length > 0) {
			const file = fileList[0];
			console.log(`File Name: ${file.name}`);
			console.log(`File Size: ${file.size} bytes`);
			console.log(`File Type: ${file.type}`);
	}
	});
/*	
const $videob = document.querySelector("#video");
	
  var streamb =  navigator.mediaDevices.getUserMedia({
        'video': true
      
      });
	
   $videob.srcObject = streamb;
                $videob.play();*/
</script>
</html>