<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';


    $HtmlPage='
 <body >	
 <div class="container p-3 " style="max-width: 800px;">
    <div class="row" > 
    <div class="col m-3" >
    
    <p class="h1 m-3">Guia de usuario</p>

    <ul class="list-unstyled m-3">
    <li class="m-3"><p class="h2 m-3" > Indice </p>
        <ul>
            <li class="m-1" ><a href="#T1">T1 Modo de la unidad <a/></li>
            <li class="m-1" ><a href="#T2">T2 Accionamiento <a/></li>
            <li class="m-1" ><a href="#T3">T3 Comandos SMS Sirecor <a/></li>
            <li class="m-1" ><a href="#T4">T4 Registros iniciacion <a/></li>
            <li class="m-1" ><a href="#T5">T5 Tipos Unidades <a/></li>
            <li class="m-1" ><a href="#T6">T6 Alertas <a/></li>
        </ul>
    </li>
    </ul>

    </div> </div> 

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T1" >T1 Modo de la unidad </p>
        <p class="m-3" style="white-space: pre-line;">

        Las unidades sirecor desde la version 4.6s es posible controlarlas desde internet. Para ver la version actual de la unidad vea  <a href="#T1"> T4 Registros iniciacion <a/>. 
        La Unidad funciona de manera asincrona,cuando la caja envia un mensaje recibe como respuesta el mensaje de control. 
        
        Modo riego off 

        La Frecuencia en la cual la caja envia mensajes es de 5 minutos, si queremos abrir la caja tenemos que esperar al lo mas 5 minitos para que la caja envie el mensaje. Cuando la caja esta abierta la frecuencia automaticamente se cambia a 1 minuto.
        
        Frecuencia de mensajes: 5 minutos cuando esta off, 1 minuto cuando esta on
        Recomendable: durante jornada normal.

        Modo riego On 

        Para tener una respuesta mas instantanea para regar, podemos cambiar la caja a modo riego, la frecuencia de mensajes sera siempre 1 min.
        
        Frecuencia de mensajes: 1 minuto cuando esta off, 1 minuto cuando esta on
        Recomendable: durante dia de riego.

        Modo standby 

        Debido a que las unidades tienen un maximo de 30 mb de trafico y una frecuencia de mensajes alta consume mas energia, es convieniente que se baje a 1 hora. 

        Frecuencia de mensajes: 60 minutos cuando esta off, 1 minuto cuando esta on
        Recomendable: durante fin de semana, noche, horarios no habiles y festivos.

        IMPORTANTE, asegurase de cambiar el modo antes de empezar la jormanda, de lo contrario habra que esperar todo un ciclo para poder abrir un punto. Desactive el modo riego para ahorar energia y bateria.
        


        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T2" >T2 Accionamiento </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T3" >T3 Comandos SMS Sirecor </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T4" >T4 Registros iniciacion </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T5" >T5 Tipos Unidades </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T6" >T6 Alertas </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>
 
 </div>
 </body>
';

       

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>