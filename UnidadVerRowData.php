<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

?>

<script>
function myFunction() {
  var x = document.getElementById("RmyTopnav");
  if (x.className === "topnav-right") {
    x.className = "topnav";
  } else {
    x.className = "topnav-right";
  }
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

	<!-- //Navigation -->
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
</script>	

	
	
<?php
date_default_timezone_set('America/Santiago');
$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "7bp0c@81X";
$dbname = "sirecor";

$dat= $_GET['tag'];
$limit= 100;
//$c=$_POST['uni'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//GETTING DATA FROM THE UNIT	
 $sql = "SELECT * FROM `unidad` WHERE `tag`= '{$dat}'";

$result = $conn->query($sql);

date_default_timezone_set('America/Santiago');

$FechaActual= date_create(date("Y-m-d H:i:s")); 

if ($result->num_rows > 0) {
    
//IMPRIMIMOS  cabecera de informacion con los datos de la unidad desde la tabla unidad
	echo '<div class="container" style="padding:50px 50px 50px 50px;width: 100%;">';// container cabecera de informacion	
	
	while($row = $result->fetch_assoc()) 
	{
		echo '<div class="container" style="padding:0px 0px 0px 0px;width: 100%;">'; //container nombre
		$CabeceraName = $row["Nombre"];
		$tag = $row["tag"];
		if($CabeceraName == "")
		{
			echo "<h1><b>Unidad</b> ". $row["tag"]."(sin nombre)</h1>";
		}
		else
		{
			echo "<h1><b>Unidad</b> ". $row["Nombre"]."</h1>";
		}
		echo '</div>';
	
// IMPRIMIMOS TABLA CON LOS DATOS DE LA UNIDAD.
	echo '<table class="table">
		  <thead >
		  <th scope="col">Nombre</th>
		  <th scope="col">unidad</th>
		  <th scope="col">UltimaActz</th>	
		  </thead><tbody>';// Header tabla
		
		//CALCULADO DIFF FECHA CON ACTUAL
		
		$FechaSQLrow= date_create($row["UltimaActualizacion"]);
		$UltimaAct= date_diff($FechaActual,$FechaSQLrow);
		if ($UltimaAct->format("%a")=="0")
		{	
			if ($UltimaAct->format("%h")=="0")
			{
				$UltimaActROW=$UltimaAct->format("%i Min");
			}
			else {$UltimaActROW=$UltimaAct->format("%h Horas");}
		}
		else {$UltimaActROW=$UltimaAct->format("%a Dias");}
		
		
		//print row
        echo "<tr>  
		<td>". $row["Nombre"].
		"</td> <td>". $row["tag"].
		"</td> <td>" .$UltimaActROW.
		"</td></tr>";
		echo '</tbody></table>';
		echo '</div>';
	}
	
	
} 
else 
{
    echo "0 results";
}
	
	
echo '<div class="container" style="padding:0px 50px 0px 50px;width: 100%;">';// container  acordion	
?>


        <?php
	
// TABLA REGISTROS DARIARIOS	
	
	$sql = "SELECT *  FROM `rowdata`  ORDER BY `id` DESC LIMIT 10";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo '<table id="TablaRegistros" class="table table-striped table-hover">
	<thead>
	<th scope="col">Id</th>
	<th scope="col">DateTime</th>
	<th scope="col">RowData</th>
	<th scope="col">IP</th>
	</thead>
	<tbody>';
    while($row = $result->fetch_assoc()) 
	{
		echo '<tr"><td>'. $row["Id"] ." </td><td>" . $row["DateTime"] ."</td><td>" . $row["RowData"] ."</td><td>" . $row["IP"] ."</td>
		</tr>";
	}
		
	echo '</tbody></table>';
}
else
{
    echo "0x results";
}

?>



		  		  <script>
$(document).ready(function () {
    $('#TablaRegistros').DataTable();
});
</script>
	
<?php
// close sql connection
$conn->close();
?>

</html>
