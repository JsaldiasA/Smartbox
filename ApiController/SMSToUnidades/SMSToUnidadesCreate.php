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

$IsDuplicated = false;

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
			$IsDuplicated = true;
		}
	}

}

// Si se abre la valvula, asegurarse de que la valvula este cerrada y viceversa.

$unidad = $model->MYSQLSelectWHERE('unidad','Id',$NewSMS->Id_unidad)[0];
$IsAlreadyOpen = false;
$IsAlreadyClose = false;

if( $unidad != null)
{
	if( ( $NewSMS->SMS == "ABRIR" && $unidad->Estado == "ON" ) ) 
	{
		$IsAlreadyOpen = true;
	}
	if( ( $NewSMS->SMS == "CERRAR" && $unidad->Estado == "OFF" ) ) 
	{
		$IsAlreadyClose = true;
	}
}


if($IsDuplicated == false && $NewSMS->SMS != null && $IsAlreadyOpen == false && $IsAlreadyOpen == false)
{
	$model->MYSQLInsertInto('smstounidades',$NewSMS);
	echo 'SMS creado Correctamente';
	echo var_dump($NewSMS);
}
else{

	If( $IsDuplicated ) 
	{
		echo 'Error, mensaje duplicado o el mensaje es NULL';
	}
	If( $IsAlreadyOpen ) 
	{
		echo 'Error al abrir solenoide, la valvula ya esta abierta';
	}
	If( $IsAlreadyClose ) 
	{
		echo 'Error al cerrar solenoide, la valvula ya esta cerrada';
	}
	If( $NewSMS->SMS == null ) 
	{
		echo 'Error, mensaje duplicado o el mensaje es NULL';
	}
	
}



?>