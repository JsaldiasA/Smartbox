<?php
date_default_timezone_set('America/Santiago');
$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$tag= $_POST['tag'];
$token= $_POST['token'];



if (strcmp($token,'eco3spa')==0)
{
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
 	 die("Connection failed: " . $conn->connect_error);
	}
	$sql = "DELETE FROM `unidad` WHERE `tag` LIKE '{$tag}'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
	echo '</tbody></table>';
	}
	else
	{   echo $result;}
	
	echo "UNIDAD ELIMINADA ";
	$conn->close();
	
}
else
{
	echo "password Incorrecta";
}

?>