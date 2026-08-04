	navbar();
    
    function navbar( )
	{

      document.getElementById('navbar').innerHTML= `
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


.custom-hover-btn {
  color: #4981c7; 
  border: 2px solid transparent;
  border-radius: 4px; 
  padding: 0.5rem 1rem;
  transition: all 0.3s ease-in-out;

}

.custom-hover-btn:hover {
  color: #8fc2ff !important; 
  }

	
.navbar {
  background-color: #213A58 ;
--bs-emphasis-color: #fff;
  --bs-emphasis-color-rgb: 254,255,255;
}

</style>


<nav class="navbar navbar-expand-lg " >
  <div class="container-fluid">
  <div class="m-1">
  <img src="https://smartbox.eco3.cl/images/LogoPrincipal.png"  style="margin-left: 0px;width:80px;height:auto;">
  </div> 
  <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link custom-hover-btn"  href="url" onclick="GetMainCuarteles();return false;" >Cuarteles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="ThisApp.TicketPage.GetMain();return false;" >Tickets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="GetMainChecklist();return false;" >Checklist</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="GetMainSprint();return false;" >Sprint</a>
        </li>
            <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="GetMainEventCenter(); return false;" ><div id="EventCenterNavbar"></div></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle custom-hover-btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
`;

	}
