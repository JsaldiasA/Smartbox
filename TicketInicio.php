<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

//echo
//    '<style>body{background-color: #191919; color: #FFFFFF}</style>
//        <style>.container{background-color: #292929;color: #FFFFFF; padding: 20px; border-radius: 8px;}</style>';


    $HtmlPage='
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
            <th scope="col">Cuertel</th>
            <th scope="col">FechaInicio</th>
            <th scope="col"></th>
	        </thead>
	        <tbody>';

            $tickets = $Model->get_ticket();
            $cuarteles = $Model->MYSQLSelect('cuarteles');

            $cuartelAsociado;

            foreach( $tickets as $ticket )
            {   

                foreach( $cuarteles as $cuartel)
                {
                    if( $cuartel->Id_unidad != null )
                    {
                        if( $cuartel->Id_unidad == $ticket->Id_unidad)
                        {
                            $cuartelAsociado =  $cuartel ;
                        } 
                    } 
                }    

                $ticketstatus = $Model->ticketStatusById( $ticket->get_Id_TicketStatus() );

                $HtmlPage = $HtmlPage. "<tr>";
                $HtmlPage = $HtmlPage. "<td>". $ticket->get_Id() ."</td>"; 
                $HtmlPage = $HtmlPage. "<td>". ( $cuartelAsociado == null ? 'sin cuartel' : $cuartelAsociado->Name )."</td>"; 
                $HtmlPage = $HtmlPage. "<td>". $ticket->get_Nombre() ."</td>";
                $HtmlPage = $HtmlPage. "<td>". $ticket->get_FechaInicio() ."</td>";
                $HtmlPage = $HtmlPage. "<td>". $ticketstatus->get_Descripcion() ."</td>";
                $HtmlPage = $HtmlPage. "<td> <a href='Ticketver.php?id_ticket=".$ticket->get_Id()."'>Ver</a></td></tr>";
                $HtmlPage = $HtmlPage. "</tr>";

                $cuartelAsociado = null;

            }

            $HtmlPage = $HtmlPage.'</tbody></table>
                                    </div>
                                    </div>';

            $Page->set_PageHTML($HtmlPage);
            echo $Page->get_PageHTML();

    ?>