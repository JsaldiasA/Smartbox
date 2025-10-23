<?php

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

$d= $_POST['name'];
$limit= $_POST['limit'];
$c=$_POST['proto'];
//echo $limit;
//$dat= "ACK10";
//echo $c;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if($c == "true"){
 $sql = "SELECT * FROM `eventos`  WHERE `TIPO` LIKE '%{$d}%' ORDER BY `TIMESTAMP` DESC LIMIT {$limit}";}
else{$sql = "SELECT * FROM `eventos`  WHERE `TIPO` LIKE '%{$d}%' AND `UNIDAD` NOT LIKE '%proto%' ORDER BY `TIMESTAMP` DESC LIMIT {$limit}";}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	echo '<table class="table table-dark table-striped table-hover"><thead><th scope="col">unidad</th><th scope="col">USUARIO1</th><th scope="col">USUARIO2</th><th scope="col">USUARIO3</th><th scope="col">USUARIO4</th><th scope="col">ADMIN</th><th scope="col">MANTENCION</th><th scope="col">LVOLTAJE</th><th scope="col">INV</th><th scope="col">VMAX</th><th scope="col">TIMESTAMP</th><th scope="col">TIPO</th></thead><tbody>';
    while($row = $result->fetch_assoc()) {
           echo "<tr>  <td>". $row["UNIDAD"]. "</td> <td>". $row["USUARIO1"]. "</td><td>" . $row["USUARIO2"] ."</td> <td>" . $row["USUARIO3"]."</td> <td>" . $row["USUARIO4"] ." </td><td>" . $row["ADMIN"] ."</td><td>" . $row["MANTENCION"] ."</td><td>" . $row["LVOLTAJE"] ."</td> <td>". $row["INV"] ."</td><td>" . $row["VOLUMEN MAX"] ."</td><td>" . $row["TIMESTAMP"] ."</td><td>" . $row["TIPO"] ."</td><td>" ;}
echo '</tbody></table>';
} else {
    echo "0 results";
}


$conn->close();
?>