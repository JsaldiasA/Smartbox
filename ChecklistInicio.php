<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

    $HtmlPage='

    <script src="/views/scripts/ChecklistInicio.js"></script>

    <div class="container">
        <div class="row">
            <div class="col">
                <br><h1><b>checklist</b></h1><br>
            </div>
            <div class="col">
                <div id="mainChecklist"><div>
            </div>
        </div>
    </div>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>