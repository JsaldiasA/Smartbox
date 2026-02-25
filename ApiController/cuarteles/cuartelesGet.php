<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
    if(isset($_GET['Id_zona'])) 
    { 
        $Id_zona = $_GET['Id_zona'];

      	$ArrayObj = $Model->MYSQLSelectWHERE('cuarteles','Id_zona',$Id_zona);
        $return = json_encode( $ArrayObj );  
    } 
    else
    {
      $ArrayObj = $Model->MYSQLSelect('cuarteles');
        $return = json_encode( $ArrayObj );  
    } 

	$return = json_encode( $ArrayObj ); 
    
echo $return;

?>