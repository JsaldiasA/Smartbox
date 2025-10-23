<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta tags -->
	<title>Eco3</title>
	<link rel="shortcut icon" href="favicon/favicon.jpg"/> 
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<!-- stylesheets  -->
	<!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
	<link rel="stylesheet" href="css/easy-responsive-tabs.css">
	<link rel="stylesheet" href="css/font-awesome.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	
	<!-- scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<!--<script src="js/bootstrap.min.js"></script>-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="js/easyResponsiveTabs.js"></script>
	<script src="js/numscroller-1.0.js"></script>
	<div class="left"></div>
	<!-- google fonts -->
	<link rel="stylesheet" href="css/fonts.googleapis.OpenSans.css">
	<link rel="stylesheet" href="css/fonts.googleapis.Raleway.css">

</head>
<body>

 <style>

.container {
	padding:0px 0px 20px 0px;
	width: 100%;
}
	 
.subContainer {
	padding:0px 0px 20px 0px;
	width: 100%;
}	 
	
	 
.topnav {
  overflow: hidden;
  background-color: #17202A ;
  vertical-align: middle;
}

.topnav a {
  float: left;
  display: block;
  text-align: center;
  padding: 14px 16px;
  font-size: 17px;
  color:#ABB2B9  ;
  text-shadow: 2px 2px 4px #000000;
  margin-top: 10px;
}

.topnav a:hover {;
  color: white;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: left;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
	clear: right;
	
  }
	 }
	 .topnav-right {
  float: right;
}
</style>
<div class="topnav" id="myTopnav">
  <a style="display: flex;justify-content: center;padding: 10px 10px;margin-top: 0px;">
  <div><img src="images/Logocortado.png"  style="margin-left: 0px;width:55px;height:auto;"></div>
  <div><img src="images/Logo letra.png"  style="margin-left: -5px;margin-right: 15px;margin-top: 5px;width:60px;height:auto;"></div></a>
  <div id="RmyTopnav" class="topnav-right">
  <a  href="index.php" class="active">Home</a>
  <a  href="OldVersion.php" class="active">OldVersion</a> 	
   <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
  </div>  
  </div>
  </div>


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
$password = "Helegta1!";
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



</body>
</html>
