<?php
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$tag= $_POST['tag'];
$NuevaUbicacion= $_POST['NuevaUbicacion'];
$token= $_POST['token'];

if (strcmp($token,'eco3spa')==0)
{

	$sql = "UPDATE `unidad` SET `Ubicacion` = '{$NuevaUbicacion}' WHERE `tag` LIKE '{$tag}'";
	$result = $model->executeSQL($sql);
	
	echo "Cambio de ubicación hecho correctamente. Nueva ubicación: ".$NuevaUbicacion;
}
else
{
	echo "Contraseña incorrecta";
}
?>