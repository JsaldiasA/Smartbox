<?php

$IMEI= $_POST['IMEI'];
$id_unidad= $_POST['id_unidad'];
$VoltajeReguladorBat= $_POST['VoltajeReguladorBat'];
$VoltajeReguladorMCU= $_POST['VoltajeReguladorMCU'];
$SmartBox=$_POST['SmartBox'];
$SMSenvio=$_POST['SMSenvio'];
$SMSrecibo=$_POST['SMSrecibo'];
$Flujometro=$_POST['Flujometro'];
$Solenoide=$_POST['Solenoide'];
$SensorNivelBajo=$_POST['SensorNivelBajo'];
$SensorNivelAlto=$_POST['SensorNivelAlto'];
$VoltajeMCU=$_POST['VoltajeMCU'];
$VoltajeMCU=$_POST['VoltajeBateria'];
$BateriaTest=$_POST['BateriaTest'];
$id_checklistMotivo=$_POST['id_checklistMotivo'];
$Observaciones=$_POST['Observaciones'];
$id_unidadtipo=$_POST['id_unidadtipo'];
$TecnicoResponsable=$_POST['TecnicoResponsable'];
$URL_foto= $_POST['URL_foto'];
$token= $_POST['token'];


$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath.'/Model/Model.php';	

$model = new Model();

if (strcmp($token,'eco3spa')==0)
{

 $sql = "INSERT INTO `checklist` (`Id`, `VoltajeReguladorBat`, `VoltajeReguladorMCU`, `SmartBox`, `SMSenvio`, `SMSrecibo`, `Flujometro`, `Solenoide`, `SensorNivelBajo`, `SensorNivelAlto`, `VoltajeMCU`, `BateriaTest`, `id_checklistMotivo`, `Observaciones`, `id_unidadtipo`, `URL_foto`, `id_unidad`, `Fecha`, `TecnicoResponsable`,`VoltajeBateria`) VALUES ( NULL,'{$VoltajeReguladorBat}',
'{$VoltajeReguladorMCU}',
'{$SmartBox}',
'{$SMSenvio}',
'{$SMSrecibo}',
'{$Flujometro}',
'{$Solenoide}',
'{$SensorNivelBajo}',
'{$SensorNivelAlto}',
'{$VoltajeMCU}',
'{$BateriaTest}',
'{$id_checklistMotivo}',
'{$Observaciones}',
'{$id_unidadtipo}',
'https://smartbox.eco3.cl/checklistform/Fotos/{$URL_foto}',
'{$id_unidad}',
current_timestamp(),
'{$TecnicoResponsable}',
'{$VoltajeBateria}'
)";

//	 $sql = "INSERT INTO `checklist` ( `VoltajeReguladorBat`, `VoltajeReguladorMCU`, `SmartBox`, `Entel4Parametros`, `SMS`, `MB`, `Internet`, `AlertaCaudal0`, `AlertaVolMax`, `AlertaCAUDALvOFF`, `llamadaAdmin`, `llamadaUsuario1`, `Estado`, `AlertaNivelBajo`, `TecnicoResponsable`, `Observaciones`, `TipoDeDispositivo`, `URL_foto`) VALUES ( '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1')";
	
	$result = $model->executeSQL($sql);

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
'SMSrecibo: '.$SMSrecibo.
'Flujometro: '.$Flujometro.
'Solenoide: '.$Solenoide.
'SensorNivelBajo: '.$SensorNivelBajo.
'SensorNivelAlto: '.$SensorNivelAlto.
'VoltajeMCU: '.$VoltajeMCU.
'BateriaTest: '.$BateriaTest.
'id_checklistMotivo: '.$id_checklistMotivo.
'Observaciones: '.$Observaciones.
'id_unidadtipo: '.$id_unidadtipo.
'URL_foto: '.$URL_foto.
'id_unidad: '.$id_unidad.
'Fecha: '.$Fecha.
'TecnicoResponsable: '.$TecnicoResponsable;
}
else
{
	echo "password Incorrecta";
}

?>