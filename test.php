 <?php
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();
$ticket =$model->get_ticket()[0];

echo $model->create_ticket($ticket);

?>