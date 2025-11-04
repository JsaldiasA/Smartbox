<?php


$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

//Tomando datos desde solicitud HTTP GET
$AppName= $_GET['AppName'];

$Model = new model();

//Insertando En tabla RowData
$result=$Model->executeSQL( "update externalapps_monitor e set e.LastUpdate = NOW() WHERE e.AppName like '".$AppName."');");

echo "OK";


?>