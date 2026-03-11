<?php

require_once 'views/page.php';

$Page = new page();
$Model = $Page->get_Model();

    $HtmlPage='

    <script src="/views/scripts/API.js"></script>

    <div class="container">
        <div class="row pb-3">
            <div class="col p-3 card shadow p-3 card shadow">
              <iframe src="https://docs.google.com/spreadsheets/d/1u6N9Kf1icpXGGutgmdJMsdKN_3U7vZC-/edit?usp=sharing&ouid=108650448787646658808&rtpof=true&sd=true" width="100%" height="500">
                </iframe>
            </div>        
        </div>
  
    </div>';

$Page->set_PageHTML($HtmlPage);
echo $Page->get_PageHTML();

    ?>