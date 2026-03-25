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
echo '<div class="row p-3">';
echo '<div class="col p-3"><h1><b>Ticket '. $ticket->get_Nombre().' </b></h1> </div>
  <div class="col p-3 d-flex justify-content-end"> <a href="/TicketForm/TicketFormUpdate.php?id_ticket='.$ticket->get_Id().'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg></<button></div>
</div>';
echo '<table class="table"><tbody>';
echo "<tr><td><b>ID:</b></td><td>". $ticket->get_Id(). "</td></tr>";
echo "<tr><td><b>Título:</b></td><td>". $ticket->get_Nombre(). "</td></tr>";
echo "<tr><td><b>Descripcion: </b></td><td>". $ticket->get_Descripcion(). "</td></tr>";
echo "<tr><td><b>Usuario:</b></td><td>". $ticket->get_Usuario(). "</td></tr>";
echo "<tr><td><b>Fecha de ingreso:</b></td><td>". $ticket->get_FechaInicio(). "</td></tr>";
echo "<tr><td><b>Prioridad:</b></td><td>". $ticket->get_Id_TicketPriority(). "</td></tr>";
echo "<tr><td><b>Estado de la solicitud:</b></td><td>". $ticket->get_Id_TicketStatus(). "</td></tr>";
echo '</tbody></table>';
echo '<div class="row">';
 echo'<form action="/ApiController/ticket/TicketDelete.php" method="POST">
  
  <input type="hidden" name="id_ticket" value="'.$ticket->get_Id().'" />
  
  <button class="btn btn-danger" type="submit">Cerrar Ticket</button>
</form>';
echo '</div>';
	
?>