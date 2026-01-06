<!DOCTYPE html>
<html lang ="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';
require_once 'Model/model.php';

$Model = new Model();

$id_ticket = $_GET['id_ticket'];

$ticket = $Model->ticketById($id_ticket);

echo '<div class="container">';
echo '<br><h1><b>Ticket '. $ticket->get_Nombre().' </b></h1>';
echo '<table class="table"><tbody>';
echo "<tr><td><b>ID:</b></td><td>". $ticket->get_Id(). "</td></tr>";
echo "<tr><td><b>Título:</b></td><td>". $ticket->get_Nombre(). "</td></tr>";
echo "<tr><td><b>Ubicacion:</b></td><td>". $ticket->get_Ubicacion(). "</td></tr>";
echo "<tr><td><b>Descripcion: </b></td><td>". $ticket->get_Descripcion(). "</td></tr>";
echo "<tr><td><b>Usuario:</b></td><td>". $ticket->get_Usuario(). "</td></tr>";
echo "<tr><td><b>Fecha de ingreso:</b></td><td>". $ticket->get_FechaInicio(). "</td></tr>";
echo "<tr><td><b>Prioridad:</b></td><td>". $ticket->get_Id_TicketPriority(). "</td></tr>";
echo "<tr><td><b>Estado de la solicitud:</b></td><td>". $ticket->get_Id_TicketStatus(). "</td></tr>";
echo '</tbody></table>';
echo '<divclass="row">';
 echo'<form action="/ApiController/ticket/delete.php" method="POST">
  
  <input type="hidden" name="id_ticket" value="'.$ticket->get_Id().'" />
  
  <button class="btn btn-danger" type="submit">Eliminar</button>
</form>';
echo '</div>';
	
?>