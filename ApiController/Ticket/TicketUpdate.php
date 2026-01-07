<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$UpdateTicket = new ticketDbEntity();

$allKeys = array_keys((array)$UpdateTicket);

foreach ($allKeys as $key ) 
{
	$UpdateTicket->$key = $_POST[$key] ;
}

$model->update_ticket($UpdateTicket);

echo 'alert(Ticket Eliminado exitosamente)';
echo '<script>window.location.href = "https://smartbox.eco3.cl/ticketinicio.php"</script>';

?>