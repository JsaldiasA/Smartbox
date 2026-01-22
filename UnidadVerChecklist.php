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
require_once 'Model/model.php';

$Model = new Model() ;
// Create connection

$checklistDbEntity= $Model->checklistsWHERE('Id',$CheckList_Id)[0];

		//IMPRIMIMOS  cabecera de informacion con los datos de la unidad desde la tabla unidad
		echo '<div class="container">';// container cabecera de informacion	
		echo '<br><h1><b>CheckList</b></h1>';
		// IMPRIMIMOS TABLA CON LOS DATOS DE LA UNIDAD.
		echo '<table class="table">
		<tbody>';// Header tabla
		echo "<tr><td><b>ID:</b></td><td>". $checklistDbEntity-> Id . "</td></tr>";
		echo "<tr><td><b>Técnico responsable:</b></td><td>". $checklistDbEntity-> TecnicoResponsable . "</td></tr>";
		$checklistMotivo = $Model->CheckListMotivoById($checklistDbEntity-> id_checklistMotivo );
		echo "<tr><td><b>Motivo del checklist:</b></td><td>". $checklistMotivo-> Nombre . "</td></tr>";
		echo "<tr><td><b>Tipo de unidad: </b></td><td>". $checklistDbEntity-> id_unidadtipo . "</td></tr>";
		echo "<tr><td><b>Voltaje regulador de batería:</b></td><td>". $checklistDbEntity-> VoltajeReguladorBat . "</td></tr>";
		echo "<tr><td><b>Voltaje regulador de MCU:</b></td><td>". $checklistDbEntity-> VoltajeReguladorMCU . "</td></tr>";
		echo "<tr><td><b>Voltaje MCU:</b></td><td>". $checklistDbEntity-> VoltajeMCU . "</td></tr>";
		echo "<tr><td><b>SmartBox:</b></td><td>". $checklistDbEntity-> SmartBox . "</td></tr>";
		echo "<tr><td><b>Envío SMS:</b></td><td>". $checklistDbEntity-> SMSenvio . "</td></tr>";
		echo "<tr><td><b>Recepción SMS:</b></td><td>". $checklistDbEntity-> SMSrecibo . "</td></tr>";
		echo "<tr><td><b>Solenoide:</b></td><td>". $checklistDbEntity-> Solenoide . "</td></tr>";
		echo "<tr><td><b>Flujómetro:</b></td><td>". $checklistDbEntity-> Flujometro . "</td></tr>";
		echo "<tr><td><b>Sensor nivel bajo:</b></td><td>". $checklistDbEntity-> SensorNivelBajo . "</td></tr>";
		echo "<tr><td><b>Sensor nivel alto:</b></td><td>". $checklistDbEntity-> SensorNivelAlto . "</td></tr>";
		echo "<tr><td><b>Voltaje de la batería:</b></td><td>". $checklistDbEntity-> VoltajeBateria . "</td></tr>";
		echo "<tr><td><b>Medidor de batería:</b></td><td>". $checklistDbEntity-> BateriaTest . "</td></tr>";
		echo "<tr><td><b>Observaciones:</b></td><td>". $checklistDbEntity-> Observaciones . "</td></tr>";
		echo "<tr><td><img src='". $checklistDbEntity-> URL_foto  ."' class='img-fluid' ></td></tr>";
		echo '</tbody></table>';
		echo '</div>';

?>
</body>
</html>