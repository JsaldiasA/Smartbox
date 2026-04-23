<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$Id_ticket= $_POST['Id'];
$ticket= $model->MYSQLSelectWHERE('ticket','Id',$Id_ticket)[0];

$UpdatedTicket = new ticketDbEntity();

$allKeys = array_keys((array)$UpdatedTicket);

//cloning ticket
foreach ($allKeys as $key ) 
{
	$UpdatedTicket->$key = (($_POST[$key] == null)? $ticket->$key : $_POST[$key]);
}

// set closed status
$UpdatedTicket->Id_TicketStatus = '3';

// SET creationtime
date_default_timezone_set('America/Santiago');
$UpdatedTicket->FechaCierre = date("Y-m-d H:i:s");

$model->MYSQLUpdate('ticket',$UpdatedTicket);

echo 'Ticket Eliminado exitosamente';


?>