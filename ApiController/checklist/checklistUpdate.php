<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();


$Id_checklist= $_POST['Id_checklist'];
$checklist= $model->MYSQLSelectWHERE('checklist','Id',$Id_checklist)[0];

$Updatedchecklist= new checklistDbEntity();

$allKeys = array_keys((array)$Updatedchecklist);

foreach ($allKeys as $key ) 
{
	$Updatedchecklist->$key = (($_POST[$key] == null)? $checklist->$key : $_POST[$key]);
}

echo var_dump($checklist);
echo var_dump($Updatedchecklist);

$model->MYSQLUpdate('checklist',$Updatedchecklist);

echo 'checklist Editado exitosamente';
echo var_dump($Updatedchecklist);

?>