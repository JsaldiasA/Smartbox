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
</style>
<style>
	 
.topnav {
  overflow: hidden;
  background-color: #17202A ;
  vertical-align: middle;
}

.topnav a {
  float: left;
  display: block;
  text-align: center;
  padding: 14px 16px;
  font-size: 17px;
  color:#ABB2B9  ;
  text-shadow: 2px 2px 4px #000000;
  margin-top: 10px;
}

.topnav a:hover {;
  color: white;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}

.topnav .icon {
  display: none;
}

@media screen and (max-width: 800px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: left;
    display: block;
  }
}

@media screen and (max-width: 800px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
	clear: right;
	
  }
	 }
	 .topnav-right {
  float: right;
}
</style>
<div class="topnav" id="myTopnav">
  <a style="display: flex;justify-content: center;padding: 10px 10px;margin-top: 0px;">
  <div><img src="../images/Logocortado.png"  style="margin-left: 0px;width:55px;height:auto;"></div>
  <div><img src="../images/Logo letra.png"  style="margin-left: -5px;margin-right: 15px;margin-top: 5px;width:60px;height:auto;"></div></a>
  <div id="RmyTopnav" class="topnav-right">
  <a  href="../index.php" class="active">Home</a>
  <a  href="../UnidadVerRowData.php" class="active">RowData</a>
  <a  href="../OldVersion.php" class="active">OldVersion</a> 	
  <a  href="../Sirecor2.0/views/riego/index.php" class="active">Sirecor2.0<a> 	
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
  </div>  
  </div>
  </div>'


?>