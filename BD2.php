<?php

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

 $sql = "SELECT * FROM `unidad` ORDER BY `UltimaActualizacion` DESC";

$result = $conn->query($sql);

date_default_timezone_set('America/Santiago');

$FechaActual= date_create(date("Y-m-d H:i:s")); 

if ($result->num_rows > 0) {
    
	echo '<table class="table table-dark table-striped table-hover"><thead><th scope="col">unidad</th><th scope="col">UltimaActz</th><th scope="col">Estado</th><th scope="col">Volumen</th></thead><tbody>';// Header tabla
	
    // output data of each row $row["UltimaActualizacion"]
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
			else {$UltimaActROW=$UltimaAct->format("%h horas");}
		}
		else {$UltimaActROW=$UltimaAct->format("%a Dias");}
		
		//print row
        echo "<tr>  <td>". $row["tag"].// TAG
		// DIFERENCIA FECHA
		"</td> <td>" .$UltimaActROW.
		//ESTADO
		"</td> <td>". $row["Estado"].
		//VOLUMEN
		"</td> <td>". $row["Volumen"].
		"</td> <td>";
	}
	echo '</tbody></table>';
} 
else 
{
    echo "0 results";
}


$conn->close();
?>