<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';



    $HtmlPage='

    <script src="/views/scripts/API.js"></script>
    <script src="/views/scripts/TicketInicio.js"></script>

    <div class="container">
        <div id="main"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>
    </div>';



            $Page->set_PageHTML($HtmlPage);
            echo $Page->get_PageHTML();

    ?>