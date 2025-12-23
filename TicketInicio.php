<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col">';
echo '<br><h1><b>Tickets</b></h1>';
echo '</div>';
echo '<div class="col">';
echo '<tr><td><b>Columna 2.</b></td></tr>';
echo '</div>';
echo '<div class="col">';
echo '<br><br><b>Ingresar nuevo ticket. <b><a href="../TicketForm/TicketForm.php" class="btn btn-primary" role="button"> + </a>';
echo '</div>';
echo '</div>';
echo '</div>';

// echo '<div class="container">';
// echo '<br><h1><b>Tickets</b></h1><br>';
// echo '<div class="subContainer">';

echo '</div>';
echo '<table class="table"><tbody>';
echo "<tr><td><b>Página para visualizar los tickets.</b></td></tr>";
echo '</tbody></table>';
echo '</div>';

?>
</body>
</html>