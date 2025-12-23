<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

echo '<div class="container">';
echo '<br><h1><b>Tickets</b></h1><br>';
echo '<div class="subContainer">';
echo '<button onclick="<a  href="../TicketForm/TicketForm.php" >" class="btn btn-info"> + </button> <b> Ingresar ticket.<b>';
echo '</div>';
echo '<table class="table"><tbody>';
echo "<tr><td><b>Página para visualizar los tickets.</b></td></tr>";
echo '</tbody></table>';
echo '</div>';

?>
</body>
</html>