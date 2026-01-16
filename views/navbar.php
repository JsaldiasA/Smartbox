<?php

echo'

<script>
	
function myFunction() {
  var x = document.getElementById("RmyTopnav");
  if (x.className === "topnav-right") {
    x.className = "topnav";
  } else {
    x.className = "topnav-right";
  }
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>



<style>

	 
.subContainer {
	padding:0px 0px 20px 0px;
	width: 100%;
}
    body {
  background-color: #eeeeeeff;
    min-width: 450px; /* Or whatever minimum width you need */

}	 
  .container {
  background-color: white;
}	 
</style>
<style>
	
.navbar {
  background-color: #213A58 ;
}

</style>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
  <div class="m-1">
  <img src="../images/LogoPrincipal.png"  style="margin-left: 0px;width:80px;height:auto;">
  </div> 
  <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../main.php" >Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../UnidadVerRowData.php" >RowData</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../TicketInicio.php" >Tickets</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Repos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="https://github.com/JsaldiasA/EcoData">EcoData</a></li>
            <li><a class="dropdown-item" href="https://github.com/JsaldiasA/Smartbox">Smartbox</a></li>
            <li><a class="dropdown-item" href="https://github.com/infoECO3/repo-S2-1">Sirecor</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>





';

?>