class AppSmartbox
{

  constructor( ) {

    this.TicketPage = new TicketPage();
    this.RFVTicketPage = new RfvTicketPage();
    this.CuartelPage= new CuartelesPage();
  }

  async init()
  {
    await this.GenerateEventCenterNavbar();
    setInterval(this.GenerateEventCenterNavbar, 10000);
    GetMainCuarteles();

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
 

}






  

