<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require($sitebasepath.'/vendor/autoload.php');
require_once $sitebasepath."/helpers/JWT.php";

class page
  {

    public $PageHTML;
    public $token;
	    
    function __construct ($PageHTML, $token)
      { 		
        $this->PageHTML = $PageHTML;
        $this->token = $token;
      }
 
    function get_PageHTML()
      { 
        $jwtHelper = new JWT();
        $decoded = $jwtHelper->decode($this->token);

        if ($decoded) {
        $expTime = $decoded["body"]["exp"];
   
        if ($expTime< time()) {
          return
          '<div class="container">
            <div class="row">
              <div class="d-flex justify-content-center">
              <br><p class="h1">token expirado</p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="d-flex justify-content-center">
                  <br><a href="index.php"><p class="h1">log in</p></a><br>
                </div>
              <div class="col">  
            </div>
           </div>';
          }
          else
          {
              return $this->PageHTML;
          }
        } else {
            return  "Invalid token.";
        }      
      }

  }


?>