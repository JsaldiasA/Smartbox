<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/views/page.php";

$Page = new page();
$Model = $Page->get_Model();

    $HtmlPage='

    <script src="/views/scripts/CuartelesVer.js"></script>

    <div class="container" >

        <div class="row">
            <div class="col">
                <br><h1><b>Cuarteles</b></h1><br>
            </div>
            <div class="col">
                <tr><td><b></b></td></tr>
            </div>
            <div class="col">
                <br><br><p class="text-end"><b>Ingresar nuevo ticket.  <b><a href="../TicketForm/TicketForm.php" class="btn btn-success" role="button"> + </a>
            </div>
        </div>

        <div id="main">
        </div>

    </div>';    

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>