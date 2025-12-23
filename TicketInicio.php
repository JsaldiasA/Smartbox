<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

'<div class="container text-center">';
  '<div class="row">';
    '<div class="col">';
echo '<br><h1><b>Tickets</b></h1>';
    '</div>';
    '<div class="col">';
echo "<tr><td><b>Columna 2.</b></td></tr>";
    '</div>';
    '<div class="col">';
echo "<tr><td><b>Columna 3.</b></td></tr>";
    '</div>';
  '</div>';
'</div>';

echo '<div class="container">';
// echo '<br><h1><b>Tickets</b></h1><br>';
echo '<div class="subContainer">';
echo '<a href="../TicketForm/TicketForm.php" class="btn btn-primary" role="button"> + </a> <b> Ingresar nuevo ticket.<b>';
echo '</div>';
echo '<table class="table"><tbody>';
echo "<tr><td><b>Página para visualizar los tickets.</b></td></tr>";
echo '</tbody></table>';
echo '</div>';

?>
</body>
</html>