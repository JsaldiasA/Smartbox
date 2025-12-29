<!DOCTYPE html>
<html lang ="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';

?>
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
        <div class="row">
    

            <table class="table">
	        <thead>
	        <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Ubicacion</th>
            <th scope="col">FechaInicio</th>
	        </thead>
	        <tbody>
            <?php  
            $tickets = $Model->get_ticket();

            foreach( $tickets as $ticket )
            {   
                echo "<tr>";
                echo "<td>".$ticket->get_Id()."</td>"; 
                echo "<td>". $ticket->get_Nombre()."</td>";
                echo "<td>". $ticket->get_Ubicacion()."</td>";
                echo "<td>". $ticket->get_FechaInicio()."</td>";
                echo "</tr>";
            }
            ?>
            </tbody></table>

        </div>
    </div>