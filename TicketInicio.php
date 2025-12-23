<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

echo '<style>body{background-color: #191919; color: #FFFFFF}</style>';
echo '<style>.container{background-color: #292929;color: #FFFFFF;padding: 20px;border-radius: 8px;}</style>';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col">';
echo '<br><h1><b>Tickets</b></h1><br>';
echo '</div>';
echo '<div class="col">';
echo '<tr><td><b></b></td></tr>';
echo '</div>';
echo '<div class="col">';
echo '<br><br><p class="text-end"><b>Ingresar nuevo ticket.  <b><a href="../TicketForm/TicketForm.php" class="btn btn-primary" role="button"> + </a>';
echo '</div>';
echo '</div>';
echo '</div>';

?>