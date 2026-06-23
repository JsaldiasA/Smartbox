<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();
//$EventTypeEstanque = new eventmessagetypeDbEntity();

$EventTypeEstanque =  $model->MYSQLSelect('eventmesagetype')[0];


$parameters = json_decode($EventTypeEstanque->ParametersArray, true);


echo var_dump($parameters);

?>