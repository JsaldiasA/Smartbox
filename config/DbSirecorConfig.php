<?php

class DbSirecorConfig {

  public  $servername = "localhost:3306";
  public  $username = "Sirecor_usuario";
  public  $password = "Helegta1!";
  public  $dbname = "sirecor";	

  //function __construct() {  }	

  function get_servername() {
    return $this->servername;
  }

  function get_username() {
    return $this->username;
  }
	
  function get_password() {
    return $this->password;
  }
	
  function get_dbname() {
    return $this->dbname;
  }		

}

//testing 
/*
echo "ok1";
$apple = new DbSirecorConfig();
echo " ServerName: ".$apple->get_servername();
echo " username: ".$apple->get_username();
echo " password: ".$apple->get_password();
echo " dbname: ".$apple->get_dbname();
*/
?>