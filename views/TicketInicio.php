<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath."/views/page.php";

$Page = new page();
$Model = $Page->get_Model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';

    $HtmlPage='

    <script src="/views/scripts/API.js"></script>
    <script src="/views/scripts/TicketInicio.js"></script>

    <div class="container">
         <div class="row">
            <div class="col">
                <br><h1><b>Tickets</b></h1><br>
            </div>
            <div class="col">
                <tr><td><b></b></td></tr>
            </div>
            <div class="col">
                <br><br><p class="text-end"><b>Ingresar nuevo ticket.  <b><a href="../TicketForm/TicketForm.php" class="btn btn-success" role="button"> + </a>
            </div>
        </div>
        <div id="main"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>
    </div>';


    $Page->set_PageHTML($HtmlPage);
    echo $Page->get_PageHTML();

    ?>