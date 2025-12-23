<!DOCTYPE html>
<html lang="en">
<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/views/head.php";
require_once $sitebasepath."/views/navbar.php";
require_once $sitebasepath."/Model/model.php";

echo '<style>body{background-color: #191919; color: #FFFFFF}</style>';
echo '<style>.container{background-color: #292929;color: #FFFFFF;padding: 20px;border-radius: 8px;}</style>';

?>
<script>
	function FunctionNuevoTicketPost()
		{
			let text = "¿Está seguro de enviar el ticket?";
			if (confirm(text) == true)
				{
					let pattern = /(^\d+\.\d+$)|(^\d+$)/;
					var URL = "NuevoTicketPost.php";
					var Respuesta;

	  				var Ubicacion= document.getElementById("Ubicacion").value;
					if (Ubicacion == "")
						{
							return alert ("Debe especificar un dispositivo y/o plataforma.");
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

					$.ajax(
						{
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
						}
					);

					window.location.href = "https://smartbox.eco3.cl/";
  				}
			else
				{
    				alert ("La operación se ha cancelado.");
  				}
		}
</script>

<?php
	echo '<div class="container">';

		echo '<div class="row">';
			echo '<div class="col">';
				echo '<b><h1>Nuevo formulario: <br></h1></b>';
			echo '</div>';

		echo '<div class="row">';
			echo '<div class="col">';
				echo '<b>Asunto: </b>';
			echo '</div>';
			echo '<div class="col">';
				echo '<input type="text" class="form-control" id="Nombre">';
			echo '</div>';
		echo '</div>';

		echo '<div class="row">';
			echo '<div class="col">';
				echo '<b>Ubicación: </b>';
			echo '</div>';
			echo '<div class="col">';
				echo '<input type="text" class="form-control" id="Ubicacion" placeholder="Dispositivo y/o plataforma.">';
			echo '</div>';
		echo '</div>';

		echo '<div class="row">';
			echo '<div class="col">';
				echo '<b>Descripción: </b>';
			echo '</div>';
			echo '<div class="col">';
				echo '<input type="text" class="form-control" id="Descripcion">';
			echo '</div>';
		echo '</div>';

		echo '<div class="row">';
			echo '<div class="col">';
				echo '<b>Usuario: </b>';
			echo '</div>';
			echo '<div class="col">';
				echo '<input type="text" class="form-control" id="Usuario">';
			echo '</div>';
		echo '</div>';

	echo '</div>';
?>

 <div class="container">
	<div class="row">
	<div class="col border">
	<table class="table">
		<tbody>
			<tr><td><b>Asunto:</b></td><td><input type="text" class="form-control" id="Nombre" placeholder=""></td><td></td></tr>
			<tr><td><b>Ubicación:</b></td><td><input type="text" class="form-control" id="Ubicacion" placeholder="Dispositivo y/o plataforma."></td><td></td></tr>
			<tr><td><b>Descripción:</b></td><td><input type="text" class="form-control" id="Descripcion" placeholder=""></td><td></td></tr>
			<tr><td><b>Usuario:</b></td><td><input type="text" class="form-control" id="Usuario" placeholder=""></td><td></td></tr>
		</tbody>
	</table>
	</div>
	</div>
	<div class="row">
		<div class="col" >
			<button type="button" class="btn btn-success" onclick="FunctionNuevoTicketPost()">Enviar ticket</button>
		</div>
	</div>

</body>
</html>