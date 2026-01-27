<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

$CheckList_Id= $_GET['CheckList_Id'];

$Model = new Model() ;
// Create connection

$checklistDbEntity= $Model->MYSQLSelectWHERE('checklist','Id',$CheckList_Id)[0];

		//IMPRIMIMOS  cabecera de informacion con los datos de la unidad desde la tabla unidad
		$HtmlPage= '<div class="container">';// container cabecera de informacion	
		$HtmlPage=$HtmlPage. '<br><h1><b>CheckList</b></h1>';
		$HtmlPage=$HtmlPage.  '<div class="row p-3">';
		$HtmlPage=$HtmlPage.  '<div class="col p-3"><h1><b>ID :'. $checklistDbEntity->Id.' </b></h1> </div>
		<div class="col p-3 d-flex justify-content-end"> <a href="/checklistForm/checklistFromUpdate.php?Id_checklist='.$checklistDbEntity->Id.'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
		<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
		<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
		</svg></<button></div>
		</div>';
		// IMPRIMIMOS TABLA CON LOS DATOS DE LA UNIDAD.
	
		$HtmlPage=$HtmlPage. '<table class="table">
		<tbody>';// Header tabla
		
		$HtmlPage=$HtmlPage. "<tr><td><b>Técnico responsable:</b></td><td>". $checklistDbEntity-> TecnicoResponsable . "</td></tr>";

		$checklistMotivo = $Model->MYSQLSelectWHERE('checklistmotivo','Id',$checklistDbEntity-> id_checklistMotivo)[0] ;

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