
async function getRiego(){
    try{
        let resp = await fetch ("https://sirecor.eco3.cl/controllers/riego.php?op=listregistros");
        json = await resp.json();
        if(json.status){
            let data = json.data;
            data.forEach((item) =>{
                let newtr = document.createElement("tr");
                newtr.id = "row_"+item.idriego;
                newtr.innerHTML =`<tr>
                                    <th scope="row">${item.idriego}</th>
                                    <td>${item.sector}</td>
                                    <td>${item.cuartel}</td>
                                    <td>${item.fecha}</td>
                                    <td>${item.volumen}</td>
                                    <td>${item.tipo}</td>
                                    <td>${item.mes}</td>
                                    <td>${item.anio}</td>
                                    <td>Options</td>`;
                document.querySelector("#tblBodyRiego").appendChild(newtr);
            });
            
        }
    }catch(err){
        console.log("Ocurrio un error"+err);
    }
}

getRiego();