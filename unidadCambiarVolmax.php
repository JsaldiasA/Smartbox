<?php
date_default_timezone_set('America/Santiago');
$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "7bp0c@81X";
$dbname = "sirecor";

$tag= $_POST['tag'];
$NuevoVolMax= $_POST['NuevoVolMax'];
$token= $_POST['token'];

if (strcmp($token,'eco3spa')==0)
{
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
 	 die("Connection failed: " . $conn->connect_error);
	}
	 $sql = "UPDATE `unidad` SET `VolMax` = '{$NuevoVolMax}' WHERE `tag` LIKE '{$tag}'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
	echo '</tbody></table>';
	}
	else
	{echo $result;}
	
	echo "Cambio de ubicación hecho correctamente. Nueva ubicación: ".$NuevoVolMax;
	$conn->close();
}
else
{
	echo "Contraseña incorrecta";
}
?>