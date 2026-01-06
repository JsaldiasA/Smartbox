<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$Id_ticket= $_POST['id_ticket'];

$ticketToDelete= $Model->ticketById($id_ticket);

$result = $model->delete_ticket($ticketToDelete);
$rows = array();

echo '<script>window.location.href = "https://smartbox.eco3.cl/"</script>';d



?>