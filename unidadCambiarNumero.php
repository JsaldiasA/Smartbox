<?php
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$tag= $_POST['tag'];
$NuevoNumero= $_POST['NuevoNumero'];
$token= $_POST['token'];

if (strcmp($token,'eco3spa')==0)
{
	$sql = "UPDATE `unidad` SET `numero` = '{$NuevoNumero}' WHERE `tag` LIKE '{$tag}'";
	$result = $model->executeSQL($sql);
	echo "Cambio de número hecho correctamente. Nuevo número: ".$NuevoNumero;
}
else
{
	echo "Contraseña incorrecta.";
}
?>