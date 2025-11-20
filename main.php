<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
require_once 'views/navbar.php';	
$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require($sitebasepath.'/vendor/autoload.php');
require_once $sitebasepath."/helpers/JWT.php";
?>	
<script>

GetAplicaciones();
GetEstanques();
GetSirecor();
GetMilesight();
GetUnidadIndefinida();
// GetBodega();
// GetSensorHumedadMilesight();
// hilo
var myRefreshAplicaciones = setInterval(GetAplicaciones, 10000);
var myRefreshEstanque = setInterval(GetEstanques, 10000);
var myRefreshSirecor = setInterval(GetSirecor, 10000);
var myRefreshMilesight = setInterval(GetMilesight, 10000);
var myRefreshUnidadIndefinida = setInterval(GetUnidadIndefinida, 10000);
// var myRefreshGetBodega = setInterval(GetBodega, 1000);
// var myRefreshGetSensorHumedadMilesight = setInterval(GetSensorHumedadMilesight, 1000);

// Funciones

// GetEstanques
function GetAplicaciones()
	{
    	var URL = "ApiController/GetAplicaciones.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetAplicacionesResult").innerHTML= result;}
		});	
	}

// GetEstanques
function GetEstanques()
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=Estanque7600"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetEstanqueResult").innerHTML= result;}
		});	
	}
// GetSirecor	
function GetSirecor()
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=Sirecor7600"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetSirecorResult").innerHTML= result;}
		});
	}
// GetMilesight	
function GetMilesight()
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=Milesight"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetMilesightResult").innerHTML= result;}
		});
	}
// GetMilesight	
function GetUnidadIndefinida()
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo="
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetUnidadIndefinidaResult").innerHTML= result;}
		});
	}
/*// GetSensorHumedadMilesight
function GetSensorHumedadMilesight()
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=SensorHumedadMilesight"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request
		    success: function(result){document.getElementById("GetSensorHumedadMilesightResult").innerHTML= result;}
		});
	}
*/

</script>
<body>

<?php

//$tk= $_GET['tk'];
if (isset($_COOKIE['token'])) {
    $tk = $_COOKIE['token'];
} else {
    $tk = "";
} 

$jwtHelper = new JWT();
$decoded = $jwtHelper->decode($tk);



if ($decoded) {

echo var_dump($decoded)	;
echo $decoded["body"]["exp"];
$expTime = $decoded["body"]["exp"];
if ($$expTime< time()) {

	echo 'token expirado';
}
echo '
<div class="container">
<br>
	<div class="row">
		<H1>Aplicaciones</H1>
		<div class="overflow-auto">
			<div id="GetAplicacionesResult"></div>
		</div>
	</div>
	<div class="row">
		<H1>Estanques</H1>
		<div class="overflow-auto">
			<div id="GetEstanqueResult"></div>
		</div>
	</div>
	<div class="row">
		<H1>Sirecor</H1>
		<div class="overflow-auto">
			<div id="GetSirecorResult"></div>
		</div>
	</div>
	<div class="row">
		<H1>Milesight</H1>
		<div class="overflow-auto">
			<div id="GetMilesightResult"></div>
		</div>
	</div>
	<div class="row">
		<h1>Unidad Indefinida</H1>
		<div class="overflow-auto">
			<div id="GetUnidadIndefinidaResult"></div>
		</div>
	</div>
</div>';
} else {
    echo "Invalid token.";
}

?>

</body>
</html>