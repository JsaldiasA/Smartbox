<?php
//Tomando datos desde solicitud HTTP GET
$AppName= $_GET['AppName'];

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";


$Model = new model();

//Insertando En tabla RowData
$Model->executeSQL( "update externalapps_monitor e set e.LastUpdate = NOW() WHERE e.AppName like '".$AppName."');");

echo 'OK';


?>