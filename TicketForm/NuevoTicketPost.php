<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/Model/model.php";

$IMEI= $_POST['IMEI'];
$id_unidad= $_POST['id_unidad'];
$VoltajeReguladorBat= $_POST['VoltajeReguladorBat'];
$VoltajeReguladorMCU= $_POST['VoltajeReguladorMCU'];

$Model = new Model();

 $sql = "INSERT INTO `checklist` (`Id`, `VoltajeReguladorBat`, `VoltajeReguladorMCU`, `SmartBox`, `SMSenvio`, `SMSrecibo`, `Flujometro`, `Solenoide`, `SensorNivelBajo`, `SensorNivelAlto`, `VoltajeMCU`, `BateriaTest`, `id_checklistMotivo`, `Observaciones`, `id_unidadtipo`, `URL_foto`, `id_unidad`, `Fecha`, `TecnicoResponsable`) VALUES ( NULL,'{$VoltajeReguladorBat}',
'{$VoltajeReguladorMCU}',
'{$SmartBox}',
'{$SMSenvio}',
'{$SMSrecibo}',

'https://smartbox.eco3.cl/checklistform/{$URL_foto}',
'{$id_unidad}',
current_timestamp(),
'{$TecnicoResponsable}')";

//	 $sql = "INSERT INTO `checklist` ( `VoltajeReguladorBat`, `VoltajeReguladorMCU`, `SmartBox`, `Entel4Parametros`, `SMS`, `MB`, `Internet`, `AlertaCaudal0`, `AlertaVolMax`, `AlertaCAUDALvOFF`, `llamadaAdmin`, `llamadaUsuario1`, `Estado`, `AlertaNivelBajo`, `TecnicoResponsable`, `Observaciones`, `TipoDeDispositivo`, `URL_foto`) VALUES ( '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1')";
	
	$result = $Model->executeSQL($sql);
	
	echo "Check list Agregado Correctamente: ".'Id: '.$Id.
'VoltajeReguladorBat: '.$VoltajeReguladorBat.
'VoltajeReguladorMCU: '.$VoltajeReguladorMCU.
'SmartBox: '.$SmartBox.
'SMSenvio: '.$SMSenvio;


?>