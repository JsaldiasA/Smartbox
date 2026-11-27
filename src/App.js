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
    this.CheckToken_IntervalId = 0;

          // 1. Create the outer container
    const toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container position-fixed middle-0 top-0 p-1';
    toastContainer.id = 'toastContainer';
    document.body.appendChild(toastContainer);
  }

  async init()
  {
    this.navbar();
     this.InitFooter();
    await this.GenerateEventCenterNavbar();
    this.GenerateEventCenterNavbar_IntervalId = setInterval(this.GenerateEventCenterNavbar, 10000);
    await this.LoginController.checkToken();
    this.CheckToken_IntervalId = setInterval(this.LoginController.checkToken, 30000);
    this.CuartelesPage.GetMain();

  }

  InitFooter(){
    let footer = document.getElementById('footer');
    footer.className = "fixed-bottom bg-white text-dark p-1";
    
    setInterval(this.GetMqttBridgeApp, 5000);

  }

  async GetMqttBridgeApp(){
    
    appModel.RefreshExternalApps_monitor();
    let footer = document.getElementById('footer');
    let MqttBridgeApp = appModel.ExternalApps_monitor.find( App => App.Id == 2 );

    let now = new Date(new Date().toLocaleString('en', {timeZone: 'America/Santiago'}))
    let LastUpdateInMinutes =   Math.floor((now -  new Date( MqttBridgeApp.LastUpdate )) / 60000);

    if( LastUpdateInMinutes > 2  )
    {
      footer.className = "fixed-bottom bg-danger text-white p-1";
      footer.innerHTML= `Bridge DESCONECTADO <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>`;
    }
    else
    {
      footer.className = "fixed-bottom bg-light p-1 ";
      footer.innerHTML= `Bridge Online <i class="bi bi-check-circle-fill text-success fs-5"></i>`;
    }  

  }



  async   GenerateEventCenterNavbar()
  {
  
      await appModel.RefresheventMessage();

      let unCheckedMessageQty = appModel.eventMessage.filter(Msg => Msg.checked =='0').length;

      if( unCheckedMessageQty > 0)
      {
        const AppStartTime = new Date(sessionStorage.getItem("StartTime"));
        appModel.eventMessage.filter(e => ( (e.checked =='0') && ( new Date( e.CreationDate ) > AppStartTime ) )).forEach( e => { 

          const SendedToasts = JSON.parse(sessionStorage.getItem("SendedToasts"));
          if(  SendedToasts )
          {
            let SendedToast = SendedToasts.find( t => t.Id_eventMessage == e.Id );

            if(!SendedToast)
            {
              let eventMessageType =  appModel.eventMessageType.find( emt => emt.Id == e.Id_MessageType ); 
              let  Cuartel = appModel.Cuarteles.find( c => c.Id_unidad == e.Id_unidad ); 
              let  Unidad = appModel.Unidades.find( u => u.Id == e.Id_unidad );
              const ToastTitle = `Alerta ${eventMessageType.Name} en ` + ( Cuartel ? Cuartel.Name : (Unidad ? Unidad.tag : e.Id_unidad ) )  ;

              ThisApp.showToast( ToastTitle  , e.MessageText, e.CreationDate  )  ;
              SendedToasts.push({ Id_eventMessage: e.Id })
              sessionStorage.setItem("SendedToasts", JSON.stringify(SendedToasts));
            }
          }
          else {
            sessionStorage.setItem("SendedToasts", '[]');
          }
         });
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


  showToast( Titile, Body, smallContent) {

  let toastContainer = document.getElementById('toastContainer');

  // 2. Create the main toast wrapper
  const toastEl = document.createElement('div');
  toastEl.id = 'Toast';
  toastEl.className = 'toast';
  toastEl.setAttribute('role', 'alert');
  toastEl.setAttribute('aria-live', 'assertive');
  toastEl.setAttribute('aria-atomic', 'true');
  toastEl.setAttribute('data-bs-autohide', 'false');
  // 3. Create the toast header
  const toastHeader = document.createElement('div');
  toastHeader.className = 'toast-header';

  const img = document.createElement('img');
  img.src = '...'; // Replace with your actual image path
  img.className = 'rounded me-2';
  img.alt = '';

  const strong = document.createElement('strong');
  strong.className = 'me-auto';
  strong.textContent = Titile;

  const small = document.createElement('small');
  small.textContent = smallContent;

  const closeBtn = document.createElement('button');
  closeBtn.type = 'button';
  closeBtn.className = 'btn-close';
  closeBtn.setAttribute('data-bs-dismiss', 'toast');
  closeBtn.setAttribute('aria-label', 'Close');

  // Assemble the header
  toastHeader.append(img, strong, small, closeBtn);

  // 4. Create the toast body
  const toastBody = document.createElement('div');
  toastBody.className = 'toast-body';
  toastBody.textContent = Body;

  // 5. Assemble the full component and append to the body
  toastEl.append(toastHeader, toastBody);
  toastContainer.appendChild(toastEl);

  // 6. Initialize and show the Bootstrap toast
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastEl);
  toastBootstrap.show();

  // Optional: Remove from DOM after it hides to prevent duplicate IDs
  //toastEl.addEventListener('hidden.bs.toast', () => {
  //  toastEl.remove();
  // });
}

  GetMainSprint(  )
	{	
		RefreshIntervals_Ids.forEach(interval_ID => { clearInterval(interval_ID)	});	

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


  

