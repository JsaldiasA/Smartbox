<?php
// Create SQL Connection

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

$arrayReturn = [];
$tickets = [];

$return = 'no data';

$Unidades =  $model->MYSQLSelect('unidad');

class ticketDTO extends ticketDbEntity
{
	public $unidad;
}

if(isset($_POST['Id'])) 
{
	$Id_ticket = $_POST['Id'];
	$tickets =  $model->MYSQLSelectWHERE('ticket','Id',$Id_ticket);
}  
else
{
	$tickets = $model->MYSQLSelect('ticket');
}

if($tickets[0] !== NULL)
{
	foreach($tickets as $tk)
    {
        foreach($Unidades as $uni)
        {
            if($tk->Id_unidad == $uni->Id)
            {
                $newTicket = new ticketDTO();
                $newTicket->unidad = $uni;
                
                $allKeys = array_keys((array)$tk);

                foreach ($allKeys as $key ) 
                {
                    $newTicket->$key = $tk->$key ;
                }
                $arrayReturn [] =  $newTicket;
            }
        }   
    }
    $return = json_encode( $arrayReturn );
}




echo $return;


?>