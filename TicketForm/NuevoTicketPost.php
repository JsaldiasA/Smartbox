<!DOCTYPE html>
<html lang = "en">
<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/Model/model.php";
$Model = new Model();

$Nombre = $_POST['Nombre'];
$Ubicacion = $_POST['Ubicacion'];
$Descripcion = $_POST['Descripcion'];
$Usuario = $_POST['Usuario'];

$sql = "INSERT INTO `ticket` (`Id`, `Nombre`, `Ubicacion`, `Descripcion`, `Usuario`, `FechaInicio`, `FechaCierre`, `Id_TicketPriority`, `Id_TicketStatus`) VALUES (NULL,'{$Nombre}','{$Ubicacion}','{$Descripcion}','{$Usuario}',current_timestamp(),NULL,1,1)";
$result = $Model->executeSQL($sql);
	
echo
	"El ticket se ha agregado correctamente: ".
	'Nombre: '.$Nombre.
	'Ubicacion: '.$Ubicacion.
	'Descripcion: '.$Descripcion.
	'Usuario: '.$Usuario;

?>