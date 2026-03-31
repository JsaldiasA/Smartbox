<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$NewObj = new cuartelesDbEntity();

$allKeys = array_keys((array)$NewObj);

foreach ($allKeys as $key ) 
{
	$NewObj->$key = (($_POST[$key] == null)? 'NULL': $_POST[$key]);
}

// SET Default values


	$model->MYSQLInsertInto('cuarteles',$NewObj);
	echo ' creado Correctamente';
	echo var_dump($NewObj);




?>