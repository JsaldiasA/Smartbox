<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$tableName = 'unidad';

$Gateway = $model->MYSQLSelectWHERE($tableName , 'Id', '0' )[0];
$return = json_encode( $Gateway ); 
    
echo $return;

?>