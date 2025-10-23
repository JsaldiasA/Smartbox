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
$sql = "INSERT INTO `rowdata`(`RowData`) VALUES ('{$data}');";

if ($conn->query($sql) === TRUE) {
 echo "ROW agregado exitosamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//Parseando la data del String que viene desde Sirecor

$UNIDAD= substr($data,  0, strpos($data,":"));
$data= substr($data, (strpos($data,":")+2), strlen($data));
$ESTADO=substr($data,  0, 2);
$VOLUMEN=substr($data,  (strpos($data,"V")+1), (strpos($data,"C")-(strpos($data,"V")+1)));
$CAUDAL=substr($data,  (strpos($data,"C")+1), (strpos($data,"S")-(strpos($data,"C")+1)));
$SENAL=substr($data,  (strpos($data,"S")+1), (strpos($data,"Vt")-(strpos($data,"S")+1)));
$VOLTAJE=substr($data,  (strpos($data,"Vt")+2),strlen($data));

//echo $UNIDAD;
//echo '!';
//echo $ESTADO;
//echo '!';
//echo $VOLUMEN;
//echo '!';
//echo $CAUDAL;
//echo '!';
//echo $SENAL;
//echo '!';
//echo $VOLTAJE;
//echo '!';

//echo $UNIDAD;
// Create connection

if ($SENAL == "NULL") {
  $SENAL="0";
}

//$VOLUMEN = intval($VOLUMEN);

//$sql = "INSERT INTO `unidades_lastortolas` (`UNIDAD`, `ESTADO`, `VOLUMEN`, `CAUDAL`, `SENAL`, `VOLTAJE`, `FECHA`, `TIEMPO`) VALUES ('"+ //$UNIDAD + "', '" + $ESTADO + "', '" + $VOLUMEN + "','" + $CAUDAL + "', '" + $SENAL +"','" + $VOLTAJE + "', CURRENT_DATE(), CURRENT_TIME())";
//$sql = "INSERT INTO `unidades_lastortolas` (`UNIDAD`, `ESTADO`, `VOLUMEN`, `CAUDAL`, `SENAL`, `VOLTAJE`, `FECHA`, `TIEMPO`) VALUES ('{$UNIDAD}', '{$ESTADO}', '{$VOLUMEN}','{$CAUDAL}', '{$SENAL}','{$VOLTAJE}', CURRENT_DATE(), CURRENT_TIME())";
//Ingresando la data a unidades las tortolas
$sql = "CALL ingreso('{$UNIDAD}', '{$ESTADO}', '{$VOLUMEN}','{$CAUDAL}', '{$SENAL}','{$VOLTAJE}')";

if ($conn->query($sql) === TRUE) {
 echo "Registro agregado exitosamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//Cerrando conexion SQL
$conn->close();
?>