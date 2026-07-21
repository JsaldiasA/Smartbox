
class Model
{

	constructor( ) {
    
    this.init();

  }

  async init()
  {
    let [ Zonas, Cuarteles, eventMessage,UltimosRegistros, Unidades,Checklists,ChecklistsNew,eventMessagesTypes,Tickets,TicketStatus,UnidadTipo] = await Promise.all([GetZonas(),GetCuarteles(),GetEventMessages(),GetUltimosRegistros(),GetUnidades(), GetChecklists(), GetChecklistsNew(), GetEventMessagesType(),GetTicket(),GetTicketStatus(),GetUnidaTipo()]);

		this.Zonas =Zonas;		
		this.Cuarteles = Cuarteles;
		this.eventMessage		= eventMessage;
		this.UltimosRegistros = UltimosRegistros;
		this.Unidades =  Unidades;
    this.Checklists = Checklists;	
    this.ChecklistsNew = ChecklistsNew;	
    this.eventMessagesTypes = eventMessagesTypes;	
    this.Tickets = Tickets;
    this.TicketStatus = TicketStatus;
    this.UnidadTipo = UnidadTipo;
  }

  async RefresheventMessage()
  {
	let eventMessage = await GetEventMessages();
	this.eventMessage	= eventMessage;
  }

  async  RefreshUltimosRegistros()
  {
	let UltimosRegistros = await GetUltimosRegistros();
	this.UltimosRegistros	= UltimosRegistros;
  }

   async RefreshUnidades()
  {
	let Unidades = await GetUnidades();
	this.Unidades	= Unidades;
  }

  async  RefreshCuarteles()
  {
	let Cuarteles = await GetCuarteles();
	this.Cuarteles	= Cuarteles;
  }

   async RefreshZonas()
  {
	let Zonas = await GetZonas();
	this.Zonas	= Zonas;
  }

}
	DivLoadingState('main');
 globalThis.RefreshIntervals_Ids = [];
 globalThis.appModel = new Model(); 

async function  GenerateEventCenterNavbar()
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
await GenerateEventCenterNavbar();
setInterval(GenerateEventCenterNavbar, 10000);

GetMainCuarteles();






