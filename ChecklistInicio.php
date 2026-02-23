<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

    $HtmlPage='

    <script src="/views/scripts/ChecklistInicio.js"></script>

    <div class="container">
        <div class="row">
            <div class="col m-3">
                 <h1><b>checklist</b></h1> 
            </div>
         </div>
        <div class="row">
            <div class="col ">
                 <h2><b>Estado General</b></h2> 
            </div>
         </div> 
        <div class="row">
            <div class="col m-3">
               <div id="TableEstadoGeneral">
            </div>
        </div>

        <div class="row">
            <div class="col ">
                 <h2><b>Sector Z3</b></h2> 
            </div>
         </div>
        <div class="row">
            <div class="col  m-3 p-3 overflow-auto">

                <div id="mainChecklistZ3"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <h2><b>Sector Z1</b></h2> 
            </div>
         </div>
        <div class="row">
            <div class="col  m-3 p-3 overflow-auto">
                <div id="mainChecklistZ1"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <h2><b>Sector Z2</b></h2> 
            </div>
         </div>
        <div class="row">
            <div class="col  m-3 p-3 overflow-auto">
                <div id="mainChecklistZ2"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <h2><b>Sector Z4</b></h2> 
            </div>
         </div>
        <div class="row">
            <div class="col  m-3 p-3 overflow-auto">
                <div id="mainChecklistZ4"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <h2><b>Sector Fase 2</b></h2> 
            </div>
            </div>
        <div class="row">
            <div class="col  m-3 p-3 overflow-auto">
                <div id="mainChecklistFASE2"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                 <h2><b>Estanques</b></h2> 
            </div>
            </div>
        <div class="row">
            <div class="col  m-3 p-3 overflow-auto">
                <div id="mainChecklistEstanques"></div>
            </div>
        </div>
    </div>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>