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

                    <div id="mainChecklist"></div>
  
  
    </div>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>