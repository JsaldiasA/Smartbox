<!DOCTYPE html>
<html lang="en">
<?php



$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath.'/views/page.php';

$Page = new page();
$Model = $Page->get_Model();

$UnidadTag= $_GET['tag'];

$unidadDbEntity=$Model->MYSQLSelectWHERE('unidad','tag',$UnidadTag)[0];

$unidadTipo=$Model->MYSQLSelectWHERE('unidadtipo','Id',$unidadDbEntity->id_unidadTipo)[0];

$IsMilesight = $unidadTipo->IsMilesight == '1' ? true : false;
$IsEstanque = $unidadTipo->Id == '1' ? true : false;
$HtmlPage='';

$HtmlPage=$HtmlPage.'
<script>
		 var Id_unidad = "'. $unidadDbEntity->get_id().'";
		 var Tag_unidad= "'. $unidadDbEntity->get_tag().'";
</script>
<script src="/CheckListForm/scripts/CheckListForm.js"></script>

<div class="container">
	<div class="row">
		<div class="col m-3 p-3">	
			<br>
			<h1 class="display-2"><b>Checklist para </b>'. $unidadDbEntity->get_Ubicacion(). '</h1>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col m-3 p-3 border">
			<table class="table">
			<tbody>	
			<tr><td><b>IMEI:</b></td><td>'.$unidadDbEntity->get_tag().'</td><td></td></tr>
			<tr><td><b>ID de la unidad:</b></td><td>'. $unidadDbEntity->Id.'</td><td></td></tr>
			<tr><td><b>Tipo de unidad:</b></td><td>
			<select name="unidadtipo" class="form-select" id="unidadtipo" required>.';	

					$UnidadesTipos = $Model->MYSQLSelect('unidadtipo');
					foreach($UnidadesTipos as $Ut){ $HtmlPage=$HtmlPage.'<option value="'.$Ut->get_Id().'">'.$Ut->get_Nombre().'</option>'; }
			
			$HtmlPage=$HtmlPage.'</select>   </td><td></td></tr>
			<tr><td><b>Motivo del checklist:</b></td><td>
			<select name="ChecklistMotivo" class="form-select" id="ChecklistMotivo" required>';
				
				$checklistmotivos = $Model->MYSQLSelect('checklistmotivo');	
				foreach($checklistmotivos as $Cm){ $HtmlPage=$HtmlPage. '<option value="'.$Cm->get_Id().'">'.$Cm->get_Nombre().'</option>'; }
			
			$HtmlPage=$HtmlPage.'</select> </td><td></td></tr>
			<tr><td><b>Voltaje regulador de batería:</b></td><td><input type="text" class="form-control" id="VoltajeReguladorBat" placeholder="13.9-14.2 Pb 12.4-12.8 Li" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" '. ($IsMilesight ? 'disabled' : '').'></td><td>(V)</td></tr>
			<tr><td><b>Voltaje regulador de MCU:</b></td><td><input type="text" class="form-control" id="VoltajeReguladorMCU" placeholder="5-5.3" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" '. ($IsMilesight ? 'disabled' : '').'></td><td>(V)</td></tr>
			<tr><td><b>Voltaje MCU:</b></td><td><input type="text" class="form-control" id="VoltajeMCU" placeholder="3.3-4V" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" '. ($IsMilesight ? 'disabled' : '').'></td><td>(V)</td></tr>
			<tr><td><b>SmartBox:</b></td><td><input type="checkbox" class="form-check-input" id="SmartBox" '. ($IsMilesight ? 'disabled' : '').'></td><td></td></tr>
			<tr><td><b>Envío SMS:</b></td><td><input type="checkbox" class="form-check-input" id="SMSenvio" '. ($IsMilesight ? 'disabled' : '').'></td><td></td></tr>
			<tr><td><b>Recepción SMS:</b></td><td><input type="checkbox" class="form-check-input" id="SMSrecibo" '. ($IsMilesight ? 'disabled' : '').'></td><td></td></tr>
			<tr><td><b>Solenoide:</b></td><td><input type="checkbox" class="form-check-input" id="Solenoide"></td><td></td></tr>
			<tr><td><b>Flujómetro:</b></td><td><input type="checkbox" class="form-check-input" id="Flujometro"></td><td></td></tr>
			<tr><td><b>Sensor nivel bajo:</b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelBajo" '. ($IsEstanque ? 'disabled' : '').'></td><td></td></tr>
			<tr><td><b>Sensor nivel alto:</b></td><td><input type="checkbox" class="form-check-input" id="SensorNivelAlto" '. ($IsEstanque ? 'disabled' : '').'></td><td></td></tr>
			<tr><td><b>Voltaje de la batería:</b></td><td><input type="text" class="form-control" id="VoltajeBateria" placeholder="12-15V" pattern="[0-9]{1,}|[0-9]{1,}[.][0-9]{1,}" title="Solo ingresar numeros" '. ($IsMilesight ? 'disabled' : '').'></td><td>(V)</td></tr>
			<tr><td><b>Medidor de batería:</b></td><td><input type="checkbox" class="form-check-input" id="BateriaTest" disabled></td><td></td></tr>
			<tr><td><b>Toolbox:</b></td><td><input type="checkbox" class="form-check-input" id="Toolbox" '. (!$IsMilesight ? 'disabled' : '').'></td><td></td></tr>
			<tr><td><b>Conduit y Choco:</b></td><td><input type="checkbox" class="form-check-input" id="ConduitChoco" ></td><td></td></tr>
			<tr><td><b>Probado con agua:</b></td><td><input type="checkbox" class="form-check-input" id="agua" ></td><td></td></tr>
			<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, col m-3 p-3oque OK."></td><td></td></tr>
			<tr><td><b>Técnico responsable:</b></td><td><input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre"></td><td></td></tr>
			<tr><td><b>Imagen:</b></td><td><div id="NombreDeFoto"></div></td><td></td></tr>
			</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col m-3 p-3" >
			<input id="sortpicture" type="file" name="sortpic" />
		</div>

		<div class="col m-3 p-3" >
			<button id="upload" class="btn btn-success btn-lg" onclick="uploadPicture()" >Subir Foto</button>
		</div>
		
		<div class="col m-3 p-3" >
			<button type="button" class="btn btn-success btn-lg" onclick="FunctionNuevoCheckListPost()">Enviar CheckList</button>
		</div>
	</div>
	
</div>
</body>

</html>

';



$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

?>