<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
require_once 'views/navbar.php';	
?>	
<script>

GetAplicaciones();
GetEstanques();
GetSirecor();
GetMilesight();
GetUnidadIndefinida();
GetBodega();
GetSensorHumedadMilesight();
// hilo	
var myRefreshEstanque = setInterval(GetAplicaciones, 1000);
var myRefreshEstanque = setInterval(GetEstanques, 1000);
var myRefreshSirecor = setInterval(GetSirecor, 1000);
var myRefreshMilesight = setInterval(GetMilesight, 1000);
var myRefreshUnidadIndefinida = setInterval(GetUnidadIndefinida, 1000);
var myRefreshGetBodega = setInterval(GetBodega, 1000);
var myRefreshGetSensorHumedadMilesight = setInterval(GetSensorHumedadMilesight, 1000);		

//Funciones

//GetEstanques
function GetAplicaciones() 
	{
    	var URL = "ApiController/GetAplicaciones.php"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetAplicacionesResult").innerHTML= result;}    
		});	
	}

//GetEstanques
function GetEstanques() 
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=Estanque7600"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetEstanqueResult").innerHTML= result;}    
		});	
	}
//GetSirecor	
function GetSirecor() 
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=Sirecor7600"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetSirecorResult").innerHTML= result;}    
		});
	}
//GetMilesight	
function GetMilesight() 
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=Milesight"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetMilesightResult").innerHTML= result;}    
		});
	}
//GetMilesight	
function GetUnidadIndefinida() 
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo="
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request 
		    success: function(result){document.getElementById("GetUnidadIndefinidaResult").innerHTML= result;}    
		});
	}
//GetSensorHumedadMilesight	
function GetSensorHumedadMilesight() 
	{
    	var URL = "ApiController/GetUnidad.php?unidadtipo=SensorHumedadMilesight"
		$.ajax({
            url:URL,    //the page containing php script
            type: "get",    //request
		    success: function(result){document.getElementById("GetSensorHumedadMilesightResult").innerHTML= result;}    
		});
	}
//GetBodega
	
function GetBodega() 
	{
    	var URL = "ApiController/GetBodega.php"; 
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
		    success: function(result){document.getElementById("GetBodegaResult").innerHTML= result;}    
		});
	}

	jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

</script>
<body>

<?php

$tk= $_GET['tk'];
$jwtHelper = new JWT();
$decoded = $jwtHelper->decode($tk);
if ($decoded) {
    print_r($decoded); // Prints header and payload
echo '<br>
<div class="container">
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
	<div class="row">
		<H1>Unidad Bodega</H1>
		<div class="overflow-auto">
			<div id="GetBodegaResult"></div>
		</div>
	</div>
		<div class="row">
		<H1>Milesight Sensor Humedad</H1>
		<div class="overflow-auto">	
			<div id="GetSensorHumedadMilesightResult"></div>
		</div>
	</div>
</div>';
} else {
    echo "Invalid token.";
}

?>

</body>
</html>
