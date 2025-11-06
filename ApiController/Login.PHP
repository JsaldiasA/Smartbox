<?php


$email= $_POST['email'];
$password= $_POST['password'];

if (strcmp($email,'info@eco3.cl')==0)
{
	if (strcmp($password,'eco3spa')==0)
	{
		echo "password correcta";
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