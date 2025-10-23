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

 $sql = "SELECT * FROM `unidad` WHERE `Id_unidadTipo`= 1 ORDER BY `UltimaActualizacion` DESC";

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
		  <th scope="col">Invertir Entrada</th>
		  <th scope="col"></th>
		  </thead><tbody>';// Header tabla
	
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
			else {$UltimaActROW=$UltimaAct->format("%h Horas");}
		}
		else {$UltimaActROW=$UltimaAct->format("%a Dias");}
		
		// Invertir las entradas si el bit es 1
		$InvertirEntrada = $row["InvertirEntrada"];
		$InvertirEntradaText = "";
		if ($InvertirEntrada == "1")
		{
			$InvertirEntradaText="SI";
		}
		else
		{
			$InvertirEntradaText="No";
		}
		
		$Estado = $row["Estado"];
		
		if ($InvertirEntrada == "1")
			{
				switch ($Estado) {
									  case "LLENO":
										$Estado = "BAJO";
										break;
									  case "NULL":
										$Estado = "MEDIO";
										break;
									  case "BAJO":
										$Estado = "ALTO";
										break;
									  default:
										$Estado = "NOTDEF";
									}
			}
		
		$level = $row["BatNivel"];
	    $BatNivel = new BatteryLevel($level);
		
		
		//print row
        echo "<tr>  
		<td>". $row["Nombre"].// TAG
		"</td> <td>". $row["tag"].
		"</td> <td>". $row["numero"].
		"</td> <td>" .$UltimaActROW.
		"</td> <td>". $Estado .
		"</td> <td>". $BatNivel->get_HtmlTableField() .
		"</td> <td>". $InvertirEntradaText .
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