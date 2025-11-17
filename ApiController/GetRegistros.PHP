<?php
// Create SQL Connection

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "7bp0c@81X";
$dbname = "sirecor";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//Tomando datos desde solicitud HTTP GET

//$data= $_GET['name'];

//Insertando En tabla RowData
$sql = "SELECT u.*,o.CAUDAL,o.DATETIME,o.id AS id_registro
FROM unidades_lastortolas o
JOIN (
    SELECT ul.unidad_id, MAX(ul.DATETIME) AS last_order_date
    FROM unidades_lastortolas ul
    GROUP BY ul.unidad_id
) t ON o.unidad_id = t.unidad_id AND o.DATETIME = t.last_order_date
INNER JOIN unidad u on u.id = o.unidad_id;";

$sth = mysqli_query($conn, $sql);
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

//Cerrando conexion SQL
$conn->close();
?>