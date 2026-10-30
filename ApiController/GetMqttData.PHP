<?php

//Tomando datos desde solicitud HTTP GET
$data= $_GET['JsonData'];
$obj = json_decode($data);

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new model();

$UnidadExistente = $Model->MYSQLSelectWHERE('unidad','tag',$obj->devEUI)[0];


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
		$NewUnidad= new unidadDbEntity();
		
		$NewUnidad->Id = "0";
		$NewUnidad->Serie = $obj->deviceName;
		$NewUnidad->tag = $obj->devEUI;
		$NewUnidad->Estado = $obj->valve_1;
		$NewUnidad->Volumen = $obj->valve_2_pulse ?? "0";
		$NewUnidad->BatNivel = $obj->battery ?? "0";

		$Model->MYSQLInsertInto('unidad',$NewUnidad);

		$NewUnidadCreada = $Model->MYSQLSelectWHERE('unidad','tag',$obj->devEUI)[0];

		$RegistroDiario= new unidades_lastortolasDbEntity();

		$RegistroDiario->Id = "0";
		$RegistroDiario->unidad_id = $NewUnidadCreada->Id;
		$RegistroDiario->ESTADO = $obj->valve_1;
		$RegistroDiario->VOLUMEN = $obj->valve_2_pulse ?? "0";
		$RegistroDiario->CAUDAL =  "0";
		$RegistroDiario->VOLTAJE =  $obj->battery ?? "0";
		$RegistroDiario->SENAL = "0";

		$Model->MYSQLInsertInto('unidades_lastortolas',$RegistroDiario);

	}
	else
	{
		
		$NewESTADO = (property_exists($obj,'valve_1') && isset($obj->valve_1) ) ? (string)$obj->valve_1 : '' ;
		$NewVOLUMEN = (property_exists($obj,'valve_2_pulse') && isset($obj->valve_2_pulse) ) ? $obj->valve_2_pulse : $UnidadExistente->get_Volumen();
		$NewCAUDAL = 0 ;
		$NewBATNIVEL =  (property_exists($obj,'battery') && isset($obj->battery) ) ? $obj->battery : $UnidadExistente->BatNivel;

		date_default_timezone_set('America/Santiago');
  		$FechaActualStr= date("Y-m-d H:i:s");

		$RegistroDiario= new unidades_lastortolasDbEntity();

		$RegistroDiario->Id = "0";
		$RegistroDiario->unidad_id = $UnidadExistente->Id;
		$RegistroDiario->ESTADO =  $NewESTADO;
		$RegistroDiario->VOLUMEN = $NewVOLUMEN;
		$RegistroDiario->CAUDAL =  999;
		$RegistroDiario->VOLTAJE =  $NewBATNIVEL;
		$RegistroDiario->SENAL = 0;
		$RegistroDiario->DATETIME = $FechaActualStr;


		$Model->MYSQLInsertInto('unidades_lastortolas',$RegistroDiario);

		$UnidadExistente->Estado = $NewESTADO;
		$UnidadExistente->BatNivel = $NewBATNIVEL ;
		$UnidadExistente->Volumen = $NewVOLUMEN;
		$UnidadExistente->UltimaActualizacion = $FechaActualStr;

		$Model->MYSQLUpdate('unidad',$UnidadExistente);
	
	}
}

?>