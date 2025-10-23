<!doctype html>
<html lang="en">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<head>
    <meta charset="utf-8">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
 </head>
  <body>
<script>
//var myVar = setInterval(create, 10000);


function RU() {
    var URL = "bdconsulta.php"; 
    
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
            data:  { 
				    name: document.getElementById("in").value, 
					limit: document.getElementById("lin").value,
				    uni: document.getElementById("myCheckRU").checked
			        },
		    success: function(result){document.getElementById("dm").innerHTML= result;}
            
	});
	
                   }
function UR() {
    var URL = "BD2.php"; 
    
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
            data:  { 
				   
			        },
		    success: function(result){document.getElementById("dm").innerHTML= result;}
            
	});
	
                   }
	function RE() {
    var URL = "BD3.php"; 

	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
            data:  { 
				    name: document.getElementById("mySelect").value,
				    limit: document.getElementById("lin3").value,
				    proto: document.getElementById("myCheck").checked,
			        },
		    success: function(result){document.getElementById("dm").innerHTML= result;}
            
	});
	
                   }
function CRD() {
    var URL = "BD4.php"; 
    
	$.ajax({
            url:URL,    //the page containing php script
            type: "post",    //request 
            //data:  { 
					//limit: document.getElementById("lin3").value
			  //      },
		    success: function(result){document.getElementById("dm").innerHTML= result;}
            
	});
	
                   }
	function myOpcionesRU() {
  var y= document.getElementById('acciones').value
  var x = document.getElementById(y);
  
  		
		
  if (x.style.display === "none") {
    x.style.display = "inline";
  } else {
    x.style.display = "none";
  }

	}
	
function funcion() {
  var y= document.getElementById('acciones').value;
  switch(y) {
  case "RU":
		  RU();
    break;
  case "UR":
         UR(); 
    break;
  case "RE":
         RE(); 
    break;
  case "CRD":
         CRD(); 
    break;
  default:
    window.alert("no existe la funcion");
}
	}
	
</script>

<H2>ECO3 plataforma</H2>

	

	
<div id="demos"></div>
<div  id="Cnt" style="padding:20px;">
	<div class="input-group mb-3" >
	<div class="input-group-prepend">
    <button onclick="funcion()" class="btn btn-outline-secondary" type="button">Consultar</button>
  	</div>
	<select class="custom-select" id="acciones" onclick="myOpcionesRU()" >
	  <option value="RU" >Registros de unidades</option>
	  <option value="UR">Unidades registradas</option>
	  <option value="RE">Registro de eventos</option>
	  <option value="CRD">Cantidad registros diarios</option>
	</select>
	</div>	
<div id="RU" style="display:inline;">	
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text" id="">Busqueda</span>
  </div>
  <input type="text" id="in" name="in" class="form-control">
  <div class="input-group-prepend">
   <span class="input-group-text" id="">Cantidad registros</span>
  </div>
  <input type="text" class="form-control" id="lin" name="lin">
</div>
<div class="form-check form-switch mt2">
  <input class="form-check-input" type="checkbox" id="myCheckRU" checked>
  <label class="form-check-label" for="flexSwitchCheckChecked">Cuartel unico</label>
</div>
</div>
	<div id="UR" style="display:none;">
	
		</div>
	</div>
	<div id="RE" style="display:none;">
			<textarea id="lin3" name="lin3" rows="1" cols="3">10</textarea>
		<select id="mySelect">
			<option value="CT">ACT</option>
			<option value="NI">INI</option>
			</select>
		Prototipo <input type="checkbox" id="myCheck">
	</div>
	<div id="CRD" style="display:none;">
	</div>
</div>
<div id="dm"></div>

  


  </body>
</html>
