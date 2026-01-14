<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$SMS = new smstounidadesDbEntity();

date_default_timezone_set('America/Santiago');
$FechaActual = date_create(date("Y-m-d H:i:s"));

$allKeys = array_keys((array)$SMS);

foreach ($allKeys as $key ) 
{
	$SMS->$key = (($_POST[$key] == null)? 'NULL': $_POST[$key]);
}

// SET creationtime
$SMS->CreateTime = $FechaActual;
echo 'alert(SMS creado Correctamente)';
echo var_dump($SMS);

?>