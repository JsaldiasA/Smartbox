<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

echo '<style>body{background-color: #191919; color: #FFFFFF}</style>';
echo '<style>.container{background-color: #292929;color: #FFFFFF;padding: 20px;border-radius: 8px;}</style>';

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "7bp0c@81X";
$dbname = "sirecor";

date_default_timezone_set('America/Santiago');
$dat= $_GET['tag'];
$limit= 100;

$conn = new mysqli($servername, $username, $password, $dbname);
$FechaActual= date_create(date("Y-m-d H:i:s"));

if ($conn->connect_error)
	{
  		die("Connection failed: " . $conn->connect_error);
	}

if ($result->num_rows > 0)
	{
    	echo '<div class="container" style="padding:50px 50px 50px 50px;width:100%;">';
	
		while ($row = $result->fetch_assoc())
			{
				echo '<div class="container" style="padding:0px 0px 0px 0px;width:100%;">';

				$CabeceraName = $row["Nombre"];
				$tag = $row["tag"];

				if ($CabeceraName == "")
					{
						echo "<h1><b>Unidad</b>". $row["tag"]."(sin nombre)</h1>";
					}
				else
					{
						echo "<h1><b>Unidad</b>". $row["Nombre"]."</h1>";
					}

				echo '</div>';
	
				echo '<table class="table">
		  			  <thead >
		 			  <th scope="col">Nombre</th>
		  			  <th scope="col">unidad</th>
		  			  <th scope="col">UltimaActz</th>	
		  			  </thead><tbody>';
		
				$FechaSQLrow= date_create($row["UltimaActualizacion"]);
				$UltimaAct= date_diff($FechaActual,$FechaSQLrow);
		
				if ($UltimaAct->format("%a")=="0")
					{	
						if ($UltimaAct->format("%h")=="0")
							{
								$UltimaActROW=$UltimaAct->format("%i Min");
							}
						else
							{
								$UltimaActROW=$UltimaAct->format("%h Horas");
							}
					}
				else
					{
						$UltimaActROW=$UltimaAct->format("%a Dias");
					}

        		echo "<tr><td>". $row["Nombre"]. "</td><td>". $row["tag"]. "</td><td>" .$UltimaActROW. "</td></tr>";
				echo '</tbody></table>';
				echo '</div>';
			}
	} 
	else 
	{
   		echo "0 results";
	}
	
echo '<div class="container" style="padding: 0px 50px 0px 50px;width: 100%;">';

$sql = "SELECT * FROM `rowdata` ORDER BY `id` DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0)
	{
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
				echo '<tr"><td>'. $row["Id"] ." </td><td>" . $row["DateTime"] ."</td><td>" . $row["RowData"] ."</td><td>" . $row["IP"] ."</td></tr>";
			}
		
		echo '</tbody></table>';
	}
else
	{
    	echo "0 results";
	}

?>

<script>

$(document).ready(function ()
	{
    	$('#TablaRegistros').DataTable();
	});

</script>

<?php

$conn->close();

?>