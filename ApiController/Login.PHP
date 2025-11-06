<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require($sitebasepath.'/vendor/autoload.php');
require_once $sitebasepath."/helpers/JWT.php";


$email= $_POST['email'];
$password= $_POST['password'];

if (strcmp($email,'info@eco3.cl')==0)
{
	if (strcmp($password,'eco3spa')==0)
	{
		echo "password correcta";
		$token = new JWT(['email' => $email, 'role' => 'admin']);
		echo " jwt: " .$token;
		
	}
	else
	{
		echo "password Incorrecta";
	}
}
else
{
	echo "Usuario desconocido";
}

	echo "p:".$email."e:".$password;

?>