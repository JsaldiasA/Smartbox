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

 $sql = "SELECT `u`.`Nombre`,`u`.`tag`,`u`.`numero`,`u`.`UltimaActualizacion`,`u`.`id_unidadTipo` FROM `unidad` `u` INNER JOIN `unidadterreno` `ut` on `u`.`id` = `ut`.`unidad_id` WHERE `ut`.`EnBodega`= 1";

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
		
		//print row
        echo "<tr> 
		<td>". $row["Nombre"].
		"</td> <td>". $row["tag"].
		"</td> <td>". $row["numero"].	
		"</td> <td>" .$UltimaActROW.		
		"</td> <td> <a href='unidadver.php?tag=". $row["tag"]."'>Ver</a></td>
		 
		 </tr>";
	}
	echo '</tbody></table>';
} 
else 
{
    echo "0 results";
}


$conn->close();
?>