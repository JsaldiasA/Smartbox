<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$Id_ticket= $_POST['id_ticket'];
$ticketToDelete= $model->ticketById($Id_ticket);
$result = $model->delete_ticket($ticketToDelete);


echo 'alert(Ticket Eliminado exitosamente)';
echo '<script>window.location.href = "https://smartbox.eco3.cl/ticketinicio.php"</script>';

?>