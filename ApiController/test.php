
<?php
require_once 'BatteryLevel.php'; // Or include_once 'MyClass.php';
//include '../BatteryLevel.php'
$apple = new BatteryLevel("999");
echo "ok".$apple->get_HtmlTableField();
?>
