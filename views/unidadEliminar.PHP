<?php
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$tag= $_POST['tag'];
$token= $_POST['token'];



if (strcmp($token,'eco3spa')==0)
{
	$sql = "DELETE FROM `unidad` WHERE `tag` LIKE '{$tag}'";
	$result = $model->executeSQL($sql);

	echo "UNIDAD ELIMINADA ";
}
else
{
	echo "password Incorrecta";
}

?>