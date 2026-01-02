<?php

echo

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
}	 
  .container {
  background-color: white;
}	 
</style>
<style>
	 
.topnav {
  overflow: hidden;
  background-color: #213A58 ;
  vertical-align: middle;
}

.topnav a {
  float: left;
  display: block;
  text-align: center;
  font-size: 17px;
  color:#ABB2B9  ;
  text-shadow: 2px 2px 4px #000000;
}

.topnav a:hover {;
  color: white;
}


</style>
<div class="topnav" id="myTopnav">
  <div class="row">
    <div class="col">
      
    </div>
    <div class="col">
    <a  href="../main.php" >Home</a>
    </div>
    <div class="col">
    </div>
    <a  href="../UnidadVerRowData.php" >RowData</a>
    </div>
    <div class="col">
    <a  href="../TicketInicio.php" >Tickets</a>
    </div>
    <div class="col">  
    <a  href="../Sirecor2.0/views/riego/index.php" >Docs<a>
    </div>
  </div>
</div>


<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
  <img src="../images/LogoPrincipal.png"  style="margin-left: 0px;width:100px;height:auto;">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a  href="../main.php" >Home</a>
        </li>
        <li class="nav-item">
          <a  href="../UnidadVerRowData.php" >RowData</a>
        </li>
        <li class="nav-item">
          <a  href="../TicketInicio.php" >Tickets</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown link
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>





';

?>