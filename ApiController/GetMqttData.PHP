<?php

//Tomando datos desde solicitud HTTP GET
$data= $_GET['JsonData'];
$obj = json_decode($data);

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new model();

$UnidadExistente = $Model->UnidadByTag($obj->devEUI);


//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`) VALUES ('{$data}');";
$result = $Model->executeSQL($sql);

//Parseando la data del String que viene desde Sirecor
if( $obj->deviceName === "sensor humedad test")
{
	$NOMBRE= $obj->deviceName;
	$UNIDAD= $obj->devEUI; 
	$ESTADO= $obj->temperature;
	$VOLUMEN=$obj->moisture;
	$BATNIVEL = $obj->battery ?? "0";
	$CAUDAL= $obj->ec;
	$Temperatura = $obj->temperature;
	$Humedad = $obj->moisture;
	$EC = $obj->ec;
}
else // si es caja u511 soleniod valve controller
{
	// si la unidad se esta registrando por primera vez
	if( is_null($UnidadExistente) ) 
	{
		$NOMBRE = $obj->deviceName;
		$UNIDAD = $obj->devEUI;
		$ESTADO = $obj->valve_1;
		$VOLUMEN = $obj->valve_2_pulse ?? "0";
		$BATNIVEL = $obj->battery ?? "0";
		$CAUDAL = "0";
		$Temperatura = 0;
		$Humedad = 0;
		$EC = 0;
	}
	else
	{
		$NOMBRE = $obj->deviceName;
		$UNIDAD = $obj->devEUI;
		$ESTADO = $obj->valve_1;
		$VOLUMEN = $obj->valve_2_pulse ?? $UnidadExistente->get_Volumen();
		$BATNIVEL = $obj->battery ?? $UnidadExistente->get_BatNivel();
		$CAUDAL = $VOLUMEN - $UnidadExistente->get_Volumen();
		$Temperatura = 0;
		$Humedad = 0;
		$EC = 0;
	}
}

// SP ingresoMilesight Parametros.
// $UNIDAD, $ESTADO, $VOLUMEN, $CAUDAL, $SENAL, $VOLTAJE, $VOLTAJE, $NOMBRE,$Temperatura, $Humedad,$EC

$sql = "CALL ingresoMilesight('{$UNIDAD}', '{$ESTADO}', '{$VOLUMEN}','{$CAUDAL}', '0','{$BATNIVEL}','{$BATNIVEL}','{$NOMBRE}','{$Temperatura}','{$Humedad}','{$EC}')";

$resultB = $Model->executeSQL($sql);
echo "unidad: {$UNIDAD}', ESTADO'{$ESTADO}', VOLUMEN'{$VOLUMEN}',CAUDAL'{$CAUDAL}', SENAL '{0}',VOLTAJE'{$BATNIVEL}',BATNIVEL'{$BATNIVEL}',NOMBRE'{$NOMBRE}',Temperatura'{$Temperatura}',Humedad'{$Humedad}',EC'{$EC}')";;

?>