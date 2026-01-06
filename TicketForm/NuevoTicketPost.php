<!DOCTYPE html>
<html lang = "en">
<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/Model/model.php";
$Model = new Model();

$NewTicket = new ticketDbEntity();

$NewTicket->$Id = '1';
$NewTicket->$Nombre = $_POST['Nombre'];
$NewTicket->$Ubicacion = $_POST['Ubicacion'];
$NewTicket->$Descripcion = $_POST['Descripcion'];
$NewTicket->$Usuario = $_POST['Usuario'];
$NewTicket->$FechaInicio = 'current_timestamp()';
$NewTicket->$FechaCierre = 'NULL';
$NewTicket->$Id_TicketPriority = '1';
$NewTicket->$Id_TicketStatus = '1';


//$sql = "INSERT INTO `ticket` (`Id`, `Nombre`, `Ubicacion`, `Descripcion`, `Usuario`, `FechaInicio`, `FechaCierre`, `Id_TicketPriority`, `Id_TicketStatus`) VALUES (NULL,'{$Nombre}','{$Ubicacion}','{$Descripcion}','{$Usuario}',current_timestamp(),NULL,1,1)";
//$result = $Model->executeSQL($sql);

$Model->create_ticket($NewTicket);

echo var_dump($NewTicket);

?>