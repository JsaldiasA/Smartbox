<?php
require_once 'BatteryLevel.php';

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$unidadTipo_Nombre= $_GET['unidadtipo'];

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
$Unidades = $model->get_unidades();
$unidadTipoFound_id = is_null($UnidadTipoFound) ? NULL : $UnidadTipoFound->get_id();

$IsMilesight = is_null($UnidadTipoFound) ? true : $UnidadTipoFound->get_IsMilesight();
$isEstanque = ($unidadTipo_Nombre == 'Estanque7600') ? true : false;

		foreach ($Unidades as $unidad)
		{
				if($unidad->get_Id_UnidadTipo() ==  $unidadTipoFound_id)
				{
					$UnidadesFiltradasPorTipo [] = $unidad;
				} 
		}

usort ($UnidadesFiltradasPorTipo, function($a, $b)
{
    if ($a->get_UltimaActualizacion() == $b->get_UltimaActualizacion())
	{
        return 0;
    }
    return ($a->get_UltimaActualizacion() > $b->get_UltimaActualizacion()) ? -1 : 1;
}
);

usort ($UnidadesFiltradasPorTipo, function($a, $b)
{
    if ($a->get_Volumen() == $b->get_Volumen())
	{
        return 0;
    }
    return ($a->get_Volumen() > $b->get_Volumen()) ? -1 : 1;
}
);

usort ($UnidadesFiltradasPorTipo, function($a, $b)
{
    if ($a->get_Estado() == $b->get_Estado())
	{
        return 0;
    }
    return ($a->get_Estado() > $b->get_Estado()) ? -1 : 1;
}
);

	// Retornar valores como tabla.
	echo '<table class="table text-nowrap">
	<thead>';
	
	echo $IsMilesight ? '<th scope="col">DevEUI</th>' : '<th scope="col">IMEI</th>';
	echo '<th scope="col"><i class="bi bi-pin-map"></i></th>';
	echo !$IsMilesight ? '<th scope="col"><i class="bi bi-activity"></i></th>' : '';
	echo '<th scope="col"></th>';
	echo '<th scope="col"></th>';
	echo !$isEstanque ? '<th scope="col">[L/m]</th>' : null;
	echo !$isEstanque ? '<th scope="col">[L]</th>' : null;
	echo '
	</thead>
	<tbody>';

	$RegistrosDiarios = [];
	$RegistrosDiarios = $model->get_UltimoRegistroDiarioDeCadaUnidad();


foreach ($UnidadesFiltradasPorTipo as $unidad)
{
	$level = $unidad->get_BatNivel();
	$BatNivel = new BatteryLevel($level);

	$ultimoRegistro = new unidades_lastortolasDbEntity();
	$ultimoRegistro->id = 0; // no unidad

	foreach ($RegistrosDiarios as $r)
		{
			if($r->unidad_id == $unidad->Id )
				{
					$ultimoRegistro = $r;
					break;
				}
		}

	// Print row.
    echo "<tr>";
    echo "<td> <a href='unidadver.php?tag=".$unidad->get_Tag()."'> ...". substr($unidad->get_Tag() ?? "NULL", -4)."</a> </td>";
    echo "<td>".$unidad->get_Ubicacion()."</td>";
    echo  !$IsMilesight ? ("<td>".$unidad->DiffBetweenNow_and_UltimaActualizacion()."</td>") : ('');
    echo "<td>".$unidad->get_Estado()  ."</td>";
    echo "<td>".$BatNivel->get_HtmlTableField()."</td>";
	echo !$isEstanque ? ($ultimoRegistro->id == 0 ? "<td>0</td>":"<td>".$ultimoRegistro->CAUDAL."</td>"): null;
    echo !$isEstanque ? ($IsMilesight ?  "<td>".$unidad->get_VolumenForMilesight()."</td>":"<td>".$unidad->get_Volumen()."</td>" ): null;
    echo "</tr>";
}
	echo '</tbody></table>';

?>