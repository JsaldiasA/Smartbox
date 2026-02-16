<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();

$Id_unidad= $_POST['Id_unidad'];
$return='';
// TABLA REGISTROS DIARIOS

//$return=$return. '<script>let table = new DataTable("#TablaRegistros");</script>';
$return=$return. '<table id="TablaRegistros" class="display"><thead><tr><th scope="col">ESTADO</th><th scope="col">VOLUMEN</th><th scope="col">CAUDAL</th><th scope="col">SENAL</th><th scope="col">BAT</th><th scope="col">FECHA</th></tr></thead><tbody>';

$RegistrosDiarios = $Model->RegistrosDiariosById_unidad($Id_unidad);

foreach ($RegistrosDiarios as $registro) {
    // output data of each row

		$return=$return. '<tr>  <td>'. $registro->ESTADO. "</td><td>" . $registro->VOLUMEN ."</td> <td>" . $registro->CAUDAL."</td> <td>" . $registro->SENAL ." </td><td>" . $registro->VOLTAJE ."%</td><td>" . $registro->DATETIME ."</td></tr>";

}

$return=$return. '</tbody></table>';
//$return=$return. "<script>
//$(document).ready(function(){
//$('#TablaRegistros').dataTable();
//});
//</script>";

echo $return;

?>