<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "7bp0c@81X";
$dbname = "sirecor";

$dat= $_GET['tag'];
$limit= 100;

$sql = "SELECT * FROM `rowdata` ORDER BY `id` DESC LIMIT 15";

$result = $conn->query($sql);

if ($result->num_rows > 0)
	{
    
		echo
			'<table id="TablaRegistros" class="table table-striped table-hover">
			<thead>
			<th scope="col">Id</th>
			<th scope="col">DateTime</th>
			<th scope="col">RowData</th>
			<th scope="col">IP</th>
			</thead>
			<tbody>';

    	while($row = $result->fetch_assoc()) 
			{
				echo '<tr"><td>'. $row["Id"] ." </td><td>" . $row["DateTime"] ."</td><td>" . $row["RowData"] ."</td><td>" . $row["IP"] ."</td></tr>";
			}
		
		echo '</tbody></table>';
	}
else
	{
    	echo "0x results";
	}

?>

<script>

$(document).ready(function ()
	{
    	$('#TablaRegistros').DataTable();
	});

</script>

<?php

$conn->close();

?>