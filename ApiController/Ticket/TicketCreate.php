<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();
$newTicket = new ticketDbEntity();

$allKeys = array_keys((array)$NewTicket);

foreach ($allKeys as $key ) 
{
	$UpdateTicket->$key = isset( $_POST[$key] ) ? $_POST[$key] : null  ;
}

date_default_timezone_set('America/Santiago');
$FechaActual= date_create(date("Y-m-d H:i:s"));

// default values
$NewTicket->Id = '0';
$NewTicket->FechaInicio = $FechaActual->format('Y-m-d H:i:s');
$NewTicket->FechaCierre = 'NULL';
$NewTicket->Id_TicketPriority = '1';
$NewTicket->Id_TicketStatus = '1';

$Model->create_ticket($NewTicket);

echo 'alert Ticket Creado exitosamente  ';

?>