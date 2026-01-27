<!DOCTYPE html>
<html lang = "en">
<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/views/head.php";
require_once $sitebasepath."/views/navbar.php";
require_once $sitebasepath."/Model/model.php";

$Model = new Model();

$Id_checklist = $_GET['Id_checklist'];

$checklist = $Model->MYSQLSelectWHERE('Checklist', 'Id', $Id_checklist)[0];				
$unidadDbEntity = $Model->MYSQLSelectWHERE('unidad','Id',$checklist->id_unidad)[0];
?>

<script src="/CheckListForm/scripts/CheckListForm.js"></script>
<script>
document.getElementById("SmartBox").checked =       <?php echo "'".$checklist->SmartBox."'";?> 		;
document.getElementById("Solenoide").checked =      <?php echo 	"'".$checklist->Solenoide."'";?>	;
document.getElementById("Flujometro").checked =     <?php echo 	"'".$checklist->Flujometro."'";?>	;
document.getElementById("ConduitChoco").checked =   <?php echo "'".$checklist->ConduitChoco."'";?>	;
document.getElementById("agua").checked = 			<?php echo "'".$checklist->agua."'";?>			;
</script>
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
			<tr><td><b>Ubicacion:</b></td><td><?php echo $unidadDbEntity->get_Ubicacion();?></td><td></td></tr>
			<tr><td><b>SmartBox:</b></td><td><input type="checkbox" class="form-check-input" id="SmartBox" ></td><td></td></tr>
			<tr><td><b>Solenoide:</b></td><td><input type="checkbox" class="form-check-input" id="Solenoide"></td><td></td></tr>
			<tr><td><b>Flujómetro:</b></td><td><input type="checkbox" class="form-check-input" id="Flujometro"></td><td></td></tr>
			<tr><td><b>Conduit y Choco:</b></td><td><input type="checkbox" class="form-check-input" id="ConduitChoco" ></td><td></td></tr>
			<tr><td><b>Probado con agua:</b></td><td><input type="checkbox" class="form-check-input" id="agua" ></td><td></td></tr>
			<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, col m-3 p-3oque OK." value = <?php echo "'".$checklist->Observaciones."'";?>></td><td></td></tr>
			</tbody>
			</table>
		</div>
	</div>
	<div class="row">
			<div class="col">
				<button type="button" class="btn btn-success" onclick="FunctionUpdateChecklistPost( <?php echo '\''.$checklist->Id.'\'';?>)">Enviar ticket</button>
			</div>
		</div>	
</div>
</body>

</html>

?>