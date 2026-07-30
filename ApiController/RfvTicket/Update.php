<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();


$Id_ticket= $_POST['Id'];
$ticket= $model->MYSQLSelectWHERE('rfvticket','Id', $Id_ticket);

$UpdatedTicket = new rfvticketDbEntity();

$allKeys = array_keys((array)$UpdatedTicket);

foreach ($allKeys as $key ) 
{
	$UpdatedTicket->$key = (($_POST[$key] == null)? $ticket->$key : $_POST[$key]);
}

echo var_dump($ticket);
echo var_dump($UpdatedTicket);

$model->MYSQLUpdate('rfvticket',$UpdatedTicket);

echo 'Ticket Editado exitosamente';
echo var_dump($UpdatedTicket);

?>