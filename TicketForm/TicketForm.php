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

					var Nombre = document.getElementById("Nombre").value;
					if (Nombre == "")
						{
							return alert ("Debe especificar un dispositivo y/o plataforma.");
						}

	  				var Ubicacion = document.getElementById("Ubicacion").value;
					if (Ubicacion == "")
						{
							return alert ("Debe especificar un dispositivo y/o plataforma.");
						}

					var Descripcion = document.getElementById("Descripcion").value;
					if (Descripcion == "" )
						{
							return alert ("Debe explicar de que se trata el problema.");
						}

					var Usuario = document.getElementById("Usuario").value;
					if (Usuario == "" )
						{
							return alert ("Debe escribir su nombre.");
						}
					var f = document.getElementById("cuartel");
					var Id_unidad = f.options[f.selectedIndex].value; 	

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
									Id_unidad: Id_unidad,
        						},
							success: function(result)
								{
									alert (result);
									window.location.href = "https://smartbox.eco3.cl/TicketInicio.php";
								}
						});

					
  				}
			else
				{
    				alert ("La operación se ha cancelado.");
  				}
		}

</script>

<?php

	echo
		'<div class="container">
			<div class="row">
				<div class="col">
					<b><h1>Nuevo formulario: <br></h1></b>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col">
					<b>Asunto: </b>
				</div>
				<div class="col">
					<input type="text" class="form-control" id="Nombre"><br>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<b>Ubicación: </b>
				</div>
				<div class="col">
					<input type="text" class="form-control" id="Ubicacion" placeholder="Dispositivo y/o plataforma."><br>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<b>cuartel: </b>
				</div>
			<div class="col">
			<select name="cuartel" class="form-select" id="cuartel" required>.';	

					$Unidades = $Model->get_unidades();
					foreach($Unidades as $uni){ echo '<option value="'.$uni->Id.'">'.$uni->Ubicacion.'</option>'; }
			
				echo '</select>
				<br>  
				</div>
			</div>

			<div class="row">
				<div class="col">
					<b>Descripción: </b>
				</div>
				<div class="col">
					<input type="text" class="form-control" style="height: 200px; width: 100%" id="Descripcion" placeholder="Describa la situación."><br>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<b>Usuario: </b>
				</div>
				<div class="col">
					<input type="text" class="form-control" id="Usuario" placeholder="Escriba su nombre."><br>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<button type="button" class="btn btn-success" onclick="FunctionNuevoTicketPost()">Enviar ticket</button>
				</div>
			</div>
		</div>';

?>