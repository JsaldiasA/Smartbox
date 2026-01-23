<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

$CheckList_Id= $_GET['CheckList_Id'];

$Model = new Model() ;
// Create connection

$checklistDbEntity= $Model->checklistsWHERE('Id',$CheckList_Id)[0];

		//IMPRIMIMOS  cabecera de informacion con los datos de la unidad desde la tabla unidad
		$HtmlPage= '<div class="container">';// container cabecera de informacion	
		$HtmlPage=$HtmlPage. '<br><h1><b>CheckList</b></h1>';
		// IMPRIMIMOS TABLA CON LOS DATOS DE LA UNIDAD.
		$HtmlPage=$HtmlPage. '<table class="table">
		<tbody>';// Header tabla
		$HtmlPage=$HtmlPage. "<tr><td><b>ID:</b></td><td>". $checklistDbEntity-> Id . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Técnico responsable:</b></td><td>". $checklistDbEntity-> TecnicoResponsable . "</td></tr>";

		$checklistMotivo = $Model->CheckListMotivoById($checklistDbEntity-> id_checklistMotivo );
		
		$HtmlPage=$HtmlPage. "<tr><td><b>Motivo del checklist:</b></td><td>". $checklistMotivo-> Nombre . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Tipo de unidad: </b></td><td>". $checklistDbEntity-> id_unidadtipo . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Voltaje regulador de batería:</b></td><td>". $checklistDbEntity-> VoltajeReguladorBat . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Voltaje regulador de MCU:</b></td><td>". $checklistDbEntity-> VoltajeReguladorMCU . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Voltaje MCU:</b></td><td>". $checklistDbEntity-> VoltajeMCU . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>SmartBox:</b></td><td>". $checklistDbEntity-> SmartBox . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Envío SMS:</b></td><td>". $checklistDbEntity-> SMSenvio . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Recepción SMS:</b></td><td>". $checklistDbEntity-> SMSrecibo . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Solenoide:</b></td><td>". $checklistDbEntity-> Solenoide . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Flujómetro:</b></td><td>". $checklistDbEntity-> Flujometro . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Sensor nivel bajo:</b></td><td>". $checklistDbEntity-> SensorNivelBajo . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Sensor nivel alto:</b></td><td>". $checklistDbEntity-> SensorNivelAlto . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Voltaje de la batería:</b></td><td>". $checklistDbEntity-> VoltajeBateria . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Medidor de batería:</b></td><td>". $checklistDbEntity-> BateriaTest . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Toolbox</b></td><td>". $checklistDbEntity->Toolbox . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b> Conduit y Choco</b></td><td>". $checklistDbEntity->ConduitChoco . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Probado con agua</b></td><td>". $checklistDbEntity->agua . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><b>Observaciones:</b></td><td>". $checklistDbEntity-> Observaciones . "</td></tr>";
		$HtmlPage=$HtmlPage. "<tr><td><img src='". $checklistDbEntity-> URL_foto  ."' class='img-fluid' ></td></tr>";
		$HtmlPage=$HtmlPage. '</tbody></table>';
		$HtmlPage=$HtmlPage. '</div>';

		$Page->set_PageHTML($HtmlPage);
		echo $Page->get_PageHTML();
?>
</html>