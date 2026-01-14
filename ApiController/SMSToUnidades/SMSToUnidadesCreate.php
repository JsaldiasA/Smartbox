<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$SMS = new smstounidadesDbEntity();



$allKeys = array_keys((array)$SMS);



foreach ($allKeys as $key ) 
{
	$SMS->$key = (($_POST[$key] == null)? 'NULL': $_POST[$key]);
}

// SET Default Recibido = 0 autoincrement
$SMS->Recibido = '0';
// SET Default Id = 0 autoincrement
$SMS->Id = '0';
// SET creationtime
date_default_timezone_set('America/Santiago');
$SMS->CreateTime = date("Y-m-d H:i:s");

$model->create_SMSToUnidades($SMS);
echo 'alert(SMS creado Correctamente)';
echo var_dump($SMS);

?>