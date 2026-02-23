<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

    $HtmlPage='

    <script src="/views/scripts/ChecklistInicio.js"></script>

    <div class="container">
        <div class="row pb-3">
            <div class="col p-3 card shadow p-3 card shadow">
                <h2><b>Estado General</b></h2> 
                <div class="overflow-auto">
                    <div id="TableEstadoGeneral"></div>
                </div>
            </div>        
            </div>
        </div>

        <div class="row pb-3">
            <div class="col p-3 card shadow ">
                 <h2><b>Sector Z3</b></h2> 
                 <div class="overflow-auto">
                    <div id="mainChecklistZ3"></div>
                </div>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col p-3 card shadow">
                 <h2><b>Sector Z1</b></h2> 
                <div class="overflow-auto">
                    <div id="mainChecklistZ1"></div>
                </div>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col p-3 card shadow">
                 <h2><b>Sector Z2</b></h2> 
                <div class="overflow-auto">
                    <div id="mainChecklistZ2"></div>
                </div>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col p-3 card shadow">
                 <h2><b>Sector Z4</b></h2> 
                <div class="overflow-auto">
                    <div id="mainChecklistZ4"></div>
                </div>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col p-3 card shadow">
                 <h2><b>Sector Fase 2</b></h2> 
                <div class="overflow-auto">
                    <div id="mainChecklistFASE2"></div>
                </div>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col p-3 card shadow">
                 <h2><b>Estanques</b></h2> 
                <div class="overflow-auto">                 
                    <div id="mainChecklistEstanques"></div>
                </div>
            </div>
        </div>
    </div>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>