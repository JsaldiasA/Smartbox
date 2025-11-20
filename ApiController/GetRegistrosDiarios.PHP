<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new model();

//Tomando datos desde solicitud HTTP GET

//$data= $_GET['name'];

//Insertando En tabla RowData
$sql = "SELECT * FROM unidades_lastortolas WHERE id in (SELECT max(id) FROM unidades_lastortolas GROUP BY unidad_id);";


$sth = $Model->executeSQL($sql);
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);

//Cerrando conexion SQL
$conn->close();
?>