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
    <li class="m-3">Indice<br>
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
        
        <p class="h2 m-3" id="T1" >T4 Registros iniciacion </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T1" >T5 Tipos Unidades </p>
        <p class="m-3" style="white-space: pre-line;">

        </p>

        </div>
    </div>

    <div class="row" > 
        <div class="col m-3" >
        
        <p class="h2 m-3" id="T1" >T6 Alertas </p>
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