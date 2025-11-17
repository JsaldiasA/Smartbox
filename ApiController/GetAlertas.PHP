<?php
// Create SQL Connection

$data= $_GET['name'];


$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`) VALUES ('{$data}');";

$result = $model->executeSQL($sql);
if ($result === TRUE) {
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

$result = $model->executeSQL($sql);
if ($result === TRUE) {
 echo "ROW agregado exitosamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


?>