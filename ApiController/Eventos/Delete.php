<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$tableName = '';

$Id_Obj= $_POST['Id'];
$Obj= $model->MYSQLSelectWHERE($tableName ,'Id',$Id_Obj)[0];
$result = $model->MYSQLDelete($tableName ,$Obj);

echo 'Eliminado exitosamente';

?>