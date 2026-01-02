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
  <div>
    <img src="../images/LogoPrincipal.png"  style="margin-left: 0px;width:55px;height:auto;">
  </div>
  <div id="RmyTopnav" class="topnav-right">
    <a  href="../main.php" >Home</a>
    <a  href="../UnidadVerRowData.php" >RowData</a>
    <a  href="../TicketInicio.php" >Tickets</a>
    <a  href="../Sirecor2.0/views/riego/index.php" >Docs<a>
  </div>
</div>
';

?>