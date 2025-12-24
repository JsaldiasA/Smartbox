<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath.'/DbEntities/unidadDbEntity.php';
require_once $sitebasepath.'/DbEntities/checklistDbEntity.php';

$IMEI= $_POST['IMEI'];
$id_unidad= $_POST['id_unidad'];
$VoltajeReguladorBat= $_POST['VoltajeReguladorBat'];
$VoltajeReguladorMCU= $_POST['VoltajeReguladorMCU'];

if (strcmp($token,'eco3spa')==0)
{
	// Create connection	
	$dbConfig = new DbSirecorConfig();		
	$conn = new mysqli($dbConfig->get_servername(),$dbConfig->get_username(),$dbConfig->get_password(),$dbConfig->get_dbname());
	
	if ($conn->connect_error) {
 	 die("Connection failed: " . $conn->connect_error);
	}
	
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
	
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
	echo '</tbody></table>';
	}
	else
	{   echo $result;}
	
	echo "Check list Agregado Correctamente: ".'Id: '.$Id.
'VoltajeReguladorBat: '.$VoltajeReguladorBat.
'VoltajeReguladorMCU: '.$VoltajeReguladorMCU.
'SmartBox: '.$SmartBox.
'SMSenvio: '.$SMSenvio.

	$conn->close();
}
else
{
	echo "password Incorrecta";
}

?>