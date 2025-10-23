<?php

require_once 'BatteryLevel.php';

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$unidadTipo_Nombre= $_GET['unidadtipo'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Id FROM unidadtipo WHERE Nombre LIKE '$unidadTipo_Nombre'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {$unidad_id = $row["Id"];}
}

$sql = "SELECT * FROM `unidad` WHERE `id_unidadTipo` = $unidad_id ORDER BY `UltimaActualizacion` DESC";
$result = $conn->query($sql);

date_default_timezone_set('America/Santiago');

$FechaActual= date_create(date("Y-m-d H:i:s"));

if ($unidadTipo_Nombre == 'Estanque7600')
{
    $isEstanque = true;
}
else
{
    $isEstanque = false;
}

if ($result->num_rows > 0) {
    
	echo '<table class="table">
		<thead>
		<th scope="col">Nombre</th>
		<th scope="col">IMEI</th>
		<th scope="col">Ubicación</th>
		<th scope="col">Número</th>
		<th scope="col">ÚltimaActz</th>
		<th scope="col">Estado</th>
		<th scope="col">Batería</th>';

    if ($isEstanque == false)
    {
        echo '<th scope="col">Volumen</th>';
    }
    
    echo '<th scope="col"></th>
		</thead>
		<tbody>';
        // Header tabla
	
    // output data of each row 
	while($row = $result->fetch_assoc()) 
	{	
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
		
		$level = $row["BatNivel"];
	    $BatNivel = new BatteryLevel($level);
		
		//print row
        echo "<tr> 
        <td>".$row["Nombre"]."</td>
        <td>".$row["tag"]."</td>
        <td>".$row["Ubicacion"]."</td>
        <td>".$row["numero"]."</td>
        <td>".$UltimaActROW."</td>
        <td>".$row["Estado"]."</td>
        <td>".$BatNivel->get_HtmlTableField()."</td>";

    if ($isEstanque == false)
    {
        echo
		"<td>".$row["Volumen"]."</td>";
    }
        echo
		"<td> <a href='unidadver.php?tag=".$row["tag"]."'>Ver</a></td></tr>";
	}
	echo '</tbody></table>';
} 
else 
{
    echo "0 results";
}

$conn->close();
?>