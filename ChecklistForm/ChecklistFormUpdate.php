<!DOCTYPE html>
<html lang = "en">
<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/views/head.php";
require_once $sitebasepath."/views/navbar.php";
require_once $sitebasepath."/Model/model.php";

echo '<style>body{background-color: #191919; color: #FFFFFF}</style>
		<style>.container{background-color: #292929;color: #FFFFFF;padding: 20px;border-radius: 8px;}</style>';

$Model = new Model();

$Id_checklist = $_GET['Id_checklist'];

$checklist = $Model->MYSQLSelectWHERE('Checklist', 'Id', $Id_checklist)[0];				

?>

<script src="/CheckListForm/scripts/CheckListForm.js"></script>

<div class="container">
	<div class="row">
		<div class="col m-3 p-3">	
			<br>
			<h1 class="display-3"><b>Editar Checklist (ID) </b><?php echo $checklist->Id;?></h1>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col m-3 p-3 border">
			<table class="table">
			<tbody>	
			<tr><td><b>IMEI:</b></td><td><?php echo $unidadDbEntity->get_tag();?></td><td></td></tr>
			<tr><td><b>ID de la unidad:</b></td><td><?php echo $unidadDbEntity->get_id();?></td><td></td></tr>
			<tr><td><b>Tipo de unidad:</b></td><td>
			<select name="unidadtipo" class="form-select" id="unidadtipo" required>	
				<?php
					$UnidadesTipos = $Model->get_unidadtipos();
					foreach($UnidadesTipos as $Ut){ echo '<option value="'.$Ut->get_Id().'">'.$Ut->get_Nombre().'</option>'; }
				?>		
			</select>   </td><td></td></tr>
			<tr><td><b>Motivo del checklist:</b></td><td>
			<select name="ChecklistMotivo" class="form-select" id="ChecklistMotivo" required>
				<?php
				$checklistmotivos = $Model->MYSQLSelect('checklistmotivo');	
				foreach($checklistmotivos as $Cm){ echo '<option value="'.$Cm->get_Id().'">'.$Cm->get_Nombre().'</option>'; }?>
			</select> </td><td></td></tr>
			<tr><td><b>Voltaje regulador de batería:</b></td><td><input type="text" class="form-control" id="VoltajeReguladorBat" placeholder="13.9-14.2 Pb 12.4-12.8 Li" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" disabled></td><td>(V)</td></tr>
			<tr><td><b>Voltaje regulador de MCU:</b></td><td><input type="text" class="form-control" id="VoltajeReguladorMCU" placeholder="5-5.3" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" disabled></td><td>(V)</td></tr>
			<tr><td><b>Voltaje MCU:</b></td><td><input type="text" class="form-control" id="VoltajeMCU" placeholder="3.3-4V" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" disabled></td><td>(V)</td></tr>
			<tr><td><b>SmartBox:</b></td><td><input type="checkbox" class="form-check-input" id="SmartBox" ></td><td></td></tr>
			<tr><td><b>Envío SMS:</b></td><td><input type="checkbox" class="form-check-input" id="SMSenvio" ></td><td></td></tr>
			<tr><td><b>Recepción SMS:</b></td><td><input type="checkbox" class="form-check-input" id="SMSrecibo" ></td><td></td></tr>
			<tr><td><b>Solenoide:</b></td><td><input type="checkbox" class="form-check-input" id="Solenoide"></td><td></td></tr>
			<tr><td><b>Flujómetro:</b></td><td><input type="checkbox" class="form-check-input" id="Flujometro"></td><td></td></tr>
			<tr><td><b>Sensor nivel bajo:</b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelBajo"></td><td></td></tr>
			<tr><td><b>Sensor nivel alto:</b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelAlto" ></td><td></td></tr>
			<tr><td><b>Voltaje de la batería:</b></td><td><input type="text" class="form-control" id="VoltajeBateria" placeholder="12-15V" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" disabled></td><td>(V)</td></tr>
			<tr><td><b>Medidor de batería:</b></td><td><input type="checkbox" class="form-check-input" id="BateriaTest" ></td><td></td></tr>
			<tr><td><b>Toolbox:</b></td><td><input type="checkbox" class="form-check-input" id="Toolbox" ></td><td></td></tr>
			<tr><td><b>Conduit y Choco:</b></td><td><input type="checkbox" class="form-check-input" id="ConduitChoco" ></td><td></td></tr>
			<tr><td><b>Probado con agua:</b></td><td><input type="checkbox" class="form-check-input" id="agua" ></td><td></td></tr>
			<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, col m-3 p-3oque OK."></td><td></td></tr>
			<tr><td><b>Técnico responsable:</b></td><td><input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre"></td><td></td></tr>
			</tbody>
			</table>
		</div>
	</div>	
</div>
</body>

</html>

?>