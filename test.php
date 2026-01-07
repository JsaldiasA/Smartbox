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

$NewTicket=$model->get_ticket()[0];

$allKeys = array_keys((array)$NewTicket);
$NewTicket->Usuario = 'testUpdate' ;

 echo'<form action="/ApiController/ticket/TicketUpdate.php" method="POST">';
 
 foreach ($allKeys as $key ) 
{
	echo' <input type="hidden" name="'.$key.'" value="'.$NewTicket->$key.'" />';
}
 
  
  echo'<button class="btn btn-danger" type="submit">Update</button>
</form>';
//echo $model->create_ticket($NewTicket);

?>