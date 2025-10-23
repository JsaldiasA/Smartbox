<?php
require_once 'BatteryLevel.php';

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$dat= $_POST['name'];
$limit= $_POST['limit'];
//echo $dat;
//$dat= "ACK10";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

 $sql = "SELECT * FROM `unidad` WHERE `id_unidadTipo` IS NULL ORDER BY `UltimaActualizacion` DESC";

$result = $conn->query($sql);

date_default_timezone_set('America/Santiago');

$FechaActual= date_create(date("Y-m-d H:i:s")); 

if ($result->num_rows > 0) {
    
	echo '<table class="table">
		<thead>
		<th scope="col">Nombre</th>
		<th scope="col">IMEI</th>
		<th scope="col">Número</th>
		<th scope="col">ÚltimaActz</th>
		<th scope="col">Estado</th>
		<th scope="col">Batería</th>
		<th scope="col">Volumen</th>
		<th scope="col"></th>
		</thead>
		<tbody>';// Header tabla
	
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
		
		// Calculando Nivel de bateria
		
		$level = $row["BatNivel"];
	    $BatNivel = new BatteryLevel($level);
		
		//print row
        echo "<tr> 
		<td>". $row["Nombre"].
		"</td> <td>". $row["tag"].
		"</td> <td>". $row["numero"].	
		"</td> <td>" .$UltimaActROW.		
		"</td> <td>". $row["Estado"].
	 	"</td> <td>". $BatNivel->get_HtmlTableField() .
		"</td> <td>". $row["Volumen"].
		"</td> <td> <a href='unidadver.php?tag=". $row["tag"]."' >Ver</a> </td>
		 
		</tr>";//end row
	}
	echo '</tbody></table>';
} 
else 
{
    echo "0 results";
}


$conn->close();
?>