<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
require_once 'views/navbar.php';	
	
$dat= $_GET['tag'];
$limit= 100;
require_once 'Model/model.php';	
	
$Model = new Model();	
$unidadDbEntity = $Model->unidadByTag($dat);
$checklistDbEntity= $Model->UltimochecklistById_unidad($unidadDbEntity->get_id());

?>	
<!-- SCRIPTS PARA editar panel -->
<script>
function FunctionNuevoNumero(  unidad ) {
  let text = "Estas seguro de cambiar el Numero de la unidad";
  if (confirm(text) == true) { 
	 
	var URL = "UnidadCambiarNumero.php"; 
	var Respuesta;
	var NuevoNumero =  document.getElementById("NuevoNumero").value;
	var token = document.getElementById("password").value ;
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoNumero: NuevoNumero,
			token: token,
        	},
		    success: function(result){alert(result)}    
		  });		 
	  
  } else {
    alert("Has cancelado");
  }
}

function FunctionNuevoNombre(  unidad ) {
  let text = "Estas seguro de cambiar el nombre de la unidad";
  if (confirm(text) == true) { 
	 
	var URL = "UnidadCambiarNombre.php"; 
	var Respuesta;
	var NuevoNombre =  document.getElementById("NuevoNombre").value;
	var token = document.getElementById("password").value ;
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoNombre: NuevoNombre,
			token: token,
        	},
		    success: function(result){alert(result)}    
		  });		 
	  
  } else {
    alert("Has cancelado");
  }
}
	
function FunctionNuevoTipo(  unidad ) {
  let text = "Estas seguro de cambiar el Tipo de la unidad";
  if (confirm(text) == true) { 
	 
	var URL = "UnidadCambiarTipo.php"; 
	var Respuesta;
	  
	var e = document.getElementById("NuevoTipo");
	var value = e.value;
	var NuevoTipo = e.options[e.selectedIndex].text;  
	  
	var token = document.getElementById("password").value ;
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			  data: {
            tag: unidad,
			NuevoTipo: NuevoTipo,
			token: token,
        	},
		    success: function(result){alert(result)}    
		  });		 
	  
  } else {
    alert("Has cancelado");
  }
}	
	
function FunctionEliminar(  unidad ) {
  let text = "Estas seguro de elimina la unidad";
  if (confirm(text) == true) { 
	 
	var URL = "UnidadEliminar.php"; 
	var Respuesta;
	var token = document.getElementById("password").value ;
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			  data: {
            tag: unidad,
			token: token,
        	},
		    success: function(result){alert(result)}    
		  });		 
	  
  } else {
    alert("Has cancelado");
  }

}
	
function FunctionComandosMilesight( ComandoNombre ) {
  let text = "Estas seguro de accionar la unidad";
  if (confirm(text) == true) { 
	 
	var URL = "ApiController/Postcomandos_milesight.php"; 
	var Respuesta;
	var token = document.getElementById("password").value ;
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			data: {
            tag: '<?php echo $unidadDbEntity->get_Tag(); ?>',
			nombre: ComandoNombre,
			token: token,
        	},
		    success: function(result){alert(result)}    
		  });		 
	  
  } else {
    alert("Has cancelado");
  }

}	
</script>	

<body>	
	
<?php


	//IMPRIMIMOS  cabecera de informacion con los datos de la unidad desde la tabla unidad
?> 
<div class="container" >
<div class="row" >
	<div class="col" >
	<?php
	$CabeceraName = $unidadDbEntity->get_Nombre();
	 
		if($CabeceraName == "")
		{
			echo "<br><h1>&nbsp;<b>Unidad</b> ". $unidadDbEntity->get_Tag()."(sin nombre)</h1>";
		}
		else
		{
			echo "<br><h1>&nbsp;<b>Unidad</b> ". $CabeceraName ."</h1>";
		}
			
		$tagTitle='IMEI';
		// si es milesigh el titulo del tag es DEviceEUI si no es el IMEI
		if( ($unidadDbEntity->get_Id_Unidadtipo() == '4') or ($unidadDbEntity->get_Id_Unidadtipo() == '3') )
		{
			$tagTitle='DeviceEUI';
		}
		?>
		<?php
		echo '<table class="table">
		 	  <thead >
		  	  	<th scope="col">Nombre</th>
		  		<th scope="col">'.$tagTitle.'</th>
		  	  </thead><tbody>';// Header tabla
		//print row
        echo "<tr> <td>". $unidadDbEntity->get_Nombre().
		"</td><td>". $unidadDbEntity->get_Tag().
		"</td> </tr>";
		echo '</tbody></table>';

		//solo para sensor humedad milesight
		if($unidadDbEntity->get_Id_Unidadtipo() == '4')
		{
			echo '<table class="table">
			<thead >
			<th scope="col">Sensor</th>
			<th scope="col">Data</th>	
			</thead><tbody>';// Header tabla
			//print row
			echo "<tr>  
			<td>". "<b>Temperatura</b>".
			"</td> <td>". $unidadDbEntity->get_Estado().
			" °C</td></tr>";
			echo "<tr>  
			<td>". "<b>Humedad</b>".
			"</td> <td>". $unidadDbEntity->get_Volumen().
			"</td></tr>";
			echo "<tr>  
			<td>". "<b>Conductividad Electrica(EC)</b>".
			"</td> <td>0". $unidadDbEntity->get_Volumen().// to do EC
			"</td></tr>";
			echo '</tbody></table>';
		}
	?>	
</div>
	</div>

<div class="row" >
	<?php
  
	if(!empty($checklistDbEntity))
	{
	echo '<div class="col-md-auto overflow-auto" >';	
		echo '<div 
    style="background-image: url('."'".$checklistDbEntity->get_URL_foto()."'".'); 
    width:350px; 
    height:400px; 
    background-position:center; "></div>';
	//echo '<img src="'.$checklistDbEntity->get_URL_foto().'" class="rounded" alt="Responsive image">';
	echo '</div>';//col
	}
// CHECKLIST table
	?>
	<div class="col">
	<?php
	echo '<table class="table" >
		  <thead >';
	echo '<th scope="col">Ultimo Checklist</th>';
	echo '<th scope="col"></th>';
	echo '</thead><tbody>';
	echo '<tr><td> <a href="checklistform/checklistform.php?tag='.$unidadDbEntity->get_Tag().'">Nuevo Check List</a></td><td></td></tr>';
	if(!empty($checklistDbEntity))
	{	
	echo '<tr><td><b>id_checklist</b></td><td>'.$checklistDbEntity->get_Id().'</td></tr>';
	echo '<tr><td><b>Fecha</b></td><td>'.$checklistDbEntity->get_Fecha().'</td></tr>';
	echo '<tr><td><b>Tecnico</b></td><td>'.$checklistDbEntity->get_TecnicoResponsable().'</td></tr>';
	echo '<tr><td><b>Observaciones</b></td><td>'.$checklistDbEntity->get_Observaciones().'</td></tr>';
	echo "<tr><td><b>Revisar</b></td><td><a href='unidadverCheckList.php?CheckList_Id=".$checklistDbEntity->get_Id()."'>Ver</a></td></tr>";
	}
	else
	{
	echo '<tr><td>Esta unidad no tiene checklist</td><td></td></tr>';
	}
			echo '</tbody></table>';
?>
	</div>
	</div>
	<?php
	if ($unidadDbEntity->get_Id_Unidadtipo() == '3')
	{	
		
		
		echo 	'<div class="row">';
		echo 	'<div class="col">';
		echo '<table class="table" > <thead >';
		echo '<th scope="col">Control</th>';
		echo '<th scope="col"></th>';
		echo '<th scope="col"></th>';
		echo '</thead><tbody>';
		$DisabledAbrir = "";
		$DisabledCerrar = "";
		if($unidadDbEntity->get_Estado() == "1"){	$DisabledAbrir = "disabled";}else{$DisabledCerrar = "disabled";}	
		echo '<tr><td><button type="button" onclick="FunctionComandosMilesight('."'Abrir V1'".')" class="btn btn-primary" '.$DisabledAbrir.' >Abrir</button></td>
		<td><button type="button" onclick="FunctionComandosMilesight('."'Cerrar V1'".')" class="btn btn-primary" '.$DisabledCerrar.'  >Cerrar</button></td>
		<td><button type="button" onclick="FunctionComandosMilesight('."'Reset Count'".')" class="btn btn-primary">Reiniciar Contador</button></td><tr>';

		echo '</tbody></table>';
		echo '</div>';
		echo '</div>';		
	}
	
	?>



<div class="row">
	<div class="col">
<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        Editar
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
		  
	<?php
	// PANEL EDITAR
	echo '<div class="subContainer" >';
	echo '<button onclick="FunctionEliminar('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-primary">Eliminar</button>';// boton eliminar
	echo '</div>';
	
	echo '<div class="subContainer" >';
	echo '<button onclick="FunctionNuevoNombre('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-primary">Cambiar</button>Nuevo Nombre';// boton cambio de nombre
	echo '<input type="text" id="NuevoNombre" name="NuevoNombre" class="form-control"> ';// input cambio de nombre
	echo ' </div> ';
	
	echo '<div class="subContainer" >';
	echo '<button onclick="FunctionNuevoNumero('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-primary">Cambiar</button> Nuevo Numero';// boton cambio de nombre
	echo '<input type="text" id="NuevoNumero" name="NuevoNumero" class="form-control"> ';// input cambio de nombre
	echo ' </div> ';
	
	echo '<div class="subContainer" >';
	echo '<button onclick="FunctionNuevoTipo('."'".$unidadDbEntity->get_Tag()."'".')" class="btn btn-primary">Cambiar</button>';// boton cambio de unidad tipo
	
    $q = $Model->executeSQL("SELECT `Nombre` FROM `unidadtipo`");
    echo  '<select name="NuevoTipo" id="NuevoTipo" required>';
    while($rows = $q->fetch_assoc()){
              $unidadTipo_name= $rows['Nombre'];
              echo "<option value='$unidadTipo_name'>$unidadTipo_name</option>";
            }
	echo "<option value='NULL'>Unidad Indefinida</option>";
    echo'</select>';// select TAG con unidad tipo
	
	echo ' </div> ';
	
	
	echo '<div class="subContainer" >';
	echo 'Password <input type="text" id="password" name="password"  class="form-control" > '; // password para accionar
	echo ' </div> ';
	
	//echo ' </div> ';
	?>
	
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Registros diarios
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
		  
		<div class="overflow-auto">
        <?php	
// TABLA REGISTROS DARIARIOS	
	
	$sql = "SELECT `UL`.`id`,`U`.`tag`,`UL`.`ESTADO`,`UL`.`VOLUMEN`,`UL`.`CAUDAL`,`UL`.`SENAL`,`UL`.`VOLTAJE`,`UL`.`DATETIME` FROM 		`unidades_lastortolas` `UL` INNER JOIN `unidad` `U` ON `U`.`ID` = `UL`.`unidad_id`  WHERE `U`.`tag` LIKE '%{$unidadDbEntity->get_Tag()}%' ORDER BY `UL`.`id` DESC LIMIT 1000";

$result = $Model->executeSQL($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo '<script>let table = new DataTable("#TablaRegistros");</script>';
	echo '<table id="TablaRegistros" class="display"><thead><tr><th scope="col">UNIDAD</th><th scope="col">ESTADO</th><th scope="col">VOLUMEN</th><th scope="col">CAUDAL</th><th scope="col">SENAL</th><th scope="col">BAT</th><th scope="col">FECHA</th></tr></thead><tbody>';
    while($row = $result->fetch_assoc()) 
	{
		echo '<tr">  <td>'. $row["tag"]. "</td> <td>". $row["ESTADO"]. "</td><td>" . $row["VOLUMEN"] ."</td> <td>" . $row["CAUDAL"]."</td> 			<td>" . $row["SENAL"] ." </td><td>" . $row["VOLTAJE"] ."%</td><td>" . $row["DATETIME"] ."</td></tr>";
	}
		
	echo '</tbody></table>';
	echo "<script>
$(document).ready(function(){
    $('#TablaRegistros').dataTable();
});
</script>";
}
else
{echo "0x results";}

?>
		  </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Registros de iniciación
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
	  <div class="overflow-auto">
       <?php
// REGISTROS INICIACION
		  
 $sql = "SELECT LEFT(`unidad`,15) AS `UNIDAD`,
 LEFT(`USUARIO1`,10) AS `USUARIO1`,
 LEFT(`USUARIO2`,10) AS `USUARIO2`,
 LEFT(`ADMIN`,10) AS `ADMIN` ,
 LEFT(`INTERNET`,5) AS `INTERNET`,
 LEFT(`VerCodigo`,10) AS `VerCodigo`,
 LEFT(`INV`,5) AS `INV`,
 LEFT(`VOLUMEN MAX`,5) AS `VOLUMEN MAX`,
 LEFT(`TIPO`,4) AS `TIPO`,
 LEFT(`LVOLTAJE`,2) AS `LVOLTAJE`,
 `TIMESTAMP` FROM `eventos` WHERE `UNIDAD` LIKE '{$dat}'  ORDER BY `TIMESTAMP` DESC";
$result = $Model->executeSQL($sql);
if ($result->num_rows > 0) {
    // output data of each row
		echo '<script>let table = new DataTable("#TablaIniciacion");</script>';
	echo '<table id="TablaIniciacion" class="display"><thead><th scope="col">unidad</th><th scope="col">USUARIO1</th><th scope="col">USUARIO2</th><th scope="col">ADMIN</th><th scope="col">INTERNET</th><th scope="col">Codigo</th><th scope="col">INV</th><th scope="col">VMAX</th><th scope="col">Bat</th><th scope="col">TIMESTAMP</th><th scope="col">TIPO</th></thead><tbody>';
    while($row = $result->fetch_assoc()) {
           echo "<tr>  <td>". $row["UNIDAD"]. "</td> <td>". $row["USUARIO1"]. "</td><td>" . $row["USUARIO2"] ."</td> <td>" . $row["ADMIN"] ."</td><td>" . $row["INTERNET"] ."</td> <td>". $row["VerCodigo"] ."</td> <td>". $row["INV"] ."</td><td>" . $row["VOLUMEN MAX"] ."</td><td>" .$row["LVOLTAJE"] ."</td><td>" . $row["TIMESTAMP"] ."</td><td>" . $row["TIPO"] ."</td></tr>" ;}
echo '</tbody></table>';
echo "<script>
$(document).ready(function(){
    $('#TablaIniciacion').dataTable();
});
</script>";
} else {
    echo "0 results";
}
		  ?>
		  </div>
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
    <div class="overflow-auto">   
	<?php
		  
 $sql = "SELECT * FROM `checklist` WHERE `id_unidad` like '{$unidadDbEntity->get_id()}'";
$result = $Model->executeSQL($sql);
if ($result->num_rows > 0) {
    // output data of each row
	echo '<script>let table = new DataTable("#TablaChecklist");</script>';
	echo '<table id="TablaChecklist" class="display""><thead>
	<th scope="col">Id</th>
	<th scope="col">TecnicoResponsable</th>
	<th scope="col">Fecha</th>
	<th scope="col"></th>
	
	</thead><tbody>';
    while($row = $result->fetch_assoc()) {
           echo "</td> <td>". $row["Id"]. "</td><td>" . $row["TecnicoResponsable"] ."</td> <td>". $row["Fecha"]."</td> <td><a href='unidadverCheckList.php?CheckList_Id=". $row["Id"]."'>Ver</a></td></tr>" ;}
echo '</tbody></table>';
echo "<script>
$(document).ready(function(){
    $('#TablaChecklist').dataTable();
});
</script>";
} else {
    echo "unidad sin checklist";
}
		  ?>
	</div>
      </div>
    </div>
  </div>
</div>
	</div>
	</div>
		</div>




</body>
</html>
