<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();
//$EventTypeEstanque = new eventmessagetypeDbEntity();

$EventTypeEstanque =  $Model->MYSQLSelect('eventmessagetype')[0];
$EventMesage =  $Model->MYSQLSelect('eventmessage')[0];

$DataJson = json_decode( $EventMesage->MessageText ); 

$parameters = json_decode($EventTypeEstanque->ParametersArray, true);

foreach($parameters as $p )
{
	echo "Parametro: ".$p." =" . $DataJson->$p;
}	


echo var_dump($parameters);

?>