<?php
date_default_timezone_set('America/Santiago');
$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$dat= $_POST['name'];
$limit= $_POST['limit'];
$c=$_POST['uni'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if($c=="true")
{
	$sql ="SELECT `UL`.`id`,`U`.`tag`,`UL`.`ESTADO`,`UL`.`VOLUMEN`,`UL`.`CAUDAL`,`UL`.`SENAL`,`UL`.`VOLTAJE`,`UL`.`DATETIME` FROM 		`unidades_lastortolas` `UL` INNER JOIN `unidad` `U` ON `U`.`ID` = `UL`.`unidad_id`  WHERE `U`.`tag`='{$dat}' ORDER BY `UL`.`id` DESC LIMIT {$limit}";
}
else
{
	$sql = "SELECT `UL`.`id`,`U`.`tag`,`UL`.`ESTADO`,`UL`.`VOLUMEN`,`UL`.`CAUDAL`,`UL`.`SENAL`,`UL`.`VOLTAJE`,`UL`.`DATETIME` FROM 		`unidades_lastortolas` `UL` INNER JOIN `unidad` `U` ON `U`.`ID` = `UL`.`unidad_id`  WHERE `U`.`tag` LIKE '%{$dat}%' ORDER BY `UL`.`id` DESC LIMIT {$limit}";
}

$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // output data of each row
	echo '<table class="table table-dark table-striped table-hover"><thead><tr><th scope="col">UNIDAD</th><th scope="col">ESTADO</th><th scope="col">VOLUMEN</th><th scope="col">CAUDAL</th><th scope="col">SENAL</th><th scope="col">VOLTAJE</th><th scope="col">FECHA</th></tr></thead><tbody>';
    while($row = $result->fetch_assoc()) 
	{
		echo '<tr">  <td>'. $row["tag"]. "</td> <td>". $row["ESTADO"]. "</td><td>" . $row["VOLUMEN"] ."</td> <td>" . $row["CAUDAL"]."</td> 			<td>" . $row["SENAL"] ." </td><td>" . $row["VOLTAJE"] ."</td><td>" . $row["DATETIME"] ."</td></tr>";
	}
		
	echo '</tbody></table>';
}
else
{
    echo "0x results";
}

$conn->close();
?>