<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

//Insertando En tabla RowData
$sql = "SELECT * FROM `alertatipo`;";
$result = $model->executeSQL($sql);
$rows = array();

while($row = $result->fetch_assoc()) {
  $rows[] = $row;
}
print json_encode($rows);

?>