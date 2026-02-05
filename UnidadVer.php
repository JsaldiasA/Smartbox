<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();
$dat= $_GET['tag'];
$unidadDbEntity = $Model->unidadByTag($dat);
$checklistDbEntity= $Model->UltimochecklistById_unidad($unidadDbEntity->get_id());

$HtmlPage='<script>var id_unidad ='.$unidadDbEntity->get_id().';</script>';
$HtmlPage=$HtmlPage.'<script>var tag_unidad ='.$unidadDbEntity->get_tag().';</script>';
$HtmlPage=$HtmlPage.'<script src="/views/scripts/UnidadVer.js"></script>';

$HtmlPage=$HtmlPage.'<body>	
	
<div class="container p-3" >
<div class="row p-3" >
	<div class="col p-3 card shadow" >
	';
	
	$CabeceraName = $unidadDbEntity->get_Serie();
	 
	$HtmlPage=$HtmlPage. "<h1>&nbsp;<b>Unidad</b> ".(($CabeceraName == "") ? $unidadDbEntity->get_Tag()."(sin nombre)</h1>" : $CabeceraName ."</h1>");
			
	$tagTitle=(( ($unidadDbEntity->get_Id_Unidadtipo() == '4') or ($unidadDbEntity->get_Id_Unidadtipo() == '3') )? 'DeviceEUI' : 'IMEI' );

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
</div>'; // row & col end

		
			
	$HtmlPage=$HtmlPage.'	
<div class="row" >';
	
	if(!empty($checklistDbEntity))
	{
	$HtmlPage=$HtmlPage. '<div class="col-3 m-3 p-3 card shadow " style=" min-width: 320px;">';	
		$HtmlPage=$HtmlPage. '<img class="img-thumbnail" src='."'".$checklistDbEntity->URL_foto."'".' ">';
	$HtmlPage=$HtmlPage. '</div>';//col
	}
    $HtmlPage=$HtmlPage.'
	<div class="col p-3 m-3 card shadow ">';
	/*		$HtmlPage=$HtmlPage. '<table class="table">
			<thead >
			<th scope="col">Parámetros</th>
			<th scope="col">Valor</th>	
			</thead><tbody>';// Header tabla
			//print row
			$HtmlPage=$HtmlPage. "<tr>  
			<td>". "<b>Volumen máximo:</b>".
			"</td> <td>". $unidadDbEntity->get_VolMax().
			" (L)</td></tr>";
			$HtmlPage=$HtmlPage. '</tbody></table>';*/// configuraciopn cuadro 

		$RegistrosDiarios = [];
		$RegistrosDiarios = $Model->get_UltimoRegistroDiarioDeCadaUnidad();

		foreach ($RegistrosDiarios as $r)
		{
			if($r->unidad_id == $unidadDbEntity->Id )
				{
					$ultimoRegistro = $r;
					break;
				}
		}	

			$HtmlPage=$HtmlPage. '<table class="table" >
		  <tbody>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Estado:</b></td><td>'.$ultimoRegistro->ESTADO.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Volumen:</b></td><td>'.$ultimoRegistro->VOLUMEN.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Caudal:</b></td><td>'.$ultimoRegistro->CAUDAL.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Última actualización:</b></td><td>'.$ultimoRegistro->DATETIME.'</td></tr>';
	$HtmlPage=$HtmlPage. '</tbody></table>';

	$HtmlPage=$HtmlPage. '<table class="table" >
		  <thead >';
	$HtmlPage=$HtmlPage. '<th scope="col">Último checklist</th>';
	$HtmlPage=$HtmlPage. '<th scope="col"><a href="checklistform/checklistform.php?tag='.$unidadDbEntity->get_Tag().'">Nuevo checklist</a></th>';
	$HtmlPage=$HtmlPage. '</thead><tbody>';
	if(!empty($checklistDbEntity))
	{	
	$HtmlPage=$HtmlPage. '<tr><td><b>Fecha:</b></td><td>'.$checklistDbEntity->Fecha.'</td></tr>';
	$HtmlPage=$HtmlPage. '<tr><td><b>Observaciones:</b></td><td>'.$checklistDbEntity->Observaciones.'</td></tr>';
	$HtmlPage=$HtmlPage. "<tr><td><b>Revisar</b></td><td><a href='unidadverCheckList.php?CheckList_Id=".$checklistDbEntity->Id."'>Ver</a></td></tr>";
	}
	else
	{
	$HtmlPage=$HtmlPage. '<tr><td>Esta unidad no tiene checklist.</td><td></td></tr>';
	}
	$HtmlPage=$HtmlPage. '</tbody></table>';


	$HtmlPage=$HtmlPage.'			
	</div>
	</div>'; // row & col end	



	

$HtmlPage=$HtmlPage.'
<div class="row p-3">
<div class="col p-3 card shadow">';

$HtmlPage=$HtmlPage.'<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingZero">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="false" aria-controls="collapseZero">
        Control
      </button>
    </h2>
    <div id="collapseZero" class="accordion-collapse collapse" aria-labelledby="headingZero" data-bs-parent="#accordionExample">
      <div class="accordion-body">
		<div class="overflow-auto">';

	if ($unidadDbEntity->get_Id_Unidadtipo() == '3')
	{	
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
	}

		if ($unidadDbEntity->get_Id_Unidadtipo() == '2')
	{	


		$HtmlPage=$HtmlPage.'<div class="overflow-auto">';
		$HtmlPage=$HtmlPage.'<div id="SMSTable" ></div>'; // sms table from post javascript 
		$HtmlPage=$HtmlPage. '</div>';

		$HtmlPage=$HtmlPage. '<table class="table" > <thead >';
		$HtmlPage=$HtmlPage. '<th scope="col">SMS</th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '</thead><tbody>';
	 
		$HtmlPage=$HtmlPage. '<tr><td class="align-middle" > Mensaje </td>
		<td  ><div class="input-group" >
  				<input type="text" class="form-control" placeholder="Escriba el SMS en mayusculas" id="InputSMS" >
  				<div class="input-group-append">
    				<button class="btn btn-outline-secondary" type="button" onclick="FunctionCreateSMS(\'InputSMS\')" >Enviar</button>
  				</div>
			</div>
		</td><tr>';
		$HtmlPage=$HtmlPage. '</tbody></table>';

		$HtmlPage=$HtmlPage. '<table class="table" > <thead >';
		$HtmlPage=$HtmlPage. '<th scope="col">Controles Basicos</th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '<th scope="col"></th>';
		$HtmlPage=$HtmlPage. '</thead><tbody>';

		$HtmlPage=$HtmlPage. '<tr><td><button type="button" onclick="FunctionCreateSMS('."'ABRIR'".')" class="btn btn-primary" >ABRIR</button></td>
			<td><button type="button" onclick="FunctionCreateSMS('."'CERRAR'".')" class="btn btn-primary" >CERRAR</button></td>
			<td><button type="button" onclick="FunctionCreateSMS('."'RESET'".')" class="btn btn-primary" >RESET</button></td><tr>
			<td><button type="button" onclick="FunctionCreateSMS('."'INTERNET30'".')" class="btn btn-primary" >Modo Riego</button></td><tr>';
		$HtmlPage=$HtmlPage. '</tbody></table>';
	}
$HtmlPage=$HtmlPage.'		  </div>
      </div>
    </div>
  </div>';

$HtmlPage=$HtmlPage.'<div class="accordion" id="accordionExample">
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

$RegistrosDiarios = $Model->RegistrosDiariosById_unidad($unidadDbEntity->Id);

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
  </div>';
  $HtmlPage=$HtmlPage.'
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