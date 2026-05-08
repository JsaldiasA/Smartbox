<?php
header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$tickets = [];

$return = 'no data';

$Unidades =  $model->MYSQLSelect('unidad');

if(isset($_POST['Id'])) 
{
	$Id_ticket = $_POST['Id'];
	$tickets =  $model->MYSQLSelectWHERE('ticket','Id',$Id_ticket);
}  
else
{
	$tickets = $model->MYSQLSelect('ticket');
}

$return = json_encode( $tickets );

echo $return;


?>