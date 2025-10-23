<?php
date_default_timezone_set('America/Santiago');
$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$tag= $_POST['tag'];
$NuevoNumero= $_POST['NuevoNumero'];
$token= $_POST['token'];



if (strcmp($token,'eco3spa')==0)
{
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
 	 die("Connection failed: " . $conn->connect_error);
	}
	 $sql = "UPDATE `unidad` SET `numero` = '{$NuevoNumero}' WHERE `tag` LIKE '{$tag}'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
	echo '</tbody></table>';
	}
	else
	{   echo $result;}
	
	echo "Cambio de nombre hecho correctamente Nuevo Numero:".$NuevoNumero;
	$conn->close();
	
}
else
{
	echo "password Incorrecta";
}

?>