<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

    $Id_unidad= $_POST['Id_unidad'];

	$SMS = $model->smstounidadesWHERE('Id_unidad',$Id_unidad);

        $return='';

	
		$counter=0;

		$deleteIcon ='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
</svg>';

		$LoadingIcon='<div class="spinner-border text-success" role="status">
  <span class="visually-hidden">Loading...</span>
</div>';

		$ReceivedIcon='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope-check" viewBox="0 0 16 16">
  <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"/>
</svg>';

        $return=$return. '<table class="table" > <thead >';
		$return=$return. '<th scope="col">Id</th>';
		$return=$return. '<th scope="col">SMS</th>';
        $return=$return. '<th scope="col">Recibido</th>';
        $return=$return. '<th scope="col">CreateTime</th>';
        $return=$return. '<th scope="col"></th>';
		$return=$return. '</thead><tbody>';

		foreach ($SMS as $s) {
		$return=$return. '<tr>  <td>'. $s->Id. "</td><td>" . $s->SMS ."</td> <td>" . ( ($s->Recibido == '0') ? $LoadingIcon : $ReceivedIcon)  ."</td> <td>" . $s->CreateTime ."</td><td><button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"FunctionDeleteSMS('".$s->Id."')\" >".$deleteIcon."</button></td></tr>";
		
		if ($counter >= 5) {
        break; // Terminate the loop after the limit is reached
    	}
   		 $counter++;

		}


		$return=$return. '</tbody></table>';
    
echo $return;
?>