<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();


  $ArrayObj = $Model->get_UltimoRegistroDiarioDeCadaUnidad();
  $return = json_encode( $ArrayObj );  




echo $return;

?>