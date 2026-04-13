<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();


if(isset($_GET['tag'])) 
{
	$ArrayObj =  $model->MYSQLSelectWHERE('eventos','UNIDAD',$_GET['tag']);
}  
else
{
	$ArrayObj = $model->MYSQLSelect('eventos');
}

$return = json_encode( $ArrayObj ); 
    
echo $return;

?>