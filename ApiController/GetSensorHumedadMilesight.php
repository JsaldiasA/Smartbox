<?php

$dat= $_POST['name'];
$limit= $_POST['limit'];

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/DbEntities/unidadDbEntity.php";
require_once $sitebasepath."/config/DbSirecorConfig.php";	

$dbConfig = new DbSirecorConfig();		
// Create connection
$conn = new mysqli($dbConfig->get_servername(),$dbConfig->get_username(),$dbConfig->get_password(),$dbConfig->get_dbname());
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//GETTING DATA FROM THE UNIT	
 $sql = "SELECT * FROM `unidad` WHERE `id_unidadTipo` = 4 ORDER BY `UltimaActualizacion` DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) 
	{
	    $unidadDbEntity= new unidadDbEntity($row["id"],$row["Nombre"],$row["tag"],$row["Numero"],$row["UltimaActualizacion"],$row["Volumen"],$row["Estado"],$row["Id_Unidadtipo"],$row["InvertirEntrada"],$row["BatNivel"]);
//cuidado con el casing, distinge de mayusculas y minusculas
	}
} 
else 
{ echo "0 results"; }

echo '<table class="table">
	  <thead >
	  <th scope="col">Nombre</th>
	  <th scope="col">Device EUI</th>
      <th scope="col">ÚltimaActz</th>
	  <th scope="col"></th>
      </thead><tbody>';// Header tabla
		//print row
        echo "<tr>  
		<td>". $unidadDbEntity->get_Nombre().
		"</td> <td>". $unidadDbEntity->get_Tag().
		"</td> <td>" .$unidadDbEntity->UltimaActualizacion().
		"</td> <td> <a href='unidadver.php?tag=". $unidadDbEntity->get_Tag() ."'>Ver</a>
		</td></tr>";
		echo '</tbody></table>';

$conn->close();

?>