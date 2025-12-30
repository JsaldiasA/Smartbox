<!DOCTYPE html>
<html lang="en">
<?php

require_once 'views/head.php';	
require_once 'views/navbar.php';
require_once 'views/page.php';
$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require($sitebasepath.'/vendor/autoload.php');
require_once $sitebasepath."/Model/model.php";

$Model = new model();

$sql = "SELECT * FROM `rowdata` ORDER BY `id` DESC LIMIT 10";
$result = $Model->executeSQL($sql);

$HtmlPage ='<div class="container">
	<div class="row">
	<div class="col">';

$HtmlPage = $HtmlPage. '<table id="TablaRegistros" class="table table-striped table-hover">
			  <thead>
			  <th scope="col">Id</th>
			  <th scope="col">DateTime</th>
			  <th scope="col">RowData</th>
			  <th scope="col">IP</th>
			  </thead>
			  <tbody>';

if ($result->num_rows > 0)
	{
    	while($row = $result->fetch_assoc()) 
			{
				$HtmlPage = $HtmlPage. '<tr"><td>'. $row["Id"] ." </td><td>" . $row["DateTime"] ."</td><td>" . $row["RowData"] ."</td><td>" . $row["IP"] ."</td></tr>";
			}		
	}
else
	{
    	$HtmlPage = $HtmlPage. "0 results";
	}

$HtmlPage = $HtmlPage. '</tbody></table>';

$HtmlPage = $HtmlPage. '</div>
	</div>
	</div>';

//$tk= $_GET['tk'];
if (isset($_COOKIE['token'])) {
    $tk = $_COOKIE['token'];
} else {
    $tk = "";
} 

$Page = new page($HtmlPage,$tk);

echo $Page->get_PageHTML();


?>