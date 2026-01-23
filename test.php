 <?php
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

//$NewTicket->Id = '1';
//$NewTicket->Nombre = 'Nombre' ;
//$NewTicket->Ubicacion = 'Ubicacion' ;
//$NewTicket->Descripcion = 'Descripcion' ;
//$NewTicket->Usuario = 'Usuario' ;
//$NewTicket->FechaInicio = 'current_timestamp()';
//$NewTicket->FechaCierre = 'NULL';
//$NewTicket->Id_TicketPriority = '1';
//$NewTicket->Id_TicketStatus = '1';


//echo var_dump($model->smstounidadesById_unidadNotRecieved(406));

?>