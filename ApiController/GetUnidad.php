<?php

require_once 'BatteryLevel.php';

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$unidadTipo_Nombre= $_GET['unidadtipo'] ;

$unidadestipo =$model->get_unidadtipos();

$UnidadTipoFound = NULL;

foreach ($unidadestipo as $unidadtipo)
{
		if($unidadtipo->get_Nombre() == $unidadTipo_Nombre)
		{
			$UnidadTipoFound = $unidadtipo;
		} 
}
$UnidadesFiltradasPorTipo = [];
$IsNotMilesight = true;

$Unidades = $model->get_unidades();
$unidadTipoFound_id = is_null($UnidadTipoFound) ? NULL : $UnidadTipoFound->get_id();

if( is_null($UnidadTipoFound) )
{
	foreach ($Unidades as $unidad)
{
	
			$UnidadesFiltradasPorTipo [] = $unidad;
	

}
}
else{	
		foreach ($Unidades as $unidad)
		{
				if($unidad->get_Id_UnidadTipo() ==  $unidadTipoFound_id )
				{
					$UnidadesFiltradasPorTipo [] = $unidad;
				} 

		}

		if ($UnidadTipoFound->get_IsMilesight() == true)
		{
			$IsNotMilesight = false;
		}
		}

$isEstanque = false;

if ($unidadTipo_Nombre == 'Estanque7600')
{
    $isEstanque = true;
}
// Retornar valores como tabla
echo '<table class="table">
		<thead>
		<th scope="col">Serie</th>';
		echo $IsNotMilesight ? '<th scope="col">IMEI</th>' : '<th scope="col">DevEUI</th>' ;
		echo '<th scope="col">Ubicación</th>';
		echo $IsNotMilesight ? '<th scope="col">Número</th>' : '';
		echo '<th scope="col">ÚltimaActz</th>
		<th scope="col">Estado</th>
		<th scope="col">Batería</th>';
		echo !$isEstanque ? '<th scope="col">Volumen</th>' : ''; 
		echo '<th scope="col"></th>
		</thead>
		<tbody>';

foreach ($UnidadesFiltradasPorTipo as $unidad)
{
		$level = $unidad->get_BatNivel();
	    $BatNivel = new BatteryLevel($level);
		
		//print row
        echo "<tr>"; 
        echo "<td>".$unidad->get_Serie()."</td>";   
        echo "<td>". $unidad->get_Tag()."</td>";
        echo "<td>".$unidad->get_Ubicacion()."</td>";
        echo $IsNotMilesight ? "<td>".$unidad->get_Numero()."</td>" : "";
        echo "<td>".$unidad->get_UltimaActualizacion()."</td>";
        echo "<td>".$unidad->get_Estado()."</td>";
        echo "<td>".$BatNivel->get_HtmlTableField()."</td>";
        echo !$isEstanque ? "<td>".$unidad->get_Volumen()."</td>" : '';
    	echo "<td> <a href='unidadver.php?tag=".$unidad->get_Tag()."'>Ver</a></td></tr>";
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