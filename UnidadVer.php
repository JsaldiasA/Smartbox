<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();
$dat= $_GET['tag'];
$unidadDbEntity = $Model->unidadByTag($dat);
$checklistDbEntity= $Model->UltimochecklistById_unidad($unidadDbEntity->get_id());

$HtmlPage='
<!-- SCRIPTS PARA editar panel -->
<script>
function FunctionNuevoNumero(unidad)
	{
  		let text = "¿Está seguro de cambiar el número de la unidad?";
 		if (confirm(text) == true)
			{
				var URL = "UnidadCambiarNumero.php";
				var Respuesta;
				var NuevoNumero = document.getElementById("NuevoNumero").value;
				var token = document.getElementById("password").value ;
		
				$.ajax({
        			url:URL,
            		type:"post",
					dataType:\'text\',
					data:
						{
            				tag: unidad,
							NuevoNumero: NuevoNumero,
							token: token,
        				},
					success: function(result)
						{
							alert(result)
						}
		  		});
  			}
		else
			{
    			alert("La operación se ha cancelado.");
  			}
	}

function FunctionNuevaUbicacion(unidad) {
  let text = "¿Está seguro de cambiar la ubicación de la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarNombre.php";
	var Respuesta;
	var NuevaUbicacion = document.getElementById("NuevaUbicacion").value;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: \'text\',
			  data: {
            tag: unidad,
			NuevaUbicacion: NuevaUbicacion,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}
	
function FunctionNuevoTipo(unidad) {
  let text = "¿Está seguro de cambiar el tipo de unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarTipo.php";
	var Respuesta;
	var e = document.getElementById("NuevoTipo");
	var value = e.value;
	var NuevoTipo = e.options[e.selectedIndex].text;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: \'text\',
			  data: {
            tag: unidad,
			NuevoTipo: NuevoTipo,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}	
	
function FunctionEliminar(unidad) {
  let text = "¿Está seguro de eliminar la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadEliminar.php";
	var Respuesta;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request 
			dataType: \'text\',
			  data: {
            tag: unidad,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });	 

  } else {
    alert("La operación se ha cancelado.");
  }
}
	
function FunctionComandosMilesight(ComandoNombre) {
  let text = "¿Está seguro de accionar la unidad?";
  if (confirm(text) == true) {

	var URL = "ApiController/Postcomandos_milesight.php";
	var Respuesta;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: \'text\',
			data: {
            tag: \''.$unidadDbEntity->get_Tag().'\',
			nombre: ComandoNombre,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

function FunctionCambiarVolMax(unidad) {
  let text = "¿Está seguro de cambiar el volumen máximo de la unidad?";
  if (confirm(text) == true) {

	var URL = "UnidadCambiarVolMax.php";
	var Respuesta;
	var NuevoVolMax = document.getElementById("VolMax").value;
	var token = document.getElementById("password").value;
	$.ajax({
            url:URL, //the page containing php script
            type: "post", //request
			dataType: \'text\',
			  data: {
            tag: unidad,
			NuevoVolMax: NuevoVolMax,
			token: token,
        	},
		    success: function(result){alert(result)}
		  });

  } else {
    alert("La operación se ha cancelado.");
  }
}

</script>	

<body>	
	

<div class="container p-3" >
<div class="row p-3" >
	<div class="col p-3 card shadow" >
	';
	
	$CabeceraName = $unidadDbEntity->get_Serie();
	 
		if($CabeceraName == "")
		{
			$HtmlPage=$HtmlPage. "<h1>&nbsp;<b>Unidad</b> ". $unidadDbEntity->get_Tag()."(sin nombre)</h1>";
		}
		else
		{
			$HtmlPage=$HtmlPage. "<h1>&nbsp;<b>Unidad</b> ". $CabeceraName ."</h1>";
		}
			
		$tagTitle='IMEI';
		// Si es Milesight el título del tag es deviceEUI, si no es el IMEI.
		if( ($unidadDbEntity->get_Id_Unidadtipo() == '4') or ($unidadDbEntity->get_Id_Unidadtipo() == '3') )
		{
			$tagTitle='DeviceEUI';
		}

		$HtmlPage=$HtmlPage. '<table class="table">
		 	  <thead >
		  	  	<th scope="col">Serie</th>
		  		<th scope="col">'.$tagTitle.'</th>
				<th scope="col">Ubicación</th>
		  	  </thead><tbody>';// Header tabla
		//print row
        $HtmlPage=$HtmlPage. "<tr> <td>". $unidadDbEntity->get_Serie().
		"</td><td>". $unidadDbEntity->get_Tag().
		"</td><td>". $unidadDbEntity->get_Ubicacion().
		"</td> </tr>";
		$HtmlPage=$HtmlPage. '</tbody></table>';

		// Sólo para sensor de humedad Milesight.
		if($unidadDbEntity->get_Id_Unidadtipo() == '4')
		{
			$HtmlPage=$HtmlPage. '<table class="table">
			<thead >
			<th scope="col">Sensor</th>
			<th scope="col">Data</th>	
			</thead><tbody>';// Header tabla
			//print row
			$HtmlPage=$HtmlPage. "<tr>  
			<td>". "<b>Temperatura</b>".
			"</td> <td>". $unidadDbEntity->get_Estado().
			" °C</td></tr>";
			$HtmlPage=$HtmlPage. "<tr>  
			<td>". "<b>Humedad</b>".
			"</td> <td>". $unidadDbEntity->get_Volumen().
			"</td></tr>";
			$HtmlPage=$HtmlPage. "<tr>  
			<td>". "<b>Conductividad eléctrica(EC)</b>".
			"</td> <td>0". $unidadDbEntity->get_Volumen().// to do EC
			"</td></tr>";
			$HtmlPage=$HtmlPage. '</tbody></table>';
		}
$HtmlPage=$HtmlPage.'			
	</div>
</div>

<div class="row p-3" >
	<div class="col p-3 card shadow" >
		<h2>Configuración</h2>';
		
			
			$HtmlPage=$HtmlPage. '<table class="table">
			<thead >
			<th scope="col">Parámetros</th>
			<th scope="col">Valor</th>	
			</thead><tbody>';// Header tabla
			//print row
			$HtmlPage=$HtmlPage. "<tr>  
			<td>". "<b>Volumen máximo:</b>".
			"</td> <td>". $unidadDbEntity->get_VolMax().
			" (L)</td></tr>";
			$HtmlPage=$HtmlPage. '</tbody></table>';
		
	$HtmlPage=$HtmlPage.'		
		</div>		
		</div>
		<div class="row p-3" >
		<div class="col p-3 card shadow" >';

			$ultimoRegistro = $unidadDbEntity->get_UltimoRegistro();
			$HtmlPage=$HtmlPage. '<h2>Últimos registros</h2>';// Header tabla
			//print row
			$HtmlPage=$HtmlPage. '<table class="table" >
		  <thead >';
	$HtmlPage=$HtmlPage. '<th scope="col">Últimos registros</th>';
	$HtmlPage=$HtmlPage. '<th scope="col"></th>';
	$HtmlPage=$HtmlPage. '</thead><tbody>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Estado:</b></td><td>'.$ultimoRegistro->ESTADO.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Volumen:</b></td><td>'.$ultimoRegistro->VOLUMEN.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Caudal:</b></td><td>'.$ultimoRegistro->CAUDAL.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Última actualización:</b></td><td>'.$ultimoRegistro->DATETIME.'</td></tr>';
	$HtmlPage=$HtmlPage. '</tbody></table>';
	$HtmlPage=$HtmlPage.'	
	</div>		
</div>

<div class="row p-3" >';
	
	if(!empty($checklistDbEntity))
	{
	$HtmlPage=$HtmlPage. '<div class="col-md-auto p-3 card shadow overflow-auto" >';	
		$HtmlPage=$HtmlPage. '<div 
    style="background-image: url('."'".$checklistDbEntity->get_URL_foto()."'".'); 
    width:350px; 
    height:400px; 
    background-position:center; "></div>';
	//$HtmlPage=$HtmlPage. '<img src="'.$checklistDbEntity->get_URL_foto().'" class="rounded" alt="Responsive image">';
	$HtmlPage=$HtmlPage. '</div>';//col
	}
    $HtmlPage=$HtmlPage.'
	<div class="col p-3 ms-3 card shadow ">';

	$HtmlPage=$HtmlPage. '<table class="table" >
		  <thead >';
	$HtmlPage=$HtmlPage. '<th scope="col">Último checklist</th>';
	$HtmlPage=$HtmlPage. '<th scope="col"><a href="checklistform/checklistform.php?tag='.$unidadDbEntity->get_Tag().'">Nuevo checklist</a></th>';
	$HtmlPage=$HtmlPage. '</thead><tbody>';
	if(!empty($checklistDbEntity))
	{	
	$HtmlPage=$HtmlPage. '<tr><td><b>ID Checklist:</b></td><td>'.$checklistDbEntity->get_Id().'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Fecha:</b></td><td>'.$checklistDbEntity->get_Fecha().'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Técnico:</b></td><td>'.$checklistDbEntity->get_TecnicoResponsable().'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Observaciones:</b></td><td>'.$checklistDbEntity->get_Observaciones().'</td></tr>';
	$HtmlPage=$HtmlPage. "<tr><td><b>Revisar</b></td><td><a href='unidadverCheckList.php?CheckList_Id=".$checklistDbEntity->get_Id()."'>Ver</a></td></tr>";
	}
	else
	{
	$HtmlPage=$HtmlPage. '<tr><td>Esta unidad no tiene checklist.</td><td></td></tr>';
	}
	$HtmlPage=$HtmlPage. '</tbody></table>';
	$HtmlPage=$HtmlPage.'
	</div>
	</div>';

	if ($unidadDbEntity->get_Id_Unidadtipo() == '3')
	{	
		$HtmlPage=$HtmlPage. '<div class="row p-3">';
		$HtmlPage=$HtmlPage. '<div class="col p-3 card shadow">';
		$HtmlPage=$HtmlPage. '<table class="table" > <thead >';
		$HtmlPage=$HtmlPage. '<th scope="col">Control</th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '</thead><tbody>';
		$DisabledAbrir = "";
		$DisabledCerrar = "";

		if ($unidadDbEntity->get_Estado() == "1")
			{	
				$DisabledAbrir = "disabled";
			}
		else
			{
				$DisabledCerrar = "disabled";
			}

		$HtmlPage=$HtmlPage. '<tr><td><button type="button" onclick="FunctionComandosMilesight('."'Abrir V1'".')" class="btn btn-primary" '.$DisabledAbrir.' >Abrir</button></td>
		<td><button type="button" onclick="FunctionComandosMilesight('."'Cerrar V1'".')" class="btn btn-primary" '.$DisabledCerrar.'  >Cerrar</button></td>
		<td><button type="button" onclick="FunctionComandosMilesight('."'Reset Count'".')" class="btn btn-primary">Reiniciar Contador</button></td><tr>';
		$HtmlPage=$HtmlPage. '</tbody></table>';
		$HtmlPage=$HtmlPage. '</div>';
		$HtmlPage=$HtmlPage. '</div>';
	}

		if ($unidadDbEntity->get_Id_Unidadtipo() == '2')
	{	


		$HtmlPage=$HtmlPage. '<div class="row p-3">';
		$HtmlPage=$HtmlPage. '<div class="col p-3 card shadow">';
		$HtmlPage=$HtmlPage. '<h2>Enviar SMS</h2>';

		$HtmlPage=$HtmlPage. '<table class="table" > <thead >';
		$HtmlPage=$HtmlPage. '<th scope="col">Id</th>';
		$HtmlPage=$HtmlPage. '<th scope="col">SMS</th>';
		$HtmlPage=$HtmlPage. '<th scope="col">Recibido</th>';
		$HtmlPage=$HtmlPage. '<th scope="col">Fecha de envio</th>';
		$HtmlPage=$HtmlPage. '</thead><tbody>';
		
		$SMS = $Model->smstounidadesById_unidad($unidadDbEntity->id);

		foreach ($SMS as $s) {
		$HtmlPage=$HtmlPage. '<tr>  <td>'. $s->Id. "</td><td>" . $s->SMS ."</td> <td>" . $s->Recibido."</td> <td>" . $s->CreateTime ."</td></tr>";

		}


		$HtmlPage=$HtmlPage. '</tbody></table>';

		$HtmlPage=$HtmlPage. '<table class="table" > <thead >';
		$HtmlPage=$HtmlPage. '<th scope="col">SMS</th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '</thead><tbody>';
		$DisabledAbrir = "";
		$DisabledCerrar = "";


		$HtmlPage=$HtmlPage. '<tr><td class="align-middle" > Mensaje </td>
		<td  ><div class="input-group" >
  				<input type="text" class="form-control" placeholder="Escriba el SMS en mayusculas" >
  				<div class="input-group-append">
    				<button class="btn btn-outline-secondary" type="button">Enviar</button>
  				</div>
			</div>
		</td><tr>';
		$HtmlPage=$HtmlPage. '</tbody></table>';

		$HtmlPage=$HtmlPage. '<table class="table" > <thead >';
		$HtmlPage=$HtmlPage. '<th scope="col">Controles Basicos</th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '</thead><tbody>';
		$DisabledAbrir = "";
		$DisabledCerrar = "";

		if ($unidadDbEntity->get_Estado() == "ON")
			{	
				$DisabledAbrir = "disabled";
			}
		else
			{
				$DisabledCerrar = "disabled";
			}

		$HtmlPage=$HtmlPage. '<tr><td><button type="button" onclick="FunctionComandosMilesight('."'Abrir V1'".')" class="btn btn-primary" '.$DisabledAbrir.'  >ABRIR</button></td>
		<td><button type="button" onclick="FunctionComandosMilesight('."'Cerrar V1'".')" class="btn btn-primary" '.$DisabledCerrar.'  >CERRAR</button></td>
		<td><button type="button" onclick="FunctionComandosMilesight('."'Reset Count'".')" class="btn btn-primary">RESET</button></td><tr>';
		$HtmlPage=$HtmlPage. '</tbody></table>';
		$HtmlPage=$HtmlPage. '</div>';
		$HtmlPage=$HtmlPage. '</div>';
	}
	

$HtmlPage=$HtmlPage.'
<div class="row p-3">
	<div class="col p-3 card shadow">
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Registros diarios
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
		<div class="overflow-auto">';

// TABLA REGISTROS DIARIOS

	$HtmlPage=$HtmlPage. '<script>let table = new DataTable("#TablaRegistros");</script>';
	$HtmlPage=$HtmlPage. '<table id="TablaRegistros" class="display"><thead><tr><th scope="col">ESTADO</th><th scope="col">VOLUMEN</th><th scope="col">CAUDAL</th><th scope="col">SENAL</th><th scope="col">BAT</th><th scope="col">FECHA</th></tr></thead><tbody>';

$RegistrosDiarios = $Model->RegistrosDiariosById_unidad($unidadDbEntity->id);

foreach ($RegistrosDiarios as $registro) {
    // output data of each row

		$HtmlPage=$HtmlPage. '<tr>  <td>'. $registro->ESTADO. "</td><td>" . $registro->VOLUMEN ."</td> <td>" . $registro->CAUDAL."</td> <td>" . $registro->SENAL ." </td><td>" . $registro->VOLTAJE ."%</td><td>" . $registro->DATETIME ."</td></tr>";

}

	$HtmlPage=$HtmlPage. '</tbody></table>';
	$HtmlPage=$HtmlPage. "<script>
$(document).ready(function(){
    $('#TablaRegistros').dataTable();
});
</script>";

$HtmlPage=$HtmlPage.'
		  </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Registros de iniciación
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
		<div class="overflow-auto">

			<script>let table = new DataTable("#TablaIniciacion");</script>
			<table id="TablaIniciacion" class="display"><thead><th scope="col">unidad</th><th scope="col">USUARIO1</th><th scope="col">USUARIO2</th><th scope="col">ADMIN</th><th scope="col">INTERNET</th><th scope="col">Codigo</th><th scope="col">INV</th><th scope="col">VMAX</th><th scope="col">Bat</th><th scope="col">TIMESTAMP</th><th scope="col">TIPO</th><th scope="col">TipoBat</th></thead><tbody> 
			';
			
			// REGISTROS INICIACION
			$RegistrosIniciacion = $Model->RegistrosIniciacionByTag($unidadDbEntity->get_tag());

			foreach($RegistrosIniciacion  as $r) {
				$HtmlPage=$HtmlPage. "<tr>  <td>". $r->get_UNIDAD(). "</td> <td>". $r->get_USUARIO1(). "</td><td>" . $r->get_USUARIO2() ."</td> <td>" . $r->get_ADMIN() ."</td><td>" . $r->get_INTERNET() ."</td> <td>". $r->get_VerCodigo() ."</td> <td>". $r->get_INV() ."</td><td>" . $r->get_VOLUMEN_MAX() ."</td><td>" .$r->get_LVOLTAJE() ."</td><td>" . $r->get_TIMESTAMP() ."</td><td>" . $r->get_TIPO() ."</td><td>".$r->get_TipoBat()."</td></tr>" ;	
			}
			$HtmlPage=$HtmlPage.'
			</tbody></table>
			<script>
			$(document).ready(function(){
			$(\'#TablaIniciacion\').dataTable();
			});
			</script>
			
		  </div>
      </div>
    </div>
  </div>
   <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        Edición
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">';
		  
		$HtmlPage=$HtmlPage. '<div class="subContainer">';
		$HtmlPage=$HtmlPage. 'Introduzca la contraseña para editar: <input type="text" id="password" name="password" class="form-control">';
		$HtmlPage=$HtmlPage. '</div>';   // Input de contraseña.

		$HtmlPage=$HtmlPage. '<div class="subContainer">';
		$HtmlPage=$HtmlPage. '<button onclick="FunctionNuevaUbicacion('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-secondary">Editar</button> Nueva ubicación:';
		$HtmlPage=$HtmlPage. '<input type="text" id="NuevaUbicacion" name="NuevaUbicacion" class="form-control">';   // Input cambio de ubicación.
		$HtmlPage=$HtmlPage. '</div>';

		$HtmlPage=$HtmlPage. '<div class="subContainer">';
		$HtmlPage=$HtmlPage. '<button onclick="FunctionNuevoNumero('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-secondary">Editar</button> Nuevo número:';
		$HtmlPage=$HtmlPage. '<input type="text" id="NuevoNumero" name="NuevoNumero" class="form-control">';   // Input cambio de número.
		$HtmlPage=$HtmlPage. '</div>';

		$HtmlPage=$HtmlPage. '<div class="subContainer">';
		$HtmlPage=$HtmlPage. '<button onclick="FunctionCambiarVolMax('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-secondary">Editar</button> Nuevo volumen máximo:';
		$HtmlPage=$HtmlPage. '<input type="text" id="VolMax" name="VolMax" class="form-control">';   // Input cambio de volumen máximo.
		$HtmlPage=$HtmlPage. '</div>';
		
		$HtmlPage=$HtmlPage. '<div class="subContainer">';
		$HtmlPage=$HtmlPage. '<button onclick="FunctionNuevoTipo('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-secondary">Editar</button>';

		$q = $Model->executeSQL("SELECT `Nombre` FROM `unidadtipo`");
		$HtmlPage=$HtmlPage. ' <select name="NuevoTipo" id="NuevoTipo" required>';
		while($rows = $q->fetch_assoc())
		{
			$unidadTipo_name= $rows['Nombre'];
			$HtmlPage=$HtmlPage. "<option value='$unidadTipo_name'>$unidadTipo_name</option>";
		}
		$HtmlPage=$HtmlPage. "<option value='NULL'>Unidad Indefinida</option>";
		$HtmlPage=$HtmlPage. '</select>';
		$HtmlPage=$HtmlPage. '</div>';

		$HtmlPage=$HtmlPage. '<div class="subContainer">';
		$HtmlPage=$HtmlPage. '<button onclick="FunctionEliminar('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-danger">Eliminar</button> Eliminar unidad...';
		$HtmlPage=$HtmlPage. '</div>';   // Función para eliminar unidad.
		$HtmlPage=$HtmlPage.'
      </div>
    </div>
  </div>
      <div class="accordion-item">
    <h2 class="accordion-header" id="headingFour">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        Checklist
      </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
      <div class="accordion-body">
    <div class="overflow-auto">';   
		  
 	$sql = "SELECT * FROM `checklist` WHERE `id_unidad` like '{$unidadDbEntity->get_id()}'";
	$result = $Model->executeSQL($sql);
	if ($result->num_rows > 0) {
    // output data of each row
	$HtmlPage=$HtmlPage. '<script>let table = new DataTable("#TablaChecklist");</script>';
	$HtmlPage=$HtmlPage. '<table id="TablaChecklist" class="display""><thead>
	<th scope="col">ID</th>
	<th scope="col">Técnico Responsable</th>
	<th scope="col">Fecha</th>
	<th scope="col"></th>
	
	</thead><tbody>';
    while($row = $result->fetch_assoc()) {
           $HtmlPage=$HtmlPage. "</td> <td>". $row["Id"]. "</td><td>" . $row["TecnicoResponsable"] ."</td> <td>". $row["Fecha"]."</td> <td><a href='unidadverCheckList.php?CheckList_Id=". $row["Id"]."'>Ver</a></td></tr>" ;}
$HtmlPage=$HtmlPage. '</tbody></table>';
$HtmlPage=$HtmlPage. "<script>
$(document).ready(function(){
    $('#TablaChecklist').dataTable();
});
</script>";
} else {
    $HtmlPage=$HtmlPage. "Unidad sin checklist.";
}
	$HtmlPage=$HtmlPage.'
	</div>
      </div>
    </div>
  </div>
</div>
	</div>
	</div>
		</div>
</body>
</html>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

?>