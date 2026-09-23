class AppSmartbox
{

  constructor( ) {

    this.TicketPage = new TicketPage();
    this.RFVTicketPage = new RfvTicketPage();
    this.CuartelesPage= new CuartelesPage();
    this.LoginController = new LoginController();
    this.EventCenterPage = new EventCenterPage();
    this.ChecklistPage = new ChecklistPage();
    this.GenerateEventCenterNavbar_IntervalId = 0;
  }

  async init()
  {

    this.navbar();
    
    await this.GenerateEventCenterNavbar();
    this.GenerateEventCenterNavbar_IntervalId = setInterval(this.GenerateEventCenterNavbar, 10000);
    await this.LoginController.checkToken();
    setInterval(this.LoginController.checkToken, 15000);

    this.CuartelesPage.GetMain();

  }

  async   GenerateEventCenterNavbar()
  {
  
      await appModel.RefresheventMessage();

      let unCheckedMessageQty = appModel.eventMessage.filter(Msg => Msg.checked =='0').length;

      if( unCheckedMessageQty > 0)
      {
        document.getElementById('EventCenterNavbar').innerHTML = ` EventCenter <span class="badge badge-danger" style=" background-color: red ; ">${unCheckedMessageQty}</span>`;
      }
      else
      {
        document.getElementById('EventCenterNavbar').innerHTML = ` EventCenter `;
      }
    }



  navbar( )
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
          <a class="nav-link custom-hover-btn"  href="url" onclick="ThisApp.CuartelesPage.GetMain();return false;" >Cuarteles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="ThisApp.TicketPage.GetMain();return false;" >Tickets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="ThisApp.RFVTicketPage.GetMain();return false;" >RFVTickets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="ThisApp.ChecklistPage.GetMain();return false;" >Checklist</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="ThisApp.GetMainSprint();return false;" >Sprint</a>
        </li>
            <li class="nav-item">
          <a class="nav-link custom-hover-btn" href="url" onclick="ThisApp.EventCenterPage.GetMain(); return false;" ><div id="EventCenterNavbar"></div></a>
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



  GetMainSprint(  )
	{	
		RefreshIntervals_Ids.forEach(interval_ID => {

		 clearInterval(interval_ID)

		});	


		 document.getElementById('main').innerHTML = `    <div class="container">
        <div class="row pb-3">
            <div class="col p-3 card shadow p-3 card shadow">
              <iframe src="https://docs.google.com/spreadsheets/d/1u6N9Kf1icpXGGutgmdJMsdKN_3U7vZC-/edit?usp=sharing&ouid=108650448787646658808&rtpof=true&sd=true" width="100%" height="1000">
                </iframe>
            </div>        
        </div>
    </div>`;

	}

}


  

