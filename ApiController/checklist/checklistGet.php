<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$unidades = $model->get_unidades();
$checklists = $model->MYSQLSelect('checklist');

$LatestChecklists = [];

foreach ($unidades as $uni )
{
	foreach($checklists as $ck)
	{
		if($ck->id_unidad == $uni->id)
		{
			$LatestChecklists[] = $ck;
			break;
		}	
	}
}

        $return='';
		$counter=0;

		$trueIcon='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
</svg>';

		$falseIcon='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg>';

        $return=$return. '<table class="table" > <thead >';
		$return=$return. '<th scope="col">Id</th>';
        $return=$return. '<th scope="col">Fecha</th>';
		$return=$return. '<th scope="col">Solenoide</th>';
        $return=$return. '<th scope="col">Flujometro</th>';
        $return=$return. '<th scope="col">test con agua</th>';
		$return=$return. '<th scope="col">Conduit y Choco</th>';
		$return=$return. '</thead><tbody>';

		foreach ($LatestChecklists as $Row) {
		$return=$return. '<tr>  <td>'. $Row->Id. "</td><td>" . $Row->Fecha ."</td> <td>" . ( ($Row->Solenoide == '1') ? $trueIcon : $falseIcon )  ."</td> <td>" . ( ($Row->Flujometro == '1') ? $trueIcon : $falseIcon )."</td> <td>" . ( ($Row->agua == '1') ? $trueIcon : $falseIcon ) ."</td> <td>" . ( ($Row->ConduitChoco == '1') ? $trueIcon : $falseIcon ) ."</td></tr>";

		}

		$return=$return. '</tbody></table>';
    
echo $return;
?>