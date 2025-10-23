<?php

//Tomando datos desde solicitud HTTP GET
$data= $_GET['JsonData'];
$obj = json_decode($data);

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";


$Model = new model();

$Unidad = $Model->UnidadByTag($obj->devEUI);

if( is_null($Unidad) == true )
{$batAnterior = "0";}
else
{$batAnterior= $Unidad->get_BatNivel();}


//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`) VALUES ('{$data}');";
$result = $Model->executeSQL($sql);
//if ($result->num_rows > 0) { echo 'Agregado a DB ROWDATA';} else { echo 'Sin resultados en DB'; }
    

// SP ingresoMilesight Parametros.
// $UNIDAD, $ESTADO, $VOLUMEN, $CAUDAL, $SENAL, $VOLTAJE, $VOLTAJE, $NOMBRE,$Temperatura, $Humedad,$EC

 $UNIDAD="";
 $ESTADO="";
 $VOLUMEN="";
 $CAUDAL="";
 $SENAL="0";
 $VOLTAJE="0";
 $BATNIVEL="0";
 $NOMBRE="";
 $Temperatura="";
 $Humedad="";
 $EC="";

//Parseando la data del String que viene desde Sirecor
if( $obj->deviceName === "sensor humedad test")
{
	$NOMBRE= $obj->deviceName;
	$UNIDAD= $obj->devEUI; 
	$ESTADO= $obj->temperature;
	$VOLUMEN=$obj->moisture;
	$CAUDAL= $obj->ec;
	$TEMPERATURA = $obj->temperature;
	$HUMEDAD = $obj->moisture;
	$EC = $obj->ec;
}
else
{
	$NOMBRE = $obj->deviceName;
	$UNIDAD = $obj->devEUI;
	$ESTADO = $obj->valve_1;
	$VOLUMEN = $obj->valve_2_pulse;
	$BATNIVEL = $obj->battery ?? $batAnterior;
	$CAUDAL = 0;
	$Temperatura = 0;
	$Humedad = 0;
	$EC = 0;
}


$sql = "CALL ingresoMilesight('{$UNIDAD}', '{$ESTADO}', '{$VOLUMEN}','{$CAUDAL}', '{$SENAL}','{$VOLTAJE}','{$BATNIVEL}','{$NOMBRE}','{$Temperatura}','{$Humedad}','{$EC}')";

$resultB = $Model->executeSQL($sql);
//if ($resultB->num_rows > 0) { echo 'CALL ingresoMilesight Exitoso';} else { echo 'Sin resultados en DB'; }
echo "unidad: {$UNIDAD}', ESTADO'{$ESTADO}', VOLUMEN'{$VOLUMEN}',CAUDAL'{$CAUDAL}', SENAL '{$SENAL}',VOLTAJE'{$VOLTAJE}',BATNIVEL'{$BATNIVEL}',NOMBRE'{$NOMBRE}',Temperatura'{$Temperatura}',Humedad'{$Humedad}',EC'{$EC}')";;

?>