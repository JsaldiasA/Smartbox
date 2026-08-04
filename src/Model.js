class Model
{

  constructor( ) {
    this.init();
  }

  async init()
  {
    let [ Zonas, Cuarteles, eventMessage,UltimosRegistros, Unidades,Checklists,ChecklistsNew,eventMessagesTypes,Tickets,TicketStatus,RfvTickets,RfvTicketStatus,UnidadTipo,TicketPriorities] = await Promise.all([GetZonas(),GetCuarteles(),GetEventMessages(),GetUltimosRegistros(),GetUnidades(), GetChecklists(), GetChecklistsNew(), GetEventMessagesType(),GetTicket(),GetTicketStatus(),GetRfvTicket(),GetRfvTicketStatus(),GetUnidaTipo(), GetTicketPriority()]);

	this.Zonas = Zonas;		
	this.Cuarteles = Cuarteles;
	this.eventMessage		= eventMessage;
	this.UltimosRegistros = UltimosRegistros;
	this.Unidades =  Unidades;
    this.Checklists = Checklists;	
    this.ChecklistsNew = ChecklistsNew;	
    this.eventMessagesTypes = eventMessagesTypes;	
    this.Tickets = Tickets;
    this.TicketStatus = TicketStatus;
    this.RfvTickets = RfvTickets;
    this.RfvTicketStatus = RfvTicketStatus;
    this.UnidadTipo = UnidadTipo;
    this.TicketPriorities = TicketPriorities;

  }

    async RefreshTickets()
  {
	let Tickets = await GetTicket();
	this.Tickets	= Tickets;
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




  

