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

$IP = $_SERVER['REMOTE_ADDR'];
$dataAndIP= $IP+$data;

echo $dataAndIP;
//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";

if ($conn->query($sql) === TRUE) {
 echo "ROW agregado exitosamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//Parseando la data del String que viene desde Sirecor

$UNIDAD= substr($data,  0, strpos($data,":"));
$data= substr($data, (strpos($data,":")+1), strlen($data));
// Extrayendo Estado
//Verificando si es estanque o valvula
if (strpos($data,"V") === 0) { 
	$ESTADO=substr($data,  0, 3); // si es solenoide el fomato es "Von"  o "Voff", por que comenzara con una V, la posicion es 0
	if($ESTADO=="Von"){ 
		$ESTADO="ON";
		$data= substr($data, 4, strlen($data));
	}
	if($ESTADO=="Vof"){ 
		$ESTADO="OFF";
		$data= substr($data, 5, strlen($data));
	}
}
else{
$ESTADO=substr($data,  0, (strpos($data,"V"))); // si es estanque se toma todo hasta la "V" sieguente correspondiente al Volumen.
$data= substr($data, (strpos($data,"V")+1), strlen($data));	
}

$VOLUMEN=substr($data,  0, strpos($data,"C"));
$CAUDAL=substr($data,  (strpos($data,"C")+1), (strpos($data,"S")-(strpos($data,"C")+1)));
$SENAL=substr($data,  (strpos($data,"S")+1), (strpos($data,"Vt")-(strpos($data,"S")+1)));
$VOLTAJE=substr($data,  (strpos($data,"Vt")+2),strlen($data));

if ($SENAL == "") {
  $SENAL="0";
  $VOLTAJE="0";
}

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
if ($VOLUMEN == "NULL") {
  $VOLUMEN="0";
}
if ($CAUDAL == "NULL") {
  $CAUDAL="0";
}
if ($VOLTAJE == "NULL") {
  $VOLTAJE="0";
}
//$VOLUMEN = intval($VOLUMEN);

//$sql = "INSERT INTO `unidades_lastortolas` (`UNIDAD`, `ESTADO`, `VOLUMEN`, `CAUDAL`, `SENAL`, `VOLTAJE`, `FECHA`, `TIEMPO`) VALUES ('"+ //$UNIDAD + "', '" + $ESTADO + "', '" + $VOLUMEN + "','" + $CAUDAL + "', '" + $SENAL +"','" + $VOLTAJE + "', CURRENT_DATE(), CURRENT_TIME())";
//$sql = "INSERT INTO `unidades_lastortolas` (`UNIDAD`, `ESTADO`, `VOLUMEN`, `CAUDAL`, `SENAL`, `VOLTAJE`, `FECHA`, `TIEMPO`) VALUES ('{$UNIDAD}', '{$ESTADO}', '{$VOLUMEN}','{$CAUDAL}', '{$SENAL}','{$VOLTAJE}', CURRENT_DATE(), CURRENT_TIME())";
//Ingresando la data a unidades las tortolas
 
$sql = "CALL ingreso('{$UNIDAD}', '{$ESTADO}', '{$VOLUMEN}','{$CAUDAL}', '{$SENAL}','{$VOLTAJE}','{$VOLTAJE}')";

if ($conn->query($sql) === TRUE) {
 echo "Registro agregado exitosamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

//Cerrando conexion SQL
$conn->close();
?>