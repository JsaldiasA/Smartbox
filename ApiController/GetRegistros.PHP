<?php
// Create SQL Connection

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//Tomando datos desde solicitud HTTP GET

$data= $_GET['name'];

//Insertando En tabla RowData
$sql = "select u.*, ul.CAUDAL from unidades_lastortolas ul inner join unidad u on ul.unidad_id = u.id group by ul.unidad_id order by ul.`DATETIME` desc";

$sth = mysqli_query($conn, $sql);
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

//Cerrando conexion SQL
$conn->close();
?>