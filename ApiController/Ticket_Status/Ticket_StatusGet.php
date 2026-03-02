<?php

// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$tableName = 'ticket_status';

$ArrayObj = $model->MYSQLSelect($tableName);
$return = json_encode( $ArrayObj ); 
    
echo $return;



?>