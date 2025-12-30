<?php

require_once 'views/page.php';

$Page = new page();

$Model = $Page->get_Model();

$sql = "SELECT * FROM `rowdata` ORDER BY `id` DESC LIMIT 500";
$result = $Model->executeSQL($sql);

$HtmlPage ='<div class="container">
	<div class="row">
	<div class="col">';

$HtmlPage = $HtmlPage. '<table class="table">
			  <thead>
			  <th scope="col">Id</th>
			  <th scope="col">DateTime</th>
			  <th scope="col">RowData</th>
			  <th scope="col">IP</th>
			  </thead>
			  <tbody>';

if ($result->num_rows > 0){
    	while($row = $result->fetch_assoc()) 
			{
				$HtmlPage = $HtmlPage. '<tr"><td>'. $row["Id"] ." </td><td>" . $row["DateTime"] ."</td><td>" . $row["RowData"] ."</td><td>" . $row["IP"] ."</td></tr>";
			}		
}
else{
    	$HtmlPage = $HtmlPage. "0 results";
}

$HtmlPage = $HtmlPage. '</tbody></table>';
$HtmlPage = $HtmlPage. '</div>
	</div>
	</div>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();


?>