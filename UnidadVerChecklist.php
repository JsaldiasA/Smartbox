<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
require_once 'views/navbar.php';
?>	

	<!-- //Navigation -->
<!-- SCRIPTS PARA editar panel -->

	
	
<?php

	
$CheckList_Id= $_GET['CheckList_Id'];

require_once 'DbEntities/unidadDbEntity.php';
require_once 'DbEntities/checklistDbEntity.php';
require_once 'config/DbSirecorConfig.php';
require_once 'Model/model.php';

$Model = new Model();		
// Create connection

$sql = "SELECT * FROM `checklist` WHERE `id`= {$CheckList_Id}";
$result = $Model->executeSQL($sql);
$HasChecklist = true;	
	
if ($result->num_rows > 0) {
	
	while($row = $result->fetch_assoc()) 
	{
	    $checklistDbEntity= new checklistDbEntity($row["Id"],
$row["VoltajeReguladorBat"],
$row["VoltajeReguladorMCU"],
$row["SmartBox"],
$row["SMSenvio"],
$row["SMSrecibo"],
$row["Flujometro"],
$row["Solenoide"],
$row["SensorNivelBajo"],
$row["SensorNivelAlto"],
$row["VoltajeMCU"],
$row["BateriaTest"],
$row["id_checklistMotivo"],
$row["Observaciones"],
$row["id_unidadtipo"],
$row["URL_foto"],
$row["id_unidad"],
$row["Fecha"],
$row["TecnicoResponsable"]												 );
//cuidado con el casing, distinge de mayusculas y minusculas
	}
} 
else 
{ $HasChecklist = false;}
	

if( $HasChecklist == true)
{   
//IMPRIMIMOS  cabecera de informacion con los datos de la unidad desde la tabla unidad
	echo '<div class="container">';// container cabecera de informacion	
	echo '<br><h1><b>CheckList</b></h1>';
	
// IMPRIMIMOS TABLA CON LOS DATOS DE LA UNIDAD.
		echo '<table class="table">
		<tbody>';// Header tabla
		

		echo "<tr><td><b>Id </b></td><td>". $checklistDbEntity->get_Id(). "</td></tr>";
		echo "<tr><td><b>VoltajeReguladorBat </b></td><td>". $checklistDbEntity->get_VoltajeReguladorBat(). "</td></tr>";
		echo "<tr><td><b>VoltajeReguladorMCU </b></td><td>". $checklistDbEntity->get_VoltajeReguladorMCU(). "</td></tr>";
		echo "<tr><td><b>SmartBox </b></td><td>". $checklistDbEntity->get_SmartBox(). "</td></tr>";
		echo "<tr><td><b>SMSenvio </b></td><td>". $checklistDbEntity->get_SMSenvio(). "</td></tr>";
		echo "<tr><td><b>SMSrecibo </b></td><td>". $checklistDbEntity->get_SMSrecibo(). "</td></tr>";
		echo "<tr><td><b>Flujometro </b></td><td>". $checklistDbEntity->get_Flujometro(). "</td></tr>";
		echo "<tr><td><b>Solenoide </b></td><td>". $checklistDbEntity->get_Solenoide(). "</td></tr>";
		echo "<tr><td><b>SensorNivelBajo </b></td><td>". $checklistDbEntity->get_SensorNivelBajo(). "</td></tr>";
		echo "<tr><td><b>SensorNivelAlto </b></td><td>". $checklistDbEntity->get_SensorNivelAlto(). "</td></tr>";
		echo "<tr><td><b>VoltajeMCU </b></td><td>". $checklistDbEntity->get_VoltajeMCU(). "</td></tr>";
		echo "<tr><td><b>BateriaTest </b></td><td>". $checklistDbEntity->get_BateriaTest(). "</td></tr>";
		$checklistMotivo = $Model->CheckListMotivoById($checklistDbEntity->get_id_checklistMotivo());
		echo "<tr><td><b>checklistMotivo </b></td><td>". $checklistMotivo->get_Nombre(). "</td></tr>";
		echo "<tr><td><b>Observaciones </b></td><td>". $checklistDbEntity->get_Observaciones(). "</td></tr>";
		echo "<tr><td><b>id_unidadtipo </b></td><td>". $checklistDbEntity->get_id_unidadtipo(). "</td></tr>";
		echo "<tr><td><b>TecnicoResponsable </b></td><td>". $checklistDbEntity->get_TecnicoResponsable(). "</td></tr>";
		echo    "<tr><td><img src='". $checklistDbEntity->get_URL_foto() ."' class='img-fluid' ></td></tr>";
		echo '</tbody></table>';
	
		
		echo '</div>';
	
	}	
	else {echo '<h1>checklist no encontrado</h1>';}

?>


	
<?php
// close sql connection
$conn->close();
?>



</body>
</html>
