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

function FunctionNuevoTicketPost()
{
	let text = "¿Está seguro de publicar el ticket?";
	if (confirm(text) == true)
		{
			let pattern = /(^\d+\.\d+$)|(^\d+$)/;
			var URL = "NuevoTicketPost.php";
			var Respuesta;

	  		var Ubicacion= document.getElementById("Ubicacion").value;
			if (Ubicacion == "")
				{
					return alert ("Debe especificar un dispositivo o plataforma.");
				}

			var Descripcion= document.getElementById("Descripcion").value;
			if (Descripcion == "" )
				{
					return alert ("Debe explicar de que se trata el problema.");
				}

			var Usuario= document.getElementById("Usuario").value;
			if (Usuario == "" )
				{
					return alert ("Debe escribir su nombre.");
				}

			$.ajax({
            url:URL,
            type:"post",
			dataType:'text',
			data:
				{
					Nombre: Nombre,
					Ubicacion: Ubicacion,
					Descripcion: Descripcion,
					Usuario: Usuario,
					FechaApertura: FechaApertura,
					Id_TicketStatus: Id_TicketStatus,
        		},
			success: function(result)
				{
					alert (result)
				}
			});
			window.location.href = "https://smartbox.eco3.cl/";
  		}
	else
		{
    		alert ("La operación se ha cancelado.");
  		}
}

</script>
	<div class="container">
		<div class="row">
			<div class="col">	
				<br><h1 class="display-2"><b>Nuevo formulario</b><?php echo $UnidadTag;?></h1><br>
			</div>
		</div>
	<div class="row">
	<div class="col border">
	<table class="table">
		<tbody>
			<tr><td><b>1:</b></td><td><input type="text" class="form-control" id="Título:" placeholder=""></td><td></td></tr>
			<tr><td><b>2:</b></td><td><input type="text" class="form-control" id="Ubicación:" placeholder="Dispositivo y/o plataforma."></td><td></td></tr>
			<tr><td><b>3:</b></td><td><input type="text" class="form-control" id="Descripción:" placeholder=""></td><td></td></tr>
			<tr><td><b>4:</b></td><td><input type="text" class="form-control" id="Usuario:" placeholder=""></td><td></td></tr>
		</tbody>
	</table>
	</div>
	</div>
	<div class="row">
		<div class="col" >
			<button type="button" class="btn btn-primary btn-lg" onclick="FunctionNuevoTicketPost()">Enviar ticket</button>
		</div>
	</div>
</body>
</html>