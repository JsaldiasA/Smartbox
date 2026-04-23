<?php

header("Access-Control-Allow-Origin: *");

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require($sitebasepath.'/vendor/autoload.php');
require_once $sitebasepath."/helpers/JWT.php";

$token;
isset($_POST['token']) ? $token= $_POST['token'] : $token = null;

if( $token != null)
{
      $jwtHelper = new JWT();
      $decoded = $jwtHelper->decode($token);

      if ($decoded) {

        $expTime = $decoded["body"]["exp"];
    
        if ($expTime< time()) 
          {
            http_response_code(404);
			return;
          }
          else
          {
			http_response_code(200); // token ok
			return;
          }
      } else {
          http_response_code(404);
		  return;
      }      
}
else
{
	http_response_code(404);
	return;
}

?>