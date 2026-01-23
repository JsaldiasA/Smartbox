<?php

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();



$externalapps =$model->MYSQLSelect('externalapps_monitor');




// Retornar valores como tabla
echo '<table class="table">
		<thead>
		<th scope="col">AppName</th>';
		echo '<th scope="col">LastUpdate</th>
		<th scope="col">Estado</th>
		</thead>
		<tbody>';

foreach ($externalapps as $app)
{

		
		//print row
        echo "<tr>"; 
        echo "<td>".$app->get_AppName()."</td>";   
        echo "<td>". $app->DiffBetweenNow_and_LastUpdate()."</td>";
		echo ($app->DiffBetweenNow_and_LastUpdate() == "0 Min") ? '<td style="color: green;" >Conectado</td>' : '<td style="color: red;">Desconectado</td>';
	
}// columnas

    
	echo '</tbody></table>';


 /*
date_default_timezone_set('America/Santiago');

$FechaActual= date_create(date("Y-m-d H:i:s"));

if ($unidadTipo_Nombre == 'Estanque7600')
{
    $isEstanque = true;
}
else
{
    $isEstanque = false;
}

if ($result->num_rows > 0) {
    
	echo '<table class="table">
		<thead>
		<th scope="col">Nombre</th>
		<th scope="col">IMEI</th>
		<th scope="col">Ubicación</th>
		<th scope="col">Número</th>
		<th scope="col">ÚltimaActz</th>
		<th scope="col">Estado</th>
		<th scope="col">Batería</th>';

    if ($isEstanque == false)
    {
        echo '<th scope="col">Volumen</th>';
    }
    
    echo '<th scope="col"></th>
		</thead>
		<tbody>';
        // Header tabla
	
    // output data of each row 
	while($row = $result->fetch_assoc()) 
	{	
		//CALCULADO DIFF FECHA CON ACTUAL
		
		$FechaSQLrow= date_create($row["UltimaActualizacion"]);
		$UltimaAct= date_diff($FechaActual,$FechaSQLrow);
		if ($UltimaAct->format("%a")=="0")
		{	
			if ($UltimaAct->format("%h")=="0")
			{
				$UltimaActROW=$UltimaAct->format("%i Min");
			}
			else {$UltimaActROW=$UltimaAct->format("%h Horas");}
		}
		else {$UltimaActROW=$UltimaAct->format("%a Dias");}
		
		$level = $row["BatNivel"];
	    $BatNivel = new BatteryLevel($level);
		
		//print row
        echo "<tr> 
        <td>".$row["Nombre"]."</td>
        <td>".$row["tag"]."</td>
        <td>".$row["Ubicacion"]."</td>
        <td>".$row["numero"]."</td>
        <td>".$UltimaActROW."</td>
        <td>".$row["Estado"]."</td>
        <td>".$BatNivel->get_HtmlTableField()."</td>";

    if ($isEstanque == false)
    {
        echo
		"<td>".$row["Volumen"]."</td>";
    }
        echo
		"<td> <a href='unidadver.php?tag=".$row["tag"]."'>Ver</a></td></tr>";
	}
	echo '</tbody></table>';
} 
else 
{
    echo "0 results";
}
*/
?>