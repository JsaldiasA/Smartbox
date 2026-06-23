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

date_default_timezone_set('America/Santiago');
$FechaActual= date_create(date("Y-m-d H:i:s"));


$NewObj = new eventmessageDbEntity();// use the name of the table related to the db entity


$NewObj->Id = '0' ;
$NewObj->MessageText = '{  "NewStatus": "BAJO", "LastStatus": "MEDIO"  }';
$NewObj->CreationDate = $FechaActual;
$NewObj->Id_MessageType = '1';
$NewObj->Id_unidad		 = '983';


// SET Default values

$Model->MYSQLInsertInto('eventmessage' ,$NewObj);


echo var_dump($parameters);

?>