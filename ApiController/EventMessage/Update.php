<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();


$Id_obj= $_POST['Id'];
$obj= $model->MYSQLSelectWHERE('eventmessage','Id',$Id_obj)[0];

$UpdatedObj= new eventmessageDbEntity();

$allKeys = array_keys((array)$UpdatedObj);

foreach ($allKeys as $key ) 
{
	$UpdatedObj->$key = (($_POST[$key] == null)? $obj->$key : $_POST[$key]);
}


$model->MYSQLUpdate('cuarteles',$UpdatedObj);

echo 'EventMessage Editado exitosamente';
echo var_dump($UpdatedObj);

?>