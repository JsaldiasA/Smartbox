<!DOCTYPE html>
<html lang="en">
<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/views/head.php";
require_once $sitebasepath."/views/navbar.php";
require_once $sitebasepath."/Model/model.php";

?>

<script>

	function FunctionNuevoCheckListPost() {
  let text = "¿Está seguro de enviar el CheckList?";
  if (confirm(text) == true) { 
	  
	let pattern = /(^\d+\.\d+$)|(^\d+$)/; 
	var URL = "NuevoCheckListPost.php"; 
	var Respuesta;
	  
	var Observaciones= document.getElementById("Observaciones").value;
	if(Observaciones == "" ){ return alert("Observaciones no puede estar vacío, coloque alguna observación. Si no tiene coloque OK");}  

	var TecnicoResponsable= document.getElementById("TecnicoResponsable").value;
	if(TecnicoResponsable == "" ){ return alert("Técnico responsable no puede estar vacío, coloque su nombre.");}
	  
  
	 
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
			dataType: 'text',
			data: {
			Observaciones: Observaciones,
			TecnicoResponsable: TecnicoResponsable, 
        	},
		    success: function(result){alert(result)}    
		  });

	window.location.href = "https://smartbox.eco3.cl/";
  	} else {
    	alert("La operación se ha cancelado.");
  	}
	}
	
</script>

	<!-- //Navigation -->
<!-- SCRIPTS PARA editar panel -->


<div class="container">
	<div class="row">
	<div class="col">	
	<br>
	<h1 class="display-2"><b>Checklist para </b><?php echo $UnidadTag;?></h1>
	<br>
	</div>
	</div>
	<div class="row">
	<div class="col border">
	<table class="table">
	<tbody>	

	<tr><td><b>Observaciones:</b></td><td><input type="text" class="form-control" id="Observaciones" placeholder="Si no tiene comentarios, coloque OK."></td><td></td></tr>
	<tr><td><b>Técnico responsable:</b></td><td><input type="text" class="form-control" id="TecnicoResponsable" placeholder="Nombre"></td><td></td></tr>
			</tbody></table>
		</div>
	</div>
				<div class="row">
				<div class="col" >
	<button type="button" class="btn btn-primary btn-lg" onclick="FunctionNuevoCheckListPost()">Enviar Ticket</button>
	</div>
</div>
</body>
</html>