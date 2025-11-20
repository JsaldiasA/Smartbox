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
		$jwt = new JWT();
		$issuedAt = time(); // Current timestamp
		$expirationTime = $issuedAt + 100;
		$token =  $jwt->encode([
			'email' => 'email',
			'role' => 'admin',
			'iat' => $issuedAt, // Issued at
    		'exp' => $expirationTime // Expiration time
			]);
		echo $token;		
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

?>