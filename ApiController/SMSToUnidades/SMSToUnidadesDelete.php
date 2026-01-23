<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$Id_SMS= $_POST['Id'];
$SMSToDelete= $model->MYSQLSelectWHERE('smstounidades','Id',$Id_SMS)[0];
$result = $model->MYSQLDelete('smstounidades',$SMSToDelete);

echo 'alert(SMS Eliminado exitosamente)';

?>