<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();

$Id= $_GET['Id']; 

$ArrayObj = $Model->MYSQLSelectWHERE('unidades_lastortolas','Id',$Id);
$return = json_encode( $ArrayObj );  

echo $return;

?>