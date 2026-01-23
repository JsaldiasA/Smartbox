<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$newRow = new checklistDbEntity();

$allKeys = array_keys((array)$newRow);

foreach ($allKeys as $key ) 
{
	$newRow->$key = (($_POST[$key] == null)? 'NULL': $_POST[$key]);
}

// SET Default Id = 0 autoincrement
$newRow->Id = '0';
// SET creationtime
date_default_timezone_set('America/Santiago');
$newRow->Fecha = date("Y-m-d H:i:s");

$model->MYSQLInsertInto('checklist',$newRow);
echo 'alert(Registro creado Correctamente)';
echo var_dump($newRow);

?>