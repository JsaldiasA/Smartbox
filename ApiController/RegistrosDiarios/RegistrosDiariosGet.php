<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new Model();

$Id_unidad= $_GET['Id_unidad'];

$return='';

if(isset($_GET['returnJson'])) 
{

  $returnJson = $_GET['returnJson'];
	
	if($returnJson == 1)
	{
    if(isset($_GET['limit'])) 
    { 
        $limit = $_GET['limit'];

      	$ArrayObj = $Model->MYSQLSelectWHERELIMIT('unidades_lastortolas','unidad_id',$Id_unidad,$limit);
        $return = json_encode( $ArrayObj );  
    } 
    else
    {
      $ArrayObj = $Model->MYSQLSelectWHERE('unidades_lastortolas','unidad_id',$Id_unidad);
        $return = json_encode( $ArrayObj );  
    } 
	}

}
else
{

     // TABLA REGISTROS DIARIOS
   $return=$return. '<table id="TablaRegistros" class="display"><thead><tr><th scope="col">ESTADO</th><th scope="col">VOLUMEN</th><th scope="col">CAUDAL</th><th scope="col">SENAL</th><th scope="col">BAT</th><th scope="col">FECHA</th></tr></thead><tbody>';
   $RegistrosDiarios = $Model->RegistrosDiariosById_unidad($Id_unidad);
   foreach ($RegistrosDiarios as $registro) {
       // output data of each row
       $return=$return. '<tr>  <td>'. $registro->ESTADO. "</td><td>" . $registro->VOLUMEN ."</td> <td>" . $registro->CAUDAL."</td> <td>" . $registro->SENAL ." </td><td>" . $registro->VOLTAJE ."%</td><td>" . $registro->DATETIME ."</td></tr>";
   }
   $return=$return. '</tbody></table>';

}




echo $return;

?>