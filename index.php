<!DOCTYPE html>
<html lang="en">
<?php
require_once 'views/head.php';	
require_once 'views/navbar.php';	
?>	
<script>
	
GetEstanques();
GetSirecor();
GetMilesight();
GetUnidadIndefinida();
GetBodega();
GetSensorHumedadMilesight();
// hilo	
var myRefreshEstanque = setInterval(GetEstanques, 1000);
var myRefreshSirecor = setInterval(GetSirecor, 1000);
var myRefreshMilesight = setInterval(GetMilesight, 1000);
var myRefreshUnidadIndefinida = setInterval(GetUnidadIndefinida, 1000);
var myRefreshGetBodega = setInterval(GetBodega, 1000);
var myRefreshGetSensorHumedadMilesight = setInterval(GetSensorHumedadMilesight, 1000);		

//Funciones
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
    	var URL = "ApiController/GetSirecor.php"; 
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
		    success: function(result){document.getElementById("GetSirecorResult").innerHTML= result;}    
		});
	}
//GetMilesight	
function GetMilesight() 
	{
    	var URL = "ApiController/GetMilesight.php"; 
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
		    success: function(result){document.getElementById("GetMilesightResult").innerHTML= result;}    
		});
	}
//GetMilesight	
function GetUnidadIndefinida() 
	{
    	var URL = "ApiController/GetUnidadIndefinida.php"; 
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
		    success: function(result){document.getElementById("GetUnidadIndefinidaResult").innerHTML= result;}    
		});
	}
//GetSensorHumedadMilesight	
function GetSensorHumedadMilesight() 
	{
    	var URL = "ApiController/GetSensorHumedadMilesight.php"; 
		$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
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
<br>
<div class="container">
	<div class="container">
		<H1>Estanques</H1>
		<div class="overflow-auto">
			<div id="GetEstanqueResult"></div>
		</div>
	</div>
	<div class="container">
		<H1>Sirecor</H1>
		<div class="overflow-auto">
			<div id="GetSirecorResult"></div>
		</div>
	</div>
	<div class="container">
		<H1>Milesight</H1>
		<div class="overflow-auto">
			<div id="GetMilesightResult"></div>
		</div>
	</div>
	<div class="container">
		<h1>Unidad Indefinida</H1>
		<div class="overflow-auto">
			<div id="GetUnidadIndefinidaResult"></div>
		</div>
	</div>
	<div class="container">
		<H1>Unidad Bodega</H1>
		<div class="overflow-auto">
			<div id="GetBodegaResult"></div>
		</div>
	</div>
		<div class="container">
		<H1>Milesight Sensor Humedad</H1>
		<div class="overflow-auto">	
			<div id="GetSensorHumedadMilesightResult"></div>
		</div>
	</div>
</div>
</body>
</html>
