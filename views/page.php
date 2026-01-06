<?php


$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];


require_once $sitebasepath.'/views/head.php';	
require_once $sitebasepath.'/views/navbar.php';
require_once $sitebasepath."/helpers/JWT.php";
require_once $sitebasepath."/Model/model.php";

require($sitebasepath.'/vendor/autoload.php');

class page
  {

    public $PageHTML;
    public $token;
    public $Model;
	    
    function __construct ()
      { 		
        $this->PageHTML = '<h1> PAGINA No agregada </h1>';
        isset($_COOKIE['token']) ? $this->token= $_COOKIE['token'] : $this->token = "";
        $this->Model = new Model();
      }
 
    function get_PageHTML()
    { 
      $jwtHelper = new JWT();
      $decoded = $jwtHelper->decode($this->token);
      if ($decoded) {

        $expTime = $decoded["body"]["exp"];
    
        if ($expTime< time()) 
          {
            return '<script>window.location.href = "https://smartbox.eco3.cl/"</script>';
          }
          else
          {
              return $this->PageHTML;
          }
      } else {
          return  '<script>window.location.href = "https://smartbox.eco3.cl/"</script>';
      }      
    }

    function set_PageHTML($HTML)
    { 
       $this->PageHTML = $HTML; 
    }
      
    function get_Model()
    {     
      return $this->Model;
    }
  }


?>