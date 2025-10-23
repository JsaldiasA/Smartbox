<?php

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$dat= $_POST['name'];
$limit= $_POST['limit'];
//echo $dat;
//$dat= "ACK10";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

 $sql = "SELECT `UNIDAD`, COUNT(*) FROM `unidades_lastortolas` WHERE `FECHA`=CURRENT_DATE-1 GROUP BY `UNIDAD` ORDER BY `UNIDAD` DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	echo '<table class="table table-dark table-striped table-hover"><thead><th scope="col">unidad</th><th scope="col">COUNT(*)</th></thead><tbody>';
    while($row = $result->fetch_assoc()) {
	$columna=$row["COUNT(*)"];
	if (($columna< 32) or($columna> 50) ){echo "<tr class='table table-warning  table-hover'>  <td>". $row["UNIDAD"]. "</td> <td>". $columna. "</td> <td>";}
     else{   echo "<tr>  <td>". $row["UNIDAD"]. "</td> <td>". $columna. "</td> <td>";}
		}
echo '</tbody></table>';
} else {
    echo "0 results";
}


$conn->close();
?>