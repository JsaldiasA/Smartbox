<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$NewSMS = new smstounidadesDbEntity();

$allKeys = array_keys((array)$NewSMS);

foreach ($allKeys as $key ) 
{
	$NewSMS->$key = (($_POST[$key] == null)? 'NULL': $_POST[$key]);
}

// SET Default Recibido = 0 autoincrement
$NewSMS->Recibido = '0';
// SET Default Id = 0 autoincrement
$NewSMS->Id = '0';
// SET creationtime
date_default_timezone_set('America/Santiago');
$NewSMS->CreateTime = date("Y-m-d H:i:s");

// Check if the mesage is duplicated

$isDuplicated = false;

$smsForThisUnit = $model->MYSQLSelectWHERE('smstounidades','Id_unidad',$NewSMS->Id_unidad);
$smsNoReceived = [];

foreach($smsForThisUnit as $sms)
{
	if($sms->Recibido == '0' )
	{
		$smsNoReceived [] = $sms;
	}
}

if($smsNoReceived != null)
{
	foreach($smsNoReceived as $sms)
	{
		if($sms->SMS == $NewSMS->SMS)
		{
			$isDuplicated = true;
		}
	}

}

if($isDuplicated == false && $NewSMS->SMS != null)
{
	$model->MYSQLInsertInto('smstounidades',$NewSMS);
	echo 'SMS creado Correctamente';
	echo var_dump($NewSMS);
}
else{
	echo 'Error, mensaje duplicado o el mensaje es NULL';
}



?>