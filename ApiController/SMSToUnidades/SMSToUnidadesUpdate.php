<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();


$Id_smstounidades= $_POST['Id'];
$SMStounidades= $model->MYSQLSelectWHERE('smstounidades','Id',$Id_SMS)[0];

$UpdatedSMStounidades= new smstounidadesDbEntity();

$allKeys = array_keys((array)$UpdatedSMStounidades);

foreach ($allKeys as $key ) 
{
	$UpdatedSMStounidades->$key = (($_POST[$key] == null)? $SMStounidades->$key : $_POST[$key]);
}

echo var_dump($SMStounidades);
echo var_dump($UpdatedSMStounidades);

$model->MYSQLUpdate('smstounidades',$UpdatedSMStounidades);

echo 'SMSToUnidades Editado exitosamente';
echo var_dump($UpdatedSMStounidades);

?>