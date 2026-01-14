<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();


$Id_smstounidades= $_POST['Id'];
$SMStounidades= $model->smstounidadesBy('Id',$Id_smstounidades);

$UpdatedSMStounidades= new smstounidadesDbEntity();

$allKeys = array_keys((array)$UpdatedSMStounidades);

foreach ($allKeys as $key ) 
{
	$UpdatedSMStounidades->$key = (($_POST[$key] == null)? $SMStounidades->$key : $_POST[$key]);
}

echo var_dump($SMStounidades);
echo var_dump($UpdatedSMStounidades);

$model->update_SMSToUnidades($UpdatedSMStounidades);

echo 'SMSToUnidades Editado exitosamente';
echo var_dump($UpdatedSMStounidades);

?>