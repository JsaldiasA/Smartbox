<!DOCTYPE html>
<html lang ="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

echo
    '<style>body{background-color: #191919; color: #FFFFFF}</style>
        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';

echo
    '<div class="container">
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
    </div>';

?>