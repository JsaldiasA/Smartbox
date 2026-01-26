<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";


// html table header adn icons
			$return='';

			$trueIcon='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
	<path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
	</svg>';

			$falseIcon='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
	<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
	</svg>';

			$return=$return. '<table class="table" > <thead >';
			$return=$return. '<th scope="col">Id</th>';
			$return=$return. '<th scope="col">Ubicacion</th>';
			$return=$return. '<th scope="col">Fecha</th>';
			$return=$return. '<th scope="col">Solenoide</th>';
			$return=$return. '<th scope="col">Flujometro</th>';
			$return=$return. '<th scope="col">test con agua</th>';
			$return=$return. '<th scope="col">Conduit y Choco</th>';
			$return=$return. '</thead><tbody>';




$model = new Model();

$unidades = $model->get_unidades();
$checklists = $model->MYSQLSelect('checklist');

$Zona =  ($_POST['Zona'] !== NULL)  ? $model->MYSQLSelectWHERE('zona','Name',$ZonaName)[0] : NULL;

$cuarteles = ($Zona !== NULL) ? $model->MYSQLSelectWHERE('cuarteles','Id_zona',$Zona->Id) : $model->MYSQLSelect('cuarteles') ;

$Unidad;
$LatestChecklist;



foreach ($cuarteles as $cuartel)
{

	if($cuartel->Id_unidad != '' || $cuartel->Id_unidad != NULL)
	{
		foreach ($unidades as $uni ) // geting the unit of the cuartel
		{
				if($cuartel->Id_unidad == $uni->id)
				{
					$Unidad = $uni;
					break;
				}	

		}

		foreach($checklists as $ck) // getting the checklist
		{
			if($ck->id_unidad == $Unidad->id)
			{
				$LatestChecklist= $ck;
				break;
			}	
		}
		if ($LatestChecklist != NULL)
		{
			$BadChecklist=false;

			if( ($LatestChecklist->Solenoide != '1') or ($LatestChecklist->Flujometro != '1') or ($LatestChecklist->agua != '1') or ($LatestChecklist->ConduitChoco != '1') )
			{
				$BadChecklist=true;
			}

			$return=$return. '<tr  class="'.($BadChecklist == true ? 'bg-danger text-white' : '').'">  <td>'. $LatestChecklist->Id. "</td><td>" . $cuartel->Name . "</td><td>" . $LatestChecklist->Fecha ."</td> <td>" . ( ($LatestChecklist->Solenoide == '1') ? $trueIcon : $falseIcon )  ."</td> <td>" . ( ($LatestChecklist->Flujometro == '1') ? $trueIcon : $falseIcon )."</td> <td>" . ( ($LatestChecklist->agua == '1') ? $trueIcon : $falseIcon ) ."</td> <td>" . ( ($LatestChecklist->ConduitChoco == '1') ? $trueIcon : $falseIcon ) ."</td></tr>";
		}
		else
		{
			$return=$return. '<tr  class="bg-danger text-white">  <td>'. 'sin checklist'. "</td><td>" . $cuartel->Name . "</td><td>" . ''."</td> <td>" . '' ."</td> <td>" . ''."</td> <td>" . '' ."</td> <td>" . '' ."</td></tr>";
		}
	}
}

	$return=$return. '</tbody></table>';
    
echo $return;
?>