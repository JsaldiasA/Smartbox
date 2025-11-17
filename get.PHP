<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

//Tomando datos desde solicitud HTTP GET

$data= $_GET['name'];

$IP = $_SERVER['REMOTE_ADDR'];

//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";
$result = $model->executeSQL($sql);


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

$unidadObj = $model->unidadByTag($UNIDAD);

echo var_dump($unidadObj);

$sql = "INSERT INTO unidades_lastortolas
( unidad_id, ESTADO, VOLUMEN, CAUDAL, SENAL, VOLTAJE, `DATETIME`)
VALUES( ".$unidadObj->get_id().", '{$ESTADO}' '{$VOLUMEN}','{$CAUDAL}', '{$SENAL}','{$VOLTAJE}', current_timestamp())";

echo $sql; 

$result = $model->executeSQL($sql);

?>