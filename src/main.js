async function  GenerateEventCenterNavbar()
{
    let [ eventMessage] = await Promise.all([GetEventMessages()]);

    let unCheckedMessageQty = eventMessage.filter(Msg => Msg.checked =='0').length;

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






