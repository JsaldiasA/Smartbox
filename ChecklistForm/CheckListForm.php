<!DOCTYPE html>
<html lang="en">
<?php
$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/views/head.php";
require_once $sitebasepath."/views/navbar.php";
require_once $sitebasepath.'/DbEntities/unidadDbEntity.php';
require_once $sitebasepath.'/DbEntities/checklistDbEntity.php';
require_once $sitebasepath.'/config/DbSirecorConfig.php';	
?>
<?php
$UnidadTag= $_GET['tag'];

$dbConfig = new DbSirecorConfig();		
// Create connection
$conn = new mysqli($dbConfig->get_servername(),$dbConfig->get_username(),$dbConfig->get_password(),$dbConfig->get_dbname());
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//GETTING DATA FROM THE UNIT	
$sql = "SELECT * FROM `unidad` WHERE `tag`= '{$UnidadTag}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) 
	{
	    $unidadDbEntity= new unidadDbEntity($row["id"],$row["Nombre"],$row["tag"],$row["Numero"],$row["UltimaActualizacion"],$row["Volumen"],$row["Estado"],$row["id_unidadTipo"],$row["InvertirEntrada"],$row["BatNivel"]);
//cuidado con el casing, distinge de mayusculas y minusculas
	}
} 
else 
{ echo "0 results"; }

	?>	
	
<script>

	function FunctionNuevoCheckListPost() {
  let text = "Estas seguro de enviar el CheckList";
  if (confirm(text) == true) { 
	  
	let pattern = /(^\d+\.\d+$)|(^\d+$)/; 
	var URL = "NuevoCheckListPost.php"; 
	var Respuesta;
	  
	var token = "eco3spa";
	var noAjustarMsg = " ,vuelva a ajustarlo.SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, pongase en contacto con la oficina tecnica.";
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
	if(Observaciones == "" ){ return alert("Observaciones no puede estar vacio, coloque alguna observacion. si no tiene coloque OK");}  
	  
	var f = document.getElementById("unidadtipo");
	var id_unidadtipo = f.options[f.selectedIndex].value;   
	  
	//var id_unidad= document.getElementById("id_unidad").value;
	//var Fecha= document.getElementById("Fecha").value;
	var TecnicoResponsable= document.getElementById("TecnicoResponsable").value;
	if(TecnicoResponsable == "" ){ return alert("TecnicoResponsable no puede estar vacio, coloque su nombre");}  
	  
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
    	alert("Has cancelado");
  	}
	}
	
</script>

	<!-- //Navigation -->
<!-- SCRIPTS PARA editar panel -->


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
      <tr><td><b>IMEI de la unidad </b></td><td><?php echo $unidadDbEntity->get_tag();?></td><td></td></tr>
	   <tr><td><b> id_unidad </b></td><td><?php echo $unidadDbEntity->get_id();?></td><td></td></tr>
<tr><td><b>VoltajeReguladorBat </b></td><td><input type="text" class="form-control" id="VoltajeReguladorBat" placeholder="13.9-14.2 Pb 12.4-12.8 Li" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" ></td><td>(V)</td></tr>
<tr><td><b>VoltajeReguladorMCU </b></td><td><input type="text" class="form-control" id="VoltajeReguladorMCU" placeholder="5-5.3" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros"></td><td>(V)</td></tr>
<tr><td><b>SmartBox </b></td><td><input type="checkbox" class="form-check-input" id="SmartBox" ></td><td></td></tr>
<tr><td><b>SMSenvio </b></td><td><input type="checkbox" class="form-check-input" id="SMSenvio" ></td><td></td></tr>
<tr><td><b>SMSrecibo </b></td><td><input type="checkbox" class="form-check-input" id="SMSrecibo" ></td><td></td></tr>
<tr><td><b>Flujometro </b></td><td><input type="checkbox" class="form-check-input" id="Flujometro"></td><td></td></tr>
<tr><td><b>Solenoide </b></td><td><input type="checkbox" class="form-check-input" id="Solenoide"></td><td></td></tr>
<tr><td><b>SensorNivelBajo </b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelBajo"></td><td></td></tr>
<tr><td><b>SensorNivelAlto </b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelAlto" ></td><td></td></tr>
<tr><td><b>VoltajeMCU </b></td><td><input type="text" class="form-control" id="VoltajeMCU" placeholder="3.3-4V" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros"></td><td>(V)</td></tr>
<tr><td><b>BateriaTest </b></td><td><input type="checkbox" class="form-check-input" id="BateriaTest" ></td><td></td></tr>
			<tr><td><b>checklist Motivo </b></td><td>	<?php
	
    $q = $conn->query("SELECT * FROM `checklistMotivo`");
    echo  '<select name="ChecklistMotivo" class="form-select" id="ChecklistMotivo" required>';
    while($rows = $q->fetch_assoc()){
              $checklistmotivo_name= $rows['Nombre'];
			  $checklistmotivo_value= $rows['id'];
              echo '<option value="'.$checklistmotivo_value.'">'.$checklistmotivo_name.'</option>';
            }
    echo'</select>';// select TAG con unidad tipo
	
?></td><td></td></tr>
<tr><td><b>Observaciones </b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si tiene comentarios, coloque ok"></td><td></td></tr>
<tr><td><b>id_unidadtipo </b></td><td><?php
	
    $q = $conn->query("SELECT * FROM `unidadtipo`");
    echo  '<select name="unidadtipo" class="form-select" id="unidadtipo" required>';
    while($rows = $q->fetch_assoc()){
              $unidadtipo_name= $rows['Nombre'];
			  $unidadtipo_value= $rows['Id'];
              echo '<option value="'.$unidadtipo_value.'">'.$unidadtipo_name.'</option>';
            }
    echo'</select>';// select TAG con unidad tipo
	
?></td><td></td></tr>
<tr><td><b>TecnicoResponsable </b></td><td><input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre"></td><td></td></tr>
<tr><td><b>Imagen </b></td><td><div id="NombreDeFoto"></div></td><td></td></tr>

			</tbody></table>
		</div>
	</div>

				<div class="row">
				<div class="col" >
	<button type="button" class="btn btn-primary btn-lg" onclick="FunctionNuevoCheckListPost()">Enviar CheckList</button>
	</div>
		
	<div class="col">
		<!--<select name="listaDeDispositivos" id="listaDeDispositivos"></select>-->
		<button id="boton"  class="btn btn-primary btn-lg" >Tomar foto</button>
		<p id="estado"></p>
	</div>
	<br>
	
	<div class="col">
	<video autoplay playsinline ></video>
	<canvas id="canvas" style="display: none;"></canvas>
	</div>
</div>
</body>
<!--<script src="script.js"></script>-->
<script> 
	
		function NumericParameterHasError(Parameter,highLimit,lowLimit) {
		let pattern = /(^\d+\.\d+$)|(^\d+$)/; 

	var noAjustarMsg = " ,vuelva a ajustarlo.SI NO PUEDE AJUSTARLO NO UTILICE ESTA PLACA EN TERRENO, pongase en contacto con la oficina tecnica.";
			  

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
		alert("Error en " +Parameter.id+". Ingrese solo valores numericos, no se aceptan letras o caracteres en este campo. EJ: 1 , 13 , 14.2 , 13.5");
		return true;
		break;
	  case (Parameter.value == ""):
		alert("Error en" +Parameter.id+". este campo no puede estar vacio");
		return true;
		break;
	  case (Parameter.value == null):
		alert("Error en" +Parameter.id+". este campo no puede estar vacio");
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
                    $estado.innerHTML = "Enviando foto. Por favor, espera...";
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
                            $estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./${nombreDeLaFoto}'> aquí</a>`;
						document.querySelector("#NombreDeFoto").innerHTML = nombreDeLaFoto;

                        })

                    //Reanudar reproducción
                    $video.play();
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