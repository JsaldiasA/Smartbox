<!DOCTYPE html>
<html lang ="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';
require_once 'DbEntities/ticketDbEntity.php';
require_once 'DbEntities/ticket_priorityDbEntity.php';
require_once 'DbEntities/ticket_statusDbEntity.php';
require_once 'Model/model.php';

$Model = new Model();

$sql = "SELECT * FROM `ticket` WHERE `id`= {$ticket_id}";
$result = $Model->executeSQL($sql);

if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
			{
				$ticketDbEntity = new ticketDbEntity
					(
						$row["Id"],
						$row["Nombre"],
						$row["Ubicacion"],
						$row["Descripcion"],
						$row["Usuario"],
						$row["FechaInicio"],
						$row["FechaCierre"],
						$row["Id_TicketPriority"],
						$row["Id_TicketStatus"]
					);
			}
	}

echo '<div class="container">';
echo '<br><h1><b>Tickets</b></h1>';
echo '<table class="table"><tbody>';
echo "<tr><td><b>ID:</b></td><td>". $ticketDbEntity->get_Id(). "</td></tr>";
echo "<tr><td><b>Título:</b></td><td>". $ticketDbEntity->get_Nombre(). "</td></tr>";
echo "<tr><td><b>Ubicacion:</b></td><td>". $ticketDbEntity->get_Ubicacion(). "</td></tr>";
echo "<tr><td><b>Descripcion: </b></td><td>". $ticketDbEntity->get_Descripcion(). "</td></tr>";
echo "<tr><td><b>Usuario:</b></td><td>". $ticketDbEntity->get_Usuario(). "</td></tr>";
echo "<tr><td><b>Fecha de ingreso:</b></td><td>". $ticketDbEntity->get_FechaInicio(). "</td></tr>";
echo "<tr><td><b>Prioridad:</b></td><td>". $ticketDbEntity->get_Id_TicketPriority(). "</td></tr>";
echo "<tr><td><b>Estado de la solicitud:</b></td><td>". $ticketDbEntity->get_Id_TicketStatus(). "</td></tr>";
echo '</tbody></table>';
echo '</div>';
	
?>