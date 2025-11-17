<?php
// Create SQL Connection

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

//Insertando En tabla RowData
$sql = "SELECT u.*,o.CAUDAL,o.DATETIME,o.id AS id_registro
FROM unidades_lastortolas o
JOIN (
    SELECT ul.unidad_id, MAX(ul.DATETIME) AS last_order_date
    FROM unidades_lastortolas ul
    GROUP BY ul.unidad_id
) t ON o.unidad_id = t.unidad_id AND o.DATETIME = t.last_order_date
INNER JOIN unidad u on u.id = o.unidad_id;";

$result = $model->executeSQL($sql);
$rows = array();

while($row = $result->fetch_assoc()) {
  $rows[] = $row;
}
print json_encode($rows);

?>