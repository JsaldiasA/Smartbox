<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$UpdateTicket = new ticketDbEntity();

$allKeys = array_keys((array)$NewTicket);

foreach ($allKeys as $key ) 
{
	$UpdateTicket->$key = $_POST[$key] ;
}

//$ticketToDelete= $model->ticketById($Id_ticket);
//$result = $model->delete_ticket($ticketToDelete);

echo var_dump($UpdateTicket);
//echo 'alert(Ticket Eliminado exitosamente)';
//echo '<script>window.location.href = "https://smartbox.eco3.cl/ticketinicio.php"</script>';

?>